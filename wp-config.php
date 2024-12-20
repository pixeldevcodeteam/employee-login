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
define( 'DB_NAME', 'cnlogin_db' );

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
define( 'AUTH_KEY',         ']{RdBLEsiu.`&q?BqIA.4}nS2J:OUR:A?q-2+9[JikGS9N.$`_+^f=F+=x1uV?b]' );
define( 'SECURE_AUTH_KEY',  'HuOlpe4q3;TM>zGsdHR6^,4AMhuX_0#vp`6ir_tduQ]zp- S<pb#P[:p909;3)5 ' );
define( 'LOGGED_IN_KEY',    '+C);AM+vQ&a0tg`nbFMs2bi.XmG3r3I$8Rn&*QX2xfv Y<c?ga|!oxXR$3NPWAT>' );
define( 'NONCE_KEY',        '.C=+^w[-oNvz{<7@T#Kk~PW<5aid&1jr66Q7JKY}ba-B].}j#t;>3Q.>DLF(88Y(' );
define( 'AUTH_SALT',        'K+`UrrbL%%^V0&1cL>C6=@v;+1)5Mw<&u{!%;/ec}xyBzhp9%~x#bk&&lqg8V{}K' );
define( 'SECURE_AUTH_SALT', 'u]o2wWY*an4/#f0=<xG&v:r1{T%J^g!P@_t%^ErhbvmF$mP4=Y]M);TZS+Gp/jan' );
define( 'LOGGED_IN_SALT',   'NC$=tM2QCGrhxgzri!_`lEwfg)-t-,P0-Aa(/{qr[;pQG%kZaKlMj#]Q/IA1+Nj ' );
define( 'NONCE_SALT',       'i/0w]4GDvpa/d8n,[p+6 nwm]sy-Z__F6a^z<9c,jDg_] CV-8bowdi2#u[{kZPE' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
define( 'WP_DEBUG', true );
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


define('AUTOMATIC_UPDATER_DISABLED', true);