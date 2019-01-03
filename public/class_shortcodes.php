<?php
/**
 * public/class_shortcodes.php
 *
 * @link              http://byggvir.de
 * @since             v2019.1.0
 * @version v2019.1.0
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @plugin-wordpress
 *
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @package Evkj
 */


/**
 * Security check: Exit if script is called directly
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('SHORTCODE_VERSION','v2019.1.0');


require_once plugin_dir_path( __FILE__ ) . 'class_litkalapi.php';

class Evkj_ShortCodes {
    
    public $version;
    
	/**
	 * Constructor of the class
	 *
	 *
	 * @param NUL
	 */
	public function __construct() {

        &this->version = SHORTCODE_VERSION;
        
        // Add the Shortcode

		add_shortcode( 'litkalender', array($this, 'litkalender') );

	}


	/**
	 *
	 * @param unknown $atts
	 * @return unknown
	 */
	public function litkalender($atts) {


		global $Plugin_Prefix;

		extract(shortcode_atts(array(
					'size' => 'big',
					'fields' => '0,1,5',
					'date' => '',
					'current' => ''
				), $atts));

		$API =  new Evkj_WidgetAPI();
		$MyShortCode = $API->litdayinfo (
			$size=$size,
			$fields=$fields,
			$date=$date,
			$current=$current
		);

		($size='big') ? $SEP = ' / ' : $SEP = '<br />';

		$Copyright = "
        <div class=\"evkj-copyright\">
        Ein Angebot der <a href=\"https://liturgischer-kalender.bayern-evangelisch.de\" target=\"_blank\">ELKB & VELKD</a>
		$SEP
		Powered by <a href=\"https://github.com/Byggvir/ev-kirchenjahr\" target=\"_blank\">Ev. Kirchenjahr 2019.1.0</a>
		$SEP
		&copy; 2019 Thomas Arend
		</div>
        </div>
        ";

		return "
        <!-- Begin shortcode Lit. Kalender -->
		<div class=\"evkj-shortcode\">
        $MyShortCode
		$Copyright
        <!-- End shortcode Lit. Kalender  -->
        ";
	}


} // End class

$Evkj_ShortCodes = new Evkj_ShortCodes();

?>
