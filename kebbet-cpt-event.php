<?php
/**
 * Plugin Name: Kebbet plugins - Custom Post Type: Event
 * Plugin URI:  https://github.com/kebbet/kebbet-cpt-event
 * Description: Registers a Custom Post Type.
 * Version:     1.2.0
 * Author:      Erik Betshammar
 * Author URI:  https://verkan.se
 * Update URI:  false
 *
 * @package kebbet-cpt-event
 * @author Erik Betshammar
 */

namespace cpt\kebbet\event;

const POSTTYPE    = 'calendar';
const SLUG        = 'calendar';
const ICON        = 'calendar';
const MENUPOS     = 6;
const THUMBNAIL   = false;

/**
 * Link to ICONS
 *
 * @link https://developer.wordpress.org/resource/dashicons/
 */

/**
 * Hook into the 'init' action
 */
function init() {
	load_textdomain();
	register();
	if ( true === THUMBNAIL ) {
		add_theme_support( 'post-thumbnails' );
	}
}
add_action( 'init', __NAMESPACE__ . '\init', 0 );

/**
 * Flush rewrite rules on registration.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
function rewrite_flush() {
	// First, we "add" the custom post type via the above written function.
	// Note: "add" is written with quotes, as CPTs don't get added to the DB,
	// They are only referenced in the post_type column with a post entry,
	// when you add a post of this CPT.
	register();

	// ATTENTION: This is *only* done during plugin activation hook in this example!
	// You should *NEVER EVER* do this on every page load!!
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\rewrite_flush' );

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'kebbet-cpt-event', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register Custom Post Type
 */
function register() {
	$labels_args   = array(
		'name'                     => _x( 'Events', 'Post Type General Name', 'kebbet-cpt-event' ),
		'singular_name'            => _x( 'Event', 'Post Type Singular Name', 'kebbet-cpt-event' ),
		'menu_name'                => __( 'Events', 'kebbet-cpt-event' ),
		'name_admin_bar'           => __( 'Event post', 'kebbet-cpt-event' ),
		'all_items'                => __( 'All posts', 'kebbet-cpt-event' ),
		'add_new_item'             => __( 'Add new', 'kebbet-cpt-event' ),
		'add_new'                  => __( 'Add new post', 'kebbet-cpt-event' ),
		'new_item'                 => __( 'New post', 'kebbet-cpt-event' ),
		'edit_item'                => __( 'Edit post', 'kebbet-cpt-event' ),
		'update_item'              => __( 'Update post', 'kebbet-cpt-event' ),
		'view_item'                => __( 'View post', 'kebbet-cpt-event' ),
		'view_items'               => __( 'View posts', 'kebbet-cpt-event' ),
		'search_items'             => __( 'Search posts', 'kebbet-cpt-event' ),
		'not_found'                => __( 'Not found', 'kebbet-cpt-event' ),
		'not_found_in_trash'       => __( 'No posts found in Trash', 'kebbet-cpt-event' ),
		'featured_image'           => __( 'Featured image', 'kebbet-cpt-event' ),
		'set_featured_image'       => __( 'Set featured image', 'kebbet-cpt-event' ),
		'remove_featured_image'    => __( 'Remove featured image', 'kebbet-cpt-event' ),
		'use_featured_image'       => __( 'Use as featured image', 'kebbet-cpt-event' ),
		'insert_into_item'         => __( 'Insert into item', 'kebbet-cpt-event' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this post', 'kebbet-cpt-event' ),
		'items_list'               => __( 'Items list', 'kebbet-cpt-event' ),
		'items_list_navigation'    => __( 'Items list navigation', 'kebbet-cpt-event' ),
		'filter_items_list'        => __( 'Filter items list', 'kebbet-cpt-event' ),
		'archives'                 => __( 'Event posts archive', 'kebbet-cpt-event' ),
		'attributes'               => __( 'Event post attributes', 'kebbet-cpt-event' ),
		'item_published'           => __( 'Post published', 'kebbet-cpt-event' ),
		'item_published_privately' => __( 'Post published privately', 'kebbet-cpt-event' ),
		'item_reverted_to_draft'   => __( 'Post reverted to Draft', 'kebbet-cpt-event' ),
		'item_scheduled'           => __( 'Post scheduled', 'kebbet-cpt-event' ),
		'item_updated'             => __( 'Post updated', 'kebbet-cpt-event' ),
		'filter_by_date'           => __( 'Filter posts by date', 'kebbet-cpt-event' ),
		'item_link'                => __( 'Event post link', 'kebbet-cpt-event' ),
		'item_link_description'    => __( 'A link to an event post', 'kebbet-cpt-event' ),
	);
	$supports_args = array(
		'title',
		'editor',
		'page-attributes',
	);

	if ( true === THUMBNAIL ) {
		$supports_args = array_merge( $supports_args, array( 'thumbnail' ) );
	}

	$rewrite_args      = array(
		'slug'       => SLUG,
		'with_front' => true,
		'pages'      => true,
		'feeds'      => false,
	);
	$capabilities_args = \cpt\kebbet\event\roles\capabilities();
	$post_type_args    = array(
		'label'               => __( 'Event post type', 'kebbet-cpt-event' ),
		'description'         => __( 'Custom post type for event', 'kebbet-cpt-event' ),
		'labels'              => $labels_args,
		'supports'            => $supports_args,
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => MENUPOS,
		'menu_icon'           => 'dashicons-' . ICON,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => SLUG,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite_args,
		'capabilities'        => $capabilities_args,
		'show_in_rest'        => false,
		'map_meta_cap'        => true,
	);
	register_post_type( POSTTYPE, $post_type_args );
}

/**
 * Add the content to the `At a glance`-widget.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/at-a-glance.php';

/**
 * Adds and modifies the admin columns for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-columns.php';

/**
 * Adjust roles and capabilities for post type
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/roles.php';

/**
 * Adds admin messages for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-messages.php';

/**
 * Adds contextual help.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/help.php';
