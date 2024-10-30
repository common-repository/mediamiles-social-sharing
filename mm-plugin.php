<?php
/**
 * Plugin Name: MediaMiles
 * Plugin URI: https://mediamiles.net/plugin
 * Description: Free plugin enables websites to offer their users MediaMiles on any of their pages by displaying the MediaMiles sharing toolbar. Users earn one MediaMile for each unique visit back from links shared using the toolbar.
 * Version: 6.0
 * Author: MediaMiles Network by Laudd, Inc.
 * Author URI: https://mediamiles.net
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
 
 class MMPlugin
 {
   function __construct() 
   {		  
		//Activate Plugin
		register_activation_hook(__FILE__, array($this, 'mmPlugin_activate'));
		
		//Calling Function Insert Menu Under Tools	
			add_action('admin_menu', array($this,'create_registration_form'));
								
		//Calling Function add Script In Head.
			add_action('wp_head', array( $this, 'register_plugin_scripts' ));
		
		//Calling Function add Style Sheet In Head.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
			
		// Call Redirect Function	
			add_action('admin_init', array($this, 'srpt_plugin_redirect'));
			
		// Add WP Ajax action for Site ID Check
			add_action('wp_ajax_check_mediamiles_site_id_status', array($this, 'check_mediamiles_site_id_status'));
			
		// Deactivate MediaMiles Plugin For Blank Site Id
			add_action('admin_head', array($this, 'deactivate_mediamiles_for_blank_site_id'));
		// Adding a setting link Under Plugin Name
			$plugin = plugin_basename(__FILE__); 
	
		if(strlen(get_option('mediamiles_siteid'))>0)
		{		
			//Calling Function to Run Code in Single.PHP file
				add_filter('the_content', array( $this,'mediamiles_add_to_content')) ;
			
				
			//Calling Function add tool bar option for single post 
				add_action( 'add_meta_boxes', array($this, 'my_custom_field_checkboxes' ));
				add_action( 'save_post', array($this,'my_custom_field_data' ));
			
			//Calling Function to create Short Code for MediaMiles Toolbar	
				add_shortcode( 'MediaMilesToolbar', array($this, 'mediamiles_toolbar') );
				

			//Code For Deactivation 
				register_deactivation_hook( __FILE__, array($this, 'deactivate_plugin' ));
				
		}
   }
   
	function processOption($varName)
    {
   			$x = get_option($varName);
   			if ($x !== FALSE) {
   				update_option($varName . '_old', $x);
   			}
   			delete_option($varName);
    }
   
   //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Deactivation Code Of plugin
	   function deactivate_plugin()
	   { 
			$this->processOption('mediamiles_siteid');
			$this->processOption('mediamiles_activated');
	   }
	
   
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Creating registration page for MediaMiles   
	   function mmPlugin_activate()
	   {
			update_option('srpt_activation_redirect', true);			
			update_option('mediamiles_activated', true);
	   }
	   function srpt_plugin_redirect() 
		{
			if( strlen( get_option( 'srpt_activation_redirect' ) ) > 0 && strlen( get_option( 'mediamiles_activated' ) ) > 0 && !strlen( get_option('mediamiles_siteid') ) > 0 ){
			
					$srpt_url = admin_url( 'tools.php?page=Register-MediaMiles', 'http' );
					if (get_option('srpt_activation_redirect', false))
					{
						delete_option('srpt_activation_redirect');
						wp_redirect($srpt_url);
					}
				}
		}
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Creating registration page for MediaMiles
	   function create_registration_form()
	    {
			if(!strlen(get_option('mediamiles_siteid'))>0)
			{
				// Registration form
				$page = add_submenu_page( 'tools.php', 'MediaMiles Registration ', 'MediaMiles Registration', 'manage_options', 'Register-MediaMiles', array($this,'register_mediamiles') );
				add_action( 'admin_print_styles-' . $page, array($this, 'register_plugin_styles' ));	
				add_action('admin_print_scripts-' . $page, array($this, 'add_plugin_scripts'));
				
			}
			
			// Thank you Page
			$page = add_submenu_page( NULL, 'MediaMiles Thankyou', 'MediaMiles Thankyou', 'manage_options', 'MediaMiles-Thankyou', array($this,'mediamiles_thankyou') );
			add_action( 'admin_print_styles-' . $page, array($this, 'register_plugin_styles' ));	
			add_action('admin_print_scripts-' . $page, array($this, 'add_plugin_scripts'));
	    }
  
  //--------------------------------------------------------------------------------------------------------------------------------------// 
   // Code for Creating Registration Menu
	   function register_mediamiles()
	   {	
				require_once('html/registration_form_html.php');
	   }
	   
  //--------------------------------------------------------------------------------------------------------------------------------------// 
   // Code for Creating Registration Menu
	   function mediamiles_thankyou()
	   {
			require_once('html/thankyou_html.php');
	   }   
	   
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Style Sheet In Head.
		public function register_plugin_styles()
		{	
			if( is_single() || is_admin()){
				wp_register_style( 'mediamiles-css', plugins_url( '/css/mm-plugin.css', __FILE__ ) );
				wp_enqueue_style( 'mediamiles-css' );
			}
		}
		 
	//--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Scripts In Head.
		public function add_plugin_scripts()
		{	
			wp_register_script( 'mediamiles-js', plugins_url( '/js/mm-plugin.js', __FILE__ ) );
			wp_enqueue_script( 'mediamiles-js' );
		}
		
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Script In Head.
		public function register_plugin_scripts()
		{
			
			if(!is_home()){
				$site_id = get_option('mediamiles_siteid');
				echo "<script>(function(){
								var ld = document.createElement('script');ld.type = 'text/javascript'; ld.async = true;
								ld.src = 'https://mediamiles.net/userv/ReIgnite?s=".$site_id."';var s = document.getElementsByTagName('script')[0];
								s.parentNode.insertBefore(ld, s);
						})();</script>";
			}
		}
		
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	//Code to Run Code in Single.PHP file
		function mediamiles_add_to_content($content)
		{	
			$updated_content .= '<div class="mediamiles-toolbar" data-aspect="horizontal"></div>';
			$updated_content .= '<div class="mediamiles-toolbar" data-aspect="vertical"></div>';
			return $updated_content . $content;
		}
	 

  
  //---------------------------------------------------------------------------------------------//	   
	//Short code for Tool Bar and Obscure Div
	function mediamiles_toolbar()
	{
			global $post;
			$post_id = $post->ID;
			$tool_values = get_post_meta( $post_id, 'load_toolbar', true );
			$updated_content="";
			if( is_single() && ($tool_values == 1 || $tool_values == '')) 
			{
				$updated_content .= '<div class="mediamiles-toolbar" data-aspect="horizontal" data-button-color="white" data-spring-loaded="false" ></div>';
				$updated_content .= '<div class="mediamiles-toolbar" data-aspect="vertical" data-button-color="white" data-spring-loaded="false" ></div>';			
			}
			echo $updated_content.$content;
	}
	
   //---------------------------------------------------------------------------------------------//	   
	//Check if Site ID is correct or not
	function check_mediamiles_site_id_status()
	{	
		$invalid_data = 'ew!';
		$deactivation_flag = true;
		if( isset( $_POST['site_id'] ) && $_POST['site_id']){
			$siteID = $_POST['site_id'];
			$url = "https://mediamiles.net/PublisherPortal/verifySiteId?s=".$siteID;
			$json = @file_get_contents($url);
			$data = json_decode($json);
			if(is_object($data)){
				if( $data->error == '' ){
					update_option( 'mediamiles_siteid', $siteID, 'yes' );
					$deactivation_flag = false;
					echo 1;
				} else {
					$deactivation_flag = true;
					echo $invalid_data;
				}
			} else {
				$deactivation_flag = true;
				echo $invalid_data;
			}	
		} else {
			$deactivation_flag = true;
			echo $invalid_data;
		}
		if( $deactivation_flag ){
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		die();
	}
	
	//---------------------------------------------------------------------------------------------//
	  //Check if Site ID is entered or not
	  function deactivate_mediamiles_for_blank_site_id()
	  {
		 $screen = get_current_screen();
		 $current_page_base = $screen->base;
		 $res = array('tools_page_Register-MediaMiles', 'plugins');
		 if( $current_page_base != '' ){
			 if( !in_array($current_page_base, $res ) && !strlen(get_option('mediamiles_siteid')) > 0  ){
				deactivate_plugins( plugin_basename( __FILE__ ) );
			 }
		 }
	  }	   
}
$mmPlugin = new MMPlugin();
?>
