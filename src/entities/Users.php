<?php

namespace Entities;

/**
 * @Entity @Table(name="Users")
 **/
class Users {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $username;

    /** @Column(type="string") **/
    protected $password;

    /** @Column(type="string") **/
    protected $sessionId;

    /** @Column(type="string") **/
    protected $cookieId;

    /** @Column(type="datetime") **/
    protected $sessionCreated;

    /** @Column(type="datetime") **/
    protected $sessionExpires;

    /** @Column(type="string", columnDefinition="ENUM('active','inactive')") **/
    protected $status;

    public function getId() {
        return $this->id;
    }

    public function getUserName() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSessionId() {
        return $this->sessionId;
    }

    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }

    public function getCookieId() {
        return $this->cookieId;
    }

    public function setCookieId($cookieId) {
        $this->cookieId = $cookieId;
    }

    public function getSessionCreated() {
        return $this->sessionCreated;
    }

    public function getSessionExpires() {
        return $this->sessionExpires;
    }

    public function getStatus() {
        return $this->status;
    }
}