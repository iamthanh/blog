<?php

namespace Blog;

class Blogs {

    /**
     * This will return all of the recent blogs of any topic
     *
     * @return array
     */
    public static function getAllRecentBlogs() {
        $blogsData = App::$entityManager->getRepository('Entities\Blogs')->findBy([], ['created'=>'DESC'], 10);
        return static::getCompleteBlogsData($blogsData);
    }

    public static function getCompleteBlogsData($blogsData) {
        $completeBlogData = [];

        // Fetching the blog entries
        foreach($blogsData as $blog) {
            $blogEntryData = static::getBlogEntryDataByBlogEntryId($blog->getBlogEntryId());
            $completeBlogData[] = static::getAssembleBlogData($blog, $blogEntryData);
        }

        return $completeBlogData;
    }

    /**
     * This will fetch all recent blogs by a specific blog topic
     *
     * @param string $topic
     * @return array
     */
    public static function getAllRecentBlogsByTopic($topic='') {
        $blogsData = App::$entityManager->getRepository('Entities\Blogs')->findBy(['blogTopic'=>$topic]);
        return static::getCompleteBlogsData($blogsData);
    }

    /**
     * This will return the blog entry data based on the blog entry id
     *
     * @param $blogEntryId
     * @return \Entities\BlogEntry
     */
    public static function getBlogEntryDataByBlogEntryId($blogEntryId) {
        return App::$entityManager->getRepository('Entities\BlogEntry')->findOneBy(['id'=>$blogEntryId]);
    }

    /**
     * This will piece together the data for a single blog used for displaying on the front-end
     *
     * @param $blogData
     * @param $blogEntryData
     * @return array
     */
    public static function getAssembleBlogData(\Entities\Blogs $blogData, \Entities\BlogEntry $blogEntryData) {
        return [
            'id' => $blogData->getId(),
            'topic' => $blogData->getBlogTopic(),
            'dateCreated' => $blogData->getDateCreated(),
            'dateUpdated' => $blogData->getDateUpdated(),
            'name' => $blogEntryData->getEntryName(),
            'title' => $blogEntryData->getTitle(),
            'body' => $blogEntryData->getBody(),
            'headerImage' => $blogEntryData->getHeaderImage()
        ];
    }
}