<?php
/**
 * Adjust role and capabilities for post type.
 *
 * @since 1.2.0
 *
 * @package kebbet-cpt-event
 */

namespace cpt\kebbet\event\roles;

use const cpt\kebbet\event\POSTTYPE;

/**
 * Adds custom capabilities to CPT. Adjust it with plugin URE later with its UI.
 */
function add_custom_capabilities() {
	$roles = array(
		'admin'  => get_role( 'administrator' ),
		'editor' => get_role( 'editor' ),
	);

	foreach ( $roles as $role ) {
		$role->add_cap( cap( '1' ) );
		$role->add_cap( cap( '2' ) );
		$role->add_cap( cap( '3' ) );
		$role->add_cap( cap( '4' ) );
		$role->add_cap( cap( '5' ) );
		$role->add_cap( cap( '6' ) );
		$role->add_cap( cap( '7' ) );
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\add_custom_capabilities' );

/**
 * Return capabilities for `register_post_type`
 *
 * @since 1.2.0
 *
 * @return array
 */
function capabilities() {
	return array(
		'edit_post'          => cap( '1' ),
		'edit_posts'         => cap( '2' ),
		'edit_others_posts'  => cap( '3' ),
		'publish_posts'      => cap( '4' ),
		'read_post'          => cap( '5' ),
		'read_private_posts' => cap( '6' ),
		'delete_post'        => cap( '7' ),
	);
}

/**
 * Return capability name string.
 *
 * @since 1.1.0
 *
 * @param string $value The value to get.
 * @return string
 */
function cap( $value ) {
	switch ( $value ) {
		case '1':
			$output = 'edit_' . POSTTYPE;
			break;
		
		case '2':
			$output = 'edit_' . POSTTYPE . 's';
			break;
		
		case '3':
			$output = 'edit_others_' . POSTTYPE . 's';
			break;
		
		case '4':
			$output = 'publish_' . POSTTYPE . 's';
			break;
		
		case '5':
			$output = 'read_' . POSTTYPE . 's';
			break;
		
		case '6':
			$output = 'read_private_' . POSTTYPE . 's';
			break;
		
		case '7':
			$output = 'delete_' . POSTTYPE;
			break;
		
		default:
			$output = '';
			break;
	}
	return $output;
}
