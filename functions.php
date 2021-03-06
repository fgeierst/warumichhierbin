<?php
add_action( 'after_setup_theme', 'wihb_setup' );
function wihb_setup() {
load_theme_textdomain( 'wihb', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'search-form' ) );
global $content_width;
if ( ! isset( $content_width ) ) { $content_width = 1920; }
register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'wihb' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wihb_load_scripts' );
function wihb_load_scripts() {
wp_enqueue_style( 'wihb-style', get_stylesheet_uri() );
// wp_enqueue_style( 'custom', get_template_directory_uri() . '/style_custom.css',false,'1.1','all');
// wp_enqueue_script( 'jquery' );
}
add_action( 'wp_footer', 'wihb_footer_scripts' );
function wihb_footer_scripts() {
?>
<script>

</script>
<?php
}
add_filter( 'document_title_separator', 'wihb_document_title_separator' );
function wihb_document_title_separator( $sep ) {
$sep = '|';
return $sep;
}
add_filter( 'the_title', 'wihb_title' );
function wihb_title( $title ) {
if ( $title == '' ) {
return '...';
} else {
return $title;
}
}
add_filter( 'the_content_more_link', 'wihb_read_more_link' );
function wihb_read_more_link() {
if ( ! is_admin() ) {
return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">...</a>';
}
}
add_filter( 'excerpt_more', 'wihb_excerpt_read_more_link' );
function wihb_excerpt_read_more_link( $more ) {
if ( ! is_admin() ) {
global $post;
return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">...</a>';
}
} 

// add_filter( 'intermediate_image_sizes_advanced', 'wihb_image_insert_override' );
// function wihb_image_insert_override( $sizes ) {
// unset( $sizes['medium_large'] );
// return $sizes;
// }

add_action( 'widgets_init', 'wihb_widgets_init' );
function wihb_widgets_init() {
register_sidebar( array(
'name' => esc_html__( 'Sidebar Widget Area', 'wihb' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'wp_head', 'wihb_pingback_header' );
function wihb_pingback_header() {
if ( is_singular() && pings_open() ) {
printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
}
add_action( 'comment_form_before', 'wihb_enqueue_comment_reply_script' );
function wihb_enqueue_comment_reply_script() {
if ( get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}
}

function wihb_custom_pings( $comment ) {
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php
}
add_filter( 'get_comments_number', 'wihb_comment_count', 0 );
function wihb_comment_count( $count ) {
if ( ! is_admin() ) {
global $id;
$get_comments = get_comments( 'status=approve&post_id=' . $id );
$comments_by_type = separate_comments( $get_comments );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}

// SVG support  - https://blog.kulturbanause.de/2013/05/svg-dateien-in-die-wordpress-mediathek-hochladen/

function kb_svg ( $svg_mime ){
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}

add_filter( 'upload_mimes', 'kb_svg' );

function kb_ignore_upload_ext($checked, $file, $filename, $mimes){

 if(!$checked['type']){
 $wp_filetype = wp_check_filetype( $filename, $mimes );
 $ext = $wp_filetype['ext'];
 $type = $wp_filetype['type'];
 $proper_filename = $filename;

 if($type && 0 === strpos($type, 'image/') && $ext !== 'svg'){
 $ext = $type = false;
 }

 $checked = compact('ext','type','proper_filename');
 }

 return $checked;
}

add_filter('wp_check_filetype_and_ext', 'kb_ignore_upload_ext', 10, 4);

// statify - show stats for different roles

add_filter(
    'statify__user_can_see_stats',
    current_user_can('edit_others_pages' )
);

/* Load properly size images by adding more media conditions / slot sizes
	 https://www.smashingmagazine.com/2015/12/responsive-images-in-wordpress-core/ 
	 Set $sizes corresponding to your settings in /wp-admin/options-media.php
	 Note that medium_large (768px) is available, but not displayed in options-media.php
	 Example: $sizes = '(max-width: 500px) 500px, (max-width: 768px) 768px, 1024px';

*/

function adjust_image_sizes_attr( $sizes, $size ) {
	$sizes = '(max-width: 500px) 500px, (max-width: 768px) 768px, 1024px';
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'adjust_image_sizes_attr', 10 , 2 );