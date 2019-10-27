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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'eD|Za:+H|eC(H` -61bKdBC&J0Se{IQn&<4h>PNk}?^u)x3]l4JLez$iV} GA[!,');
define('SECURE_AUTH_KEY',  '@GptZH>p+T4-1M=E0M i[dcO2^rUAobAP_d2jY<x*fR[Xe_Pd {6fvb~(uRN`%Tm');
define('LOGGED_IN_KEY',    'yN=D  Hn]cXdor.w>OI+a]iX*6){)lLEuVH<MK&CS;9&1{7O?1Zn$3e4Pf>.1yGN');
define('NONCE_KEY',        'v+2!_QIVap3wUCyjr*~M6jUPOcF~)tP0,T!T)<YR]%D4}W kH0[=RbE PPb63xjE');
define('AUTH_SALT',        'F)3?B9pQoS4D1?Yi-~!c*i{o8Ne8Z:er9Q.~aTZt^eMoP 6S= kmG!m03<DV_33G');
define('SECURE_AUTH_SALT', 'y7ZA-Z,f2M0F8GewTWH*2Y.>d vmj$jO2!N_qiY|M+[`/4i?BracMq[Kgo(]*JfO');
define('LOGGED_IN_SALT',   'A&^B[(p#e7QPbT}Cx.Z?hRR1Hy9?Dnc6nm7M7A///dF/+0 ^W&S~HNkzG 4b*[Fv');
define('NONCE_SALT',       'w3F(NjSG1+a9SLAKD-,4:=4Y(?Xn|m|KPiKC][xm|5dGv-s=#rj)?$z!Q3ym,%Qo');

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
