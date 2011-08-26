<?php //Begin widget code
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
$themename = "VisitingCard";
$shortname = "pt";
$options = array (
    
array(	"name" => "Profile Image Settings",
		"type" => "title"),
 	
	array(  "name" => "Profile Image URL",
			"desc" => "Write full path of your profile image. Must be of 60 x 60 pixels dimension",
            "id" => $shortname."_profileimage",
            "std" => "",
            "type" => "text"),

array(	"name" => "Network - Tab Settings",
		"type" => "title"),
 	
	array(  "name" => "Twitter",
			"desc" => "write full URL of your twitter profile",
            "id" => $shortname."_twitter",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Facebook",
			"desc" => "write full URL of your facebook profile",
            "id" => $shortname."_facebook",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Stumbleupon",
			"desc" => "write full URL of your Stumbleupon profile",
            "id" => $shortname."_stumbleupon",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Delicious",
			"desc" => "write full URL of your Delicious profile",
            "id" => $shortname."_delicious",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Digg",
			"desc" => "write full URL of your digg profile",
            "id" => $shortname."_digg",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Flickr",
			"desc" => "write full URL of your Flickr profile",
            "id" => $shortname."_flickr",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Last.fm",
			"desc" => "write full URL of your Last.fm profile",
            "id" => $shortname."_lastfm",
            "std" => "",
            "type" => "text"),

	array(  "name" => "MySpace",
			"desc" => "write full URL of your MySpace profile",
            "id" => $shortname."_myspace",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Reddit",
			"desc" => "write full URL of your Reddit profile",
            "id" => $shortname."_reddit",
            "std" => "",
            "type" => "text"),


array(	"name" => "Contact - Tab Settings",
		"type" => "title"),
 	
	array(  "name" => "Company",
			"desc" => "write your company name",
            "id" => $shortname."_company",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Location",
			"desc" => "Where your company is located?",
            "id" => $shortname."_location",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Website",
			"desc" => "write URL of your website. Don't prefix http:// ",
            "id" => $shortname."_website",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Email",
			"desc" => "write your email address",
            "id" => $shortname."_email",
            "std" => "",
            "type" => "text"),

	array(  "name" => "IM",
			"desc" => "write your Instant Messenger ID",
            "id" => $shortname."_im",
            "std" => "",
            "type" => "text"),

	array(  "name" => "Skype",
			"desc" => "write your Skype ID",
            "id" => $shortname."_skype",
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

    add_theme_page($themename." Options", "Current Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

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

?>
