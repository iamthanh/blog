<?php

namespace Blog;

class View {

    // Defining prefixes for paths
    const BLOGS_PREFIX = '/blogs';
    const BLOG_PREFIX = '/blog';
    const PROJECTS_PREFIX = '/projects';
    const PROJECT_PREFIX = '/project';
    const CONTACT_ME_PATH = '/contact';

    // Defined universal template paths
    const PATH_HEADER = 'header.php';
    const PATH_FOOTER = 'footer.php';
    const CONTENT_NOT_FOUND = 'contentNotFound.php';

    // Defined blogs (recent/by topic) template paths
    const BLOGS_PATH_LISTING = 'blogs/listing.php';
    const BLOGS_PATH_SIDE = 'blogs/side.php';

    // Defined paths for a single blog posting
    const BLOG_TITLE_PATH = 'blog/title.php';
    const BLOG_BODY_PATH = 'blog/body.php';

    // Defined projects listing template paths
    const PROJECTS_PATH_LISTING = 'projects/listing.php';
    const PROJECTS_PATH_SIDE = 'projects/side.php';

    // Defined single project detail page paths
    const PROJECT_DETAIL_PATH = 'project/detail.php';


    /**
     * This will put together the templates necessary for a blogs listing
     *
     * @param array $model
     * @return string
     */
    public static function generateBlogView($model=[]) {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::BLOGS_PATH_LISTING, $model);
        $page .= Template::load(static::BLOGS_PATH_SIDE, []);
        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }

    /**
     * Page for single blog detail page
     *
     * @param \Entities\Blogs $data
     * @param \Entities\BlogEntry $entry
     * @return string
     */
    public static function generateBlogDetailView(\Entities\Blogs $data, \Entities\BlogEntry $entry) {

        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::BLOG_TITLE_PATH, $data);
        $page .= Template::load(static::BLOG_BODY_PATH, $entry);
        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }

    /**
     * This will be the page for the projects
     *
     * @param array $model
     * @return string
     */
    public static function generateProjectsView($model=[]) {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::PROJECTS_PATH_LISTING, $model);
        $page .= Template::load(static::PROJECTS_PATH_SIDE, $model);
        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }

    public static function generateSingleProjectView($model=[]) {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::PROJECT_DETAIL_PATH, $model);
        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }

    /**
     * This will generate the page for content that was not found
     *
     * @param array $model
     * @return string
     */
    public static function generateNotFoundView($model=[]) {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::CONTENT_NOT_FOUND, $model);
        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }
}