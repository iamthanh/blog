<?php

namespace Blog;

class Admin {

    const ACTION_TYPE_EDIT = 'edit';
    const ACTION_TYPE_CREATE = 'create';


    const EDIT_TYPE_BLOGS = 'blogs';
    const EDIT_TYPE_PROJECTS = 'projects';

    const DEFAULT_ACTION = self::ACTION_TYPE_EDIT;
    const DEFAULT_EDIT_TYPE = self::EDIT_TYPE_BLOGS;

    public static $allowedActions = [
        self::ACTION_TYPE_EDIT,

    ];

    public static $allowedTypes = [
        self::EDIT_TYPE_BLOGS,
        self::EDIT_TYPE_PROJECTS
    ];

    /**
     * Gets all the data required for the admin page
     *
     * @return array
     */
    public static function getBlogsForAdmin() {
        // Get all blogs
        $blogs = Blogs::getAll(['status'=>\Entities\Blogs::STATUS_ACTIVE], ['created'=>'DESC']);
        if ($blogs) {
            $results = [];
            /** @var \Entities\Blogs $blog */
            foreach($blogs as $blog) {
                $results[] = [
                    'id'          => $blog->getId(),
                    'url'         => $blog->getUrl(),
                    'title'       => $blog->getTitle(),
                    'blogTopic'   => $blog->getBlogTopic(),
                    'description' => $blog->getDescription(),
                    'headerImage' => $blog->getHeaderImage(),
                    'fullBody'    => $blog->getBody(),
                    'thumbnail'   => $blog->getThumbnail(),
                    'created'     => $blog->getDateCreated(),
                    'updated'     => $blog->getDateUpdated()
                ];
            }

            return ['contentData' => $results];
        }

        return ['contentData' => []];
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
            $data['headerImage'] = filter_var(trim($data['headerImage']), FILTER_SANITIZE_STRING);

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

            $data['description'] = filter_var(trim($data['description']), FILTER_SANITIZE_STRING);
            if (!$data['description']) {
                trigger_error('Error: cannot update blog data, description is invalid');
                return false;
            }

            // Sanitize if its not null
            if (!empty($data['id'])) {
                $data['id'] = filter_var(trim($data['id']), FILTER_SANITIZE_NUMBER_INT);
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
     * @param $data
     * @return array|bool
     */
    public static function updateBlogDataByBlogId($data) {

        if ($data['id']) {

            /** @var $blog \Entities\Blogs */
            $blog = App::$entityManager->getRepository('Entities\Blogs')->findOneBy(['id'=>$data['id']]);

            if ($blog) {

                // Setting the new values
                $blog->setTitle($data['title']);
                $blog->setUrl($data['url']);
                $blog->setBlogTopic($data['blogTopic']);
                $blog->setThumbnail($data['thumbnail']);
                $blog->setHeaderImage($data['headerImage']);
                $blog->setDescription($data['description']);
                $blog->setBody($data['fullBody']);

                // Set the new update date
                $blog->setDateUpdated(new \DateTime('NOW'));

                // Save/update the Blog entry
                try {
                    App::$entityManager->persist($blog);

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
        }

        return [
            'status' => false,
            'message'=> 'Error: Update failed'
        ];
    }

    /**
     * This will create a new blog post in the database
     *
     * @param $data
     * @return array
     */
    public static function createNewBlogPost($data) {

        if (!empty($data)) {

            try {

                /** @var $blog \Entities\Blogs */
                $blog = new \Entities\Blogs($data);
                $blog->setStatus(\Entities\Blogs::STATUS_ACTIVE);
                $blog->setDateCreated(new \DateTime('NOW'));
                $blog->setDateUpdated(new \DateTime('NOW'));

                App::$entityManager->persist($blog);
                App::$entityManager->flush();

                return [
                    'status' => true,
                    'message'=> 'New blog created successful'
                ];
            } catch (\Exception $exception) {

                return [
                    'status' => false,
                    'message'=> 'There was an error, could not create new blog. Message: ' . $exception->getMessage()
                ];
            }
        }

        // There was a problem
        return [
            'status' => true,
            'message'=> 'There was an error, could not create new blog.'
        ];
    }

    /**
     * This function will deactivate a blog post and set it as inactive
     *
     * @param $id
     * @return array
     */
    public static function deleteBlogPost($id) {
        if (!$id) return ['status'=>false];

        try {

            // Try to fetch this blog
            /** @var \Entities\Blogs $blog */
            $blog = App::$entityManager->getRepository('Entities\Blogs')->findOneBy(['id'=>$id]);

            if ($blog) {
                // Update the status as inactive
                $blog->setStatus(\Entities\Blogs::STATUS_INACTIVE);
                $blog->setDateUpdated(new \DateTime('NOW'));

                App::$entityManager->persist($blog);
                App::$entityManager->flush();

                return [
                    'status' => true,
                    'message'=> 'Blog deleted successfully'
                ];
            }
        } catch (\Exception $exception) {
            // There was a problem
            return [
                'status' => true,
                'message'=> 'There was an error, could not delete blog. Message: ' . $exception->getMessage()
            ];
        }

        // There was a problem
        return [
            'status' => true,
            'message'=> 'There was an error, could not delete blog.'
        ];
    }

    protected static function getProjectsForEditing() {
        // Get all projects
        $projects = Projects::getProjects('',null);
        if ($projects) {

        }

        return [];
    }
}