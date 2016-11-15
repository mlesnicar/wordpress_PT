<?php
/**
 * beam functions and definitions
 *
 * @package beam
 */


if ( ! function_exists( 'beam_setup' ) ) :

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */

function beam_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'beam', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	
	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 */
	if ( function_exists( 'add_theme_support' ) ) { 
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions, cropped
		// additional image sizes
        add_image_size( 'beam-small-thumbnail', 80, 80, true ); 
		add_image_size( 'beam-big-thumbnail', 600, 220); 
		add_image_size( 'beam-large-thumbnail', 720, 340 ); 
	}


	/**
	* This theme uses wp_nav_menu() in two locations.
	*/
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'beam' ),
		'footer' => __( 'Footer Menu', 'beam' ),
	) );

	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	
	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );
	
	// Enable support for Custom Logo
    add_theme_support('custom-logo');

	
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'beam_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
}
endif; // beam_setup
add_action( 'after_setup_theme', 'beam_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function beam_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'beam_content_width', 1170 );
}
add_action( 'after_setup_theme', 'beam_content_width', 0 );


/**
 * Register widgetized area and update sidebar with default widgets
 */
function beam_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar Right', 'beam' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar Left', 'beam' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar Home', 'beam' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );	

	register_sidebar( array(
		'name'          => __( 'Footer Widget', 'beam' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'beam_widgets_init' );


/**
 * Enqueue Scripts
 */
function beam_scripts() {
	wp_enqueue_script( 'beam-js-scripts', get_template_directory_uri() . '/js/beam-scripts.min.js', array('jquery'), '20160817', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'beam_scripts' );


/**
 * Enqueue Styles
 */
function beam_styles() 
{
	wp_enqueue_style( 'style', get_stylesheet_uri() );
    //wp_enqueue_style( 'beam-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '4.0.3' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/inc/fonts/css/font-awesome.min.css' ); // Local
}
add_action( 'wp_enqueue_scripts', 'beam_styles' ); 


/**
 * Add Kirki Toolkit
 */
if( ! class_exists('Kirki') ) {
	include_once( dirname( __FILE__ ) . '/inc/adm/kirki/kirki.php' );
}
require_once('options-config.php');


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/*
 * Load content-one content
 * Used in Include One template
 * to-do: check if template actually being used
 */ 
function beam_load_content_one($path) {
        $post = get_page_by_path($path);
        $content = apply_filters('the_content', $post->post_content);
        echo $content;
}

/**
 * Plugin Recommendation
 */
include_once( dirname( __FILE__ ) . '/inc/adm/tgm/install.php' );

/*-----------------------------------------------------------------------------------------------------*/
/* CUSTOM POST TYPE  */
function custom_post_type(){
	$labels = array(
		'name' => 'Eventi',
		'singular_name' => 'Event',
		'add_new' => 'Dodaj event',
		'all_items' => 'Svi eventi',
		'add_new_item' => 'Dodaj event',
		'eidt_item' => 'Uredi event',
		'new_item' => 'Novi event',
		'view_item' => 'Pogledaj event',
		'search_event' => 'Trazi event',
		'not_found' => 'Nije pronaden event',
		'parent_item_colon' => 'Parent Item',		
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revision',
		),
		'taxonomies' => array('Kategorija', 'post_tag'),
		'menu_position' => 5,
		'exclude_form_search' => false,
		'register_meta_box_cb' => 'ep_eventposts_metaboxes' //metabox
		);
	register_post_type('eventi',$args);
} 
add_action('init','custom_post_type');



/* CUSTOM TAXONOMY  */
function custom_taxonomies() {	
	$labels = array(
		'name' => 'Kategorija',
		'singular_name' => 'Kategorija',
		'search_items' => 'Searchs Kategorija',
		'all_items' => 'Sve Kategorija',
		'parent_item' => 'Parent Kategorija',
		'parent_item_colon' => 'Parent Kategorija:',
		'edit_item' => 'Uredi Kategorija',
		'update_item' => 'Update Kategorija',
		'add_new_item' => 'Dodaj novu Kategoriju',
		'new_item_name' => 'New Kategorija Name',
		'menu_name' => 'Kategorije'
		);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slog' => 'Kategorija')
		);
	register_taxonomy('Kategorija', array('eventi'), $args);
}
add_action('init', 'custom_taxonomies');



/* META BOX */
function ep_eventposts_metaboxes($post) {
    add_meta_box( 'ept_event_date_start', 'Početak eventa', 'ept_event_date', 'eventi', 'normal', 'default');
    add_meta_box( 'ept_event_date_end', 'Završetak eventa', 'ept_event_date', 'eventi', 'normal', 'default');
}
add_action( 'admin_init', 'ep_eventposts_metaboxes' );

// Metabox HTML
function ept_event_date($post, $args) {
    $metabox_id = $args['args']['id'];
    global $post, $wp_locale;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ep_eventposts_nonce' );
    $time_adj = current_time( 'timestamp' );
    $month = get_post_meta( $post->ID, $metabox_id . '_month', true );
    if ( empty( $month ) ) {
        $month = gmdate( 'm', $time_adj );
    }
    $day = get_post_meta( $post->ID, $metabox_id . '_day', true );
    if ( empty( $day ) ) {
        $day = gmdate( 'd', $time_adj );
    }
    $year = get_post_meta( $post->ID, $metabox_id . '_year', true );
    if ( empty( $year ) ) {
        $year = gmdate( 'Y', $time_adj );
    }
    $hour = get_post_meta($post->ID, $metabox_id . '_hour', true);
    if ( empty($hour) ) {
        $hour = gmdate( 'H', $time_adj );
    }
    $min = get_post_meta($post->ID, $metabox_id . '_minute', true);
    if ( empty($min) ) {
        $min = '00';
    }
    $month_s = '<select name="' . $metabox_id . '_month">';
    for ( $i = 1; $i < 13; $i = $i +1 ) {
        $month_s .= "\t\t\t" . '<option value="' . zeroise( $i, 2 ) . '"';
        if ( $i == $month )
            $month_s .= ' selected="selected"';
        $month_s .= '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . "</option>\n";
    }
    $month_s .= '</select>';
    echo $month_s;
    echo '<input type="text" name="' . $metabox_id . '_day" value="' . $day  . '" size="2" maxlength="2" />';
    echo '<input type="text" name="' . $metabox_id . '_year" value="' . $year . '" size="4" maxlength="4" /> ';
    echo '<input type="text" name="' . $metabox_id . '_hour" value="' . $hour . '" size="2" maxlength="2"/>:';
    echo '<input type="text" name="' . $metabox_id . '_minute" value="' . $min . '" size="2" maxlength="2" />';
}

// Save the Metabox Data
function ep_eventposts_save_meta( $post_id, $post ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( !isset( $_POST['ep_eventposts_nonce'] ) )
        return;
    if ( !wp_verify_nonce( $_POST['ep_eventposts_nonce'], plugin_basename( __FILE__ ) ) )
        return;
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ) )
        return;
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though
    $metabox_ids = array( '_start', '_end' );
    foreach ($metabox_ids as $key ) {
        $events_meta[$key . '_month'] = $_POST[$key . '_month'];
        $events_meta[$key . '_day'] = $_POST[$key . '_day'];
            if($_POST[$key . '_hour']<10){
                 $events_meta[$key . '_hour'] = '0'.$_POST[$key . '_hour'];
             } else {
                   $events_meta[$key . '_hour'] = $_POST[$key . '_hour'];
             }
        $events_meta[$key . '_year'] = $_POST[$key . '_year'];
        $events_meta[$key . '_hour'] = $_POST[$key . '_hour'];
        $events_meta[$key . '_minute'] = $_POST[$key . '_minute'];
        $events_meta[$key . '_eventtimestamp'] = $events_meta[$key . '_year'] . $events_meta[$key . '_month'] . $events_meta[$key . '_day'] . $events_meta[$key . '_hour'] . $events_meta[$key . '_minute'];
    }
    // Add values of $events_meta as custom fields
    foreach ( $events_meta as $key => $value ) { // Cycle through the $events_meta array!
        if ( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode( ',', (array)$value ); // If $value is an array, make it a CSV (unlikely)
        if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
            update_post_meta( $post->ID, $key, $value );
        } else { // If the custom field doesn't have a value
            add_post_meta( $post->ID, $key, $value );
        }
        if ( !$value ) delete_post_meta( $post->ID, $key ); // Delete if blank
    }
}
add_action( 'save_post', 'ep_eventposts_save_meta', 1, 2 );


/**
 * Helpers to display the date on the front end
 */
// Get the Month Abbreviation

function eventposttype_get_the_month_abbr($month) {
    global $wp_locale;
    for ( $i = 1; $i < 13; $i = $i +1 ) {
                if ( $i == $month )
                    $monthabbr = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
                }
    return $monthabbr;
}
// Display the date
function eventposttype_get_the_event_date() {
    global $post;
    $eventdate = '';
    $month = get_post_meta($post->ID, '_month', true);
    $eventdate = eventposttype_get_the_month_abbr($month);
    $eventdate .= ' ' . get_post_meta($post->ID, '_day', true) . ',';
    $eventdate .= ' ' . get_post_meta($post->ID, '_year', true);
    $eventdate .= ' at ' . get_post_meta($post->ID, '_hour', true);
    $eventdate .= ':' . get_post_meta($post->ID, '_minute', true);
    echo $eventdate;
}

/* CUSTOM POST TYPE REZERVACIJE  */
function custom_post_type_reservation(){
	$labels = array(
		'name' => 'Rezervacije',
		'singular_name' => 'Rezervacija',
		'add_new' => 'Dodaj rezervaciju',
		'all_items' => 'Sve rezervacije',
		'add_new_item' => 'Dodaj rezervaciju',
		'eidt_item' => 'Uredi rezervaciju',
		'new_item' => 'Nova rezervacija',
		'view_item' => 'Pogledaj rezervaciju',
		'search_event' => 'Trazi rezervaciju',
		'not_found' => 'Nije pronadena rezervacija',
		'parent_item_colon' => 'Parent Item',		
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revision',
		),
		'taxonomies' => array('Rezervacije', 'post_tag'),
		'menu_position' => 6,
		'exclude_form_search' => false,
		'register_meta_box_cb' => 'ep_eventposts_metaboxes' //metabox
		);
	register_post_type('rezervacije',$args);
} 
add_action('init','custom_post_type_reservation');