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
define( 'DB_NAME', 'borderlands' );
/** MySQL database username */
define( 'DB_USER', 'root' );
/** MySQL database password */
define( 'DB_PASSWORD', 'root' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
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
define( 'AUTH_KEY',         '|nMcs-ujcLI`]kqB&y{3l:6#;pj`ZtE0I>$:9$YT4mUT/h.26]XYj{3Sj+a#$u> ' );
define( 'SECURE_AUTH_KEY',  ')avdu,41z*Iz#7)]_dD2>mN[KEgp[|CuJ,rnkLXfmUDb]2fwZUB>6U`=R0n.r$sb' );
define( 'LOGGED_IN_KEY',    'lc9Ts3IN[?S;?Q]H$Hfd-<UMl?re?sc=8+*mGQ4w67Xg.Ew3p/QRDL(9XJVUQCS%' );
define( 'NONCE_KEY',        '=xn#Z3#dxG9f%(Qw`,;/91eYd49Ubn,N_F1_Ji3itE`a7RmP`vUUoX4! k@V`:yz' );
define( 'AUTH_SALT',        'q&@+k85/wklj*dJ8c9FU)l`*x/j;4AiHG<Z$|0rV9bPUZM?dmJm$zm-30T,?%s`{' );
define( 'SECURE_AUTH_SALT', 'c]Gy+zQ`sKjjJFCou.%XN0jgAz(p+h=@7V2]IEFZslyg{:l ~B>xZ9KJ8c~5Yu[w' );
define( 'LOGGED_IN_SALT',   'UenJ)r#<..1$`Zt8?Z<VSh<;u>!]+vAxWc(+}M$,P^0y_*8JY&4Pj(Pb;JReU., ' );
define( 'NONCE_SALT',       '3Qqa813ox[Z~tu&_J$M(J24pTP9yFn*!-CRkrRfzbr32m(CHG&XHWGa~Px)I`A1-' );
/**#@-*/
/**
* WordPress Database Table prefix.
*
* You can have multiple installations in one database if you give each
* a unique prefix. Only numbers, letters, and underscores please!
*/
$table_prefix = '4vxsmn_';
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
