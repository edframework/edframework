<?php

/**
 * Web Root pour la base de redirection
 */
define('WROOT', 'http://localhost/EdFramework-1.0/'.$lang);
/**
 * Variable pour l'inclusion de fichiers
 */
define('RES', '/EdFramework-1.0');

/**
* Constante de langue
*/

define('LANG' , $lang);
/**
 * Email du site web
 */
define('EMAILDUSITE', 'conanedogawa595@gmail.com');

/**
 * Ensemble des bases de données à utiliser sur le site
 */
define("DATABASE", array(
        'db' => array(
            'DATABASE' => 'mysql',
            'HOST' => '127.0.0.1',
            'PORT' => '3306',
            'DATABASE_NAME' => 'concourstv5',
            'LOGIN' => 'root',
            'PASSWORD' => ''
        )
    )
);

/**
 * Base de données par défaut
 */
define("DEFAULT_DATABASE" , "db");

/**
 * Condordance erreur class CSS.
 * Donc une erreur flash se traduira par la class CSS danger
 */
define("MESSAGES" , array(
    'error' => 'danger',
    'warning' => 'warning',
    'success' => 'success',
    'info' => 'info',
));

/**
 * Salt pour le cryptage SHA512 et SHA256
 */
define('SHA_KEY', '103db4dc6a7b4e0db5aabd1b1ee955b7');

/**
 * URL_CASE_SENSITIVE <=> false si ED == ed
 * URL_CASE_SENSITIVE <=> true si ED != ed
 */
define('URL_CASE_SENSITIVE', false);
