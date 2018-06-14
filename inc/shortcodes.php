<?php
/*
 * ショートコード関連
 */

/*
 * シェアボタンを出力する
 * [sharebutton]
 */
function shortcode_sharebutton( $atts ) {
	global $snsutils;
	extract( shortcode_atts( array(
		'official' => $snsutils->getOption( 'snsutils_share_official' ),
		'title' => '<h3 class="share-title">' . __( 'Share', 'sns-utils' ) . '</h3>',
		'link_target' => $snsutils->getOption( 'snsutils_share_linktarget' )
	), $atts ) );

	// シェアボタン取得
	$output = get_sharebutton($official, $title, $link_target, false );

	return $output;
}
add_shortcode( 'sharebutton', 'shortcode_sharebutton' );

/*
 * SNSリンクリストを出力する
 * [social_linklist]
 */
function shortcode_social_linklist( $atts ) {
	extract( shortcode_atts( array(
		'style' => 'list',
		'link_target' => '_self'
	), $atts ) );

	$output = get_social_linklist( $style, $link_target );

	return $output;
}
add_shortcode( 'social_linklist', 'shortcode_social_linklist' );

/*
 * SNSリンクを出力する
 * [social_link]
 */
function shortcode_social_link( $atts ) {
	extract( shortcode_atts( array(
		'service' => 'facebook',
		'link_target' => '_self'
	), $atts ) );

	$url = get_social_linkurl( $service );
	$output = '<a class="social-link-url ' . $service . '" href="' . $url . '" target="' . $link_target . '">' . $service . '</a>';

	return $output;
}
add_shortcode( 'social_link', 'shortcode_social_link' );

?>
