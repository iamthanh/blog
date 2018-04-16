<?php

namespace Entities;

/**
 * @Entity @Table(name="BlogEntry")
 **/
class BlogEntry extends EntityBase {

    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="text") **/
    protected $body = '';

    /** @Column(type="string") **/
    protected $headerImage = '';

    public function __construct($data) {
        parent::convertArrayToObject($data);
    }

    public function getId() { return $this->id; }

    public function getBody() { return $this->body; }
    public function setBody($body) { $this->body = $body; }

    public function getHeaderImage() { return $this->headerImage; }
    public function setHeaderImage($headerImage) { $this->headerImage = $headerImage; }
}