<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 14:01
 */

session_cache_limiter('private, must-revalidate');
session_cache_expire(60);
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

if (getenv('ENV') === false) {
    require_once __DIR__ . '/../config/debug.php';
    require_once __DIR__ . '/../config/db.php';
}
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/routing.php';
