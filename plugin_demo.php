<?php
/**
 * Plugin Demo
 *
 * Plugin Demo and single structure
 *
 * @link              http://pisd.com.mx
 * @since             1.0.0
 * @package           Demo
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Demo
 * Plugin URI:        http://pisd.com.mx
 * Description:       Plugin Demo and single structure
 * Version:           1.0.0
 * Author:            Gerardo Correa B.
 * Author URI:        http://pisd.com.mx
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if( !class_exists('demo_plugin') ):

class demo_plugin
{

	
	/*
	*  Constructor
	*
	*  This function will construct all the neccessary actions, filters and functions.
	*
	*  @type	function
	*  @date	23/06/12
	*  @since	1.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	function __construct()
	{
			
		// vars
		$this->settings = array(
			'version'			=> '1.0',
			'upgrade_version'	=> '0.1',
			'include_3rd_party'	=> false
		);
		
		// actions
		add_action('init', array($this, 'init'), 1);/**/
		
		$this->include_before_theme();		
		
	}

	function fix($phpmailer) {
	  	$phpmailer->Sender = $phpmailer->From;
	}
    
        
	/*
	*  include_before_theme
	*
	*  This function will include core files before the theme's functions.php file has been excecuted.
	*  
	*  @type	action (plugins_loaded)
	*  @date	3/09/13
	*  @since	4.3.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	function include_before_theme()
	{	

		// incudes
		include_once('custom_php.php');

	}


	/*
	*  init
	*
	*  This function is called during the 'init' action and will do things such as:
	*  create post_type, register scripts, add actions / filters
	*
	*  @type	action (init)
	*  @date	23/06/12
	*  @since	1.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	function init()
	{
		add_action('phpmailer_init', array( $this, 'fix' ) );
		
		// admin only
		if( is_admin() )
		{
			//Setups for Admin Page
			//add_action('admin_menu', 'users_iels_list_menu');
			
		}
	}


}
	/*
	*  jal_install_demo_plugin
	*
	*  This function create a DB demo
	*
	*  @type	action (init)
	*  @date	23/06/12
	*  @since	1.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	function jal_install_demo_plugin() {
		global $wpdb;
		global $jal_db_version;

		$table_name = $wpdb->prefix . 'demo_users';
		
		$charset_collate = $wpdb->get_charset_collate();
 		
		$sql = "
			DROP TABLE IF EXISTS $table_name;
			CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			nombre text NOT NULL,
			apellidos text NOT NULL,
			email text NOT NULL,
			telefono text NOT NULL,
			estado text NOT NULL,
			escuela text NOT NULL,
			curso text NOT NULL,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'jal_db_version', $jal_db_version );
		
	}
	register_activation_hook( __FILE__, 'jal_install_iels_users' );

	function demo_plugin()
	{
		global $demo_plugin;
		
		if( !isset($demo_plugin) )
		{
			$demo_plugin = new demo_plugin();
		}
		
		return $demo_plugin;
	}


	// initialize
	demo_plugin();


	endif; // class_exists check

?>
