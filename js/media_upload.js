/*
 * メディアアップロード用スクリプト
 */
jQuery(document).ready(function($) {

	var custom_uploader;

	$("input:button[name=snsutils_media_select]").click(function(e) {

		e.preventDefault();

		if (custom_uploader) {

			custom_uploader.open();
			return;

		}

		custom_uploader = wp.media({

			title: "Choose Image",

			/* ライブラリの一覧は画像のみにする */
			library: {
				type: "image"
			},

			button: {
				text: "Choose Image"
			},

			/* 選択できる画像は 1 つだけにする */
			multiple: false

		});

		custom_uploader.on("select", function() {

			var images = custom_uploader.state().get("selection");

			/* file の中に選択された画像の各種情報が入っている */
			images.each(function(file){
				var url = file.toJSON().url;
				var thumb_url = file.toJSON().sizes.thumbnail.url;

				/* テキストフォームと表示されたサムネイル画像があればクリア */
				$("input:text[name=snsutils_ogp_defaultimg]").val("");
				$("#snsutils_media").empty();

				/* テキストフォームに画像の ID を表示 */
				$("input:text[name=snsutils_ogp_defaultimg]").val(url);

				/* プレビュー用に選択されたサムネイル画像を表示 */
				$("#snsutils_media").empty().append('<img src="' + thumb_url + '" />');

			});
		});

		custom_uploader.open();

	});

	/* クリアボタンを押した時の処理 */
	$("input:button[name=snsutils_media_clear]").click(function() {

		$("input:text[name=snsutils_ogp_defaultimg]").val("");
		$("#snsutils_media").empty().html('<p>Unspecified Image</p>');

	});

});
