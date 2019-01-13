<?php
/**
 * public/class-shortcodes.php
 *
 * @link              http://byggvir.de
 * @since             2019.1.0
 * @version 2019.2.0
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @plugin-wordpress
 *
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @package evkj
 */


/**
 * Security check: Exit if script is called directly
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('EVKJ_SHORTCODE_VERSION', '2019.2.0');


require_once EVKJ_PATH . 'public/class-litkalapi.php';

class evkj_ShortCodes {

	public $version;



	/**
	 * Constructor of the class
	 *
	 *
	 * @param NUL
	 */
	public function __construct() {

		$this->version = EVKJ_SHORTCODE_VERSION;

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
					'current' => '',
					'date' => ''
				), $atts));

		(strtolower($size) == 'big') ? $size = 'big' : $size='small';
		($size == 'big') ? $SEP = ' / ' : $SEP = '<br />';

		$API =  new evkj_WidgetAPI();

		if (preg_match('/(Googlebot|bingbot)/', $_SERVER['HTTP_USER_AGENT'])) {
			$innercontent ='
                <div class="lk_widget lk_widget_small">
                <div class="lk_widget_inner">
                <h2>Liturgischer Kalender
                </h2>
                <div class="lk_widget_box">
                <p><span class="evkj-fieldname">Der HERR sprach zu den Bots:</span><br /> Und ich sage euch auch:<br />Bittet, so wird euch gegeben;<br /> suchet, so werdet ihr finden;<br />klopfet an, so wird euch aufgetan<br />
                <a href="https://www.bibleserver.com/search/LUT/suchet/1">Lukas 11,9</a><p>
                </div></div></div>
                ';
		}
		else {
			$innercontent = $API->getday (
				$size,
				$fields,
				$current,
				$date
			);
		}

		$ver= $this->version;
		$Copyright = "
        <div class=\"evkj-copyright\">
        Ein Angebot der <a href=\"https://liturgischer-kalender.bayern-evangelisch.de\" target=\"_blank\">ELKB & VELKD</a>
		$SEP
		Powered by <a href=\"https://github.com/Byggvir/ev-kirchenjahr\" target=\"_blank\">$plungin_name()Ev. Kirchenjahr $ver </a>
		$SEP
		&copy; 2019 Thomas Arend
		</div>
        ";

		return "
        <!-- Begin shortcode Lit. Kalender -->
		<div class=\"evkj-shortcode-$size\">
        $innercontent
		$Copyright
        </div>
        <!-- End shortcode Lit. Kalender  -->
        ";
	}


} // End class

$evkj_ShortCodes = new evkj_ShortCodes();

?>
