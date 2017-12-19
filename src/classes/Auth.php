<?php

namespace Blog;

class Auth {

    const SESSION_AUTH_KEY = 'auth_session';
    const COOKIE_AUTH_KEY  = 'ac'; // auth cookie
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
    private static function generateHashForSessionAndCookie() {
        return hash('sha256', time());
    }

    /**
     * @param $user
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function storeSessionIdAndCookieId($user) {
        if (!$user) return false;

        $authSessionId = static::generateHashForSessionAndCookie();
        $authCookieId = static::generateHashForSessionAndCookie();

        // Store into session and cookie
        $_SESSION[static::SESSION_AUTH_KEY] = $authSessionId;
        $_COOKIE[static::COOKIE_AUTH_KEY] = $authCookieId;

        // Store into db
        $user->setSessionId($authSessionId);
        $user->setCookieId($authCookieId);
        App::$entityManager->persist($user);
        App::$entityManager->flush();

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
         * 2) Check that the auth cookie keys and values exist
         * 3) Check that the session/cookie are both in the db for the logged in user
         * 4) Verify that the session is still valid and has not expired
         */

        if (!empty($_SESSION[static::SESSION_AUTH_KEY]) && !empty($_SESSION[static::COOKIE_AUTH_KEY])) {
            if (!empty($_SESSION[static::SESSION_USER_DATA_KEY])) {
                $userId = $_SESSION[static::SESSION_USER_DATA_KEY]['userId'];

                // Verify the session/cookie matches up with the session/cookie in db for this userId
                /** @var \Entities\Users $user */
                $user = App::$entityManager->getRepository('Entities\Users')->findOneBy(['id'=>$userId, 'status'=>'active']);
                if ($user) {
                    if ($user->getCookieId() === $_SESSION[static::COOKIE_AUTH_KEY] && $user->getSessionId() === $_SESSION[static::SESSION_AUTH_KEY]) {
                        if (strtotime($user->getSessionExpires()) > time()) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    private static function verifySessionAndCookie() {

    }

    /**
     * Checks and returns true/false if the login parameters are valid
     *
     * @param $username
     * @param $rawPassword
     * @param array $options
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function verifyLogin($username, $rawPassword, $options=[]) {

        // First, get the user data based on username
        /** @var \Entities\Users $userData */
        $user = App::$entityManager->getRepository('Entities\Users')->findOneBy(['username'=>$username, 'status'=>'active']);

        if ($user->getId()) {
            // Verify the password
            if (static::verifyPassword($rawPassword, $user->getPassword())) {

                // Store the session and cookie auth data
                return static::storeSessionIdAndCookieId($user);
            }
        }
        return false;
    }
}