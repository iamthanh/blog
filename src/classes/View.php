<?php

namespace Blog;

class View {

    // Defining prefixes for paths
    const BLOGS_PREFIX = '/blogs';
    const BLOG_PREFIX = '/blog';
    const PROJECTS_PREFIX = '/projects';
    const PROJECT_PREFIX = '/project';

    // Defined universal template paths
    const PATH_HEADER = 'header.php';

    // Defined blogs (recent/by topic) template paths
    const BLOGS_PATH_LISTING = 'blogs/listing.php';
    const BLOGS_PATH_SIDE = 'blogs/side.php';
    const BLOGS_PATH_FOOTER = 'blogs/footer.php';

    // Defined paths for a single blog posting
    const BLOG_TITLE = 'blog/title.php';
    const BLOG_BODY = 'blog/body.php';

    // Defined projects template paths
    const PROJECTS_PATH_LISTING = 'projects/listing.php';
    const PROJECTS_PATH_SIDE = 'projects/side.php';

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
        $page .= Template::load(static::BLOG_TITLE, $data);
        $page .= Template::load(static::BLOG_BODY, $entry);

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

        return $page;
    }

    /**
     * This will generate the page for content that was not found
     *
     * @param array $model
     * @return string
     */
    public static function generateNotFoundView($model=[]) {

    }
}