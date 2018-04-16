<?php

namespace Entities;

/**
 * @Entity @Table(name="ProjectTags")
 **/
class ProjectTags extends EntityBase {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /**
     * @Column(type="integer")
     *
     **/
    protected $projectId;

    /** @Column(type="string") **/
    protected $tagName;

    public function __construct($data) {
        parent::convertArrayToObject($data);
    }

    public function getId() { return $this->id; }

    public function getProjectId() { return $this->projectId; }

    public function getTagName() { return $this->tagName; }
}