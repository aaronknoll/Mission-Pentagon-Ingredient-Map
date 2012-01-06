<?php
/*
Plugin Name: Pentagon Rating Tool
Plugin URI: http://theginisin.com/projectpentagon
Description: A plugin which allows posts to be rated in 5 categories on a scale of 1-3
Version: 0.5
Author: Aaron Knoll
Author URI: http://aaronknoll.com
License: GPL
*/

//initial version is a proof of concept. Pending interest I could likely
// make a lot of these things much more elegant. But for now, this is 
// is a personal project for my gin blog. 

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'projectpentagon_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'projectpentagon_remove' );

function projectpentagon_install() {
/* Creates new database field */
add_option("projectpentagon_title", 'fgfhgThis it the Title of my Pentagram', '', 'yes');
add_option("projectpentagon_name1", 'Name a', '', 'yes');
add_option("projectpentagon_name2", 'Name b', '', 'yes');
add_option("projectpentagon_name3", 'Name c', '', 'yes');
add_option("projectpentagon_name4", 'Name d', '', 'yes');
add_option("projectpentagon_name5", 'Name e', '', 'yes');
add_option("projectpentagon_color1", 'Blue', '', 'yes');
add_option("projectpentagon_color2", 'Red', '', 'yes');
add_option("projectpentagon_color3", 'Yellow', '', 'yes');
add_option("projectpentagon_color4", 'Green', '', 'yes');
add_option("projectpentagon_color5", 'Orange', '', 'yes');
//these could probably be created as an array? eventually
}

function projectpentagon_remove() {
/* Deletes the database field */
delete_option('projectpentagon_title');
delete_option('projectpentagon_name1');
delete_option('projectpentagon_name2');
delete_option('projectpentagon_name3');
delete_option('projectpentagon_name4');
delete_option('projectpentagon_name5');
delete_option('projectpentagon_color1');
delete_option('projectpentagon_color2');
delete_option('projectpentagon_color3');
delete_option('projectpentagon_color4');
delete_option('projectpentagon_color5');
}

if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'projectpentagon_menu');

function projectpentagon_menu() {
	//create new top-level menu
	add_menu_page('Project Pentagon', 'Project Pentagon', 'administrator', __FILE__, 'projectpentagon_htmlpage',plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'projectpentagon_mysettings' );
}
}

function projectpentagon_mysettings() {
	//register our settings
	register_setting( 'baw-settings-group', 'projectpentagon_name1' );
	register_setting( 'baw-settings-group', 'projectpentagon_name2' );
	register_setting( 'baw-settings-group', 'projectpentagon_name3' );
	register_setting( 'baw-settings-group', 'projectpentagon_name4' );
	register_setting( 'baw-settings-group', 'projectpentagon_name5' );
	register_setting( 'baw-settings-group', 'projectpentagon_color1' );
	register_setting( 'baw-settings-group', 'projectpentagon_color2' );
	register_setting( 'baw-settings-group', 'projectpentagon_color3' );
	register_setting( 'baw-settings-group', 'projectpentagon_color4' );
	register_setting( 'baw-settings-group', 'projectpentagon_color5' );
}

function projectpentagon_htmlpage() {
?>
<div class="wrap">
<h2>Project Pentagon</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <table class="form-table">
    	        <tr valign="top">
        <th scope="row">Name 1</th>
        <td><input type="text" name="projectpentagon_name1" value="<?php echo get_option('projectpentagon_name1'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Color 1</th>
        <td><input type="text" name="projectpentagon_color1" value="<?php echo get_option('projectpentagon_color1'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Name 2</th>
        <td><input type="text" name="projectpentagon_name2" value="<?php echo get_option('projectpentagon_name2'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Color 2</th>
        <td><input type="text" name="projectpentagon_color2" value="<?php echo get_option('projectpentagon_color2'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Name 3</th>
        <td><input type="text" name="projectpentagon_name3" value="<?php echo get_option('projectpentagon_name3'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Color 3</th>
        <td><input type="text" name="projectpentagon_color3" value="<?php echo get_option('projectpentagon_color3'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Name 4</th>
        <td><input type="text" name="projectpentagon_name4" value="<?php echo get_option('projectpentagon_name4'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Color 4</th>
        <td><input type="text" name="projectpentagon_color4" value="<?php echo get_option('projectpentagon_color4'); ?>" /></td>
        </tr>
                <tr valign="top">
        <th scope="row">Name 5</th>
        <td><input type="text" name="projectpentagon_name5" value="<?php echo get_option('projectpentagon_name5'); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Color 5</th>
        <td><input type="text" name="projectpentagon_color5" value="<?php echo get_option('projectpentagon_color5'); ?>" /></td>
        </tr>
         

    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php
}
?>