<?php

namespace Entities;

/**
 * @Entity @Table(name="ProjectLinks")
 **/
class ProjectLinks {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="integer") **/
    protected $projectId;

    /** @Column(type="string") **/
    protected $type;

    /** @Column(type="string") **/
    protected $path;

    public function getId() {
        return $this->id;
    }

    public function getProjectId() {
        return $this->projectId;
    }

    public function getType() {
        return $this->type;
    }

    public function getPath() {
        return $this->path;
    }
}