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

                $blogId = $blog->getBlogEntryId();

                /** @var $blogEntry \Entities\BlogEntry */
                $blogEntry = App::$entityManager->getRepository('Entities\BlogEntry')->findOneBy(['id'=>$blogId]);

                $results[] = [
                    'id' => $blog->getId(),
                    'url' => $blog->getUrl(),
                    'title' => $blog->getTitle(),
                    'blogEntryId' => $blogId,
                    'blogTopic' => $blog->getBlogTopic(),
                    'shortDescription' => $blog->getShortDescription(),
                    'fullBody' => htmlspecialchars($blogEntry->getBody()),
                    'bodyHeaderImage' => $blogEntry->getHeaderImage(),
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

    /**
     * Sanitizes edit blog modal data and checks if valid
     *
     * @param $data
     * @return bool
     */
    public static function sanitizeAndVerifyEditModalData($data) {

        if (!empty($data)) {

            // The thumbnail and body header images are not required
            $data['thumbnail'] = filter_var(trim($data['thumbnail']), FILTER_SANITIZE_STRING);
            $data['bodyHeaderImage'] = filter_var(trim($data['bodyHeaderImage']), FILTER_SANITIZE_STRING);

            $data['title'] = filter_var(trim($data['title']), FILTER_SANITIZE_STRING);
            if (!$data['title']) {
                trigger_error('Error: cannot update blog data, title is invalid');
                return false;
            }

            $data['blogTopic'] = filter_var(trim($data['blogTopic']), FILTER_SANITIZE_STRING);
            if (!$data['blogTopic']) {
                trigger_error('Error: cannot update blog data, blogTopic is invalid');
                return false;
            }

            $data['shortDescription'] = filter_var(trim($data['shortDescription']), FILTER_SANITIZE_STRING);
            if (!$data['shortDescription']) {
                trigger_error('Error: cannot update blog data, shortDescription is invalid');
                return false;
            }

            $data['id'] = filter_var(trim($data['id']), FILTER_SANITIZE_NUMBER_INT);
            if (!$data['id']) {
                trigger_error('Error: cannot update blog data, id is invalid');
                return false;
            }
        } else {
            // Data is empty
            return false;
        }

        return $data;
    }

    /**
     * This will update a blog posting by the blog's id
     * returns true when successful, otherwise false
     *
     * @param $blogId
     * @param $data
     * @return array|bool
     */
    public static function updateBlogDataByBlogId($blogId, $data) {

        if ($blogId) {

            /** @var $blog \Entities\Blogs */
            $blog = App::$entityManager->getRepository('Entities\Blogs')->findOneBy(['id'=>$blogId]);

            /** @var $blogEntry \Entities\BlogEntry */
            $blogEntry = App::$entityManager->getRepository('Entities\BlogEntry')->findOneBy(['id'=>$blogId]);

            // Setting the new values
            $blog->setTitle($data['title']);
            $blog->setUrl($data['url']);
            $blog->setBlogTopic($data['blogTopic']);
            $blog->setThumbnail($data['thumbnail']);
            $blog->setShortDescription($data['shortDescription']);

            // Setting the new values for BlogEntry
            $blogEntry->setHeaderImage($data['bodyHeaderImage']);
            $blogEntry->setBody($data['fullBody']);

            // Save/update the Blog entry
            try {
                App::$entityManager->persist($blog);
                App::$entityManager->persist($blogEntry);

                // Exclude the update
                App::$entityManager->flush();

                return [
                    'status' => true,
                    'message'=> 'Update successful'
                ];
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'message'=> 'Error: Update failed'
                ];
            }
        }

        return false;
    }

    protected static function getProjectsForEditing() {
        // Get all projects
        $projects = Projects::getProjects('',null);
        if ($projects) {

        }

        return [];
    }
}