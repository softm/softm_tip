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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         ';vPdl]WrU&x/E0U;&}[F:j%2JIhYf@KA~(Vc%tNoOi;Zx$pX-::KWzg,V.[6Fv2}');
define('SECURE_AUTH_KEY',  ']CkAgRKF7A++,!1`M4FtoOw@CPTZbFv,!wi9y2 !w7|!.>+;K9_[1*bHv&KrE[&P');
define('LOGGED_IN_KEY',    'C[)EkD(4}X0%_srb.a-GM;}$@zdeE7q&H lQw{yqOo J3J;NF` Y~2`;g/8;u3ik');
define('NONCE_KEY',        'oMC=/[U3^}_oTOj[crCJ=UW.Zn?s#]gLP$p?ZX~i]EW8y;Lcowf}X`RTQoS!fC5Z');
define('AUTH_SALT',        'H<0yc$lcYOx5,[|_syA,?@TVDR#~lafg .,L-N1%[?@T`%7/P,#JOKph(EzG$6%6');
define('SECURE_AUTH_SALT', 'o*[lS!3#-iF/4~{Nm+}P>2=oKWr_6UvS1EN:UE}`Z,@{y#nu[BF,[Y]6?Gy.GhB5');
define('LOGGED_IN_SALT',   '0Iv0f/O>%!$NG&wQ;a44{CgGt4+~DW!A u?0eUIa8s@%7Vmmd#9L5/=4FVTbUV|u');
define('NONCE_SALT',       '&82zF!P:/roWnaQnF/]%dWgz9F.eL(fej{h>xP]f([fIEb$`Z|`%Ih98V~f,./yG');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'ko_KR');

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
