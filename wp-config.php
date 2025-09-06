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
define( 'DB_NAME', 'portfolio' );

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
define( 'AUTH_KEY',         '(B]KP d>]_(<mK0C~q7@af#_(UHW,v3o(Fz2X=,6eOJY<G+nrb5*XjX9wtjUwQIa' );
define( 'SECURE_AUTH_KEY',  ' 6TnC136< HMH.rN);+-T$1^x3F@,2 [[X*[H;hpP=l#y{HMvs-g{N9#!y{x>x0G' );
define( 'LOGGED_IN_KEY',    'Gk9ELUI`_:UKVzW*@<gl~N}ky~1Lt7T@gu,*!cr26>~^Wziy`?7BG.YM;Bi(NTi^' );
define( 'NONCE_KEY',        'm[LNO3x83]Ryw>~^2 z$$P3AtvqmAHiLcPqpwGIu-YQ?!3x0(s?_$E)>jssHR~v*' );
define( 'AUTH_SALT',        '`~E2ax&{7)a5,:5U%3KidJyP|Y1x6YXi*3h{sz)N|KBI+^7{&qqRT;,E{aB:!zPz' );
define( 'SECURE_AUTH_SALT', 'n5c(Fn6,SldPoz(f]J~WkUB}My evp|~~o-xg?-L?M^xm o$eX}>uic*<GgoFJ8(' );
define( 'LOGGED_IN_SALT',   'H)WSkn_BVP_R#%0Uu1=C1mdBma9ahC3myCeIz_(}8teUv!oZ9-gK4Zd!`j/j7ACa' );
define( 'NONCE_SALT',       '8M4^~?A=p~`nyS|6A992#X//&AMk21c+Z28`.k,UerGMy{n/4S*`l}b,skl2=q)=' );

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
