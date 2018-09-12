<?php

namespace Blog;

class Ads {

    static $ga_config = null;
    static $ad_client = "ca-pub-8117292460941523";

    public static function isAdsEnabled() {
        if (!static::$ga_config) {
            static::$ga_config = Config::getConfig('google_adSense');
        }

        return isset(static::$ga_config['enabled']) && static::$ga_config['enabled'] ? true : false;
    }

    public static function getAdSenseHeadScript() {
        if (self::isAdsEnabled()) {
            $ad_client = static::$ad_client;

            return <<<EOT
<!-- Google AdSense tag -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: '$ad_client',
    enable_page_level_ads: true
  });
</script>
EOT;
        }
        return null;
    }
}