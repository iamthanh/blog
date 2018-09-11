<?php

namespace Blog;

class Meta {

    /**
     * This generates a <meta> tag with data as attributes
     *
     * @param array $data
     * @return null|string
     */
    public static function createMetaTag($data=[]) {
        if (empty($data)) return null;

        $valuesArray = [];
        foreach($data as $key=>$value) {
            $valuesArray[] = htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }
        $metaDataString = implode(' ', $valuesArray);

        return <<<EOT
<meta $metaDataString>
EOT;
    }

}