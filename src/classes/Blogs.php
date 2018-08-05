<?php

namespace Blog;

class Blogs {

    const BLOGS_FETCH_LIMIT = 10;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const ORDER_BY_DEFAULT = 'DESC';

    const BLOG_TOPICS_DELIMITER = ';';

    /**
     * Fetches blogs based on some parameters/conditions
     *
     * @param bool $topic
     * @param string $search
     * @param string $sort
     * @param int $limit
     * @param string $status
     * @param bool $month
     * @param bool $year
     * @return mixed
     */
    public static function getBlogs(
        $topic  = false,
        $search = '',
        $sort   = self::ORDER_BY_DEFAULT,
        $limit  = self::BLOGS_FETCH_LIMIT,
        $status = self::STATUS_ACTIVE,
        $month  = false,
        $year   = false) {

        $qb = App::$entityManager->createQueryBuilder();
        $qb->select('b')
            ->from('Entities\Blogs', 'b')

            // Joining with the BlogTopics table
            ->where($qb->expr()->eq('b.status', ':status'))
            ->orderBy('b.created',$sort)
            ->setMaxResults($limit)
            ->setParameters(['status' => $status])
            ->groupBy('b.id');

        // Checking if we have any tags to filter
        if ($topic) {
            $qb->andWhere('b.topics LIKE :topic')
               ->setParameter('topic', '%'.$topic.'%');
        }

        if ($search) {
            $qb->andWhere('b.title LIKE :search OR b.description LIKE :search OR b.topics LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        if ($month) $qb->andWhere('Month(b.created)=:month')->setParameter('month', $month);
        if ($year) $qb->andWhere('Year(b.created)=:year')->setParameter('year', $year);

        $query = $qb->getQuery();
        $results = $query->getResult();

        return $results;
    }

    /**
     * This will fetch all blogs
     *
     * @return mixed
     */
    public static function getAll() {
        return self::getBlogs();
    }

    /**
     * This will fetch all recent blogs by a specific blog topic
     *
     * @param bool $topic
     * @return mixed
     */
    public static function getAllRecentBlogsByTopic($topic = false) {
        return self::getBlogs($topic);
    }

    public static function searchBlogs($query) {
        return self::getBlogs('', $query);
    }

    /**
     * Fetches all of the blogs by certain year/month
     *
     * @param $year
     * @param $month
     * @return array
     */
    public static function getAllBlogsByYearMonth($year='', $month='') {
        return self::getBlogs(false, '', self::ORDER_BY_DEFAULT, self::BLOGS_FETCH_LIMIT, self::STATUS_ACTIVE, $month, $year);
    }

    /**
     * Gets the data for a single blog posting
     * @param $blogUrl
     * @return bool|\Entities\Blogs|null|object
     */
    public static function getSingleBlogDetails($blogUrl) {
        if ($blogUrl) {
            $qb = App::$entityManager->createQueryBuilder();
            $qb->select('b')
                ->from('Entities\Blogs', 'b')

                ->where($qb->expr()->eq('b.status', ':status'))
                ->setParameters(['status' => self::STATUS_ACTIVE])

                ->andWhere($qb->expr()->eq('b.url', ':url'))
                ->setParameter('url', $blogUrl);

            $query = $qb->getQuery();
            $results = $query->getResult();

            // Just return 1 single result
            if(!empty($results[0])) {
                return $results[0];
            }
        }
        return false;
    }
}