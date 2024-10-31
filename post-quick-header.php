<?php
/* 
Plugin Name: Post Quick Header 
Plugin URI: http://www.shannonreca.com/2011/06/post-quick-header-wp-plugin/
Quickly insert a header for you post in seconds! No need to design anything from scratch.
Version: 1.0 
Author: Shannon Reca
Author URI: http://www.shannonreca.com 
*/

function add_directurl() {
	echo '<directurl>';
	echo get_post_meta($post->ID,'http://www.ShannonReca.com',1);
	echo '</directurl>';
}

add_action('postquickheader_entry','add_directurl',10,1);

define('SR - Post Quick Header', '1.0');

load_plugin_textdomain('post-quick-header', false, dirname(plugin_basename(__FILE__)) . '/language');

if (!defined('PLUGINDIR')) {
	define('PLUGINDIR','wp-content/plugins');
}



class QuickHeader{
	//---------------------------------------------
	// variable that can be modified
	//---------------------------------------------
	var $tag_name="post-quick-header";
	var $plugin_folder="post-quick-header";
	var $plugin_url;	
					
	function post_quick_header() {
		$this->plugin_url=get_bloginfo("wpurl") . "/wp-content/plugins/$this->plugin_folder";		
		$this->bind_hooks();
	}
	
	function bind_hooks() {
		// init process for button control
		add_action('init', array(&$this,'post_quick_header_addbuttons'));
		add_action('admin_print_scripts',array(&$this,'admin_javascript'));
	}
	
	// ---------------- Editor Plugin //
	function post_quick_header_addbuttons() {
		// Don't bother doing this stuff if the current user lacks permissions
	   	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
	    	return;
	    //rich_editing
	    add_filter("mce_external_plugins", array(&$this,'add_tinymce_plugin'));
	    add_filter('mce_buttons', array(&$this,'register_button'));
	     
	    //for html editing 
		add_action('edit_form_advanced', array(&$this,'print_javascript'));
		add_action('edit_page_form',array(&$this,'print_javascript'));
	}
	 
	function register_button($buttons) {
		//array_push($buttons, "separator", "pqhinsert");
		array_push($buttons,  "pqhinsert");
		return $buttons;
	}
	 
	// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
	function add_tinymce_plugin($plugin_array) {
		$plugin_array['postquickheader'] = $this->plugin_url . '/tinymce3/editor_plugin_sr.js';
		return $plugin_array;
	}
	
	function admin_javascript(){
		//show only when editing a post or page.
		if (strpos($_SERVER['REQUEST_URI'], 'post.php') || strpos($_SERVER['REQUEST_URI'], 'post-new.php') || strpos($_SERVER['REQUEST_URI'], 'page-new.php') || strpos($_SERVER['REQUEST_URI'], 'page.php')) {
		
			//wp_enqueue_script only works  in => 'init'(for all), 'template_redirect'(for only public) , 'admin_print_scripts' for admin only
			if (function_exists('wp_enqueue_script')) {
				$jspath='/'. PLUGINDIR  . '/'. $this->plugin_folder.'/jqModal/jqModal.js';
				wp_enqueue_script('jqmodal_pqh', $jspath, array('jquery'));
			}
		}
	}
	
	function print_javascript () {
?>
<!--  for popup dialog -->
<link href="<?php echo $MyPluginsURL.'/jqModal/jqModal.css'; ?>" type="text/css" rel="stylesheet" />
<meta name="keywords" content="social media,social networking,graphics,business,business cards,art,dj,games,play,online play,entertainment,xbox,playstation,nintendo,wii,free,free games,free tv,free ipod,ipad,movies,tickets" />

<script type="text/javascript">
jQuery(document).ready(function(){
    // Add the buttons to the HTML view
    jQuery("#ed_toolbar").append('<input type=\"button\" class=\"ed_button\" onclick=\"jQuery(\'#dialog_postquickheader\').jqmShow();\" title=\"Post Quick Header\" value=\"Post Quick Header\" />');
});

jQuery(document).ready(function () {
    jQuery('#dialog_postquickheader').jqm();
});

function insertHeader(imageURL){
	if (imageURL) {
		text = '<div style="margin-bottom:15px;"><img src="<?php echo site_url();?>/'+imageURL+'"/></div>';				
		if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
			ed.focus();
			if (tinymce.isIE)
				ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
			ed.execCommand('mceInsertContent', false, text);
		} else
			edInsertContent(edCanvas, text);
	}
	jQuery('#dialog_postquickheader').jqmHide();
}
</script>
<div id="dialog_postquickheader" class='jqmWindow' style="width:480px; text-align:center;">
<!--GoogleCode-->
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6280842952948805";
/* WP-Plugin_PostQuickHeader_468x60 */
google_ad_slot = "6975813977";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<!--GoogleCode-->
<iframe id="Uploader" scrolling="no" height="350" width="480" frameborder="0" src="<?php echo $this->plugin_url;?>/form.php"></iframe>
</div>
<?php
	}
}
//initialize PostQuickHeader object
$PQH = new QuickHeader;
$PQH->post_quick_header();
?>