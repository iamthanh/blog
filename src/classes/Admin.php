<?php

namespace Blog;

class Admin {

    const ACTION_EDIT = 'edit';
    const EDIT_TYPE_BLOGS = 'blogs';
    const EDIT_TYPE_PROJECTS = 'projects';

    public static $allowedActions = [
        self::ACTION_EDIT
    ];

    public static $allowedTypes = [
        self::EDIT_TYPE_BLOGS,
        self::EDIT_TYPE_PROJECTS
    ];

    /**
     * @param array $params
     * @return bool|array
     */
    public static function getAdminData($params = []) {
        if (!empty($params[0]) && !empty($params[1])) {

            if (in_array($params[0], static::$allowedActions)) {

                // Checking if the admin is editing
                if ($params[0] === 'edit' && in_array($params[1], static::$allowedTypes)) {

                    $contentData = [];
                    if ($params[1] === static::EDIT_TYPE_BLOGS) {
                        $contentData = self::getBlogsForEditing();
                    } else if ($params[1] === static::EDIT_TYPE_PROJECTS) {
                        $contentData = self::getProjectsForEditing();
                    }

                    return [
                        'type' => $params[1],
                        'contentData' => $contentData
                    ];
                }
            }
        }

        return false;
    }

    protected static function getBlogsForEditing() {
        // Get all blogs
        return Blogs::getAll([], ['created'=>'DESC']);
    }

    protected static function getProjectsForEditing() {
        // Get all projects
        return Projects::getProjects('',null);
    }
}