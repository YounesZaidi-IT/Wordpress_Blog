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
define('DB_NAME', ‘wordpress1’);

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', ‘root’);

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
define('AUTH_KEY',         '+9:gRjd_kA 1 m| A!b}-^=F3;yzcv;`V-cARi+ym&ToF?nRtY#fZ+{{azNb,QLg');
define('SECURE_AUTH_KEY',  '%;>c|% Mr=t_MR+S}Q[#.q69?eazp}tA^a_fL=>7ExP)q|1 aQysUrL>B_:92wv@');
define('LOGGED_IN_KEY',    'qHwF#Pqh|qX44@WJEGVb/XvdG-T&)]J[OAE:qp^IyW76V.}DSKUux8fUXcDkS.7>');
define('NONCE_KEY',        'f}@7>v{i4SYNpL%:ZD#F. yAjjFk?]ue9AStqW2Pi@f2YYX2;K(yJy;w=e/Wx4E;');
define('AUTH_SALT',        'ZGf*H!PE0|DZ;.c:r@@}?@Y$D{hR)5t!Ip{PSLbvw:bW=Zwubl,1AuZ3F2(.l4 D');
define('SECURE_AUTH_SALT', 'rlfYn.J1^V>}s9=-qVq:T39fj+BoXpI<#!@<vSPYfd#@{YDSqGk5B&I1T&PQcONN');
define('LOGGED_IN_SALT',   '}T*{,=icQFM-k.Whq`<=7Z).R_bD-}2!>bm2$8SZ9k{:mTA-.`Rs8XA>nvR@4WmK');
define('NONCE_SALT',       '=`%ilzu8DSss|,{/uQ:U$NP^W|ht!RIy%Fiy4<$v@gavG2%vur3_J!4[3rk]PkTw');

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
