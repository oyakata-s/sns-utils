<?php
/*
 * Plugin Name: SNS Utilities
 * Plugin URI: https://github.com/oyakata-s/sns-utils
 * Description: SNS button, OGP setting
 * Version: 0.2.2
 * Author: oyakata-s
 * Author URI: https://something-25.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sns-utils
 */

/*
 * 定数定義
 */
define( 'SNSUTILS_FILE', __FILE__ );								// プラグインファイルへのパス
define( 'SNSUTILS_DIR_PATH', plugin_dir_path( __FILE__ ) );			// プラグインディレクトリへのパス
define( 'SNSUTILS_DIR_URL', plugin_dir_url( __FILE__ ) );			// プラグインディレクトリへのURL
define( 'SNSUTILS_TEXTDOMAIN', 'sns-utils' );						// テキストドメイン

/*
 * ライブラリ読込
 */
require_once SNSUTILS_DIR_PATH . 'inc/setting.php';			// 設定関連
require_once SNSUTILS_DIR_PATH . 'inc/template-tags.php';	// テンプレートタグ定義
require_once SNSUTILS_DIR_PATH . 'inc/shortcodes.php';		// ショートコード定義
require_once SNSUTILS_DIR_PATH . 'inc/filters.php';			// フィルター設定

require_once SNSUTILS_DIR_PATH . 'inc/base/class-ft-base.php';			// 初期化関連

class SnsUtils extends  FtBase {

	/*
	 * 初期化
	 */
	public function __construct() {
		
		/*
		 * ベースクラスのコンストラクタ呼び出し
		 */
		try {
			parent::__construct( SNSUTILS_FILE );
		} catch ( Exception $e ) {
			throw $e;
		}
		
		// 多言語翻訳用
		load_plugin_textdomain( 'sns-utils', false, 'sns-utils/languages' );

		$this->setting = new SnsUtilsSetting();

		/*
		 * CSS&JS出力
		 */
		add_action( 'wp_head', array( $this, 'addHead' ) );
		add_action( 'wp_footer', array( $this, 'addFooter' ) );
		add_action( 'wp_footer', array( $this, 'addFooter_2' ) );
		add_action( 'wp_print_styles', array( $this, 'enqueueStyles' ) );		
	}

	/* 
	 * head追加
	 */
	public function addHead() {
		if ( $this->getOption( 'snsutils_ogp_enable' ) != 1 ) {
			return;
		}

		$postdata = null;
		if ( is_singular() ) {
			global $post;
			$postdata = $post;
		}
		include_once SNSUTILS_DIR_PATH . 'inc/utils/class-ogp-meta.php';
		$ogpmeta = new OgpMeta( $postdata );
		$ogpmeta->setDescriptionLength( $this->getOption( 'snsutils_ogp_desc_length' ) );
		$ogpmeta->setDefaultImage( $this->getOption('snsutils_ogp_defaultimg' ) );
		$ogpmeta->setFacebookAppId( $this->getOption( 'snsutils_facebook_appid' ) );
		$ogpmeta->setTwitterCardType( $this->getOption( 'snsutils_ogp_twcard_type' ) );
		$ogpmeta->output();

		$head_prefix = $ogpmeta->getHeadPrefix();
		?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('head').attr('prefix', '<?php echo $head_prefix; ?>');
});
</script>
<?php
	}

	/* 
	 * footer追加
	 */
	public function addFooter() {
		// 条件チェック
		if ( ( is_front_page() && $this->getOption( 'snsutils_float_at_frontpage' ) ) ||
			( is_single() &&  $this->getOption( 'snsutils_float_at_post' ) ) ||
			( is_page() && $this->getOption( 'snsutils_float_at_page' ) ) ||
			( ! is_front_page() && $this->getOption( 'snsutils_float_at_index' ) )
		) {
		//
		} else {
			return false;
		}

		// シェアボタン取得
		$output = get_sharebutton(
			$this->getOption( 'snsutils_share_official' ),
			null,
			$this->getOption( 'snsutils_share_linktarget' ),
			true	// float
		);
		echo $output;
	}

	public function addFooter_2() {
		$fbappid = ( ! empty( $this->getOption( 'snsutils_facebook_appid' ) ) ) ? '&appId=' . $this->getOption( 'snsutils_facebook_appid' ) : '';
?>
<!-- google+ -->
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: "ja"}
</script>
<!-- facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.4<?php echo $fbappid; ?>";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- twitter -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!-- line -->
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
<?php
	}

	/* 
	 * style追加
	 */
	public function enqueueStyles() {
		wp_enqueue_style( 'plugin-sns-utils',
			SNSUTILS_DIR_URL . 'css/style.min.css',
			array(),
			$this->getVersion(),
			'all' );
		wp_enqueue_style( 'snsutils_icomoon_style',
			SNSUTILS_DIR_URL . 'css/icomoon.css',
			array(),
			$this->getVersion(),
			'all' );
	}

	/* 
	 * js追加
	 */
	public function enqueueScripts() {
	}

}

$snsutils = new SnsUtils();

?>
