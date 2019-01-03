<?php
/**
 * public/class_widget.php
 *
 * @link              http://byggvir.de
 * @since             2019.0.1
 * @version 2019.0.1
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

require_once plugin_dir_path( __FILE__ ) . 'class_litkalapi.php';

/**
 * Losungen widget for SQL
 *
 */
$evkj_DefLabels =
	array (
	'size' => 'Gr&ouml&szlig;e (small / big)',
	'fields' => '(0 = Wochenpsalm, 1 = Wochenspruch, 2 = Eingangspsalm, 3 = AT-Lesung, 4= Epistel, 5 = Predigttext) ',
	'css' => 'StyleSheet',
	'date' => 'Datum',
	'current' => 'Aktueller = true, kommender Feiertag leer',
	'title' => 'Titel',
	'url' => 'URL https://liturgischer-kalender.bayern-evangelisch.de/widget/widget.php'

);

$evkj_SettingNames =
	array (
	'size' => 'size',
	'fields' => 'fields',
	'css' => 'css',
	'date' => 'date',
	'current' => 'current',
	'title' => 'title',
	'url' => 'url'
);

/*
 ----------------------------------------------------------------
 Default Werte für die Widgets und Shortcodes!

 ----------------------------------------------------------------
*/

$evkj_DefValues =
	array (

	// Geben sie hier die gewünschte Widgetvariante ('small' oder 'big') an.
	'size' => 'big',

	// Geben Sie hier die gewünschten liturgischen Informationen kommasepariert (0 = Wochenpsalm, 1 = Wochenspruch, 2 = Eingangspsalm, 3 = AT-Lesung, 4= Epistel, 5 = Predigttext) an.
	'fields' => '0,1,2,3,4,5',

	// Geben Sie hier eine CSS-Datei an, die im Widget aufgerufen werden soll (z.B. http://www.ihredomain.de/meincss.css).
	'css' => '',

	// Geben Sie hier ein spezifisches Datum an, zu dem das Widget Daten anzeigen soll
	'date' => '',

	// Geben Sie hier ein 'true' ein, wenn das Widget den aktuellen statt den kommenden Feiertag anzeigen soll
	'current' => '',

	// Titel de Widget
	'title' => 'Kirchenjahr evangelisch',

	// Url für den Download des Liturgischen Kalenders
	'url' => 'https://liturgischer-kalender.bayern-evangelisch.de/widget/widget.php'

);

class evkj_Widget extends WP_Widget {

	/** constructor */
	function __construct() {
		parent::__construct(
			/* Base ID */ 'evkj_widget' ,
			/* Name */ 'Kirchenjahr evangelisch' ,
			array( 'description' => 'Zeigt die Informationen zum nächsten Feiertag an.' ) );
	}


	/**
	 *
	 * @see WP_Widget::widget
	 * @param unknown $args
	 * @param unknown $instance
	 */
	function widget( $args, $instance ) {

		global $evkj_DefValues, $evkj_DefLabels ;

		$wg_atts = $args;

		foreach ( $instance as $key => $value) {
			$wg_atts[$key] = trim(empty($instance[$key]) ? $evkj_DefValues[$key] : $instance[$key]);
		}
		$wg_atts['title'] = apply_filters('widget_title', $wg_atts['title']);

        $API = new Evkj_WidgetAPI();
        
		echo "<div class=\"evkj-widget\">";
        print $API-> litdayinfo ( 
            $size=$wg_atts['size'],
            $fields=$wg_atts['fields'],
            $css=$wg_atts['css'],
            $date=$wg_atts['date'],
            $current=$wg_atts['current'],
            $url = $wg_atts['url'],
            $bodyonly=true);

		print "
		<div class=\"evkj-copyright\">Ein Angebot der <a href=\"https://liturgischer-kalender.bayern-evangelisch.de\" target=\"_blank\">ELKB & VELKD</a>
		<br />Powered by <a href=\"https://github.com/Byggvir/ev-kirchenjahr\" target=\"_blank\">Ev. Kirchenjahr 2019.0.0</a><br/>&copy; 2019 Thomas Arend<br /></div>
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

		global $evkj_DefValues, $evkj_DefLabels ;

		$instance = $old_instance;
		foreach ( $evkj_DefValues as $key => $value ) {
			$instance[$key] = strip_tags($new_instance[$key]);
		}

		return $instance;
	}


	/**
	 *
	 * @see WP_Widget::form
	 * @param unknown $instance
	 */
	function form( $instance ) {

		global $evkj_DefValues, $evkj_DefLabels ;

		if ( $instance ) {
			$instance = wp_parse_args( (array) $instance, $evkj_DefValues );
			foreach ( $evkj_DefValues as $key => $value ) {
				$$key = esc_attr( $instance[ $key ] );
			}
		}
		else {
			foreach ( $evkj_DefValues as $key => $value ) {
				$$key = __( $value , 'text_domain' );
			}
		}
		echo '<p>' ;

		foreach ( $evkj_DefValues as $key => $value ) {
?>

	<label for="<?php echo $this->get_field_id($key); ?>"><?php _e($evkj_DefLabels[$key].':'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo $$key; ?>" />

	<?php
		}
		echo '</p>' ;

	}


} // class evkj__Widget

// register evkj__Widget

add_action( 'widgets_init', create_function( '', 'register_widget("evkj_Widget");' ) );

?>
