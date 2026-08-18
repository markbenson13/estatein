<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'estatein' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?$ZNSA^;6zTGA*=|+|uZ<Fb;dO3D3+=.f<~85*-RUn_(!G7C$#4,dSU.Kw//|R[|' );
define( 'SECURE_AUTH_KEY',  'cYH~G>G/:-29fcnwj:_id;V+!j;VDrM{$o qK}5NeF1lJ w/]2GjDjenxK!?bGl1' );
define( 'LOGGED_IN_KEY',    'FtLI]eZ>-{N_l|io,b!Spy$>xo[eTSQKt!!+D/Rgp}y+A8m ~29z@}u~92PJbc:o' );
define( 'NONCE_KEY',        '1@<)3`aZj}D/mGy2ULXc4).onKSPGg+/S-KxN<EI>OK}ttgx^KIkdkZih@jEj*Yf' );
define( 'AUTH_SALT',        '8>KiWaSsSe+Bm.slQ0&f!2SjQ-F`k)||w:2#P3yi6;a5IaasA3!L=dM~jV&ZrPa[' );
define( 'SECURE_AUTH_SALT', 'TZbQWRn;$L(~^*{ff[~$__4?,%J)M>3V;:r@PS,c@Uji>cjz<fTO@X=rU,q%g}<?' );
define( 'LOGGED_IN_SALT',   '>.E>s`~(-1.Xyz8QuY|c`M:`!F</OY?ne.U:u6kj~XtYJjUR5WL$KB koeACTHP#' );
define( 'NONCE_SALT',       'J11EIRRn|#>QeHpy{m+L7$%vZ<YZ7Vf/H{oioJ;1rXi9#T,,4bCNV`B&@T*;cPqH' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
