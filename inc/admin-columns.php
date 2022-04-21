<?php
/**
 * Adds and modifies the admin columns for the post type.
 *
 * @package kebbet-cpt-event
 */

namespace cpt\kebbet\event\admincolumns;

use const cpt\kebbet\event\POSTTYPE;

/**
 * Add additional admin column.
 *
 * @param array $columns The existing columns.
 * @return array
 */
function set_admin_column_list( $columns ) {
	unset( $columns['modified'] );
	unset( $columns['date'] );

	$columns['title']       = _x( 'Title / Name', 'Heading for column', 'kebbet-cpt-event' );
	$columns['name']        = _x( 'Title if name', 'Heading for column', 'kebbet-cpt-event' );
	$columns['date_time']   = _x( 'Event date & time', 'Heading for column', 'kebbet-cpt-event' );
	$columns['last_edited'] = __( 'Published and edited','kebbet-cpt-event' );
	
	return $columns;
}
add_filter( 'manage_' . POSTTYPE . '_posts_columns', __NAMESPACE__ . '\set_admin_column_list' );

/**
 * Add data to each row.
 *
 * @param string $column The column slug.
 * @param int    $post_id The post ID for the row.
 * @return void
 */
function populate_custom_columns( $column, $post_id ) {
	$date_format  = 'Y-m-d';
	$time_format  = 'H:i';

	switch ( $column ) {
		case "name":
			$extra_title = get_post_meta( $post_id, 'title_participants_tags_participants_text__participant', true );
			if ( ! empty( $extra_title ) ) {
		  		echo $extra_title;
			} else {
		  		echo '<i>' . __( 'Title not defined', 'kebbet-cpt-event' ) . '</i>';
			}
			break;
  
		case "date_time":
			$output      = '<i>' . __( 'Date and time not yet defined', 'kebbet-cpt-event' ) . '</i>';
			$time        = \get_field( 'whitin_event_datetime', $post_id );
			$occurrences = false;
			if ( isset( $time['event_occurrences'] ) ) {
				$occurrences = $time['event_occurrences'];
			}

			if ( $occurrences ) {
				$output = null;
				$count  = count( $occurrences );

				foreach ( $occurrences as $key => $event_details ) {
  
					$num   = $key+1;
					$date  = $event_details['event_date'];
					$start = $event_details['event_start_time'];
					$end   = $event_details['event_end_time'];
  
					if ( 1 === $count) {
						$output .= $date . ', ';
					} else {
						$output .= '<strong>#' . $num . '</strong>: ' . $date . ', ';
					}

					if ( ! empty( $end ) ) {
						$output .= $start . '&ndash;' . $end;
					} else {
						$output .= $start;
					}
					$output .= '<br/>';
		  		}
			}
			echo $output;
			break;
  
		case 'last_edited':
			switch ( get_post_status() ) {
				case 'draft':
					$output = __( 'Draft edited: %s at %s', 'kebbet-cpt-event' );
					break;

				case 'future':
					$output = __( 'Planned for: %s at %s', 'kebbet-cpt-event' );
					break;

				case 'publish':
				default:
					$output = __( 'Published: %s at %s', 'kebbet-cpt-event' );
					break;
			}
			$output  = sprintf(
				$output,
				esc_html( get_the_date( $date_format ) ),
				esc_html( get_the_time( $time_format ) )
			);
			$output .= '<br/>';
			$output .= sprintf(
				__( 'Last edited: %s at %s', 'kebbet-cpt-event' ),
				esc_html( get_the_modified_date( $date_format ) ),
				esc_html( get_the_modified_date( $time_format ) )
			);
			$output .= '<br/>';

			echo $output;
			break;
	}
}
add_action( 'manage_' . POSTTYPE . '_posts_custom_column', __NAMESPACE__ . '\populate_custom_columns', 10, 2 );
