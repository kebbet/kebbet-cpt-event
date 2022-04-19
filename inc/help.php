<?php
/**
 * Add contextual help.
 *
 * @since 1.2.0
 *
 * @package kebbet-cpt-event
 */

namespace cpt\kebbet\event\help;

use const cpt\kebbet\event\POSTTYPE;

/**
 * Display contextual help for calendar events
 *
 * @return void
 */
function add_context_menu_help() {
	$current_screen = get_current_screen();
	$args_tab_1     = array(
		'id'       => 'cpt_' . POSTTYPE . '_help_screen_1',
		'title'    => __( 'General', 'kebbet-cpt-event' ),
		'callback' => __NAMESPACE__ . '\content_tab_1'
	);
	$args_tab_2     =  array(
		'id'       => 'cpt_' . POSTTYPE . '_help_screen_2',
		'title'    => __( 'Schedule posting', 'kebbet-cpt-event' ),
		'callback' => __NAMESPACE__ . '\content_tab_2'
	);
	$args_tab_3     =  array(
		'id'       => 'cpt_' . POSTTYPE . '_help_screen_3',
		'title'    => __( 'General', 'kebbet-cpt-event' ),
		'callback' => __NAMESPACE__ . '\content_tab_3'
	);

	switch ( $current_screen->id ) {
		 // The edit view.
		case 'calendar':
			$current_screen->set_help_sidebar( content_sidebar() );
			$current_screen->add_help_tab( $args_tab_1 );
			$current_screen->add_help_tab( $args_tab_2 );
			break;

		// The list view.
		case 'edit-calendar':
			$current_screen->set_help_sidebar( content_sidebar() );
			$current_screen->add_help_tab( $args_tab_3 );
			break;

		default:
			break;
	}
}
add_action( 'admin_head', __NAMESPACE__ . '\add_context_menu_help' );

/**
 * Content for help tab 1
 *
 * @return void
 */
function content_tab_1() {
	$tab_content  = '<h4>' . __( 'Things to remember when adding or editing an calendar event:', 'kebbet-cpt-event' ) . '</h4>';
	$tab_content .= '<ul>';
	$tab_content .= '<li>' . __( 'Specify the correct title', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '<li>' . __( 'Specify the correct thumbnail of the event. Remember that the image will be shown on the front page of the website.', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '<li>' . __( 'Specify the correct year of the event. Remember that the year will be shown on the website.', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '</ul>';

	echo $tab_content;
}

/**
 * Content for help tab 2
 *
 * @return void
 */
function content_tab_2() {
	$tab_content  = '<h4>' . __( 'If you want to schedule the calendar event to be published in the future:', 'kebbet-cpt-event' ) . '</h4>';
	$tab_content .= '<ul>';
	$tab_content .= '<li>' . __( 'Under the Publish module, click on the Edit link next to Publish (on the last line, above the Publish-button).', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '<li>' . __( 'Change the date to the date you actually want to publish this article, then click on Ok.', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '<li>' . __( 'Press the button Schedule, and wait for right time and date.', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '</ul>';

	echo $tab_content;
}

/**
 * Content for help tab 3
 *
 * @return void
 */
function content_tab_3() {
	$tab_content  = '<h4>' . __( 'Things to remember in this list view.', 'kebbet-cpt-event' ) . '</h4>';
	$tab_content .= '<ul>';
	$tab_content .= '<li>' . __( 'Click, drag and drop the events to sort them in preferred order.', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '<li>' . __( 'The order of the events here will be reflected on the front page', 'kebbet-cpt-event' ) . '</li>';
	$tab_content .= '</ul>';

	echo $tab_content;
}

/**
 * Content for sidebar.
 *
 * @return string
 */
function content_sidebar() {
	$output  = '<p><strong>' . __( 'For more information:', 'kebbet-cpt-event' ) . '</strong></p>';
	$output .= '<p>' . sprintf( __( '%sEdit Posts Documentation%s', 'kebbet-cpt-event' ), '<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">', '</a>' );
	$output .= '<p>' . sprintf( __( '%sSupport Forums%s', 'kebbet-cpt-event' ), '<a href="http://wordpress.org/support/" target="_blank">', '</a>' );

	return $output;
}
