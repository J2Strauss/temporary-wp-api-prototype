<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

/** Project root directory */
define('PROJECT_ROOT', dirname(__DIR__));

/** Environment name */
define('PROJECT_ENV', getenv('SERVER_ENV'));

/** Configuration specific to a local environment, sever environment or default */
if ( file_exists(PROJECT_ROOT . '/config/servers/local.php') ) {

	require PROJECT_ROOT . '/config/servers/local.php';

} else {

	require PROJECT_ROOT . '/config/servers/' . PROJECT_ENV . '.php';
	
}

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpapi_';

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__DIR__) . '/public/site/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
