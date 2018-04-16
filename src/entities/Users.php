<?php

namespace Entities;

/**
 * @Entity @Table(name="Users")
 **/
class Users extends EntityBase {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $username;

    /** @Column(type="string") **/
    protected $password;

    /** @Column(type="string") **/
    protected $sessionId;

    /** @Column(type="datetime") **/
    protected $sessionCreated;

    /** @Column(type="datetime") **/
    protected $sessionExpires;

    /** @Column(type="string", columnDefinition="ENUM('active','inactive')") **/
    protected $status;

    public function __construct($data) {
        parent::convertArrayToObject($data);
    }

    public function getId() { return $this->id; }

    public function getUserName() { return $this->username; }

    public function getPassword() { return $this->password; }

    public function getSessionId() { return $this->sessionId; }
    public function setSessionId($sessionId) { $this->sessionId = $sessionId; }

    public function getSessionCreated() { return $this->sessionCreated; }

    public function getSessionExpires() { return $this->sessionExpires; }

    public function getStatus() { return $this->status; }
}