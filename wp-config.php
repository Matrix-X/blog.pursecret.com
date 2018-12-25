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
define('DB_NAME', 'pursecret');

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
define('AUTH_KEY',         'BFH=seb*Namp8%M|K<jf.}P&s X~r dMNf~qk#^u:OWpy0rPK):=.(d/=(2EEY6 ');
define('SECURE_AUTH_KEY',  'o.m`mkSv^G0QiYys?n41uYm2lX?_|*zX0AO?RRe=e^0q9:gy1}gI(?)xeOFWQBFM');
define('LOGGED_IN_KEY',    '@GdnNlH:UF;^y(3hFrr>IXf+_9)DL]C]hK`D*3i@`urE-{EtU3)ZA]g1hiD}vslW');
define('NONCE_KEY',        '&g{!U{`u&v(}jVV,C^zuz.7XT]!Po$Uy*p}4*$k9+#1h4CJ3q=7r,np3_73+jOes');
define('AUTH_SALT',        'QsiYRC8=En$9H`4Iz)x+lCf*lCo#aX;@8qUxe`o;m#6qt;!wV:oFXK+*b*?Lm,CH');
define('SECURE_AUTH_SALT', '[ iGmP5z+;O_JG8z;Y`b,tAbpp_Y5 / |T>,ZXZnp}L=aiyB@14CKkG%OedK6zqX');
define('LOGGED_IN_SALT',   ',CU~1Y,S8EjJYma,3;b_duu#v|h_.~np6Vb;z,}{Z($eY#H}VvI:,r.oY3c=]CyS');
define('NONCE_SALT',       '{b0S.~!8>fo}x;p*j{6U>8?96cQc(AV0epNb$?V$nknt|M&ntu/6j;xf}k15K{K.');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ps_';

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
