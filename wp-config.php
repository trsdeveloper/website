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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'technqp8_WPROC');

/** MySQL database username */
define('DB_USER', 'technqp8_WPROC');

/** MySQL database password */
define('DB_PASSWORD', 'f{yF.lQHP)yGqaU?s');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '02a97ee2d3c72ba33164a09316bcfa550083caa12fd70cb30c6a57375a557cc7');
define('SECURE_AUTH_KEY', '8a621699e45712a8fb5d641a265ed9ce6742f5aa2469104da8658a347edb392a');
define('LOGGED_IN_KEY', 'bd4dad23b855da1adbc70571752bdd0a28bcb4ecb8e32420a1d83e66455fff62');
define('NONCE_KEY', '0e594073a0666c2e70d1dd6fc3cc2d7cfc3fa29ad1388fcb99f744f74d6909b5');
define('AUTH_SALT', '38f04a0401e6dad9b24ee4869499e33a02466d6b7541d1fa1317bc9391e6eac4');
define('SECURE_AUTH_SALT', '1e53ab8ef0fa3408c5544075a02c8ef94035682c545904d06ba5a673da3979b0');
define('LOGGED_IN_SALT', '032475422f13a03eca2fcdb0ee0f9e17245aa44f2fcd92504292553edbdbe33a');
define('NONCE_SALT', 'cc9319178be04b6acf00885503a2d348481d1f5cbdeb371c999e6699ffcdf735');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'q1n_';
define('WP_CRON_LOCK_TIMEOUT', 120);
define('AUTOSAVE_INTERVAL', 300);
define('WP_POST_REVISIONS', 5);
define('EMPTY_TRASH_DAYS', 7);
define('WP_AUTO_UPDATE_CORE', true);

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
