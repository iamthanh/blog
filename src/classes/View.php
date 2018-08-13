<?php

namespace Blog;

class View {

    // Defining prefixes for paths
    const BLOGS_PREFIX = '/blogs';
    const BLOG_PREFIX = '/blog';
    const CONTACT_ME_PATH = '/contact';

    // Defined universal template paths
    const PATH_HEADER = 'header.php';
    const PATH_FOOTER = 'footer.php';
    const CONTENT_NOT_FOUND = 'contentNotFound.php';
    const PATH_TOP_NAV = 'topNav.php';

    // Defined blogs (recent/by topic) template paths
    const BLOGS_PATH_LISTING = 'blogs/listing.php';
    const BLOGS_SIDE_NAV_PATH = 'blogs/sideNav.php';

    // Defined paths for a single blog posting
    const BLOG_BODY_PATH = 'blog/body.php';

    // Defined secure paths
    const SECURE_ADMIN_PATH = 'secure/admin.php';
    const SECURE_LOG_IN_PATH = 'secure/login.php';
    const SECURE_FOOTER_PATH = 'secure/footer.php';

    const CONTACT_PATH = 'contactPage/form.php';

    const MAIN_ARTICLE_BODY = 'mainArticle.php';

    /**
     * Combines templates together under an <article> tag
     *
     * @param array $content
     * @return string
     */
    public static function buildMainArticleBody($content = []) {
        return Template::load(static::MAIN_ARTICLE_BODY, implode('', $content));
    }

    /**
     * This will put together the templates necessary for a blogs listing
     *
     * @param array $blogsModel
     * @param array $sideNav
     * @param string $topic
     * @return string
     */
    public static function generateBlogView($blogsModel=[], $sideNav=[], $topic='') {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::PATH_TOP_NAV);

        $page .= static::buildMainArticleBody([
            Template::load(static::BLOGS_PATH_LISTING, [
                    'blogs'  => $blogsModel,
                    'topic'  => $topic,
                    'sideNav'=> $sideNav
                ]
            )
        ]);

        $page .= Template::load(static::PATH_FOOTER, []);
        return $page;
    }

    /**
     * Page for single blog detail page
     *
     * @param \Entities\Blogs $data
     * @return string
     */
    public static function generateBlogDetailView($data) {

        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::PATH_TOP_NAV);

        $page .= static::buildMainArticleBody([
            Template::load(static::BLOG_BODY_PATH, $data)
        ]);

        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }

    /**
     * This will generate the page for content that was not found
     *
     * @param array $model
     * @param string $query
     * @return string
     */
    public static function generateNotFoundView($model=[], $query='') {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::PATH_TOP_NAV);

        $page .= static::buildMainArticleBody([
            Template::load(static::CONTENT_NOT_FOUND, $model)
        ]);

        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }

    /**
     * Page for the secure/me login page
     *
     * @param array $model
     * @return string
     */
    public static function generateSecureLoginPageView($model=[]) {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::SECURE_LOG_IN_PATH, []);
        $page .= Template::load(static::SECURE_FOOTER_PATH, []);

        return $page;
    }

    /**
     * Secure page for adding/editing content
     *
     * @param array $model
     * @return string
     */
    public static function generateSecureCMS($model=[]) {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::SECURE_ADMIN_PATH, $model);
        $page .= Template::load(static::SECURE_FOOTER_PATH, []);

        return $page;
    }

    /**
     * Creates the contact page/form
     *
     * @return string
     */
    public static function generateContactPage() {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::PATH_TOP_NAV);
        $page .= Template::load(static::CONTACT_PATH);
        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }

    public static function generateSearchBlogsView($blogsModel=[], $query, $topic='') {
        $page = Template::load(static::PATH_HEADER);
        $page .= Template::load(static::PATH_TOP_NAV);

        $page .= static::buildMainArticleBody([
            Template::load(static::BLOGS_PATH_LISTING, [
                'blogs' => $blogsModel,
                'topic' => $topic,
                'resultsFound' => count($blogsModel),
                'query' => $query
            ])
        ]);

        $page .= Template::load(static::PATH_FOOTER, []);

        return $page;
    }
}