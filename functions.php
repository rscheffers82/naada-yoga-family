<?php
// Start the engine

add_action('genesis_setup','genesischild_theme_setup', 15);
function genesischild_theme_setup() {

	add_theme_support( 'html5' );
	add_theme_support( 'genesis-responsive-viewport' );
	add_theme_support( 'genesis-footer-widgets', 3 );
  add_theme_support( 'woocommerce' );

	/* Remove Genesis menu link
	remove_theme_support( 'genesis-admin-menu' ); */

	//* Reposition the primary navigation menu & remove secondary nav
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
  remove_action( 'genesis_after_header', 'genesis_do_subnav' );
	add_action( 'genesis_before', 'genesis_do_nav' );

	add_action( 'get_header', 'child_remove_page_titles' );
	function child_remove_page_titles() {
	    if ( is_front_page() ) {
	        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	    }
		}

	add_action( 'genesis_before','remove_page_content' );

	function remove_page_content() {
			if ( is_page_template('landing.php') ) {
				remove_action( 'genesis_loop', 'genesis_do_loop' );
			}
	}


	//* Customize search form input box text
	add_filter( 'genesis_search_text', 'naada_search_text' );
	function naada_search_text( $text ) {
		//echo '<img src="/images/search.jpg" alt="search"/> Search';
		return esc_attr( ' ' );
	}

	//* Customize the credits
	add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
	function sp_footer_creds_text() {
		$currentDate = 	date('Y');
		printf('<div class="creds"><p> Copyright &copy; %s | <a href="/terms-conditions/">Terms & Conditions</a> <a href="#" class="naada-top naada-button green-button small">Go To Top</a></p></div>', $currentDate );
	}

	// Registers new Sidebar for  Family Banner Overlay

	$sidebars = array('Family Call Out');
	foreach ($sidebars as $sidebar) {
			register_sidebar(array('name'=> $sidebar,
				'id' => 'family_callout',
					'before_widget' => '<div class="familyCallout">',
					'after_widget' => '</div>',
					'before_title' => '<h2>',
					'after_title' => '</h2>'
			));
	}

	// Setup new Nav Menu location
	function register_my_menu() {
		register_nav_menu('naada-secondary',__( 'Naada Secondary Menu' ));
	}
	add_action( 'init', 'register_my_menu' );

	function add_naada_secondary() {
		 wp_nav_menu( array( 'theme_location' => 'naada-secondary' ) );
	}
	add_action('genesis_header', 'add_naada_secondary', 10);

} // End genesischild_theme_setup

// Add custom JS script
function naada_scripts() {
	wp_enqueue_script('parallax-scroll', get_stylesheet_directory_uri() . '/js/jquery.parallax.js', true);
  wp_enqueue_script( 'naada-custom', get_stylesheet_directory_uri() . '/js/naada-custom.js', array(), '1.0.0', true );
	wp_enqueue_script( 'slick', '//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js');
	wp_enqueue_script( 'jqueryUI', '//code.jquery.com/ui/1.11.4/jquery-ui.js');
	wp_enqueue_style( 'slick-css', '//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css');
	wp_enqueue_style( 'slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.5.7/slick-theme.css' );
}

add_action( 'wp_enqueue_scripts', 'naada_scripts' );

// Add Big JS files for homepage only
function naada_homepage_script() {
 if (is_front_page()){
	 wp_enqueue_script('naada-homepage', get_stylesheet_directory_uri() . '/js/naada-homepage.js', array(), '1.0.0', true);
 }
}
add_action('wp_enqueue_scripts', 'naada_homepage_script');

// Add JS Only to clinic pages
function clinic_script() {
	if (is_page( array('our-therapists', 'clinic-appointments', 'therapeutic-clinic'))) {
		wp_enqueue_script('clinic', get_stylesheet_directory_uri() . '/js/clinic.js', true);
	}
}
add_action('wp_enqueue_scripts', 'clinic_script');

function fbPixel() {
	?>
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '1403554433067380'); // Insert your pixel ID here.
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1403554433067380&ev=PageView&noscript=1"
	/></noscript>
	<!-- DO NOT MODIFY -->
	<!-- End Facebook Pixel Code -->
	<?php
}
// add_action('wp_head', 'fbPixel');

function pixelTrack() {
		echo '<script> fbq("track", "AddToCart", {value: 265.00, currency: "USD"}); </script>';
}
// add_action('genesis_before', 'pixelTrack');




// Adding FACEBOOK's Open Graph to Landing pages
//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
//add_filter('language_attributes', 'add_opengraph_doctype');

//
// FB OPEN GRAPH META FOR CUSTOM PAGES
//

function insert_fb_in_head() {
	if ( is_page( 8013 )) { //if it's Matthew's course page
        echo '<meta property="og:site_name" content="Naada Yoga Family" />
				<meta property="og:url" content="' . get_permalink() . '" />
				<meta property="og:title" content="' . get_the_title() . '" />
				<meta property="og:image" content="' . get_stylesheet_directory_uri() . '/images/opengraph/Ayurveda-with-Matthew.jpg" />
				<meta property="og:image:width" content="1200"/>
				<meta property="og:image:height" content="674"/>
				<meta property="og:description" content="' . get_field('course_short_description') . '"/>
				<meta property="og:type" content="article">';
			}
}
// add_action( 'wp_head', 'insert_fb_in_head', 5 );

add_filter('nimble_portfolio_taxonomy_slug', 'handle_nimble_portfolio_taxonomy_slug');
function handle_nimble_portfolio_taxonomy_slug() {
		return 'resources'; // you can use any name here provided its a valid slug
}

add_action('login_head', 'naada_custom_login_logo');
function naada_custom_login_logo() {
    echo '<style type="text/css">
    h1 a { background-image:url('.get_stylesheet_directory_uri().'/images/naada-family-logo.png) !important; background-size: 320px 100px !important;height: 88px !important; width: 320px !important; margin-bottom: 0 !important; padding-bottom: 10px !important; }
    .login form { margin-top: 10px !important; }
    </style>';
}

function naada_url_login_logo(){
    return get_bloginfo( 'wpurl' );
}
add_filter('login_headerurl', 'naada_url_login_logo');

function naada_modify_footer_admin () {
  echo '<span id="footer-thankyou">Theme by <a href="http://thinkupdesign.ca" target="_blank">Think Up! Design</a></span>';
}
add_filter('admin_footer_text', 'naada_modify_footer_admin');

// Add Read More Link to Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
   return '...&nbsp;<a href="' . get_permalink() . '">[Read&nbsp;More]</a>';
}



//Remove Annoying Woo THeme updater Notice
remove_action( 'admin_notices', 'woothemes_updater_notice' );

/* Paid Memberships Pro Super User Function */
/*
  Give level 5 members (Admins) access to everything.
  Add this to your active theme's functions.php or a custom plugin.
*/
function my_pmpro_has_membership_access_filter($access, $post, $user)
{
	if(!empty($user->membership_level) && $user->membership_level->ID == 5)
		return true;	//level 5 ALWAYS has access

	return $access;
}
add_filter("pmpro_has_membership_access_filter", "my_pmpro_has_membership_access_filter", 10, 3);

/* WooCommerce */

function filterProductDescription(){
	return "Course Description";
}
add_filter('woocommerce_product_description_heading', 'filterProductDescription');

function naada_cart_button_text() {
        return __( 'Purchase', 'woocommerce' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'naada_cart_button_text' );

function naadaOrderReceived() {
	return "Thank you. Your order is complete. For your records your account information and receipt of purchase have been emailed to you. If you are ready to start your course, visit the <a href=\"/online-school/my-courses/\">My Courses</a> page to begin.";
}
add_filter('woocommerce_thankyou_order_received_text', 'naadaOrderReceived');

/**
* Prints the Google Analytics tracking code in the Thank you page.
* @return void
*/
function wc_ga_conversion_tracking() {
if ( is_order_received_page() ) {
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-24471214-1', 'auto');
  ga('send', 'pageview');

</script>
<?php
}
}

/*
 * wc_remove_related_products
 *
*/
function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10);

/* Other Shortcodes */

function dropcap_shortcode( $atts, $content = null ) {
	return '<span class="dropcap">' . $content . '</span>';
}
add_shortcode( 'dropcap', 'dropcap_shortcode' );

function naada_button_orange ( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'link' => '/',
	), $atts );
	return '<a href="' . esc_attr($a['link']) . '" class="naada-button orange-button medium">' . $content . '</a>';
}
add_shortcode( 'button-1', 'naada_button_orange' );

function naada_login ( $atts, $content = null ) {
	return wp_login_form();
}
add_shortcode( 'naada-login', 'naada_login' );

function naada_login_redirect( $url, $request, $user ){
    if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        if( $user->has_cap( 'administrator' ) ) {
            $url = admin_url();
        } else {
            $url = home_url('/online-school/my-courses/');
        }
    }
    return $url;
}
add_filter('login_redirect', 'naada_login_redirect', 10, 3 );

function check_user ($params, $content = null){
  //check tha the user is logged in
  if ( !is_user_logged_in() ){
    //user is not logged in so show the content
    return do_shortcode($content);
  }
  else{
    //user is not logged in so hide the content
		$current_user = wp_get_current_user();
		echo '<p>Welcome ' . $current_user->user_login . ' | <a href="' . wp_logout_url(home_url()) .  '">Logout</a></p>';
    return;
  }
}

//add a shortcode which calls the above function
add_shortcode('notloggedin', 'check_user' );

// function rowWrapper ($atts, $content = null) {
// 	return '<div class="row">' . do_shortcode($content) . '</div>';
// }
// add_shortcode('row', 'rowWrapper');

function twoColumnLayout ($atts, $content = null) {
	return '<div class="twocol">' . do_shortcode($content) . '</div>';
}
add_shortcode('twoColumn', 'twoColumnLayout');


/* Shortcodes for YTT Custom Fields **
*********************************** */

	// Asana 101
function naada_asana101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('asana_101_instructor_link', 9 ) . '"> ' . get_field('asana_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('asana_101_instructor_link', 9 ) . '"> ' . get_field('asana_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'asana-101-instructor', 'naada_asana101_instructor' );

function naada_asana101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('asana_101_dates', 9 ) . '</span>';
}
add_shortcode( 'asana-101-dates', 'naada_asana101_dates' );

	// Anatomy 101
function naada_anatomy101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('anatomy_101_instructor_link', 9 ) . '"> ' . get_field('anatomy_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('anatomy_101_instructor_link', 9 ) . '"> ' . get_field('anatomy_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'anatomy-101-instructor', 'naada_anatomy101_instructor' );

function naada_anatomy101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('anatomy_101_dates', 9 ) . '</span>';
}
add_shortcode( 'anatomy-101-dates', 'naada_anatomy101_dates' );

	// Asana 102
function naada_asana102_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('asana_102_instructor_link', 9 ) . '"> ' . get_field('asana_102_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('asana_102_instructor_link', 9 ) . '"> ' . get_field('asana_102_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'asana-102-instructor', 'naada_asana102_instructor' );

function naada_asana102_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('asana_102_dates', 9 ) . '</span>';
}
add_shortcode( 'asana-102-dates', 'naada_asana102_dates' );

	// Philosophy 101
function naada_philosophy101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('philosophy_101_instructor_link', 9 ) . '"> ' . get_field('philosophy_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('philosophy_101_instructor_link', 9 ) . '"> ' . get_field('philosophy_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'philosophy-101-instructor', 'naada_philosophy101_instructor' );

function naada_philosophy101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('philosophy_101_dates', 9 ) . '</span>';
}
add_shortcode( 'philosophy-101-dates', 'naada_philosophy101_dates' );

	// Assisting 101
function naada_assisting101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('assisting_101_instructor_link', 9 ) . '"> ' . get_field('assisting_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('assisting_101_instructor_link', 9 ) . '"> ' . get_field('assisting_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'assisting-101-instructor', 'naada_assisting101_instructor' );

function naada_assisting101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('assisting_101_dates', 9 ) . '</span>';
}
add_shortcode( 'assisting-101-dates', 'naada_assisting101_dates' );

// Restorative 101
function naada_restorative101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('restorative_101_instructor_link', 9 ) . '"> ' . get_field('restorative_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('restorative_101_instructor_link', 9 ) . '"> ' . get_field('restorative_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'restorative-101-instructor', 'naada_restorative101_instructor' );

function naada_restorative101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('restorative_101_dates', 9 ) . '</span>';
}
add_shortcode( 'restorative-101-dates', 'naada_restorative101_dates' );

	// Meditation 101
function naada_meditation101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('meditation_101_instructor_link', 9 ) . '"> ' . get_field('meditation_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('meditation_101_instructor_link', 9 ) . '"> ' . get_field('meditation_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'meditation-101-instructor', 'naada_meditation101_instructor' );

function naada_meditation101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('meditation_101_dates', 9 ) . '</span>';
}
add_shortcode( 'meditation-101-dates', 'naada_meditation101_dates' );

	// Asana 103
function naada_asana103_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('asana_103_instructor_link', 9 ) . '"> ' . get_field('asana_103_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('asana_103_instructor_link', 9 ) . '"> ' . get_field('asana_103_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'asana-103-instructor', 'naada_asana103_instructor' );

function naada_asana103_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('asana_103_dates', 9 ) . '</span>';
}
add_shortcode( 'asana-103-dates', 'naada_asana103_dates' );

	// Pranayama 101
function naada_pranayama101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('pranayama_101_instructor_link', 9 ) . '"> ' . get_field('pranayama_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('pranayama_101_instructor_link', 9 ) . '"> ' . get_field('pranayama_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'pranayama-101-instructor', 'naada_pranayama101_instructor' );

function naada_pranayama101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('pranayama_101_dates', 9 ) . '</span>';
}
add_shortcode( 'pranayama-101-dates', 'naada_pranayama101_dates' );

	// Naada 101
function naada_naada101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('naada_101_instructor_link', 9 ) . '"> ' . get_field('naada_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('naada_101_instructor_link', 9 ) . '"> ' . get_field('naada_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'naada-101-instructor', 'naada_naada101_instructor' );

function naada_naada101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('naada_101_dates', 9 ) . '</span>';
}
add_shortcode( 'naada-101-dates', 'naada_naada101_dates' );

	// Yoga Therapy 101
function naada_yogatherapy101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('yoga_therapy_101_instructor_link', 9 ) . '"> ' . get_field('yoga_therapy_101_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('yoga_therapy_101_instructor_link', 9 ) . '"> ' . get_field('yoga_therapy_101_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'yoga-therapy-101-instructor', 'naada_yogatherapy101_instructor' );

function naada_yogatherapy101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('yoga_therapy_101_dates', 9 ) . '</span>';
}
add_shortcode( 'yoga-therapy-101-dates', 'naada_yogatherapy101_dates' );

	// Advanced Anatomy
function naada_advancedanatomy101_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('advanced_anatomy_instructor_link', 9 ) . '"> ' . get_field('advanced_anatomy_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('advanced_anatomy_instructor_link', 9 ) . '"> ' . get_field('advanced_anatomy_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'advanced-anatomy-instructor', 'naada_advancedanatomy101_instructor' );

function naada_advancedanatomy101_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('advanced_anatomy_dates', 9 ) . '</span>';
}
add_shortcode( 'advanced-anatomy-dates', 'naada_advancedanatomy101_dates' );

	// Ayurveda
function naada_ayurveda_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('ayurveda_instructor_link', 9 ) . '"> ' . get_field('ayurveda_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('ayurveda_instructor_link', 9 ) . '"> ' . get_field('ayurveda_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'ayurveda-instructor', 'naada_ayurveda_instructor' );

function naada_ayurveda_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('ayurveda_dates', 9 ) . '</span>';
}
add_shortcode( 'ayurveda-dates', 'naada_ayurveda_dates' );

	// Back Care
function naada_back_care_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('back_care_instructor_link', 9 ) . '"> ' . get_field('back_care_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('back_care_instructor_link', 9 ) . '"> ' . get_field('back_care_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'back-care-instructor', 'naada_back_care_instructor' );

function naada_back_care_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('back_care_dates', 9 ) . '</span>';
}
add_shortcode( 'back-care-dates', 'naada_back_care_dates' );

	// Psychology
function naada_psychology_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('psychology_instructor_link', 9 ) . '"> ' . get_field('psychology_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('psychology_instructor_link', 9 ) . '"> ' . get_field('psychology_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'psychology-instructor', 'naada_psychology_instructor' );

function naada_psychology_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('psychology_dates', 9 ) . '</span>';
}
add_shortcode( 'psychology-dates', 'naada_psychology_dates' );

	// Yoga Wall
function naada_yoga_wall_instructor ( $atts ){
		if (ICL_LANGUAGE_CODE == 'fr' ) {
			return '<span class="naada-instructor"><a href="/fr' . get_field('yoga_wall_instructor_link', 9 ) . '"> ' . get_field('yoga_wall_instructor', 9 ) . '</a></span>';				} else {
			return '<span class="naada-instructor"><a href="' . get_field('yoga_wall_instructor_link', 9 ) . '"> ' . get_field('yoga_wall_instructor', 9 ) . '</a></span>'; }
	}
add_shortcode( 'yoga-wall-instructor', 'naada_yoga_wall_instructor' );

function naada_yoga_wall_dates ( $atts ){
	return '<span class="naada-dates">' . get_field('yoga_wall_dates', 9 ) . '</span>';
}
add_shortcode( 'yoga-wall-dates', 'naada_yoga_wall_dates' );

// Intake & Assessment
function naada_intake_instructor ( $atts ){
	if (ICL_LANGUAGE_CODE == 'fr' ) {
		return '<span class="naada-instructor"><a href="/fr' . get_field('intake_instructor_link', 9 ) . '"> ' . get_field('intake_instructor', 9 ) . '</a></span>';				} else {
		return '<span class="naada-instructor"><a href="' . get_field('intake_instructor_link', 9 ) . '"> ' . get_field('intake_instructor', 9 ) . '</a></span>'; }
}
add_shortcode( 'intake-instructor', 'naada_intake_instructor' );

function naada_intake_dates ( $atts ){
return '<span class="naada-dates">' . get_field('intake_dates', 9 ) . '</span>';
}
add_shortcode( 'intake-dates', 'naada_intake_dates' );

// Intake & Assessment
function naada_pelvic_instructor ( $atts ){
	if (ICL_LANGUAGE_CODE == 'fr' ) {
		return '<span class="naada-instructor"><a href="/fr' . get_field('pelvic_instructor_link', 9 ) . '"> ' . get_field('pelvic_instructor', 9 ) . '</a></span>';				} else {
		return '<span class="naada-instructor"><a href="' . get_field('pelvic_instructor_link', 9 ) . '"> ' . get_field('pelvic_instructor', 9 ) . '</a></span>'; }
}
add_shortcode( 'pelvic-instructor', 'naada_pelvic_instructor' );

function naada_pelvic_dates ( $atts ){
return '<span class="naada-dates">' . get_field('pelvic_dates', 9 ) . '</span>';
}
add_shortcode( 'pelvic-dates', 'naada_pelvic_dates' );
?>
