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
define('DB_NAME', 'stefania');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'FhLM(OA3GQ|aO2J+YP.NVb#-/4jC&ZM0y9rJtoxnsqN>GF#I|-crtz0H3)#o*|jD');
define('SECURE_AUTH_KEY',  'L/=RlQS.-+SS1+;WjdGNwGN7q^ ou+B;J)Rxm,uWVN=K,mcNXD 7hHmlRBHy;U~h');
define('LOGGED_IN_KEY',    ';h|Miqd+tp.$>%!HdALEK/l@vbMoH+!k?UT6-`E}4!lb&XI~V8/cuXYC^`W;oU:j');
define('NONCE_KEY',        't7?1/_ba7^hlUH2#{ T-)~B/ W6me>Ayj*/PTQ)_wa#:[At;g#D{[G+$aj<F|M+f');
define('AUTH_SALT',        'bK-7L?]wPf=*uOrjNcwy`F0r-m@`Ut/pD:mF5{LaR:*[+#Mb2GHTWk@#6HloaU{@');
define('SECURE_AUTH_SALT', 'oYx@R?;`lTP*p_~6-K|4fKrG5).e3ApfQg8QftOge-a;+PFG{YrI$q`-2<:|H-Hz');
define('LOGGED_IN_SALT',   '.!kcKQzW8EC])x_%)1`](0xeaT(ObW|!exrDvV#p1K{&&?{+z-V?Jy7NjAi4*p`4');
define('NONCE_SALT',       ',f-$M9ha[A?Z_ v]rk;;7|X1d0)7?__5zS8{}ZDGibCFed>$Ntz@5:nzx9U^inp8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_izzo_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
