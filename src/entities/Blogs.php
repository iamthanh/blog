<?php

namespace Entities;

/**
 * @Entity @Table(name="Blogs")
 **/
class Blogs extends EntityBase {

    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $url = '';

    /** @Column(type="string") **/
    protected $title = '';

    /** @Column(type="text") **/
    protected $description = '';

    /** @Column(type="text") **/
    protected $topics = '';

    /** @Column(type="text") **/
    protected $body = '';

    /** @Column(type="string") **/
    protected $headerImage = '';

    /** @Column(type="string") **/
    protected $thumbnail = '';

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
    public function setUrl($url) { $this->url = $url; }

    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }

    public function getTopics() { return $this->topics; }
    public function setTopics($topics) { $this->topics = $topics; }

    public function getBody() { return $this->body; }
    public function setBody($body) { $this->body = $body; }

    public function getHeaderImage() { return $this->headerImage; }
    public function setHeaderImage($headerImage) { $this->headerImage = $headerImage; }

    public function getThumbnail() { return $this->thumbnail; }
    public function setThumbnail($thumbnail) { $this->thumbnail = $thumbnail; }

    public function getDateCreated() { return $this->created; }
    public function setDateCreated($dateCreated) { $this->created = $dateCreated; }

    public function getDateUpdated() { return $this->updated; }
    public function setDateUpdated($dateUpdated) { $this->updated = $dateUpdated; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }
}