<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://byggvir-de
 * @since      2910.3.0
 *
 * @package    Evkj
 * @subpackage Evkj/admin
 * @author     Thomas Arend <thomas@arend-rhb.de>
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * Init the setings page
 *
 * @package    Evkj
 * @subpackage Evkj/admin
 * @author     Thomas Arend <thomas@arend-rhb.de>
 */
 
class Evkj_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */

	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    private $EVKJ_BibelLink;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->EVKJ_BibelLink = array (
            'URL' => 'https://www.bibleserver.com/text/%s/%s',
            'Translation' => 'LUT'
        ); 
        add_action('admin_init', array(&$this, 'admin_init'));
		add_action('admin_menu', array(&$this, 'add_menu'));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Evkj_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Evkj_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/evkj-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Evkj_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Evkj_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/evkj-admin.js', array( 'jquery' ), $this->version, false );

	}

		/**
		 * hook into WP's admin_init action hook
		 *
		 */
	public function admin_init() {

 
			// register your plugin's settings


		foreach ($this->EVKJ_BibelLink as $key => $value) {
			register_setting('evkj_group', EVKJ.$key, array( 'string', $key, '', false, $value));
		}

		add_settings_section(
			'evkj_Link',
			'Bibel Links',
			array(&$this, 'settings_section_link'),
			'evkj_kirchenjahr'
		);

		// add your setting's fields

		foreach ($this->EVKJ_BibelLink as $key => $value) {
			add_settings_field(
				EVKJ.$key,
				$key,
				array(&$this, 'settings_field_input_text'),
				'evkj_kirchenjahr',
				'evkj_Link',
				array(
					'field' => EVKJ.$key
				)
			);
		}

		// Possibly do additional admin_init tasks


	} // END public static function activate

		/**
		 * These functions place text after the title of the setting section
		 *
		 */
	public function settings_section_link() {

		// Think of this as help text for the section.
		echo "\n<p>Hier k&ouml;nnen die Vorgabewerte für die Links zur Bibelstelle auf einem Bibelserver angepasst werden.</p>";
	}

	/**
	 * This function provides text inputs for settings fields
	 *
	 *
	 * @param unknown $args
	 */
	public function settings_field_input_text($args) {
        // Get the field name from the $args array
		$field = $args['field'];

		// Get the value of this setting
        
        $def = $this->EVKJ_BibelLink[substr($field,strlen(EVKJ))];
        $value = get_option($field,$def);
        $len = strlen($value)+5;

        // echo a proper input type="text"
		echo "\n" . sprintf('<input type="text" name="%s" id="%s" value="%s" size="%s" /S>', $field, $field, $value, $len);

	} // END public function settings_field_input_text($args)

	/**
	 * add a menu
	 *
	 */
	public function add_menu() {
		// Add a page to manage this plugin's settings
		add_options_page(
			'Kirchenjahr evangelisch',
			'Kirchenjahr',
			'manage_options',
			EVKJ.'kirchenjahr',
			array(&$this, 'plugin_settings_page')
		);

	} // END public function add_menu()

	/**
	 * Menu Callback
	 *
	 */
	public function plugin_settings_page() {
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}

		// Render the settings template
		include sprintf("%s/setting-template.php", dirname(__FILE__));

	} // END public function plugin_settings_page()

} // end Class
