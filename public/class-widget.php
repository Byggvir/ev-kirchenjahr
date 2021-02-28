<?php
/**
 * public/class-widget.php
 *
 * @link              http://byggvir.de
 * @since             2019.0.1
 * @version 2019.3.2
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @plugin-wordpress
 *
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @package           Ev-Kirchenjahr
 */


/**
 * Security check: Exit if script is called directly
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once EVKJ_PATH . 'public/class-litkalapi.php';

/**
 * Losungen widget for SQL
 *
 */
$evkj_WidgetLabels =
	array (
	'size' => 'Gr&ouml&szlig;e (small / big)',
	'fields' => 'Felder: 0 = Wochen&shy;spruch, 1 = Wochen&shy;psalm, 2 = Eingangs&shy;psalm, 3 = AT-Lesung, 4= Epis&shy;tel, 5 = Predigt&shy;text, 6 = Evan&shy;gelium, 7 = Wochen&shy;lied, 8 = litur&shy;gische Farbe,  9 = Wochen&shy;spruch (Text)) ',
	'current' => 'Aktueller = true, kommender Feiertag leer',
	'date' => 'Datum',
	'title' => 'Titel'

);

$evkj_WidgetSettingNames =
	array (
	'size' => 'size',
	'fields' => 'fields',
	'current' => 'current',
	'date' => 'date',
	'title' => 'title'
);

/*
 ----------------------------------------------------------------
 Default Werte für die Widgets und Shortcodes!

 ----------------------------------------------------------------
*/

$evkj_WidgetDefValues =
	array (

	// Geben sie hier die gewünschte Widgetvariante ('small' oder 'big') an.
	'size' => 'big',

	// Geben Sie hier die gewünschten liturgischen Informationen kommasepariert
	// 0 = Wochenpspruch, 1 = Wochenpsalm, 2 = Eingangspsalm, 3 = AT-Lesung, 4= Epistel,
	// 5 = Predigttext, 6 = Evangelium ,7 = Wochenlied , 8 = liturgische Farbe als Text 9 = Wochenspruch (als Text)
	// an.
	'fields' => '3,4,5,6,7,9',

	// Geben Sie hier ein 'true' ein, wenn das Widget den aktuellen statt den kommenden Feiertag anzeigen soll
	'current' => '',

	// Geben Sie hier ein spezifisches Datum an, zu dem das Widget Daten anzeigen soll
	'date' => '',

	// Titel de Widget
	'title' => 'Kirchenjahr evangelisch'


);

class evkj_Widget extends WP_Widget {

	public $version;

	/** constructor */
	function __construct() {
		parent::__construct(
			/* Base ID */ 'evkj_widget' ,
			/* Name */ 'Kirchenjahr evangelisch' ,
			array( 'description' => 'Zeigt die Informationen zum nächsten Feiertag an.' ) );
		$this->version = EVKJ_VERSION ;
	}

	/**
	 *
	 * @see WP_Widget::widget
	 * @param unknown $args
	 * @param unknown $instance
	 */
	function widget( $args, $instance ) {

		global $wpdb, $evkj_WidgetDefValues, $evkj_WidgetLabels, $evkj_WidgetSettingNames ;

		$wg_atts = array (
            'size' => 'big',
            'fields' => 'max',
            'current' => '',
            'date' => '',
            'title' => 'Kirchenjahr'
            );
            
		foreach ( $instance as $key => $value) {
			$wg_atts[$key] = empty($instance[$key]) ? trim($evkj_WidgetDefValues[$key]) : trim($instance[$key]);
		}
		
		$wg_atts['title'] = apply_filters('widget_title', $wg_atts['title']);

		$API = new evkj_WidgetAPI();

		$innercontent = $API->getday(
				$wg_atts['size'],
				$wg_atts['fields'],
				$wg_atts['current'],
				$wg_atts['date'],
				true);

		$v= $this->version;
		$title = $wg_atts['title'] ;

		print "
        <div class=\"evkj-widget\">
        <h3 class=\"evkj-widget-title\">$title</h3>
        $innercontent
		<div class=\"evkj-copyright\">Ein Angebot der <a href=\"https://liturgischer-kalender.bayern-evangelisch.de\" target=\"_blank\">ELKB & VELKD</a>
		<br />Powered by <a href=\"https://github.com/Byggvir/ev-kirchenjahr\" target=\"_blank\">Ev. Kirchenjahr $v</a><br/>&copy; 2019 Thomas Arend</div>
		</div>
		";

	}

	/**
	 *
	 * @see WP_Widget::update
	 * @param unknown $new_instance
	 * @param unknown $old_instance
	 * @return unknown
	 */
	function update( $new_instance, $old_instance ) {

		global $evkj_WidgetDefValues, $evkj_WidgetLabels ;

		$instance = $old_instance;
		foreach ( $evkj_WidgetDefValues as $key => $value ) {
			$instance[$key] = strip_tags($new_instance[$key]);
		}
		// ToDo Check input
		// $instance['fields'] = preg_replace('#[0-9](,[0-9])*.*#', '$1', $instance['fields']);
		return $instance;
	}

	/**
	 *
	 * @see WP_Widget::form
	 * @param unknown $instance
	 */
	function form( $instance ) {

		global $evkj_WidgetDefValues, $evkj_WidgetLabels ;

		if ( $instance ) {
			$instance = wp_parse_args( (array) $instance, $evkj_WidgetDefValues );
			foreach ( $evkj_WidgetDefValues as $key => $value ) {
				$$key = esc_attr( $instance[ $key ] );
			}
		}
		else {
			foreach ( $evkj_WidgetDefValues as $key => $value ) {
				$$key = __( $value , 'text_domain' );
			}
		}
		echo '<p>' ;

		foreach ( $evkj_WidgetDefValues as $key => $value ) {
?>

	<label for="<?php echo $this->get_field_id($key); ?>"><?php _e($evkj_WidgetLabels[$key].':'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo $$key; ?>" />

	<?php
		}
		echo '</p>' ;

	}


} // class evkj_Widget

// register evkj_Widget

add_action( 'widgets_init', function () { return register_widget("evkj_Widget");} );

?>
