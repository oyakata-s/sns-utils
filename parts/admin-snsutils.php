<div id="snsutils-setting" class="wrap">
	<h2><?php _e( 'SNS Utilities Settings', 'sns-utils' ); ?></h2>
	<form method="POST" action="options.php">
<?php
		global $snsutils;
		settings_fields( 'snsutils_settings_group' );
		do_settings_sections( 'snsutils_settings_group' );
?>

		<!-- tab control -->
		<ul id="settings-tab">
			<li class="active"><a href="#"><?php _e( 'Account Settings', 'sns-utils' ); ?></a></li>
			<li><a href="#"><?php _e( 'Share Button Settings', 'sns-utils' ); ?></a></li>
			<li><a href="#"><?php _e( 'OGP Settings', 'sns-utils' ); ?></a></li>
			<li><a href="#"><?php _e( 'Facebook Settings', 'sns-utils' ); ?></a></li>
		</ul>

		<div id="tab-contents">

		<!-- account settings -->
		<table class="form-table tab-content active">
			<tr>
				<th scope="row"><?php _e( 'Account Settings', 'sns-utils' ); ?></th>
				<td><fieldset id="account-set">
					<label for="snsutils_account_facebook">Facebook</label>
					<input type="text" name="snsutils_account_facebook" id="snsutils_account_facebook" placeholder="<?php _e( 'Please enter Facebook account name or Profile URL', 'sns-utils' ); ?>" value="<?php echo esc_attr( $snsutils->getOption( 'snsutils_account_facebook' ) ); ?>"><br />
					<label for="snsutils_account_twitter">Twitter</label>
					<input type="text" name="snsutils_account_twitter" id="snsutils_account_twitter" placeholder="<?php _e( 'Please enter Twitter account name or Profile URL', 'sns-utils' ); ?>" value="<?php echo esc_attr( $snsutils->getOption( 'snsutils_account_twitter' ) ); ?>"><br />
					<label for="snsutils_account_gplus">Google+</label>
					<input type="text" name="snsutils_account_gplus" id="snsutils_account_gplus" placeholder="<?php _e( 'Please enter Google+ Profile URL / ID', 'sns-utils'); ?>" value="<?php echo esc_attr( $snsutils->getOption( 'snsutils_account_gplus' ) ); ?>"><br />
					<label for="snsutils_account_instagram">Instagram</label>
					<input type="text" name="snsutils_account_instagram" id="snsutils_account_instagram" placeholder="<?php _e( 'Please enter Instagram account name or Profile URL', 'sns-utils' ); ?>" value="<?php echo esc_attr( $snsutils->getOption( 'snsutils_account_instagram' ) ); ?>"><br />
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e('Shortcode', 'sns-utils'); ?></th>
				<td>
					<p class="description">
						<code>[social_link]</code>
						<table id="shortcode_table">
							<tr>
								<th>Parameter(Optical)</th>
								<th>Type</th>
								<th>Default</th>
								<th>Description</th>
							</tr>
							<tr>
								<td>service</td>
								<td>text</td>
								<td>'facebook'</td>
								<td>Select service</td>
							</tr>
							<tr>
								<td>link_target</td>
								<td>text</td>
								<td>'_self'</td>
								<td>"link_target" attribute of &lt;a&gt; tag.</td>
							</tr>
						</table>
					</p>
					<p class="description">
						<code>[social_linklist]</code>
						<table id="shortcode_table">
							<tr>
								<th>Parameter(Optical)</th>
								<th>Type</th>
								<th>Default</th>
								<th>Description</th>
							</tr>
							<tr>
								<td>style</td>
								<td>text</td>
								<td>'list'</td>
								<td>Output style</td>
							</tr>
							<tr>
								<td>link_target</td>
								<td>text</td>
								<td>'_self'</td>
								<td>"link_target" attribute of &lt;a&gt; tag.</td>
							</tr>
						</table>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e('Template Tag', 'sns-utils'); ?></th>
				<td>
					<p class="description">
						<code><?php echo esc_html("<?php if ( function_exists( 'social_link' ) ) { social_link(); } ?>"); ?></code>
						<table id="shortcode_table">
							<tr>
								<th>Parameter(Optical)</th>
								<th>Type</th>
								<th>Default</th>
								<th>Description</th>
							</tr>
							<tr>
								<td>service</td>
								<td>text</td>
								<td colspan="2" rowspan="2">Same as shortcode parameter.</td>
							</tr>
							<tr>
								<td>link_target</td>
								<td>text</td>
							</tr>
						</table>
					</p>
					<p class="description">
						<code><?php echo esc_html("<?php if ( function_exists( 'social_linklist' ) ) { social_linklist(); } ?>"); ?></code>
						<table id="shortcode_table">
							<tr>
								<th>Parameter(Optical)</th>
								<th>Type</th>
								<th>Default</th>
								<th>Description</th>
							</tr>
							<tr>
								<td>style</td>
								<td>text</td>
								<td colspan="2" rowspan="2">Same as shortcode parameter.</td>
							</tr>
							<tr>
								<td>link_target</td>
								<td>text</td>
							</tr>
						</table>
					</p>
				</td>
			</tr>
		</table>

		<!-- share button settings -->
		<table class="form-table tab-content">
			<tr>
				<th scope="row"><?php _e( 'Official Button', 'sns-utils' ); ?></th>
				<td><fieldset>
					<input type="checkbox" name="snsutils_share_official" id="snsutils_share_official" <?php checked( $snsutils->getOption( 'snsutils_share_official' ) === 'on', 1 ); ?> />
					<label for="snsutils_share_official"><?php _e( 'Use Official Share Button', 'sns-utils' ); ?></label><br />
					<div class="share_official_only">
						<input type="checkbox" name="snsutils_share_official_pc_only" id="snsutils_share_official_pc_only" value="1" <?php checked( $snsutils->getOption( 'snsutils_share_official_pc_only' ), 1 ); ?> />
						<label for="snsutils_share_official_pc_only"><?php _e( 'Do not use in mobile device.', 'sns-utils' ); ?></label>
					</div>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php _e( 'Services', 'sns-utils' ); ?>
					<p class="description"><?php _e('Specify the service to use.', 'sns-utils'); ?></p>
				</th>
				<td><fieldset>
					<input type="checkbox" name="snsutils_service_facebook" id="snsutils_service_facebook" value="1" <?php checked( $snsutils->getOption( 'snsutils_service_facebook' ), 1 ); ?> />
					<label for="snsutils_service_facebook"><span>Facebook</span></label>
					<input type="checkbox" name="snsutils_service_twitter" id="snsutils_service_twitter" value="1" <?php checked( $snsutils->getOption( 'snsutils_service_twitter' ), 1 ); ?> />
					<label for="snsutils_service_twitter"><span>Twitter</span></label>
					<input type="checkbox" name="snsutils_service_line" id="snsutils_service_line" value="1" <?php checked( $snsutils->getOption( 'snsutils_service_line' ), 1 ); ?> />
					<label for="snsutils_service_line"><span>Line</span></label>
					<input type="checkbox" name="snsutils_service_gplus" id="snsutils_service_gplus" value="1" <?php checked( $snsutils->getOption( 'snsutils_service_gplus' ), 1 ); ?> />
					<label for="snsutils_service_gplus"><span>Google+</span></label>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php _e( 'Float display on', 'sns-utils' ); ?>
					<p class="description"><?php _e('Specify the page to be displayed.', 'sns-utils'); ?></p>
				</th>
				<td><fieldset>
					<input type="checkbox" name="snsutils_float_at_page" id="snsutils_float_at_page" value="1" <?php checked( $snsutils->getOption( 'snsutils_float_at_page' ), 1 ); ?> />
					<label for="snsutils_float_at_page"><span><?php _e( 'Page', 'sns-utils' ); ?></span></label>
					<input type="checkbox" name="snsutils_float_at_post" id="snsutils_float_at_post" value="1" <?php checked( $snsutils->getOption( 'snsutils_float_at_post' ), 1 ); ?> />
					<label for="snsutils_float_at_post"><span><?php _e( 'Post', 'sns-utils' ); ?></span></label>
					<input type="checkbox" name="snsutils_float_at_index" id="snsutils_float_at_index" value="1" <?php checked( $snsutils->getOption( 'snsutils_float_at_index' ), 1 ); ?> />
					<label for="snsutils_float_at_index"><span><?php _e( 'Index', 'sns-utils' ); ?></span></label>
					<input type="checkbox" name="snsutils_float_at_frontpage" id="snsutils_float_at_frontpage" value="1" <?php checked( $snsutils->getOption( 'snsutils_float_at_frontpage' ), 1 ); ?> />
					<label for="snsutils_float_at_frontpage"><span><?php _e( 'Front Page', 'sns-utils' ); ?></span></label>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e( 'Automatically add', 'sns-utils' ); ?></th>
				<td><fieldset>
					<input type="checkbox" name="snsutils_share_auto_add" id="snsutils_share_auto_add" value="1" <?php checked( $snsutils->getOption( 'snsutils_share_auto_add' ), 1 ); ?> />
					<label for="snsutils_share_auto_add"><span><?php _e( 'Automatically add to the_content', 'sns-utils' ); ?></span></label>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e( 'Link Target', 'sns-utils' ); ?></th>
				<td><fieldset>
					<input type="checkbox" name="snsutils_share_linktarget" id="snsutils_share_linktarget" value="_blank" <?php checked( $snsutils->getOption( 'snsutils_share_linktarget' ) === '_blank', 1 ); ?> />
					<label for="snsutils_share_linktarget"><span><?php _e( 'Open a link in a new window', 'sns-utils' ); ?></span></label>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e('Shortcode', 'sns-utils'); ?></th>
				<td>
					<p class="description">
						<code>[sharebutton]</code>
						<table id="shortcode_table">
							<tr>
								<th>Parameter(Optical)</th>
								<th>Type</th>
								<th>Default</th>
								<th>Description</th>
							</tr>
							<tr>
								<td>official</td>
								<td>0(do not use) / 1(use)</td>
								<td>Setting value on this page.</td>
								<td>Official code is used.</td>
							</tr>
							<tr>
								<td>title</td>
								<td>text</td>
								<td>&lt;h3 class="share-title"&gt;Share&lt;/h3&gt;</td>
								<td>Headline html</td>
							</tr>
							<tr>
								<td>link_target</td>
								<td>text</td>
								<td>Setting value on this page.</td>
								<td>"link_target" attribute of &lt;a&gt; tag.</td>
							</tr>
						</table>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e('Template Tag', 'sns-utils'); ?></th>
				<td>
					<p class="description">
						<code><?php echo esc_html("<?php if ( function_exists( 'sharebutton' ) ) { sharebutton(); } ?>"); ?></code>
						<table id="shortcode_table">
							<tr>
								<th>Parameter(Optical)</th>
								<th>Type</th>
								<th>Default</th>
								<th>Description</th>
							</tr>
							<tr>
								<td>official</td>
								<td>boolean</td>
								<td colspan="2" rowspan="3">Same as shortcode parameter.</td>
							</tr>
							<tr>
								<td>title</td>
								<td>text</td>
							</tr>
							<tr>
								<td>link_target</td>
								<td>text</td>
							</tr>
							<tr>
								<td>float</td>
								<td>boolean</td>
								<td>false</td>
								<td>set "fixed" value to "display" attribute of block.</td>
							</tr>
						</table>
					</p>
				</td>
			</tr>
		</table>

		<!-- ogp settings -->
		<table class="form-table tab-content">
			<tr>
				<th scope="row"><?php _e( 'Output OGP', 'sns-utils' ); ?></th>
				<td><fieldset>
					<input type="checkbox" name="snsutils_ogp_enable" id="snsutils_ogp_enable" value="1" <?php checked( $snsutils->getOption( 'snsutils_ogp_enable' ), 1 ); ?> />
					<label for="snsutils_ogp_enable"><?php _e( 'Output Ogp tags automatically.', 'sns-utils' ); ?></label><br />
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="snsutils_ogp_desc_length"><?php _e( 'ogp:description', 'sns-utils' ); ?>
					<p class="description"><?php _e('Set max length of description.', 'sns-utils'); ?></p>
				</th>
				<td><fieldset>
					<input type="number" name="snsutils_ogp_desc_length" id="snsutils_ogp_desc_length" placeholder="<?php _e( 'Please enter description text length', 'sns-utils' ); ?>" value="<?php echo esc_attr( $snsutils->getOption( ' snsutils_ogp_desc_length' ) ); ?>"><br>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="snsutils_ogp_defaultimg"><?php _e( 'ogp:image', 'sns-utils' ); ?></label>
					<p class="description"><?php _e( 'Default image in case there is no image in the post.', 'sns-utils' ); ?></p>
				</th>
				<td><fieldset id="media-upload">
					<?php
						$ogp_image = $snsutils->getOption('snsutils_ogp_defaultimg' );
					?>
					<input name="snsutils_ogp_defaultimg" id="snsutils_ogp_defaultimg" type="text" value="<?php echo $ogp_image; ?>" />
					<div class="btn-control">
						<input class="button-primary" type="button" name="snsutils_media_select" value="<?php _e( 'Select', 'sns-utils' ); ?>" />
						<input class="button-secondary" type="button" name="snsutils_media_clear" value="<?php _e( 'Clear', 'sns-utils' ); ?>" />
					</div>
					<div id="snsutils_media">
						<img src="<?php echo $ogp_image; ?>" />
					</div>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="snsutils_ogp_twcard_type"><?php _e('twitter:card', 'sns-utils'); ?></label></th>
				<td><fieldset>
					<?php
						$ogp_twcard_type = $snsutils->getOption( 'snsutils_ogp_twcard_type' );
					?>
					<input type="radio" name="snsutils_ogp_twcard_type" id="snsutils_ogp_twcard_type_summary" value="summary" <?php checked( $ogp_twcard_type === 'summary' , 1 ); ?> /><label for="snsutils_ogp_twcard_type_summary">summary</label>&emsp;
					<input type="radio" name="snsutils_ogp_twcard_type" id="snsutils_ogp_twcard_type_summary_large_image" value="summary_large_image" <?php checked( $ogp_twcard_type === 'summary_large_image', 1 ); ?> /><label for="snsutils_ogp_twcard_type_summary_large_image">summary_large_image</label>&emsp;
					</fieldset>
				</td>
			</tr>
		</table>

		<!-- facebook settings -->
		<table class="form-table tab-content">
			<tr>
				<th scope="row"><?php _e( 'Application ID', 'sns-utils' ); ?></th>
				<td><fieldset>
					<input type="text" name="snsutils_facebook_appid" id="snsutils_facebook_appid" placeholder="<?php _e( 'Please enter Facebook Application ID', 'sns-utils' ); ?>" value="<?php echo esc_attr( $snsutils->getOption(' snsutils_facebook_appid' ) ); ?>"><br>
					</fieldset>
				</td>
			</tr>
		</table>

		</div>
		<!-- /.tab-content -->

		<?php submit_button(); ?>
	</form>
</div>
