<?php

namespace Entities;

/**
 * @Entity @Table(name="ContactMessages")
 **/
class ContactMessages extends EntityBase {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $name;

    /** @Column(type="string") **/
    protected $email;

    /** @Column(type="text") **/
    protected $message;

    /** @Column(type="datetime") **/
    protected $created;

    public function __construct($data) {
        parent::convertArrayToObject($data);
    }

    public function getId() { return $this->id; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getMessage() { return $this->message; }
    public function setMessage($message) { $this->message = $message; }

    public function getCreated() { return $this->created; }
    public function setCreated($created) { $this->created = $created; }
}