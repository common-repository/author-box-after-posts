<?php
/*
Plugin Name: Author Box After Posts
Plugin URI: https://www.pandasilk.com/wordpress-author-box-after-posts-plugin/
Description: Adds an author box after your post contents, with avatar and social profile links.
Version: 1.6
Author: pandasilk
Author URI: https://www.pandasilk.com/wordpress-author-box-after-posts-plugin/
*/

/* 
Registering Options Page
*/	
if(!class_exists('anchor_register_button')) :

// DEFINE PLUGIN ID
define('ABAPPluginOptions_ID', 'abap-plugin');
// DEFINE PLUGIN NICK
define('ABAPPluginOptions_NICK', 'Author Box After Posts');

    class ABAPPluginOptions
    {
		/** function/method
		* Usage: return absolute file path
		* Arg(1): string
		* Return: string
		*/
		public static function file_path($file)
		{
			return ABSPATH.'wp-content/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).$file;
		}
		/** function/method
		* Usage: hooking the plugin options/settings
		* Arg(0): null
		* Return: void
		*/
		public static function register()
		{
			register_setting(ABAPPluginOptions_ID.'_options', 'enable_abap_email');
		}
		/** function/method
		* Usage: hooking (registering) the plugin menu
		* Arg(0): null
		* Return: void
		*/
		public static function menu()
		{
			// Create menu tab
			add_options_page(ABAPPluginOptions_NICK.' Plugin Options', ABAPPluginOptions_NICK, 'manage_options', ABAPPluginOptions_ID.'_options', array('ABAPPluginOptions', 'options_page'));
		}
		/** function/method
		* Usage: show options/settings form page
		* Arg(0): null
		* Return: void
		*/
		public static function options_page()
		{ 
			if (!current_user_can('manage_options')) 
			{
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			
			$plugin_id = ABAPPluginOptions_ID;
			// display options page
			include(self::file_path('options.php'));
		}
		
    }
	
	if ( is_admin() )
	{
		add_action('admin_init', array('ABAPPluginOptions', 'register'));
		add_action('admin_menu', array('ABAPPluginOptions', 'menu'));
		
	}
	
endif;



// Enqueue CSS file
add_action( 'wp_enqueue_scripts', 'add_authorbox_css' );	
function add_authorbox_css() {
	wp_enqueue_style( 'abap-css', plugins_url( 'abap.css', __FILE__ ) );
}
	
add_filter('user_contactmethods','abap_user_contactmethods',10,1);	
function abap_user_contactmethods( $contactmethods ) {

//Remove user contact methods
  if ( isset( $contactmethods['skype'] ) )
    unset( $contactmethods['skype'] );	
	
  if ( isset( $contactmethods['facebook'] ) )
    unset( $contactmethods['facebook'] );
	
  if ( isset( $contactmethods['twitter'] ) )
    unset( $contactmethods['twitter'] );
	
  if ( isset( $contactmethods['googleplus'] ) )
    unset( $contactmethods['googleplus'] );	
	
  if ( isset( $contactmethods['linkedin'] ) )
    unset( $contactmethods['linkedin'] );	

  if ( isset( $contactmethods['youtube'] ) )
    unset( $contactmethods['youtube'] );	
	
  if ( isset( $contactmethods['flickr'] ) )
    unset( $contactmethods['flickr'] );		
	
  if ( isset( $contactmethods['pinterest'] ) )
    unset( $contactmethods['pinterest'] );	
	
  if ( isset( $contactmethods['instagram'] ) )
    unset( $contactmethods['instagram'] );		
	
  if ( isset( $contactmethods['quora'] ) )
    unset( $contactmethods['quora'] );	
	
//Add user contact methods
  if ( !isset( $contactmethods['skype'] ) )
    $contactmethods['skype'] = __('Skype Username'); 
	
  if ( !isset( $contactmethods['facebook'] ) )
    $contactmethods['facebook'] = __('Facebook URL'); 
	
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = __('Twitter Username'); 
	
  if ( !isset( $contactmethods['googleplus'] ) )
    $contactmethods['googleplus'] = __('Google + URL'); 
	
  if ( !isset( $contactmethods['linkedin'] ) )
    $contactmethods['linkedin'] = __('Linkedin URL'); 
	
  if ( !isset( $contactmethods['youtube'] ) )
    $contactmethods['youtube'] = __('Youtube URL'); 
	
  if ( !isset( $contactmethods['flickr'] ) )
    $contactmethods['flickr'] = __('Flickr URL'); 
	
  if ( !isset( $contactmethods['pinterest'] ) )
    $contactmethods['pinterest'] = __('Pinterest URL'); 

  if ( !isset( $contactmethods['instagram'] ) )
    $contactmethods['instagram'] = __('Instagram URL'); 

  if ( !isset( $contactmethods['quora'] ) )
    $contactmethods['quora'] = __('Quora URL'); 	

  if ( !isset( $contactmethods['abap_avatar'] ) )
    $contactmethods['abap_avatar'] = __('Custom Avatar Image URL'); 	
	
	return $contactmethods;
}

//Custom Avatar
function abap_get_avatar( $avatar, $id_or_email, $size ) {
	if (get_the_author_meta('abap_avatar')){
		$avatar = '<img src="'. get_the_author_meta('abap_avatar').'" alt="' . get_the_author() . '" width="' . $size . '" height="' . $size . '" />';
	}else{
		$avatar = get_avatar(get_the_author_meta('ID') );
	}
    return $avatar;
}


//Difine Author Box Structure
add_filter('the_content', 'add_author_box');
function add_author_box($content) {
	//Define the Main Part of Author Box
	$author_box='<div id="abap_box">
	
	<p><span class="author_photo">'.abap_get_avatar( $avatar, $id_or_email, $size ).'</span> <strong>About <a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author_meta('display_name').'</a></strong> <br>'.get_the_author_meta('description').'</p>
	<p class="abap_links">';
	
//Fetch the User Social Contact Infomation
	global $post;
	$abap_skype_url = get_the_author_meta( 'skype' );
	$abap_facebook_url = get_the_author_meta( 'facebook' );
	$abap_twitter_url = 'https://twitter.com/'.get_the_author_meta( 'twitter' );
	$abap_google_url = get_the_author_meta( 'googleplus' );
	$abap_linkedin_url = get_the_author_meta( 'linkedin' );	
	$abap_youtube_url = get_the_author_meta( 'youtube' );
	$abap_flickr_url = get_the_author_meta( 'flickr' );
	$abap_pinterest_url = get_the_author_meta( 'pinterest' );
	$abap_instagram_url = get_the_author_meta( 'instagram' );
	$abap_quora_url = get_the_author_meta( 'quora' );

	if(get_option('enable_abap_email')=='1'){
		$abap_email_info='<a href="mailto:'.get_the_author_meta('email').'" title="Send an Email to the Author of this Post">Email</a>&nbsp;&#8226;&nbsp;';
	}else {
		$abap_email_info='';
	}
	if($abap_skype_url){
		$abap_skype_url='<a rel="me nofollow" href="skype:'.$abap_skype_url.'?call" target="_blank">Skype </a>&nbsp;&#8226;&nbsp;';
	}else {
		$abap_skype_url='';
	}
	
	if($abap_facebook_url){
		$abap_facebook_url='<a rel="me nofollow" href="' . esc_url($abap_facebook_url) . '" target="_blank">Facebook </a>&nbsp;&#8226;&nbsp;';
	}else {
		$abap_facebook_url='';
	}
	
	if($abap_twitter_url){	
		$abap_twitter_url='<a rel="me nofollow" href="' . esc_url($abap_twitter_url) . '" target="_blank">Twitter</a>&nbsp;&#8226;&nbsp;';
	}else {
		$abap_twitter_url='';
	}
	
	if($abap_google_url){
		$abap_google_url='<a  rel="me nofollow" href="' . esc_url($abap_google_url) . '" target="_blank">Google</a>&nbsp;&#8226;&nbsp;';
	} else {
		$abap_google_url='';
	}
	if($abap_linkedin_url){
		$abap_linkedin_url='<a  rel="me nofollow" href="' . esc_url($abap_linkedin_url) . '" target="_blank">Linkedin</a>&nbsp;&#8226;&nbsp;';
	} else {
		$abap_linkedin_url='';
	}	
 	if($abap_youtube_url){
		$abap_youtube_url='<a  rel="me nofollow" href="' . esc_url($abap_youtube_url) . '" target="_blank">Youtube</a>&nbsp;&#8226;&nbsp;';
	} else {
		$abap_youtube_url='';
	}	
	
 	if($abap_flickr_url){
		$abap_flickr_url='<a  rel="me nofollow" href="' . esc_url($abap_flickr_url) . '" target="_blank">Flickr</a>&nbsp;&#8226;&nbsp;';
	} else {
		$abap_flickr_url='';
	}	
	
 	if($abap_pinterest_url){
		$abap_pinterest_url='<a  rel="me nofollow" href="' . esc_url($abap_pinterest_url) . '" target="_blank">Pinterest</a>&nbsp;&#8226;&nbsp;';
	} else {
		$abap_pinterest_url='';
	}	
	
 	if($abap_instagram_url){
		$abap_instagram_url='<a rel="me nofollow" href="' . esc_url($abap_instagram_url) . '" target="_blank">Instagram</a>&nbsp;&#8226;&nbsp;';
	} else {
		$abap_instagram_url='';
	}	
	
 	if($abap_quora_url){
		$abap_quora_url='<a  rel="me nofollow" href="' . esc_url($abap_quora_url) . '" target="_blank">Quora</a>';
	} else {
		$abap_quora_url='';
	}	

//Display Author Box
	if(is_single()) {

		$content.= ($author_box.$abap_email_info.$abap_skype_url.$abap_facebook_url.$abap_twitter_url.$abap_linkedin_url.$abap_google_url.$abap_youtube_url.$abap_flickr_url.$abap_pinterest_url.$abap_instagram_url.$abap_quora_url.'</p></div>');
    }
	
    return $content;
}