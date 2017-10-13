<?php

namespace Blog;

class Config {

    // Static storage of the config as an array
    private static $config;
    private static $config_file_path = __DIR__ . '/../../config/config.json';

    /**
     * This is grab the json file and load it
     */
    public static function loadConfig() {
        return static::$config = json_decode(file_get_contents(static::$config_file_path), true);
    }

    /**
     * This function will return the value of a specific config
     *
     * @param string $key
     * @return array|bool
     */
    public static function getConfig($key='') {
        // Check if config has not been loaded
        if (!static::$config) {
            static::$config = static::loadConfig();
        }

        if (isset(static::$config[$key])) {
            return static::$config[$key];
        }

        return false;
    }
}