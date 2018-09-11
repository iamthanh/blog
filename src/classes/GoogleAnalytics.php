<?php

namespace Blog;

class GoogleAnalytics {

    static $ga_config = null;

    /**
     * This function will check if the GA is enabled
     */
    public static function isGAEnabled() {
        if (!static::$ga_config) {
            static::$ga_config = Config::getConfig('google_analytics');
        }

        return isset(static::$ga_config['enabled']) && static::$ga_config['enabled'] ? true : false;
    }


    public static function getGATrackingID() {
        if (!static::$ga_config) {
            static::$ga_config = Config::getConfig('google_analytics');
        }

        return isset(static::$ga_config['tracking_id']) ? static::$ga_config['tracking_id'] : false;
    }

    public static function getGATrackingScript() {
        // Check if the server is dev, if so, don't run GA
        $server_config = Config::getConfig('server');
        if ($server_config) {
            if (isset($server_config['isProduction']) && !$server_config['isProduction']) {
                return null;
            }
        }

        if (self::isGAEnabled()) {
            $ga_tracking_id = self::getGATrackingID();

            return <<<EOT
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=$ga_tracking_id"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '$ga_tracking_id');
</script>
EOT;
        }
        return null;
    }
}