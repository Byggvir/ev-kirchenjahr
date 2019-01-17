<?php

/**
 * Fired during plugin activation
 *
 * @link       https://byggvir-de
 * @since      1.0.0
 *
 * @package    evkj
 * @subpackage ev-kirchenjahr/includes
 * @author     Thomas Arend <thomas@arend-rhb.de>
 */

/**
 * Security check: Exit if script is called directly
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' ) ;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2019.2.0
 * @package    evkj
 * @subpackage ev-kirchenjahr/includes
 * @author     Thomas Arend <thomas@arend-rhb.de>
 */
class evkj_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	global $wpdb;

        $charset_collate = $wpdb->get_charset_collate() ;
        
        $table_name = $wpdb->prefix . EVKJ_CACHETAB ;

        $sql = "
CREATE TABLE `$table_name` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `cachetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reqdate` date NOT NULL DEFAULT '0000-00-00',
  `litdate` date NOT NULL DEFAULT '0000-00-00',
  `nextdate` date NOT NULL DEFAULT '0000-00-00',
  `litname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nextname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `litfarbe` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nextfarbe` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `wochenvers` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `wochenspruch` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `wochenpsalm` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `wochenlied` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `eingangspsalm` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `atlesung` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `epistel` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `predigttext` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `evangelium` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `liturgischefarbe` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `xcachedate` (`cachetime`),
  KEY `xreqdate` (`reqdate`),
  KEY `xlitdate` (`litdate`),
  KEY `xnextdate` (`nextdate`)
) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' ) ;
        dbDelta( $sql ) ;
    
	}

}
?>
