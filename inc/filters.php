<?php
/*
 * フィルター関連
 */

/* 
 * the_content にシェアボタンを追加する
 */
function add_sharebutton( $html ) {
	global $snsutils;
	
	// 自動追加するか
	$automatic = $snsutils->getOption( 'snsutils_share_auto_add' );

	// 投稿ページまたは固定ページのみ
	if ( $automatic && is_singular() ) {
		$html .= get_sharebutton(
			$snsutils->getOption( 'snsutils_share_official' ),
			'<h3 class="share-title">' . __( 'Share', 'sns-utils' ) . '</h3>',
			$snsutils->getOption( 'snsutils_share_linktarget' ),
			false
		);
	}

	return $html;
}
add_filter( 'the_content', 'add_sharebutton' );

?>
