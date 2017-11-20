<?php

namespace Entities;

/**
 * @Entity @Table(name="Projects")
 **/
class Projects {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $url;

    /** @Column(type="string") **/
    protected $title;

    /** @Column(type="string") **/
    protected $thumbnail;

    /** @Column(type="text") **/
    protected $description;

    /** @Column(type="text") **/
    protected $text;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $created;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $updated;

    /** @Column(type="string", columnDefinition="ENUM('active','inactive')") **/
    protected $status;

    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getThumbnail() {
        return $this->thumbnail;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getText() {
        return $this->text;
    }

    public function getDateCreated() {
        return $this->created;
    }

    public function getDateUpdated() {
        return $this->updated;
    }

    public function getStatus() {
        return $this->status;
    }
}