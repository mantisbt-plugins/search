<?php
/**
 * Copyright (C) 2009	Kirill Krasnov
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

/**
 * Prepare table-row with bug data
 * @param int $t_bug_id
 * @return string
 */
function prepare_search_bug_data( $t_bug_id )
{
	$result = '';
	$c_bug_id = db_prepare_int( $t_bug_id );
	if ( bug_exists( $c_bug_id ) ) {
		$t_icon_path = config_get( 'icon_path' );
		$g_bug = bug_get( $c_bug_id );
		$status_color = get_status_color( $g_bug->status );
		$result .= '<tr bgcolor="' . $status_color . '">';
		$result .= '<td class="center" valign="top" width ="0" nowrap="nowrap">';
		$result .= '<span class="small"';
		$result .= string_get_bug_view_link( $c_bug_id );
		$result .= '</span><br />';
		if( VS_PRIVATE == $g_bug->view_state ) {
			$result .= '<img src="' . $t_icon_path . 'protected.gif" width="8" height="15" alt="' . lang_get( 'private' ) . '" />';
		}
		$result .= '</span></td><td class="left" valign="top" width="80%"><span class="small">';
		$result .= $g_bug->summary;
		$result .= '</span></td><td class="left" valign="top"><span class="small">';
		$result .= user_get_name( $g_bug->reporter_id );
		$result	.= '</span></td>';
		$result .= '</tr>';
	}
	return $result;
}

/**
 * Return bug id from bugnote id
 * @param int $t_bugnote_id
 * @return int
 */
function get_bug_id_from_bugnote_id( $t_bugnote_id ) {
	$c_bugnote_id = db_prepare_int( $t_bugnote_id );
	$t_bug_id = 0;
	if ( bugnote_exists( $c_bugnote_id )){
		$t_table = db_get_table( 'bugnote' );
		$query = 'select bug_id from ' . $t_table . ' where ' .db_helper_like( 'bugnote_text_id' );
		$result = db_query_bound( $query, array( $c_bugnote_id ) );
		$count = db_num_rows( $result );
		if ($count != 0) { 
			$row = db_fetch_array( $result ); 
			$t_bug_id = db_prepare_int( $row['bug_id'] ); 
		}
	}
	return $t_bug_id;
}

form_security_validate( 'plugin_Search_search_press' );

$g_text = '%' . gpc_get_string( 'text' ) . '%';
$g_param[] = $g_text;
$g_param[] = $g_text;
$g_param[] = $g_text;

$g_table_bug = db_get_table( 'bug' );
$g_table_bug_text = db_get_table( 'bug_text' );
$g_table_bug_note = db_get_table( 'bugnote_text' );

$g_query_bug = 'select * from ' . $g_table_bug . ' where ' . db_helper_like( 'summary' );
$g_query_bug_text = 'select * from ' . $g_table_bug_text . ' where ' . db_helper_like( 'description' ) . ' or ' . db_helper_like( 'steps_to_reproduce' ) . ' or ' . db_helper_like( 'additional_information' );
$g_query_bug_note = 'select * from ' . $g_table_bug_note . ' where ' . db_helper_like( 'note' );

$g_result_bug = db_query_bound( $g_query_bug, array( $g_text ) );
$g_count_bug = db_num_rows( $g_result_bug );
$g_result_bug_text = db_query_bound( $g_query_bug_text, $g_param );
$g_count_bug_text = db_num_rows( $g_result_bug_text );
$g_result_bug_note = db_query_bound( $g_query_bug_note, array( $g_text ) );
$g_count_bug_note = db_num_rows( $g_result_bug_note );

/**
 * Result string with links
 * @var string
 */
$g_result = "";

if( ( $g_count_bug == 0 ) and ( $g_count_bug_text == 0 ) and ( $g_count_bug_note == 0 ) )
{
	$g_result .= plugin_lang_get( "not_found" );
}
else
{
	$g_result .= '<table class="width75" align="center" cellspacing="1">';
	$t_bug_array = array();
	if ( $g_count_bug != 0) {
		while( $row = db_fetch_array( $g_result_bug ) ){
			$t_bug_array[] = db_prepare_int( $row['id'] );
		}
	}
	if ( $g_count_bug_text != 0) {
		while( $row = db_fetch_array( $g_result_bug_text ) ){
			$t_bug_array[] = db_prepare_int( $row['id'] );
		}
	}
	if ( $g_count_bug_note != 0) {
		while( $row = db_fetch_array( $g_result_bug_note ) ){
			$t_bug_array[] = db_prepare_int( get_bug_id_from_bugnote_id( $row['id'] ));
		}
	}
	$t_bug_array = array_unique( $t_bug_array );
	sort( $t_bug_array, SORT_NUMERIC );
	foreach( $t_bug_array as $t_bug_id )
		$g_result .= prepare_search_bug_data( $t_bug_id );
	$g_result .= '</table>';
}
html_page_top1( plugin_lang_get( 'title' ) );
html_page_top2( );
?>
<br/>
<?php
echo $g_result;
html_page_bottom( );