<?php
if ( function_exists('register_sidebar') )
	register_sidebar(array(
	'name' => 'About',
	'before_widget' => '<div class="sidebar-box">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));	
?>
<?php
$themename = "The DBC Theme";
$shortname = "pt";
$options = array (
    
array(	"name" => "Contact Image",
		"type" => "title"),
 	
	array(  "name" => "Profile Image URL",
			"desc" => "Full URL Path to Image. Up to 475px Wide. If blank it will show MY awesome face...!",
            "id" => $shortname."_profileimage",
            "std" => "",
            "type" => "text"),
            
array(	"name" => "Contact Information",
		"type" => "title"),
 	
	array(  "name" => "Company Name",
			"desc" => "What is Your Company Name?",
            "id" => $shortname."_company",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Company Website",
			"desc" => "URL of Company Website. Include http://",
            "id" => $shortname."_website",
            "std" => "",
            "type" => "text"),


	array(  "name" => "Blog",
			"desc" => "URL of Your Blog. Do NOT Include http://",
            "id" => $shortname."_location",
            "std" => "",
            "type" => "text"),


	array(  "name" => "Email Address",
			"desc" => "Add Your Email Address.",
            "id" => $shortname."_email",
            "std" => "",
            "type" => "text"),

	array(  "name" => "IM",
			"desc" => "What is Your Instant Messenger ID?",
            "id" => $shortname."_im",
            "std" => "",
            "type" => "text"),
            

array(	"name" => "Social Networking Profiles",
		"type" => "title"),
 	
	array(  "name" => "Twitter",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_twitter",
            "std" => "",
            "type" => "text"),
    
    array(  "name" => "Technorati",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_technorati",
            "std" => "",
            "type" => "text"),
        
	array(  "name" => "Vimeo",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_vimeo",
            "std" => "",
            "type" => "text"),

	array(  "name" => "YouTube",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_youtube",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Facebook",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_facebook",
            "std" => "",
            "type" => "text"),
   
    array(  "name" => "Posterous",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_posterous",
            "std" => "",
            "type" => "text"),
    
    array(  "name" => "LinkedIN",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_linkedin",
            "std" => "",
            "type" => "text"),
                     
    array(  "name" => "FriendFeed",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_friendfeed",
            "std" => "",
            "type" => "text"),         

	array(  "name" => "Stumbleupon",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_stumbleupon",
            "std" => "",
            "type" => "text"),
    
    array(  "name" => "Reddit",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_reddit",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Delicious",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_delicious",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Digg",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_digg",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Flickr",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_flickr",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Last.fm",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_lastfm",
            "std" => "",
            "type" => "text"),

	array(  "name" => "MySpace",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_myspace",
            "std" => "",
            "type" => "text"),
   
    array(  "name" => "Wordpress",
			"desc" => "Full URL to Your Profile.",
            "id" => $shortname."_wordpress",
            "std" => "",
            "type" => "text"),
	
);


function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>

<style type="text/css"  >
	
	h3 { padding:10px 20px; margin:20px 0 0 0; font:normal 18px Arial, Helvetica, sans-serif; color: #fff ; background:#52778a; }
	
	.admin_table td, .admin_table th { padding:8px 8px 5px 8px; border-bottom:1px solid #ccc; background:#eee; font:12px Arial, Helvetica, sans-serif; color:#333;  }
	
	.admin_table th { font-weight:bold; text-align:left; width:200px; }
	
	.admin_table td input, .admin_table td select { background:#fff; padding:4px; width:400px; border:1px solid #ccc; margin-bottom:4px;   }
	
	.admin_table td select { width:200px;  }
	
	.admin_table td.head { background:#fff; padding:0; margin:0;  }
	
</style>

<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>
<form method="post">
  <table class="admin_table">
    <?php foreach ($options as $value) {
    
if ($value['type'] == "title") { ?>
		<tr valign="top"> 
		    <td colspan="2" class="head"><h3 ><?php echo $value['name']; ?></h3></td>
		</tr>

    <?php } elseif ($value['type'] == "checkbox") { ?>

    <tr valign="top">
      <th scope="row" style="font:bold 11px Verdana, Arial, Helvetica, sans-serif; padding-top:10px;"><?php echo $value['name']; ?>:</th>
      <td><? if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        <br />
        <small><?php echo $value['desc'] ; ?></small> </td>
    </tr>


    <?php } elseif ($value['type'] == "text") { ?>

    <tr valign="top">
      <th scope="row" style="font:bold 11px Verdana, Arial, Helvetica, sans-serif; padding-top:10px;"><?php echo $value['name']; ?>:</th>
      <td><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
        <br />
        <small><?php echo $value['desc'] ; ?></small> </td>
    </tr>

    <?php } elseif ($value['type'] == "select") { ?>
    <tr valign="top">
      <th scope="row" style="font:bold 11px Verdana; padding-top:10px;"><?php echo $value['name']; ?>:</th>
      <td style="font:11px Verdana, Arial, Helvetica, sans-serif;"><select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
          <?php foreach ($value['options'] as $option) { ?>
          <option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
          <?php } ?>
        </select>
        <br />
        <small><?php echo $value['desc'] ; ?></small> </td>
    </tr>
    <?php
}
}
?>
  </table>
  <p class="submit">
    <input name="save" type="submit" value="Save changes" />
    <input type="hidden" name="action" value="save" />
  </p>
</form>
<form method="post">
  <p class="submit">
    <input name="reset" type="submit" value="Reset" />
    <input type="hidden" name="action" value="reset" />
  </p>
</form>
<?php
}

function mytheme_wp_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/style.php" rel="stylesheet" type="text/css" />
<?php }

add_action('wp_head', 'mytheme_wp_head');
add_action('admin_menu', 'mytheme_add_admin'); ?>