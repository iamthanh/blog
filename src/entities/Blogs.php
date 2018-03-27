<?php

namespace Entities;

/**
 * @Entity @Table(name="Blogs")
 **/
class Blogs {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $url;

    /** @Column(type="string") **/
    protected $title;

    /** @Column(type="integer") **/
    protected $blogEntryId;

    /** @Column(type="string") **/
    protected $blogTopic;

    /** @Column(type="string") **/
    protected $shortDescription;

    /** @Column(type="text") **/
    protected $description;

    /** @Column(type="string") **/
    protected $thumbnail;

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

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getBlogEntryId() {
        return $this->blogEntryId;
    }

    public function getBlogTopic() {
        return $this->blogTopic;
    }

    public function setBlogTopic($topic) {
        $this->blogTopic = $topic;
    }

    public function getShortDescription() {
        return $this->shortDescription;
    }

    public function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getThumbnail() {
        return $this->thumbnail;
    }

    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
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

    public function setStatus($status) {
        $this->status = $status;
    }
}