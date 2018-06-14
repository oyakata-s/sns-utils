<?php
/*
 * シェアボタンを扱うクラス
 */

if ( ! class_exists( 'OgpMeta' ) ) {
class OgpMeta {

	private $postdata = null;

	private $descriptionLength = 140;
	private $defaultImage = null;
	private $facebookAppId = null;
	private $twitterCardType = null;

	/*
	 * コンストラクタ
	 */
	public function __construct( $postdata = null ) {
		$this->postdata = $postdata;
	}

	/*
	 * setter
	 */
	public function setDescriptionLength ( $length ) {
		$this->descriptionLength = $length;
	}
	public function setDefaultImage( $image ) {
		$this->defaultImage = $image;
	}
	public function setFacebookAppId( $appid ) {
		$this->facebookAppId = $appid;
	}
	public function setTwitterCardType( $type ) {
		$this->twitterCardType = $type;
	}

	/*
	 * prefixを出力
	 */
	public function getHeadPrefix() {
		if ( is_front_page() || is_home() ) {
			return 'og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#';
		} else {
			return 'og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#';
		}
	}

	/*
	 * HTML出力
	 */
	public function output() {
		echo $this->getOgpMeta( );
	}

	/*
	 * OGP用メタタグを取得
	 */
	public function getOgpMeta() {
		$html = '';

		$html .= $this->getOgpLocale() . "\n";
		$html .= $this->getOgpType() . "\n";
		$html .= $this->getOgpSiteName() . "\n";
		$html .= $this->getOgpTitle() . "\n";
		$html .= $this->getOgpUrl() . "\n";
		$html .= $this->getOgpDescription() . "\n";
		$html .= $this->getOgpImage() . "\n";
		$html .= $this->getTwitterCard() . "\n";
		$html .= $this->getFbAppId() . "\n";

		$output = apply_filters( 'ogp_meta', $html );
		return $output;
	}

	/*
	 * OGP:URLを取得
	 */
	private function getOgpUrl() {
		if ( empty( $this->postdata ) ) {
			$url = get_bloginfo('url');
		} else {
			$url = get_the_permalink();
		}

		return '<meta property="og:url" content="' . esc_url( $url ) . '" />';
	}

	/*
	 * OGP:titleを取得
	 */
	private function getOgpTitle() {
		$title = wp_get_document_title();
		return '<meta property="og:title" content="' . esc_html( $title ) . '" />';
	}

	/*
	 * OGP:typeを取得
	 */
	private function getOgpType() {
		if ( is_front_page() || is_home() ) {
			$type = 'website';
		} else {
			$type = 'article';
		}

		return '<meta property="og:type" content="' . $type . '" />';
	}

	/*
	 * OGP:localeを取得
	 */
	private function getOgpLocale() {
		$locale = get_locale();
		if ( $locale == 'ja' ) { $locale = 'ja_JP'; }
		return '<meta property="og:locale" content="' . $locale . '" />';
	}

	/*
	 * OGP:sitenameを取得
	 */
	private function getOgpSiteName() {
		$site_name = get_bloginfo( 'name' );
		return '<meta property="og:site_name" content="' . esc_html( $site_name ) . '" />';
	}

	/*
	 * OGP:descriptionを取得
	 */
	private function getOgpDescription() {
		if ( empty( $this->postdata ) || is_front_page() || is_home()  ) {
			$description = get_bloginfo( 'description' );
		} else {
			$description = '';
			$content = $this->postdata->post_content;
			$excerpt = $this->postdata->post_excerpt;
			if ( ! $excerpt ) {
				$description = strip_tags( $content );
				$description = strip_shortcodes( $description );
				$description = preg_replace( '#<img (.*?)>#i', '', $description );
				$description = str_replace( array( "\r\n", "\r", "\n" ), '', $description );
			} else {
				$description = strip_tags( $excerpt );
			}

			if ( mb_strlen( $description ) > $this->descriptionLength ) {
				$description = mb_substr( $description, 0, $this->descriptionLength );
				$description .= '...';
			}
		}

		return '<meta property="og:description" content="' . esc_html( $description ) . '" />';
	}

	/*
	 * OGP:imageを取得
	 */
	private function getOgpImage() {
		// header画像取得
		if ( current_theme_supports( 'custom-header' ) ) {
			$image = get_header_image();
		} else {
			$image = null;
		}

		// アイキャッチ取得
		if ( ! empty( $this->postdata ) && current_theme_supports( 'post-thumbnails' ) ) {
			$image = get_the_post_thumbnail_url( $this->postdata->ID, 'full ');
		}

		// なければデフォルト画像
		if ( empty( $image ) ) {
			$image = $this->defaultImage;
		}

		return '<meta property="og:image" content="' . esc_url( $image ) . '" />';
	}

	/*
	 * FB:appidを取得
	 */
	private function getFbAppId() {
		if ( ! empty( $this->facebookAppId ) ) {
			return '<meta property="fb:app_id" content="' . esc_html( $this->facebookAppId ) . '" />';
		} else {
			return '';
		}
	}

	/*
	 * twitter:cardを取得
	 */
	private function getTwitterCard() {
		return '<meta name="twitter:card" content="' . $this->twitterCardType . '" />';
	}
}
}

?>
