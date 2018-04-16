<?php

namespace Entities;

/**
 * @Entity @Table(name="Projects")
 **/
class Projects extends EntityBase {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $url;

    /** @Column(type="string") **/
    protected $title;

    /** @Column(type="string") **/
    protected $thumbnail;

    /** @Column(type="string") **/
    protected $description;

    /** @Column(type="text") **/
    protected $body;

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

    public function __construct($data) {
        parent::convertArrayToObject($data);
    }

    public function getId() { return $this->id; }

    public function getUrl() { return $this->url; }

    public function getTitle() { return $this->title; }

    public function getThumbnail() { return $this->thumbnail; }
    public function setThumbnail($thumbnail) { $this->thumbnail = $thumbnail; }

    public function getDescription() { return $this->description; }

    public function getBody() { return $this->body; }

    public function getDateCreated() { return $this->created; }

    public function getDateUpdated() { return $this->updated; }

    public function getStatus() { return $this->status; }
}