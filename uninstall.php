<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://byggvir-de
 * @since      2019.2.5
 *
 * @package    Evkj
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

define( 'EVKJ_CACHETAB' , 'evkj_cache' ) ;

function evkj_delete_table () {
        global $wpdb;
        $tcache = $wpdb->prefix . EVKJ_CACHETAB ;
        $toptions = $wpdb->prefix . 'options';

        $wpdb->query( "DROP TABLE IF EXISTS $tcache;" );
        $wpdb->query( "DELETE FROM  $toptions where option_name regexp \"evkj_\";");
}

evkj_delete_table();

?>
