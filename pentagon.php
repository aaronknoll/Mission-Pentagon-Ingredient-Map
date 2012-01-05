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
add_option("projectpentagon_data", 'Default', '', 'yes');
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
delete_option('projectpentagon_data');
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
add_options_page('Project Pentagon', 'Project Pentagon', 'administrator',
'projectpentagon', 'projectpentagon_html_page');
}
}


function projectpentagon_html_page() {
?>
<link rel='stylesheet' href='pentagon.css' type='text/css' media='all' />
<div>
<h2>Rating Pentagram Options</h2>
<p>The pentagon rating system has five categories. Assign categories + the
	color that ratings in that segment of the pentagon should appear.</p>
	
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<?php 
for($i=1;$i<6;$i++)
	{
	?>	
	<fieldset class="former">
	<label>Enter NAME for segment #<?php echo $i; ?></label>
	<input name="projectpentagon_name<?php echo $i; ?>" type="text" id="projectpentagon_name<?php echo $i; ?>"
value="<?php echo get_option('projectpentagon_name'+ $i +''); ?>" />
</fieldset>
<fieldset class="latter">
	<label>Enter COLOR for segment #<?php echo $i; ?></label>
	<input name="projectpentagon_color<?php echo $i; ?>" type="text" id="projectpentagon_color<?php echo $i; ?>"
value="<?php echo get_option('projectpentagon_color'+ $i +''); ?>" />
</fieldset>
	<?php
	}
	?>
<fieldset>
	<label>Enter Text</label>
	<input name="projectpentagon_data" type="text" id="projectpentagon_data"
value="<?php echo get_option('projectpentagon_data'); ?>" />
</fieldset>



<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="projectpentagon_data" />

<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
<?php
}
?>