<?php

namespace Blog;

class Ads {

    static $ga_config = null;
    static $ad_client = "ca-pub-8117292460941523";

    static $autoAdsEnabled = false;
    static $adUnits = [
        'blog-listing' => [
            'enabled' => true
        ]
    ];

    public static function isAutoAdsEnabled() {
        if (!static::$ga_config) {
            static::$ga_config = Config::getConfig('google_adSense');
        }

        return isset(static::$ga_config['auto_ads_enabled']) && static::$ga_config['auto_ads_enabled'] ? true : false;
    }

    public static function getAdSenseAutoAdScript() {
        if (!self::$autoAdsEnabled) return null;

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

    public static function getBlogListingAds() {
        return <<<EOT
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-format="fluid"
             data-ad-layout-key="-fb+5w+4e-db+86"
             data-ad-client="ca-pub-8117292460941523"
             data-ad-slot="7589493133"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
EOT;

    }
}