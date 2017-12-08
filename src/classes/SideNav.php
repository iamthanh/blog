<?php

namespace Blog;

class SideNav {

    /**
     * This returns an array of data for building the side nav on blog sections
     *
     * @param array $blogs
     * @return array|boolean
     */
    public static function generateSideNavFromBlogs(array $blogs) {
        if (empty($blogs) || !is_array($blogs)) {
            return false;
        }

        $results = [];

        /** @var $blog \Entities\Blogs */
        foreach($blogs as $blog) {
            /** @var $dateUpdated \DateTime */
            $dateUpdated = $blog->getDateUpdated();

            $month = $dateUpdated->format('F');
            $year = $dateUpdated->format('Y');

            if (isset($results[$year])) {
                if (isset($results[$year][$month])) {
                    $results[$year][$month]++;
                } else {
                    $results[$year][$month] = 1;
                }
            } else {
                $results[$year] = [$month=>1];
            }
        }
        return $results;
    }
}