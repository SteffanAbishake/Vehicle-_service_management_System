<?php
define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_7');

/** MySQL database username */
define('DB_USER', 'wordpress_3');

/** MySQL database password */
define('DB_PASSWORD', 'Q08$FzhN6g');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'oVoNS4w5M6pzi3w6OAVoU%ippl#1aQf4^JTVNi5efnxImwKVJjDhzZV8KdEhdE!l');
define('SECURE_AUTH_KEY',  'qimz8C77TlUzn#JGayWll&ZXmIIqzddfb&keZr(rym1M5Mb4ml#XruNArtzXSSbb');
define('LOGGED_IN_KEY',    'Ms9ozrd6J19bCeEeLv6w^k0%PDA55fmiexzvRerfg*AFrwUBt)2ntWONuhKT0%LN');
define('NONCE_KEY',        'zz1AALP%sYB(lK4t7guAb9OyrW3SYFYS9PSTvXKg&!w%iMUM2zjD0B&nHUnoJTsC');
define('AUTH_SALT',        'vVUlWdCqDQdsS%XEnqwjwj*6JRox2eQns^aNvvR7wyC%fEH7&J!LHVzWya@WkQKp');
define('SECURE_AUTH_SALT', '#P*I(@A*4Kcicq3#1kHLQ3KX!s3hwVfPLQy)GHXlxrQ1CjB^M*4)TOqDDlF1Gphe');
define('LOGGED_IN_SALT',   'aHukYKdp8syoMFiZJQClaIhWXRt()IyA&*wohsxGAn%Ara8I7K1AGg6@Y^4MuEkY');
define('NONCE_SALT',       'G%20YK2J5!#hIV4%%XpUojj5S^AB9@BP5zEpGkbJBjKAS6yuDSs(aG!7OvhP7xP&');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
