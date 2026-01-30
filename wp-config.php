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
define( 'DB_NAME', 'heiploi' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'N_{,{bBUfRIU[XXZXqa9+9o&9)2`PvxNV`*7~s<==dq4-#/TN-@93^X`bUQhl*m#' );
define( 'SECURE_AUTH_KEY',  'AK!=|)[C_=l{+=F ~UIxbg$6w8sO{Lz^^ r1,m%FjVF[LkY1N%oJM35K|VfaHk6E' );
define( 'LOGGED_IN_KEY',    'YX|4m]dS&Ru{ 1K|8(vVp^M[w}%7z-iRg;!3XA<2KR1iN62K{(ygEf!F!~7/ Tfg' );
define( 'NONCE_KEY',        'tsm5OORV--z! fEiDtJ+:3)Oa{Ke&t-9MF@>`B 6d>{z~f8!#9phFNZB0jX om0p' );
define( 'AUTH_SALT',        '&Nh!maTW^7K%Bct HXnsBB6k2uq:K9]J&Gex*2Xx^Thmqpw4^Tot>FRO.t2.Bs[n' );
define( 'SECURE_AUTH_SALT', '!0RA^sVo-&%2$q5@#vcY$*#Pu!/$jG_E{J<_@;_X[`Ay5~e[O`CVxF-J]z0^ituu' );
define( 'LOGGED_IN_SALT',   'dDv3j409,PsA#j*1KD>!P2T^q$qV/:ZwimLMF{jNu=ey).R4#rYNJp+b`8j -zEk' );
define( 'NONCE_SALT',       'w`9M.&u!;/8#4c2+IakSUmUXer2umJxsE=bG-Q#6*uk[++X-N:+6KbL,5r@iRXlm' );

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
