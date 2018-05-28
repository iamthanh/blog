<?php

namespace Blog;

class Blogs {

    public static function getAll($criteria = [], $orderBy = []) {
        return App::$entityManager->getRepository('Entities\Blogs')->findBy($criteria, $orderBy);
    }

    /**
     * This will return all of the recent blogs of any topic
     *
     * @return array
     */
    public static function getAllRecentBlogs() {
        return App::$entityManager->getRepository('Entities\Blogs')->findBy(['status'=>[\Entities\Blogs::STATUS_ACTIVE]], ['created'=>'DESC'], 10);
    }

    /**
     * This will fetch all recent blogs by a specific blog topic
     *
     * @param string $topic
     * @return array
     */
    public static function getAllRecentBlogsByTopic($topic='') {
        return App::$entityManager->getRepository('Entities\Blogs')->findBy(['blogTopic'=>$topic,'status'=>\Entities\Blogs::STATUS_ACTIVE]);
    }

    /**
     * Fetches all of the blogs by certain year/month
     *
     * @param $year
     * @param $month
     * @return array
     */
    public static function getAllBlogsByYearMonth($year='', $month='') {

        /**
         * SELECT * FROM Blogs
         * WHERE YEAR(updated)={year} AND MONTH(updated)={month} AND status='active'
         * ORDER BY `updated` DESC
         */

        $qb = App::$entityManager->createQueryBuilder();
        $qb->select('b')
            ->from('Entities\Blogs', 'b')
            ->where($qb->expr()->eq('b.status', ':status'))
            ->andWhere('Month(b.updated)=:month')
            ->andWhere('Year(b.updated)=:year')
            ->orderBy('b.updated','DESC')

            ->setParameters([
                'status'=>\Entities\Blogs::STATUS_ACTIVE,
                'month'=>$month,
                'year'=>$year
            ]);

        $query = $qb->getQuery();
        $results = $query->getResult();

        return $results;
    }

    /**
     * Gets the data for a single blog posting
     *
     * @param $topic
     * @param $blogUrl
     * @return bool|\Entities\Blogs|null|object
     */
    public static function getSingleBlogDetails($topic, $blogUrl) {
        /** @var \Entities\Blogs $blogData */
        $blogData = App::$entityManager->getRepository('Entities\Blogs')->findOneBy(['url'=>$blogUrl, 'blogTopic'=>$topic, 'status'=>\Entities\Blogs::STATUS_ACTIVE]);

        if ($blogData) {
            return $blogData;
        }
        return false;
    }
}