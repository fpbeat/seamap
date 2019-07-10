<?php

namespace leafTracker\Helpers;

use Noodlehaus\Config;

class Url {

    public static function getBaseUrl($suffix = '') {
        $baseUrl = rtrim(Config::load(DOCROOT . 'config/app.php')->get('baseurl'), '/') . '/';

        return !empty($suffix) ? sprintf('%s%s', $baseUrl, ltrim($suffix, '/')) : $baseUrl;
    }
}