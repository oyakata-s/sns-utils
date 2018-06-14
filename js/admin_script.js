/*
 * 管理画面用スクリプト
 */

jQuery(document).ready(function($) {

	/*
	 * 初期化
	 */
	if ($('#snsutils_share_official').prop('checked')) {
		$('.share_official_only input').prop('disabled', false);
		$('.share_official_only label').css('opacity', 1);
	} else {
		$('.share_official_only input').prop('disabled', true);
		$('.share_official_only label').css('opacity', 0.5);
	}

	/*
	 * タブ切替
	 */
	$('#settings-tab li').on('click', 'a', function() {
		var index = $('#settings-tab li a').index(this);
		console.log(index);

		$('#settings-tab li').each(function() {
			$(this).removeClass('active');
		});
		$('#tab-contents .tab-content').each(function() {
			$(this).removeClass('active');
		});

		$(this).parent().addClass('active');
		$('#tab-contents .tab-content').eq(index).addClass('active')

		return false;
	});

	// 公式ボタン使用の選択切替時
	$('#snsutils_share_official').change(function() {
		if ($('#snsutils_share_official').prop('checked')) {
			$('.share_official_only input').prop('disabled', false);
			$('.share_official_only label').css('opacity', 1);
		} else {
			$('.share_official_only input').prop('disabled', true);
			$('.share_official_only label').css('opacity', 0.5);
		}
	});

});
