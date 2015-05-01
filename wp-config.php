<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ellawher_wp');

/** MySQL database username */
define('DB_USER', 'ellawher_wp');

/** MySQL database password */
define('DB_PASSWORD', ':XP(Y5QX');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'U1DdwyZAzl_E2LpSRf9MVErDMqzwGLqwekJg5Qu7zkNtSv3X7zP0krBTHIo15s6E');
define('SECURE_AUTH_KEY',  '0Z8Uab6zDLx9Mck8W24izQVpjKGzI8HXlh_bTZspgHf97Kyyv0ta5LheY_m75QbZ');
define('LOGGED_IN_KEY',    'Uze9ruKEr7HCOoSZzQUwylhX5ehKZaD9VfTfckAKAA3Cz2nMKGLSYQnstFhtQona');
define('NONCE_KEY',        'UVU4Ke6mT54HovbjFDFeJopRs_UUCShNyLufQGE2VqHqz_OJxBoWsBoEFvsyXDy6');
define('AUTH_SALT',        'p3yPWkw5n9gCwIybQIUUwuSTpw_84k3moSIHZh1hhFp8S9dRcBGwdeUNVZwvykQe');
define('SECURE_AUTH_SALT', 'AXDcOfqVRIjsb2RaB080h8ORAiw78jm4TS0V_uOOduCP07nIyhYsOnk9Xy8KMsPL');
define('LOGGED_IN_SALT',   'muoFuxaXp3AY6VFYWAtl7CGx1KyrphXmipxrI97MjL3LrtyU7hIuMwWyCeh6tZ8w');
define('NONCE_SALT',       '6lRehYIMpyP6A0Mev0Waqrdc3kKiTlknIOcsEBQdhnjRJrld6k42cwT7cIWUvpju');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
