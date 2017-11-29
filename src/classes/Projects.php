<?php

namespace Blog;

class Projects {

    /**
     * This will get all of the recent projects
     *
     * @param string $tag optional if displaying the projects filtered by tag
     * @return array
     */
    public static function getRecentProjects($tag='') {

        /**
         * SELECT
         * p.*,
         * GROUP_CONCAT(DISTINCT pt.tagName) as tags
         *
         * FROM `Projects` as p
         *
         * LEFT JOIN ProjectTags as pt ON pt.projectId=p.id
         *
         * WHERE p.status='active'
         *
         * GROUP BY p.id
         * ORDER BY p.updated DESC
         */

        $qb = App::$entityManager->createQueryBuilder();
        $qb->select('p,GROUP_CONCAT(DISTINCT pt.tagName) as tags')
            ->from('Entities\Projects', 'p')
            ->leftJoin('Entities\ProjectTags', 'pt', 'WITH', $qb->expr()->eq('pt.projectId', 'p.id'))
            ->where($qb->expr()->eq('p.status', ':status'))
            ->orderBy('p.updated','DESC')
            ->groupBy('p.id')
            ->setParameter('status', 'active');

        // Checking if we have any tags to filter
        if ($tag) {
            $qb->andWhere($qb->expr()->eq('pt.tagName', ':tag'))
                ->setParameter('tag', $tag);
        }

        $query = $qb->getQuery();
        $results = $query->getResult();

        /**
         * Sample of what the $results could look like:
         *
         * Array [
         *    [
         *       [0]      => {Entities\Projects object},
         *       ['tags'] => {string}
         *    ],
         *    [
         *       [0]      => {Entities\Projects object},
         *       ['tags'] => {string}
         *    ]
         * ]
         *
         * We are going to rename the index '0' to 'project'
         *
         */
        if (!empty($results)) {
            $results = array_map(function($project) {

                // Explode the tags (string) as an array
                $tags = explode(',', $project['tags']);
                return array(
                    'project' => $project[0],
                    'tags'    => $tags
                );
            }, $results);
        }

        return $results;
    }
}