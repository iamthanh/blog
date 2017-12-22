<?php

namespace Blog;

class Auth {

    const SESSION_AUTH_KEY = 'auth_session';
    const SESSION_USER_DATA_KEY = 'user_data';

    /**
     * This is will create a new user and store it into DB
     *
     * @param $username
     * @param $rawPassword
     */
    public static function createUser($username, $rawPassword) {

    }

    /**
     * Prepare/hashes a raw password and returns it
     *
     * @param $rawPassword
     * @return string
     */
    private static function hashPassword($rawPassword) {
        return password_hash($rawPassword, PASSWORD_DEFAULT);
    }

    /**
     * Returns true/false for checking if the password is correct
     *
     * @param $hashedPassword
     * @param $rawPassword
     * @return bool
     */
    private static function verifyPassword($rawPassword, $hashedPassword) {
        return password_verify($rawPassword, $hashedPassword);
    }

    /**
     * Creates a hashed string used as session id for a logged in user
     *
     * @return string
     */
    private static function generateHashForSessionId() {
        return hash('sha256', time());
    }

    /**
     * @param $user \Entities\Users
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function storeSessionId($user) {
        if (!$user) return false;

        $authSessionId = static::generateHashForSessionId();

        // Store into session
        $_SESSION[static::SESSION_AUTH_KEY] = $authSessionId;

        // Store into db
        $user->setSessionId($authSessionId);
        App::$entityManager->persist($user);
        App::$entityManager->flush();

        return true;
    }

    /**
     * Sets user data in the session
     *
     * @param $user \Entities\Users
     * @return bool
     */
    public static function storeUserDataInSession($user) {
        if (!$user) {
            trigger_error('user not passed in function storeUserDataInSession');
            return false;
        };

        $_SESSION[static::SESSION_USER_DATA_KEY] = [
            'user_id' => $user->getId(),
            'username' => $user->getUserName()
        ];

        return true;
    }

    /**
     * Checks if there is a user logged in saved in session
     *
     * @return bool
     */
    public static function isLoggedIn() {
        /**
         * Current logged in auth process
         * 1) Check that the auth session keys and values exist
         * 3) Check that the session are both in the db for the logged in user
         * 4) Verify that the session is still valid and has not expired
         */

        if (!empty($_SESSION[static::SESSION_AUTH_KEY])) {
            if (!empty($_SESSION[static::SESSION_USER_DATA_KEY])) {
                $userId = $_SESSION[static::SESSION_USER_DATA_KEY]['user_id'];

                // Verify the session matches up with the session in db for this userId
                /** @var \Entities\Users $user */
                $user = App::$entityManager->getRepository('Entities\Users')->findOneBy(['id'=>$userId, 'status'=>'active']);
                if ($user) {
                    if ($user->getSessionId() === $_SESSION[static::SESSION_AUTH_KEY]) {

                        /** @var \DateTime $sessionExpires */
                        $sessionExpires = $user->getSessionExpires();
                        if (strtotime($sessionExpires->getTimestamp()) > time()) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Checks and returns true/false if the login parameters are valid
     *
     * @param $username
     * @param $rawPassword
     * @param array $options
     * @return bool|\Entities\Users
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function verifyLogin($username, $rawPassword, $options=[]) {

        // First, get the user data based on username
        /** @var \Entities\Users $user */
        $user = App::$entityManager->getRepository('Entities\Users')->findOneBy(['username'=>$username, 'status'=>'active']);

        if ($user) {
            // Verify the password
            if (static::verifyPassword($rawPassword, $user->getPassword())) {

                // Store the session auth data
                static::storeSessionId($user);
                return $user;
            }
        }
        return false;
    }
}