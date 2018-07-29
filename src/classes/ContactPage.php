<?php

namespace Blog;

class ContactPage {

    public static function sanitizeFormData($data) {

        if (!empty($data['name'])) {
            $data['name'] = filter_var($data['name'],FILTER_SANITIZE_STRING);
        }

        if (!empty($data['email'])) {
            $data['email'] = filter_var($data['email'],FILTER_SANITIZE_EMAIL);
        }

        if (!empty($data['message'])) {
            $data['message'] = filter_var(substr($data['message'], 0, 1000),FILTER_SANITIZE_STRING);
        }

        return $data;
    }

    public static function validateFormData($data) {
        if (empty($data) || empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public static function saveFormData($data) {
        if (empty($data) || empty($data['name']) || empty($data['email']) || empty($data['message'])) return false;

        try {

            /** @var $blog \Entities\ContactMessages */
            $contactMessages = new \Entities\ContactMessages($data);
            $contactMessages->setName($data['name']);
            $contactMessages->setEmail($data['email']);
            $contactMessages->setMessage($data['message']);
            $contactMessages->setCreated(new \DateTime('NOW'));

            App::$entityManager->persist($contactMessages);
            App::$entityManager->flush();

            return true;
        } catch (\Exception $exception) {
            trigger_error('There was an error, could not save contact message. Response message: ' . $exception->getMessage());
            return false;
        }
    }
}