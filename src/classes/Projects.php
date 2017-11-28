<?php

namespace Blog;

class Projects {

    /**
     * This will get all of the recent projects
     *
     * @param string $tag optional if displaying the projects filtered by tag
     * @return array
     */
    public static function getAllRecentProjects($tag='') {

        /**
         * SELECT
         * p.*,
         * GROUP_CONCAT(pt.tagName separator ';') as tags
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
        $qb->select('p,GROUP_CONCAT(pt.tagName separator ";") as tags')
            ->from('Entities\Projects', 'p')
            ->leftJoin('Entities\ProjectTags', 'pt', 'WITH', $qb->expr()->eq('pt.projectId', 'p.id'))
            ->where($qb->expr()->eq('p.status', ':status'))
            ->orderBy('p.updated','DESC')
            ->groupBy('p.id')
//            ->addSelect('')
            ->setParameter('status', 'active');

        // Checking if we have any tags to filter
        if ($tag) {
            $qb->andWhere($qb->expr()->eq('pt.tagName', ':tag'))
                ->setParameter('tag', $tag);
        }

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param $projectData
     * @return array
     */
//    public static function getCompleteProjectsData($projectData) {
//        $completeProjectData = [];
//
//        /**
//         * Fetching the blog entries
//         * @var $project \Entities\Projects
//         */
//        foreach($projectData as $project) {
//            $links = static::getProjectLinks($project->getId());
//            $completeProjectData[] = static::getAssembleProjectData($project, $links);
//        }
//
//        return $completeProjectData;
//    }

    /**
     * @param \Entities\Projects $projectData
     * @param array $projectLinks
     * @return array
     */
//    public static function getAssembleProjectData(\Entities\Projects $projectData, array $projectLinks) {
//        return [
//            'id' => $projectData->getId(),
//            'url' => $projectData->getUrl(),
//            'title' => $projectData->getTitle(),
//            'thumbnail' => $projectData->getThumbnail(),
//            'description' => $projectData->getDescription(),
//            'text' => $projectData->getText(),
//            'dateCreated' => $projectData->getDateCreated(),
//            'dateUpdated' => $projectData->getDateUpdated(),
//            'links' => $projectLinks
//        ];
//    }
}