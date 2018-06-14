<?php
/*
 * 設定関連
 */
define( 'SNSUTILS_HOOK_SUFFIX', 'settings_page_plugin_snsutils_options' );

require_once SNSUTILS_DIR_PATH . 'inc/base/class-ft-setting.php';			// 設定ベースクラス

class SnsUtilsSetting extends  FtSetting {

	/*
	 * 初期化
	 */
	public function __construct() {

		try {
			parent::__construct(
				'snsutils',
				array(
					'snsutils_account_facebook' => '',
					'snsutils_account_twitter' => '',
					'snsutils_account_gplus' => '',
					'snsutils_account_instagram' => '',
					'snsutils_share_official' => false,
					'snsutils_share_official_pc_only' => false,
					'snsutils_share_linktarget' => '_self',
					'snsutils_share_auto_add' => false,
					'snsutils_float_at_frontpage' => true,
					'snsutils_float_at_page' => false,
					'snsutils_float_at_post' => false,
					'snsutils_float_at_index' => false,
					'snsutils_service_facebook' => false,
					'snsutils_service_twitter' => false,
					'snsutils_service_gplus' => false,
					'snsutils_service_line' => false,
					'snsutils_facebook_appid' => '',
					'snsutils_ogp_enable' => true,
					'snsutils_ogp_desc_length' => 140,
					'snsutils_ogp_defaultimg' => SNSUTILS_DIR_URL . 'img/noimage.jpg',
					'snsutils_ogp_twcard_type' => 'summary'
				) );
		} catch ( Exception $e ) {
			throw $e;
		}

		add_action( 'admin_menu', array( $this, 'addOptionsPage' ) );

		add_action( 'admin_print_styles-'.SNSUTILS_HOOK_SUFFIX, array( $this, 'enqueueStyles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );

	}

	/* 
	 * オプションページ追加
	 */
	public function addOptionsPage() {
		$this->registerOptionsPage(
			__('SNS Utilities Settings', 'sns-utils'),
			__('SNS Utilities Settings', 'sns-utils'),
			'manage_options',
			'plugin_snsutils_options',
			SNSUTILS_DIR_PATH . 'parts/admin-snsutils.php'
		);
	}

	/* 
	 * css追加
	 */
	public function enqueueStyles() {
		global $snsutils;
		wp_enqueue_style( 'snsutils-admin-style',
			SNSUTILS_DIR_URL . 'css/admin-style.min.css',
			array(),
			$snsutils->getVersion(),
			'all' );
	}

	/* 
	 * js追加
	 */
	public function enqueueScripts( $hook_suffix ) {
		if ( $hook_suffix == SNSUTILS_HOOK_SUFFIX ) {
			global $snsutils;
			wp_enqueue_media();
			wp_enqueue_script( 'snsutils-admin-script',
				SNSUTILS_DIR_URL.'js/admin_script.min.js',
				array( 'jquery' ),
				$snsutils->getVersion(),
				false );
			wp_enqueue_script( 'snsutils-image-upload',
				SNSUTILS_DIR_URL.'js/media_upload.min.js',
				array( 'media-upload' ),
				$snsutils->getVersion(),
				false );
		}
	}

}

?>
