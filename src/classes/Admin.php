<?php

namespace Blog;

class Admin {

    const ACTION_EDIT = 'edit';
    const EDIT_TYPE_BLOGS = 'blogs';
    const EDIT_TYPE_PROJECTS = 'projects';

    const DEFAULT_ACTION = self::ACTION_EDIT;
    const DEFAULT_EDIT_TYPE = self::EDIT_TYPE_BLOGS;

    public static $allowedActions = [
        self::ACTION_EDIT
    ];

    public static $allowedTypes = [
        self::EDIT_TYPE_BLOGS,
        self::EDIT_TYPE_PROJECTS
    ];

    /**
     * @param string $action
     * @param string $type
     * @return array|bool
     */
    public static function getAdminData($action='', $type='') {

        // Use the default values if the parameters are not set
        if (empty($action) || empty($type)) {
            $action  = self::DEFAULT_ACTION;
            $type = self::DEFAULT_EDIT_TYPE;
        }

        if (in_array($action, static::$allowedActions)) {

            // Checking if the admin is editing
            if ($action === 'edit' && in_array($type, static::$allowedTypes)) {

                $contentData = [];
                if ($type === static::EDIT_TYPE_BLOGS) {
                    $contentData = self::getBlogsForEditing();
                } else if ($type === static::EDIT_TYPE_PROJECTS) {
                    $contentData = self::getProjectsForEditing();
                }

                return [
                    'type' => $type,
                    'contentData' => $contentData
                ];
            }
        }

        return false;
    }

    protected static function getBlogsForEditing() {
        // Get all blogs
        $blogs = Blogs::getAll([], ['created'=>'DESC']);
        if ($blogs) {
            $results = [];
            /** @var \Entities\Blogs $blog */
            foreach($blogs as $blog) {
                $results[] = [
                    'id' => $blog->getId(),
                    'url' => $blog->getUrl(),
                    'title' => $blog->getTitle(),
                    'blogEntryId' => $blog->getBlogEntryId(),
                    'blogTopic' => $blog->getBlogTopic(),
                    'shortDescription' => $blog->getShortDescription(),
                    'description' => $blog->getDescription(),
                    'thumbnail' => $blog->getThumbnail(),
                    'created' => $blog->getDateCreated(),
                    'updated' => $blog->getDateUpdated()
                ];
            }

            return $results;
        }

        return [];
    }

    protected static function getProjectsForEditing() {
        // Get all projects
        $projects = Projects::getProjects('',null);
        if ($projects) {

        }

        return [];
    }
}