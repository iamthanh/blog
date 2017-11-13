<?php

namespace Entities;

/**
 * @Entity @Table(name="Blogs")
 **/
class Blogs {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="integer") **/
    protected $blogEntryId;

    /** @Column(type="string") **/
    protected $blogTopic;

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

    public function getBlogEntryId() {
        return $this->blogEntryId;
    }

    public function setBlogEntryId($id) {
        $this->blogEntryId = $id;
    }
}