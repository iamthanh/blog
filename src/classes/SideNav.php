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

        $calender = [];

        /** @var $blog \Entities\Blogs */
        foreach($blogs as $blog) {
            
            /** @var $dateCreated \DateTime */
            $dateCreated = $blog->getDateCreated();

            $month = $dateCreated->format('F');
            $year = $dateCreated->format('Y');

            if (isset($calender[$year])) {
                if (isset($calender[$year][$month])) {
                    $calender[$year][$month]++;
                } else {
                    $calender[$year][$month] = 1;
                }
            } else {
                $calender[$year] = [$month=>1];
            }
        }

        return [
            'calender'=>$calender
        ];
    }
}