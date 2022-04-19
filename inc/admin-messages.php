<?php
/**
 * Adds admin messages or the post type.
 *
 * @since 1.1.0
 *
 * @package kebbet-cpt-event
 */

namespace cpt\kebbet\event\adminmessages;

use const cpt\kebbet\event\POSTTYPE;

/**
 * Post type update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 * @return array Amended post update messages with new CPT update messages.
 */
function post_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages[ POSTTYPE ] = array(
		0  => '',
		1  => __( 'Post updated.', 'kebbet-cpt-event' ),
		2  => __( 'Custom field updated.', 'kebbet-cpt-event' ),
		3  => __( 'Custom field deleted.', 'kebbet-cpt-event' ),
		4  => __( 'Post updated.', 'kebbet-cpt-event' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Post restored to revision from %s', 'kebbet-cpt-event' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Post published.', 'kebbet-cpt-event' ),
		7  => __( 'Post saved.', 'kebbet-cpt-event' ),
		8  => __( 'Post submitted.', 'kebbet-cpt-event' ),
		9  => sprintf(
			/* translators: %1$s: date and time of the scheduled post */
			__( 'Post scheduled for: <strong>%1$s</strong>.', 'kebbet-cpt-event' ),
			date_i18n( __( 'M j, Y @ G:i', 'kebbet-cpt-event' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Post draft updated.', 'kebbet-cpt-event' ),
	);
	if ( $post_type_object->publicly_queryable && POSTTYPE === $post_type ) {
		$permalink         = get_permalink( $post->ID );
		$view_link         = sprintf(
			' <a href="%s">%s</a>',
			esc_url( $permalink ),
			__( 'View Post', 'kebbet-cpt-event' )
		);
		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link      = sprintf(
			' <a target="_blank" href="%s">%s</a>',
			esc_url( $preview_permalink ),
			__( 'Preview Post', 'kebbet-cpt-event' )
		);

		$messages[ $post_type ][1]  .= $view_link;
		$messages[ $post_type ][6]  .= $view_link;
		$messages[ $post_type ][9]  .= $view_link;
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}
add_filter( 'post_updated_messages', __NAMESPACE__ . '\post_updated_messages' );

/**
 * Custom bulk post updates messages
 *
 * @param array  $bulk_messages The messages for bulk updating posts.
 * @param string $bulk_counts Number of updated posts.
 */
function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {
	$bulk_messages[ POSTTYPE ] = array(
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'updated'   => _n( '%s event updated.', '%s events updated.', number_format_i18n( $bulk_counts['updated'] ), 'kebbet-cpt-event' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'locked'    => _n( '%s event not updated, somebody is editing it.', '%s events not updated, somebody is editing them.', number_format_i18n( $bulk_counts['locked'] ), 'kebbet-cpt-event' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'deleted'   => _n( '%s event permanently deleted.', '%s events permanently deleted.', number_format_i18n( $bulk_counts['deleted'] ), 'kebbet-cpt-event' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'trashed'   => _n( '%s event moved to the Trash.', '%s events moved to the Trash.', number_format_i18n( $bulk_counts['trashed'] ), 'kebbet-cpt-event' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'untrashed' => _n( '%s event restored from the Trash.', '%s events restored from the Trash.', number_format_i18n( $bulk_counts['untrashed'] ), 'kebbet-cpt-event' ),
	);

	return $bulk_messages;
}
add_filter( 'bulk_post_updated_messages', __NAMESPACE__ . '\bulk_post_updated_messages', 10, 2 );
