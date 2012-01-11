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

add_option("projectpentagon_category", 'Category Name', '', 'yes');
add_option("projectpentagon-titleonpages", 'title for pages', '', 'yes');

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

delete_option('projectpentagon_category');
delete_option('projectpentagon-titleonpages');

}




if ( is_admin() ){



/* Call the html code */

	/* puts the admin section for Project Pentagon on the pages */

	add_action('admin_menu', 'projectpentagon_menu');

	/* puts the options to add ratings on individual post pages */

	add_action( 'add_meta_boxes', 'projectpentagon_custom_box' );

	/* Do something with the data entered */

	add_action( 'save_post', 'projectpentagon_save_postdata' );
	


function projectpentagon_custom_box() {	

	add_meta_box( 

       'myplugin_sectionid',

        __( 'Pentagon Ratings', 'myplugin_textdomain' ),

        'projectpentagon_ratingsperbottle',

        'post','side','high'

    );

	    add_meta_box( 
        'myplugin_sectionid2',
        __( 'Pentagon Notes', 'myplugin_textdomain' ),
        'projectpentagon_tastingnotes',
        'post' 
    );

}



function projectpentagon_save_postdata($post_id) {

  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  // Check permissions

  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

	//update the tasting notes
   	$outside_newvalue = $_POST['tasting-notes'];
	update_post_meta($post_id, 'tasting-notes',  $outside_newvalue);

  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)
  for($hh=1;$hh<6;$hh++)

  	{
  	//do an update for each of the potential 5 fields....

  	$get_field_name					=	"myplugin_new_field" . $hh ."";	
  	$create_variable_name			=	"pentagon-field-". $hh ."";	
	$create_name_of_field_to_update =	"mydata" . $hh ."";
	$newvalue = $_POST[$get_field_name];
	//echo "$newvalue is returning  ---". 	$newvalue	."<br />";//DEBUG
	update_post_meta($post_id, $create_variable_name, $newvalue);	

	//echo "get field name is returning --- ". $get_field_name	."<br />";//DEBUG
	//echo "create variable name name is returning --- ".   	$create_variable_name		."<br />";//DEBUG
	//echo "$create_name_of_field_to_update is returning --- ". 	$create_name_of_field_to_update	."<br />";//DEBUG
	}



  //echo "$mydata is mydata....";//debug

}

// adds a box to the mainbox for tasting/rating notes. 
function projectpentagon_tastingnotes() {
	  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
	 $post_idinhere	=	$_GET['post']; //GET THE ID OUTSIDE OF THE LOOP
	 
	 $get_field_name	=	 get_option('projectpentagon-titleonpages');
	 $meta_value_field = get_post_meta($post_idinhere, 'tasting-notes', true); 
	if($meta_value_field1)
		{
		  	//echo "we're at debut point a";//debug
		  	$display1 = $meta_value_field1; 
		}
	else 
		{
		  	//echo "we're at debut point b". $meta_value_field1 ."";//debug
		  	$display1 = "enter value here.";
		}

		// we're not using _e because its user input text we're retrieving.
	    // we'll assume that the user put it in the database in their preferred language
			 echo '<label for="'. $get_field_name .'">';
			echo $get_field_name;
		  	echo '</label> <br /> ';
			echo '<textarea id="tasting-notes" name="tasting-notes"  cols="60" rows="4" tabindex="30" style="width: 97%;">'. $meta_value_field .'</textarea>';	
}


/* Adds a box to the main column on the Post and Page edit screens */

function projectpentagon_ratingsperbottle() {


  // Use nonce for verification

  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );



	 $post_idinhere	=	$_GET['post']; //GET THE ID OUTSIDE OF THE LOOP

 	// OKAY, WE NEED TO SETUP 5 OF THESE ENTRY FIELDS. (5 OF EVERYTHING)

 	 for($jj=1;$jj<6;$jj++)

  	{

  		  $get_option_name		=	"projectpentagon_name" . $jj ."";

  		  $get_field_name		=	"myplugin_new_field" . $jj ."";

  		  $create_variable_name	=	"pentagon-field-". $jj ."";	

		 	 // The actual fields for data entry

		  echo '<label for="'. $get_field_name .'">';

		   // see if there's a value already in the database:

		  $meta_value_field1 = get_post_meta($post_idinhere, $create_variable_name, true); 

		  if($meta_value_field1)

		  	{

		  	//echo "we're at debut point a";//debug

		  	$display1 = $meta_value_field1; 

			}

		  else 

		  	{

		  	//echo "we're at debut point b". $meta_value_field1 ."";//debug

		  	$display1 = "enter value here.";

			}

			// we're not using _e because its user input text we're retrieving.

			// we'll assume that the user put it in the database in their preferred language

		 	echo get_option($get_option_name);
		  	echo '</label> <br /> ';
			echo '<input type="text" id="'. $get_field_name .'" name="'. $get_field_name .'" value="'. $display1 .'" size="25" />
			<br /><br />';	
	}

}



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

	register_setting( 'baw-settings-group', 'projectpentagon_category' );
	register_setting( 'baw-settings-group', 'projectpentagon-titleonpages' );



}



function projectpentagon_htmlpage() {

?>

<div class="wrap">

<h2>Project Pentagon</h2>



<form method="post" action="options.php">

    <?php settings_fields( 'baw-settings-group' ); ?>

    <table class="form-table">

    	<tr valign="top">

        <th scope="row">Name or slug of category for Pentagon display</th>

        <td><input type="text" name="projectpentagon_category" value="<?php echo get_option('projectpentagon_category'); ?>" /></td>

        </tr>
        
      <tr valign="top">

        <th scope="row">Section Title [will appear on post pages in selected category]</th>

        <td><input type="text" name="projectpentagon-titleonpages" value="<?php echo get_option('projectpentagon-titleonpages'); ?>" /></td>

        </tr>

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





/*DISPLAY FILTERS AND HOOKS */

add_filter( 'the_content', 'pentagonseverywhere', 20 );
add_action( 'wp_head', 'pentagon_front_css');



		function pentagonseverywhere( $content )

		 	{

		 	//what category does this belong in?

			$nameofcat	=	get_option("projectpentagon_category");

			$idinloop	=	get_the_ID();

		 	if ( in_category( $nameofcat )) 

				{

				$pentarray	=	array(); //instantiate the array we'll use in the display to fill in the variables.

				

				//so now we need to get all of the information for this page

				//we need the names 

				//we need the colors

				 for($oo=1;$oo<6;$oo++)

				  	{

				  	 $name	=	"projectpentagon_name" . $oo ."";

				  	 $color	=	"projectpentagon_color" . $oo ."";

				 	 $pentarray[name][$oo]	= get_option($name);

					 $pentarray[color][$oo]= get_option($color);


					//field whose post meta we want

					$postmetafield	=	"pentagon-field-". $oo ."";	

					$pentarray[rating][$oo] = get_post_meta($idinloop, $postmetafield, true); 

					//DEBUG
					//echo get_option($name);
					//echo get_option($color);
					//echo get_post_meta($idinloop, $postmetafield, true); 

					}

				// and we need the ratings for this specific post. 
				// Returns the content.

				//The words are NOT rotated:
				$titular_element	=	get_option("projectpentagon-titleonpages");
				?>
         <div id="arbitrary">
				<svg id="svgelem" height="100" width="200" xmlns="http://www.w3.org/2000/svg">
	

				<text x = "125" y = "85" fill = "black" font-size = "11"><?php echo $pentarray[name][1]; ?></text>
				<text x = "85" y = "65" fill = "black" font-size = "11"><?php echo $pentarray[name][2]; ?></text>
				<text x = "170" y = "65" fill = "black" font-size = "11"><?php echo $pentarray[name][5]; ?></text>
				<text x = "165" y = "20" fill = "black" font-size = "11"><?php echo $pentarray[name][4]; ?></text>
				<text x = "75" y = "20" fill = "black" font-size = "11"><?php echo $pentarray[name][3]; ?></text> 


				<?php 

				for ($i=1; $i < 6; $i++) 

					{

					$rotation = (($i-1) * 72); 

				?>

					<g transform="rotate(<?php echo $rotation; ?>,139.38,42.4)" >
						
 						<?php 
						//if it is 3 stars, color the outside. 
						if($pentarray[rating][$i] == 3)
							{
							?>
							<polygon Stroke="#000" points="139.38,42.4 117.24,71.42 161.98,71.42" fill="#<?php echo $pentarray[color][$i]; ?>" />
							<polygon Stroke="#000" points="139.38,42.4 125.04,61.6 154.18,61.6" fill="#<?php echo $pentarray[color][$i]; ?>" />
							<polygon Stroke="#000"  points="139.38,42.4 132.46,51.72, 147.76,51.72" fill="#<?php echo $pentarray[color][$i]; ?>" />
							<?php
							}
						elseif($pentarray[rating][$i] == 2)
							{
							?>
                            <polygon Stroke="#000" points="139.38,42.4 117.24,71.42 161.98,71.42" fill="#FFFFFF" />
							<polygon Stroke="#000" points="139.38,42.4 125.04,61.6 154.18,61.6" fill="#<?php echo $pentarray[color][$i]; ?>" />
							<polygon Stroke="#000"  points="139.38,42.4 132.46,51.72, 147.76,51.72" fill="#<?php echo $pentarray[color][$i]; ?>" />	

							<?php
							}
						elseif($pentarray[rating][$i] == 1)
							{
							?>
                            <polygon Stroke="#000" points="139.38,42.4 117.24,71.42 161.98,71.42" fill="#FFFFFF" />
							<polygon Stroke="#000" points="139.38,42.4 125.04,61.6 154.18,61.6" fill="#FFFFFF" />
							<polygon Stroke="#000"  points="139.38,42.4 132.46,51.72, 147.76,51.72" fill="#<?php echo $pentarray[color][$i]; ?>" />

							<?php
							}
							elseif($pentarray[rating][$i] == 0)
							{
							?>
							<polygon Stroke="#000" points="139.38,42.4 117.24,71.42 161.98,71.42" fill="#FFFFFF" />

							<?php	
							}
						else
							{
							?>
							 <polygon Stroke="#000" points="139.38,42.4 117.24,71.42 161.98,71.42" fill="#FFFFFF" />
							<polygon Stroke="#000" points="139.38,42.4 125.04,61.6 154.18,61.6" fill="#FFFFFF" />
							<polygon Stroke="#000"  points="139.38,42.4 132.46,51.72, 147.76,51.72" fill="#FFFFFF" />
							<?php
                            }
						?>
					</g>

				<?php

				}

				?>

				</svg> 
                
                <div id="descripter" style="float: right; width: 60%;">
                    <h5 style="font-size: 115%;">
                    <?php echo $titular_element; ?>
                    </h5>
                    <p>
                    <?php 	 $tastenotespub = get_post_meta($idinloop, 'tasting-notes', true);
					echo $tastenotespub;?> 
                    </p>
                </div>
               
          </div> <!-- end of arbitrary div class-->

				<?php 

				return $content;

				}

				else

				{

				return $content;

				}

			}

	
	
	
	
	 function pentagon_front_css() 
	 {
            $css = '<!--[if lte IE 8]><link rel="stylesheet" href="'. get_home_url().'/wp-content/plugins/projectpentagon/ie8.css"  type="text/css"><![endif]-->';
			 echo $css;

    }


?>