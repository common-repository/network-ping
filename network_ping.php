<?php
/*
Plugin Name: Network Ping
Plugin URI: http://sean-fisher.com/
Description: Network standard ping list, for WordPress.
Version: 1.0
Author: Sean Fisher
Author URI: http://sean-fisher.com/

Release under GPLv2
*/

/**
 *	Add the form for ping lists for WPMU.
**/
function np_add_network_option() {
	?>
	<h3><?php _e( 'Ping Settings' ); ?></h3>
		<table id="menu" class="form-table">
			<tr valign="top">
			
				<td>
					
<p><label for="ping_sites"><?php _e('When you publish a new post, WordPress automatically notifies the following site update services. For more about this, see <a href="http://codex.wordpress.org/Update_Services">Update Services</a> on the Codex. Separate multiple service <abbr title="Universal Resource Locator">URL</abbr>s with line breaks.') ?></label></p>

<textarea name="ping_sites" id="ping_sites" class="large-text code" rows="3"><?php echo get_site_option('ping_sites'); ?></textarea>
				</td>
			</tr>
		</table>

<?php
}

/**
 *	Saving the network ping list.
**/
function np_add_network_option_save() {
	if ( !isset( $_POST['ping_sites'] ) ) 
		return false;
	
	
	$value = $_POST['ping_sites'];
	
	$value = trim($value);
	$value = stripslashes_deep($value);
	//var_dump($value);
	
	update_site_option( 'ping_sites', $value );
	
}

/**
 *	Function to fix the get_option() function for 'ping_sites'.
**/
function np_update_pings($what = NULL) {
	return get_site_option('ping_sites');
}

//	Preventing manual ping lists.
remove_filter('enable_update_services_configuration', '__return_false');
add_filter( 'enable_update_services_configuration', '_do_return_true', 40 );


add_action('update_wpmu_options', 'np_add_network_option_save');
add_action('wpmu_options', 'np_add_network_option');
add_filter('option_ping_sites', 'np_update_pings');