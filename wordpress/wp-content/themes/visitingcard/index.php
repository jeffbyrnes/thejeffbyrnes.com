<?php get_header(); ?>
<div id="top"></div>
<div id="page">
  <div class="page-in">
    <div id="datacontent">
	<span id="pt"><a href="http://premiumthemes.net">premiumthemes.net</a></span>
      <ul class="navigation">
        <li><a href="#networks">Networks</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
       </ul>
      <div class="about clearfix">
        <img src="http://images.jeffbyrnes.net/avatars/manga-60x60.png" alt="<?php bloginfo('name'); ?>"/>
        <h1>
          <?php bloginfo('name'); ?>
        </h1>
        <p>
          <?php bloginfo('description'); ?>
        </p>
      </div>
      <!-- Top about  -->
       
    </div>
    <!-- datacontent #end  -->
    <div class="wrapper" >
      <div id="networks" >
        <div id="content">
          <ul>
            <? if ($pt_twitter) { ?>
            <li><a href="<?php echo $pt_twitter; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_twitter.png" /><strong>Twitter</strong>twitter.com</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_facebook) { ?>
            <li><a href="<?php echo $pt_facebook; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_facebook.png" /><strong>Face Book</strong>facebook.com</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_stumbleupon) { ?>
            <li><a href="<?php echo $pt_stumbleupon; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_stumbleupon.png" /><strong>Stumbleupon</strong>stumbleupon.com</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_delicious) { ?>
            <li><a href="<?php echo $pt_delicious; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_delicious.png" /><strong>Delicious</strong>delicious.com</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_digg) { ?>
            <li><a href="<?php echo $pt_digg; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_digg.png" /><strong>Digg</strong>digg.com</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_flickr) { ?>
            <li><a href="<?php echo $pt_flickr; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_flickr.png" /><strong>Flickr</strong>flickr.com</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_lastfm) { ?>
            <li><a href="<?php echo $pt_lastfm; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_lastfm.png" /><strong>Last.fm</strong>last.fm</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_myspace) { ?>
            <li><a href="<?php echo $pt_myspace; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_myspace.png" /><strong>My Space</strong>myspace.com</a></li>
            <? } else { ?>
            <? } ?>
            <? if ($pt_reddit) { ?>
            <li><a href="<?php echo $pt_reddit; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_reddit.png" /><strong>Reddit</strong>reddit.com</a></li>
            <? } else { ?>
            <? } ?>
          </ul>
          <div class="clear"></div>
        </div>
      </div>
      <div id="about">
        <div class="main_content">
          <ul class="nobullet">
            <?php 	/* Widgetized sidebar, if you have the plugin installed. */
                            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <!-- about #end -->
      <div id="contact" >
        <div class="main_content">
          <? if ($pt_company) { ?>
          <div class="row"><span class="field_l i_company">Company:</span><span class="field_r"><?php echo $pt_company; ?></span></div>
          <? } else { ?>
          <? } ?>
          <? if ($pt_location) { ?>
          <div class="row"><span class="field_l i_location">Location:</span><span class="field_r"><?php echo $pt_location; ?></span></div>
          <? } else { ?>
          <? } ?>
          <? if ($pt_website) { ?>
          <div class="row"><span class="field_l i_web">Website:</span><span class="field_r"><a href="http://<?php echo $pt_website; ?>"><?php echo $pt_website; ?></a></span></div>
          <? } else { ?>
          <? } ?>
          <? if ($pt_email) { ?>
          <div class="row"><span class="field_l i_mail">E-Mail:</span><span class="field_r"><?php echo $pt_email; ?></span></div>
          <? } else { ?>
          <? } ?>
          <? if ($pt_im) { ?>
          <div class="row"><span class="field_l i_mail">IM :</span><span class="field_r"><?php echo $pt_im; ?></span></div>
          <? } else { ?>
          <? } ?>
          <? if ($pt_skype) { ?>
          <div class="row"><span class="field_l i_mail">Skype:</span><span class="field_r"><?php echo $pt_skype; ?></span></div>
          <? } else { ?>
          <? } ?>
        </div>
      </div>
      <!-- contact #end -->
    </div>
  </div>
</div>
</div>
<!-- page #end -->
<?php get_footer(); ?>