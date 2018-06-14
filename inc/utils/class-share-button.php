<?php
/*
 * シェアボタンを扱うクラス
 */

define( 'SNSUTILS_SHAREBUTTON_NAME', 'snsutils-share-button' );

if ( ! class_exists( 'ShareButton' ) ) {
class ShareButton {

	private $url = null;
	private $id = null;
	private $classes = array( SNSUTILS_SHAREBUTTON_NAME );
	private $float = true;
	private $title = false;
	private $linkTarget = '_self';

	private static $num = 0;

	/*
	 * コンストラクタ
	 */
	public function __construct( $url ) {
		if ( empty( $url ) ) {
			throw new Exception( 'ShareButton construction failed.' );
		}
		try {
			$this->url = $url;
			$this->id = SNSUTILS_SHAREBUTTON_NAME . '-' . ++self::$num;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/*
	 * setter
	 */
	public function setFloat( $float ) {
		$this->float = $float;
	}
	public function setTitle( $title ) {
		$this->title = $title;
	}
	public function setLinkTarget( $link_target ) {
		$this->linkTarget = $link_target;
	}

	/*
	 * HTML出力
	 */
	public function output( $services, $isOfficial = false ) {
		echo $this->getShareButton( $services, $isOfficial );
	}

	/*
	 * シェアボタンを取得
	 */
	public function getShareButton( $services, $isOfficial = false ) {
		if ( ! is_array( $services ) ) {
			return false;
		}

		if ( $isOfficial ) {
			$html = $this->getOfficialButtons( $services );
		} else {
			$html = $this->getCustomButtons( $services );
		}

		$output = apply_filters( 'sharebutton', $html );
		return $output;
	}

	/*
	 * カスタムボタンを取得
	 */
	private function getCustomButtons( $services ) {

		$this->classes[] = 'custom';
		if ( $this->float ) {
			$this->classes[] = 'float';
		} else {
			$this->classes[] = 'static';
		}
		$this->classes = apply_filters( 'sharebutton_class', $this->classes );

		$html = '';
		foreach( $services as $service ) {
			switch ( $service ) {
				case 'twitter':
					$html .= '<div class="twitter button">';
					$html .= '<a href="' . $this->getTwitterShareUrl() . '" class="twitter" target="' . $this->linkTarget . '">';
					$html .= '<p><i class="fa fa-twitter"></i><span>' . __('Tweet', 'sns-utils') . '</span></p>';
					$html .= '</a>';
					$html .= '</div>';
					break;
				case 'facebook':
					$html .= '<div class="facebook button">';
					$html .= '<a href="' . $this->getFacebookShareUrl() . '" class="facebook" target="' . $this->linkTarget . '">';
					$html .= '<p><i class="fa fa-facebook"></i><span>' . __('Share', 'sns-utils') . '</span></p>';
					$html .= '</a>';
					$html .= '</div>';
					break;
				case 'line':
					$html .= '<div class="line button">';
					$html .= '<a href="' . $this->getLineShareUrl() . '" class="line" target="' . $this->linkTarget . '">';
					$html .= '<p><i class="fa fa-line"></i><span>' . __('LINE', 'sns-utils') . '</span></p>';
					$html .= '</a>';
					$html .= '</div>';
					break;
				case 'gplus':
					$html .= '<div class="gplus button">';
					$html .= '<a href="' . $this->getGplusShareUrl() . '" class="gplus" target="' . $this->linkTarget . '">';
					$html .= '<p><i class="fa fa-google-plus"></i><span>' . __('Google+', 'sns-utils') . '</span></p>';
					$html .= '</a>';
					$html .= '</div>';
					break;
			}
		}

		$output = '<div id="' . $this->id . '" class="' . implode(' ', $this->classes) . '">';
		$output .= ( ! empty( $this->title ) ) ? $this->title : '';
		$output .= $html;
		$output .= '</div>';
		return $output;
	}

	/*
	 * 公式ボタンを取得
	 */
	private function getOfficialButtons( $services ) {

		$this->classes[] = 'official';
		if ( $this->float ) {
			$this->classes[] = 'float';
		} else {
			$this->classes[] = 'static';
		}
		$this->classes = apply_filters( 'sharebutton_class', $this->classes );

		$html = '';
		foreach( $services as $service ) {
			switch ( $service ) {
				case 'twitter':
					$html .= '<div class="twitter button">';
					$html .= '<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>';
					$html .= '</div>';
					break;
				case 'facebook':
					$button_type = ( $this->float && ! wp_is_mobile() ) ? 'box_count' : 'button_count';
					$html .= '<div class="facebook button">';
					$html .= '<div class="fb-like" data-href="' . $this->url . '" data-layout="' . $button_type . '" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>';
					$html .= '</div>';
					break;
				case 'line':
					$html .= '<div class="line button">';
					$html .= '<div class="line-it-button" data-lang="ja" data-type="share-a" data-url="' . $this->url . '" style="display: none;"></div>';
					$html .= '</div>';
					break;
				case 'gplus':
					$html .= '<div class="gplus button">';
					$html .= '<g:plus action="share" size="medium"></g:plus>';
					$html .= '</div>';
					break;
			}
		}

		$output = '<div id="' . $this->id . '" class="' . implode(' ', $this->classes) . '">';
		$output .= ( ! empty( $this->title ) ) ? $this->title : '';
		$output .= $html;
		$output .= '</div>';
		return $output;
	}

	/*
	 * 各サービスのシェアURL取得
	 */
	private function getFacebookShareUrl( ) {
		return 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $this->url );
	}
	private function getTwitterShareUrl( ) {
		$twtext = wp_get_document_title();
		return 'https://twitter.com/share?url=' . rawurlencode( $this->url ) . '&text=' . rawurlencode( $twtext );
	}
	private function getLineShareUrl( ) {
		$lntext = wp_get_document_title();
		return 'http://line.me/R/msg/text/?' . rawurlencode($lntext . ' ' . $this->url);
	}
	private function getGplusShareUrl( ) {
		return 'https://plus.google.com/share?url=' . rawurlencode( $this->url );
	}

}
}

?>
