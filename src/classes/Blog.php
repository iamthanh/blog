<?php

namespace Blog;

class Blogs {

    /**
     * This will return all of the recent blogs of any topic
     *
     * @return array
     */
    public static function getAllRecentBlogs() {
        return App::$entityManager->getRepository('Entities\Blogs')->findBy(['status'=>'active'], ['created'=>'DESC'], 10);
    }

    /**
     * This will fetch all recent blogs by a specific blog topic
     *
     * @param string $topic
     * @return array
     */
    public static function getAllRecentBlogsByTopic($topic='') {
        return App::$entityManager->getRepository('Entities\Blogs')->findBy(['blogTopic'=>$topic,'status'=>'active']);
    }

    /**
     * Gets the data for a single blog posting
     *
     * @param $topic
     * @param $blogUrl
     * @return array
     */
    public static function getSingleBlogDetails($topic, $blogUrl) {
        /**
         * @var $blog \Entities\Blogs
         */
        $blogData = App::$entityManager->getRepository('Entities\Blogs')->findOneBy(['url'=>$blogUrl, 'blogTopic'=>$topic, 'status'=>'active']);
        $blogEntryData = App::$entityManager->getRepository('Entities\BlogEntry')->findBy(['id'=>$blogData->getId()]);
        return [
            'data' => $blogData,
            'entry' => $blogEntryData[0]
        ];
    }

    /**
     * This will return the blog entry data based on the blog entry id
     *
     * @param $blogEntryId
     * @return \Entities\BlogEntry|Object
     */
    public static function getBlogEntryDataByBlogEntryId($blogEntryId) {
        return App::$entityManager->getRepository('Entities\BlogEntry')->findOneBy(['id'=>$blogEntryId]);
    }
}