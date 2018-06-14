<?php

/*
 * テンプレートタグ
 */

/*
 * シェアボタンを出力する
 */
function sharebutton( $official = null, $title = null, $link_target = '_self', $float = false ) {
	if ( is_null( $title ) ) {
		$title = '<h3 class="share-title">' . __( 'Share', 'sns-utils' ) . '</h3>';
	}
	echo get_sharebutton( $official, $title, $link_target, $float );
}

/*
 * シェアボタンを取得する
 */
function get_sharebutton( $official = null, $title = null, $link_target = '_self', $float = false ) {
	include_once SNSUTILS_DIR_PATH . 'inc/utils/class-share-button.php';

	// シェアするURL取得
	if( is_front_page() ) {
		$url = get_bloginfo( 'url' );
	} else {
		$url = get_the_permalink();
	}

	global $snsutils;
	
	// 公式ボタンを使用するか
	if ( is_null( $official ) ) {
		$official = $snsutils->getOption( 'snsutils_share_official' );
	}
	if ( $official && wp_is_mobile() ) {
		$official = ( $snsutils->getOption( 'snsutils_share_official_pc_only' ) ) ? false : true;
	}

	// サービス設定
	$services = array();
	if ( $snsutils->getOption( 'snsutils_service_facebook' ) ) {
		$services[] = 'facebook';
	}
	if ( $snsutils->getOption( 'snsutils_service_twitter' ) ) {
		$services[] = 'twitter';
	}
	if ( $snsutils->getOption( 'snsutils_service_line' ) ) {
		$services[] = 'line';
	}
	if ( $snsutils->getOption( 'snsutils_service_gplus' ) ) {
		$services[] = 'gplus';
	}

	// シェアボタン生成
	$sharebtn = new ShareButton( $url );
	if ( ! empty( $title ) ) {
		$sharebtn->setTitle( $title );
	}
	$sharebtn->setLinkTarget( $link_target );
	$sharebtn->setFloat( $float );
	$output = $sharebtn->getShareButton( $services, $official );

	return $output;
}

/*
 * SNSアカウントへのリンクリストを出力
 */
function social_linklist( $style = 'list', $link_target = '_self' ) {
	echo get_social_linklist( $style, $link_target );
}

/*
 * SNSアカウントへのリンクリストを取得
 */
function get_social_linklist( $style = 'list', $link_target = '_self' ) {
	// サービス設定
	$services = array();
	$facebook_url = get_social_linkurl( 'facebook' );
	if ( ! empty( $facebook_url ) ) {
		$facebook = array();
		$facebook['service'] = 'facebook';
		$facebook['url'] = get_social_linkurl( 'facebook' );
		$services[] = $facebook;
	}
	$twitter_url = get_social_linkurl( 'twitter' );
	if ( ! empty( $twitter_url ) ) {
		$twitter = array();
		$twitter['service'] = 'twitter';
		$twitter['url'] = get_social_linkurl( 'twitter' );
		$services[] = $twitter;
	}
	$gplus_url = get_social_linkurl( 'gplus' );
	if ( ! empty( $gplus_url ) ) {
		$gplus = array();
		$gplus['service'] = 'gplus';
		$gplus['url'] = get_social_linkurl( 'gplus' );
		$services[] = $gplus;
	}
	$instagram_url = get_social_linkurl( 'instagram' );
	if ( ! empty( $instagram_url ) ) {
		$instagram = array();
		$instagram['service'] = 'instagram';
		$instagram['url'] = get_social_linkurl( 'instagram' );
		$services[] = $instagram;
	}
	$feed = array();
	$feed['service'] = 'feed';
	$feed['url'] = get_social_linkurl( 'feed' );
	$services[] = $feed;

	$output = '';
	if ( $style == 'list' ) {
		$output .= '<ul class="social-link-list">';
	}

	foreach ( $services as $service ) {
		if ( $style == 'list' ) {
			$output .= '<li class="social-link"><a class="social-link-url ' . $service['service'] . '" href="' . $service['url'] . '" target="' . $link_target . '">' . $service['service'] . '</a></li>';
		} else {
			$output .= '<a class="social-link-url ' . $service['service'] . '" href="' . $service['url'] . '" target="' . $link_target . '">' . $service['service'] . '</a><br />';
		}
	}

	if ( $style == 'list' ) {
		$output .= '</ul>';
	}

	return $output;
}

/*
 * SNSアカウントのリンクを出力
 */
function social_link( $type, $link_target = '_self' ) {
	$url = get_social_linkurl( $type );
	if ( ! empty( $url ) ) {
		echo '<a class="social-link-url ' . $type . '" href="' . $url . '" target="' . $link_target . '">' . $type . '</a>';
	}
}

/*
 * SNSアカウントのプロフィールURLを出力
 */
function social_linkurl( $type ) {
	echo get_social_linkurl( $type );
}

/*
 * SNSアカウントのプロフィールURLを取得
 */
function get_social_linkurl( $type ) {
	global $snsutils;
	
	$url = '';
	switch ( $type ) {
		case 'feed':
			$url = get_bloginfo( 'rss2_url' );
			break;

		case 'facebook':
			$account = $snsutils->getOption( 'snsutils_account_facebook' );
			if ( ! empty( $account ) ) {
				if ( preg_match( '/^(http|https)/', $account ) ) {
					$url = $account;
				} else {
					$url = 'https://www.facebook.com/' . $account;
				}
			}
			break;

		case 'twitter':
			$account = $snsutils->getOption( 'snsutils_account_twitter' );
			if ( ! empty( $account ) ) {
				if ( preg_match( '/^(http|https)/', $account ) ) {
					$url = $account;
				} else {
					$url = 'https://twitter.com/' . $account;
				}
			}
			break;

		case 'gplus':
			$account = $snsutils->getOption( 'snsutils_account_gplus' );
			if ( ! empty( $account ) ) {
				if ( preg_match( '/^(http|https)/', $account ) ) {
					$url = $account;
				} else {
					$url = 'https://plus.google.com/' . $account;
				}
			}
			break;

		case 'instagram':
			$account = $snsutils->getOption( 'snsutils_account_instagram' );
			if ( ! empty( $account ) ) {
				if ( preg_match( '/^(http|https)/', $account ) ) {
					$url = $account;
				} else {
					$url = 'https://www.instagram.com/' . $account;
				}
			}
			break;

		default:
			break;
	}

	return $url;
}

?>
