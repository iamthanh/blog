<?php

namespace Blog;

class View {

    /**
     * This will put together the templates necessary for a blog post
     * @param array $model
     * @return string
     */
    public static function generateBlogView($model = []) {
        $page = Template::load('blog/header.php', []);
        $page .= Template::load('blog/article.php', $model);
        $page .= Template::load('blog/side.php', []);
        $page .= Template::load('blog/footer.php', []);

        return $page;
    }
}