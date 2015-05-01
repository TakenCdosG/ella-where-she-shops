<?php
function shortcodes_text_advertisements() {
	$tmp_query = $wp_query;
	wp_reset_postdata();
	wp_reset_query();
	$the_query = new WP_Query( 'post_type=textads' );
	$out .='<div class="bottom_links">';
	if ($the_query->have_posts()) {
		$out .= '';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$textads_link = get_post_meta(get_the_ID(), 'textads-link', true);
			$textads_des  = get_post_meta(get_the_ID(), 'textads-des', true);
			$out .= '
			<a href="http://' . $textads_link . '" title="' . get_the_title() . '" class="' . get_the_title() . '" style="text-decoration:none !important; color:#566422 !important; font-size:10pt !important;">' . get_the_title() . '</a>, 
			';
		}
		$out .= '<span>&nbsp;</span></div>';
	} else {
		$out .= '
		<span>' . __('There is no text advertisement.', 'text-advertisements') . '
		</span>
		';
	}
	$out .= '';
	return $out;
	wp_reset_postdata();
	wp_reset_query();
	$wp_query = $tmp_query;
}

add_shortcode('Text-Advertisements', 'shortcodes_text_advertisements');

?>
