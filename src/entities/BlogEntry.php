<?php

namespace Entities;

/**
 * @Entity @Table(name="BlogEntry")
 **/
class BlogEntry {

    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $entryName;

    /** @Column(type="string") **/
    protected $title;

    /** @Column(type="text") **/
    protected $body;

    /** @Column(type="string") **/
    protected $headerImage;

    public function getId() {
        return $this->id;
    }

    public function getEntryName() {
        return $this->entryName;
    }

    public function setEntryName($name) {
        $this->entryName = $name;
    }
}