<?php /*
Template Name: Homepage
*/ ?>

<?php
add_action( 'genesis_after_header', 'naada_videoBanner', 10 );
function naada_videoBanner() {
  ?>
  <div class="familyBanner">

    <!-- Calls our Call out Widget -->
    <?php dynamic_sidebar("family_callout"); ?>

  </div>
  <?php
}
?>

<?php

function homepage_Output(){
  ?>
  <div class="homeContentWrap">
    <h3 class="schedule"><?php the_field('upcoming_schedule');?></h3>
    <a class="fullSched" href="/schedule"><?php the_field('full_schedule');?></a>
    <div class="horz-sched"><?php echo do_shortcode( '[hc-hmw snippet="Family-Program-Schedule-Horizontal"]');?></div>
    <div class="sell first">
      <div class="greenbox">
        <h3><?php the_field('sell_box_1_title'); ?></h3>
      </div>
      <p><?php the_field('sell_box_1_text');?></p>
    </div>
    <div class="sell second">
      <div class="greenbox">
        <h3><?php the_field('sell_box_2_title'); ?></h3>
        </div>
        <p><?php the_field('sell_box_2_text');?>
          <a class="naada-button orange-button medium" href="http://naada.ca/schedule" target="_blank"><?php the_field('sell_btn_text');?></a>
        </p>
    </div>

    <hr />

    <h3>Upcoming Workshops</h3>
    <div class="naada-carousel">
      <div id="healCodeLoading"><?php echo do_shortcode( '[hc-hmw snippet="Family-Workshops-Carousel"]');?></div>
    </div>
  </div><!-- .homeContentWrap -->

  <section class="module parallax parallax-1">
    <div class="parallaxContent">
      <h2><?php the_field('parallax1_section_title');?></h2>
      <div class="block left">
        <?php the_field('parallax1_left_col');?>
      </div>
      <div class="block right">
        <?php the_field('parallax1_right_col');?>
      </div>
      <div class="clear"></div>
      <div class="downArrow"></div>
      <div class="clear"></div>
    </div>
  </section>

  <div class="homeContentWrap ageGroups">
    <div class="one-third first">
      <img src="wp-content/themes/naada-family2018/images/prenatal-postnatal.png" alt="prenatal yoga"/>
      <h3><?php the_field('age_group_1_title');?> </h2>
      <p><?php the_field('age_group_1_copy'); ?></h2>
    </div>

    <div class="one-third">
      <img src="wp-content/themes/naada-family2018/images/tweens-teens.png" alt="teen yoga"/>
      <h3><?php the_field('age_group_2_title');?></h3>
      <p><?php the_field('age_group_2_copy'); ?></h2>
    </div>

    <div class="one-third">
      <img src="wp-content/themes/naada-family2018/images/family-yoga.png" alt="family yoga"/>
      <h3><?php the_field('age_group_3_title');?></h3>
      <p><?php the_field('age_group_3_copy'); ?></h2>
    </div>
  </div>

  <!-- EMPTY -->
  <div class="homeContentWrap testimonials">
    <h2><?php the_field('testimonial_header');?> </h2>
    <?php
      thinkup_testimonials(9000);
    ?>
  </div>
  <div class="homeContentWrap instagram">
    <?php echo do_shortcode( '[instagram-feed]');?>
  </div>

  <!-- NYTT Parallax Section -->
  <!-- <section class="module parallax parallax-2">
    <div class="parallaxContent">
    <h2><?php// the_field('parallax2_section_title');?></h2>
      <div class="block left">
        <?php //the_field('parallax2_left_col');?>
      </div>
      <div class="block right">
        <?php //the_field('parallax2_right_col');?>
      </div>
      <div class="clear"></div>
      <a class="button orange-button medium" href="/yoga-teacher-training"><?php// the_field('parallax2_more');?></a>
      <div class="downArrow"></div>
      <div class="clear"></div>
    </div>
  </section> -->
<?php
}
  remove_action('genesis_loop', 'genesis_do_loop');
  add_action('genesis_loop', 'homepage_Output');
  //* This file handles pages, but only exists for the sake of child theme forward compatibility.
  genesis();
?>
