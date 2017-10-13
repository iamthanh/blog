<?php

namespace Blog;

class Template {

    public static $view_folder = __DIR__ . '/../views/';


    /**
     * This will take a php template file and load with data (model) and return it as html
     *
     * @param bool $path
     * @param array $model
     * @param array $css
     * @param array $js
     * @return string
     */
    public static function load($path=false, $model=[], $css=[], $js=[]) {
        if ($path) {
            extract(['m'=>$model]);
            ob_start();
            include(self::$view_folder . $path);
            return ob_get_clean();
        }
    }
}