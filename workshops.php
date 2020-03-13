<?php /*
Template Name: Workshops Page
*/ ?>

<?php
add_action( 'genesis_entry_content', 'banner_ad', 1 );
function banner_ad() {
  // Check if Banner is activated
  if (get_field('activate_banner_ad')):
    // if So, output banner markup & fields ?>
    <div class="bannerAd">
       <img src="/wp-content/uploads/2019/04/littleflower-logo.png" class="adLogo"/>
       <h2><?php the_field('banner_title');?></h2>
       <h4><?php the_field('banner_ad_date');?></h4>
       <a class="button orange" href="<?php the_field('banner_ad_button_link');?>" target="_blank"><?php the_field('banner_ad_button_text');?></a>
    </div><?php
  endif;
}
?>

<?php
//* This file handles pages, but only exists for the sake of child theme forward compatibility.
genesis();
?>
