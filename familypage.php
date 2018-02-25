<?php /*
Template Name: Family Page
*/ ?>

<?php
add_action( 'genesis_after_header', 'naada_familyBanner', 10 );
function naada_familyBanner() {
  ?>
  <div class="familyBanner">

    <!-- Calls our Call out Widget -->
    <?php dynamic_sidebar("family_callout"); ?>

  </div>
  <?php
}
?>

<?php
//* This file handles pages, but only exists for the sake of child theme forward compatibility.
genesis();
?>
