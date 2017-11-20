<?php

namespace Blog;

class Projects {

    /**
     * This will get all of the recent projects
     * @return mixed
     */
    public static function getAllRecentProjects() {
        $projects = App::$entityManager->getRepository('Entities\Projects')->findBy(['status'=>'active'], ['created'=>'DESC']);
        return static::getCompleteProjectsData($projects);
    }

    /**
     * @param $projectData
     * @return array
     */
    public static function getCompleteProjectsData($projectData) {
        $completeProjectData = [];

        /**
         * Fetching the blog entries
         * @var $project \Entities\Projects
         */
        foreach($projectData as $project) {
            $links = static::getProjectLinks($project->getId());
            $completeProjectData[] = static::getAssembleProjectData($project, $links);
        }

        return $completeProjectData;
    }

    /**
     * This will return the links for a specific project
     * @param $projectId
     * @return array|\Entities\ProjectLinks|Object
     */
    public static function getProjectLinks($projectId) {
        return App::$entityManager->getRepository('Entities\ProjectLinks')->findAll(['id'=>$projectId]);
    }

    /**
     * @param \Entities\Projects $projectData
     * @param array $projectLinks
     * @return array
     */
    public static function getAssembleProjectData(\Entities\Projects $projectData, array $projectLinks) {
        return [
            'id' => $projectData->getId(),
            'url' => $projectData->getUrl(),
            'title' => $projectData->getTitle(),
            'thumbnail' => $projectData->getThumbnail(),
            'description' => $projectData->getDescription(),
            'text' => $projectData->getText(),
            'dateCreated' => $projectData->getDateCreated(),
            'dateUpdated' => $projectData->getDateUpdated(),
            'links' => $projectLinks
        ];
    }
}