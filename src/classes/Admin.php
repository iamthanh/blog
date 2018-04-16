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

            $data['shortDescription'] = filter_var(trim($data['shortDescription']), FILTER_SANITIZE_STRING);
            if (!$data['shortDescription']) {
                trigger_error('Error: cannot update blog data, shortDescription is invalid');
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

            /** @var $blogEntry \Entities\BlogEntry */
            $blogEntry = App::$entityManager->getRepository('Entities\BlogEntry')->findOneBy(['id'=>$data['id']]);

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

    /**
     * This will create a new blog post in the database
     *
     * @param $data
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function createNewBlogPost($data) {

        if (!empty($data)) {

            try {
                /** @var $blogEntry \Entities\EntityBase */
                $blogEntry = new \Entities\BlogEntry($data);
                App::$entityManager->persist($blogEntry);
                App::$entityManager->flush();

                $blogEntryId = $blogEntry->getId();

                /** @var $blog \Entities\Blogs */
                $blog = new \Entities\Blogs($data);
                $blog->setBlogEntryId($blogEntryId);
                $blog->setStatus(\Entities\Blogs::STATUS_ACTIVE);
                App::$entityManager->persist($blog);
                App::$entityManager->flush();

                return [
                    'status' => true,
                    'message'=> 'Update successful'
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

    protected static function getProjectsForEditing() {
        // Get all projects
        $projects = Projects::getProjects('',null);
        if ($projects) {

        }

        return [];
    }
}