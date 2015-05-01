<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>
 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */

screen_icon();
?>



<div id="fade-overlay" class="loading">
	<i class="flaticon-settings"></i>
</div>


<!-- @TODO: Provide markup for your options page here. -->
<form id="flow_flow_form" method="post" action="options.php" enctype="multipart/form-data">

	<!--Register settings-->
	<?php
		settings_fields('ff_opts');
		$options = FlowFlow::get_instance()->get_options();
		$auth = FlowFlow::get_instance()->get_auth_options();
		$arr = (array)$options['streams'];
		$count = count($arr);
		$feedsChanged = $options['feeds_changed'];
		$options['feeds_changed'] = ''; // init clear

//		FlowFlowAdmin::debug_to_console('OPTIONS');
//		FlowFlowAdmin::debug_to_console($options);

	?>

	<script>
		var STREAMS = <?php echo json_encode($options["streams"])?>;
	</script>
	<input type="hidden" id="lastSubmit" name="flow_flow_options[last_submit]" value="<?php echo $options['last_submit'] ?>"/>
	<input type="hidden" id="feedsChanged" name="flow_flow_options[feeds_changed]" value="<?php echo $options['feeds_changed'] ?>"/>
	<div class="wrapper">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<ul class="section-tabs">
			<li id="streams-tab"><i class="flaticon-flow"></i> <span>Streams</span></li><li id="general-tab"><i class="flaticon-settings"></i> <span>General Settings</span></li><li id="auth-tab"><i class="flaticon-user"></i> <span>Auth Settings</span></li>
		</ul>
		<div class="section-contents">
			<div class="section-content" id="streams-cont" data-tab="streams-tab">
				<div class="section-stream" id="streams-list" data-view-mode="streams-list">

					<input type="hidden" id="streams" name="flow_flow_options[streams]" value=''/>
					<input type="hidden" id="streams_count" name="flow_flow_options[streams_count]" value = "<?php echo $count ?>"/>

					<div class="section" id="streams-list">
						<h1 class="desc-following"><span>List of your streams</span> <span class="admin-button green-button button-add">Add stream</span></h1>
						<p class="desc">Here is a list of your streams. Edit them to change styling or to add/remove your social feeds.</p>
					  <table>
						  <thead>
						   <tr>
							   <th></th>
							   <th>Stream</th>
							   <th>Layout</th>
							   <th>Feeds</th>
							   <th>Shortcode</th>
						   </tr>
						  </thead>
						  <tbody>
						  <?php


					    foreach ($options['streams'] as $key => $stream) {

						    $info = '';

						    $shortcodeStr = '[ff id="' . $stream->id . '"]';

							  if (isset($stream->feeds)) {
								  $feeds = json_decode($stream->feeds);
								  $length = count($feeds);

								  for ($i = 0; $i < $length; $i++) {
									  $feed = $feeds[$i];
									  $info = $info . '<i class="flaticon-' . $feed->type . '"></i>';
								  }
							  }


						    echo
							    '<tr data-stream-id="' . $stream->id . '">
							      <td class="controls"><i class="flaticon-pen"></i> <i class="flaticon-copy"></i> <i class="flaticon-trash"></i></td>
							      <td class="td-name">' . (!empty($stream->name) ? $stream->name : 'Unnamed') . '</td>
							      <td class="td-type">' . (isset($stream->layout) ? '<span class="icon-' . $stream->layout . '"></span>': '-') . '</td>
							      <td class="td-feed">' . (empty($info) ? '-' : $info) . '</td>
							      <td><span class="shortcode">' . $shortcodeStr . '</span><span class="shortcode-copy">Copy to clipboard</span></td>
						      </tr>';
					    }

						  //$arr = (array)$options['streams'];
						  if (empty($arr)) {
							  echo '<tr><td class="empty-cell" colspan="5">Please add at least one stream</td></tr>';
						  }

						  ?>
						  </tbody>
					  </table>
					</div>
				</div>
				<?php

				$templates = array(
					'view' => '
						<div class="section-stream" id="streams-update-%id%" data-view-mode="streams-update">
							<input type="hidden" name="stream-%id%-id" class="stream-id-value" value="%id%"/>
							<div class="section" id="stream-name-%id%">
								<h1>Edit stream name <span class="admin-button grey-button button-go-back">Go back to list</span></h1>
								<p><input type="text" name="stream-%id%-name" placeholder="Type name of stream."/></p>
								<span id="stream-name-sbmt-%id%" class="admin-button green-button submit-button">Save Changes</span>
							</div>
							<div class="section" id="stream-feeds-%id%">
								<input type="hidden" name="stream-%id%-feeds"/>
								<h1>Feeds in your stream <span class="admin-button green-button button-add">Add social feed</span></h1>
								<table>
									<thead>
									<tr>
										<th></th>
										<th>Feed</th>
										<th>Settings</th>
									</tr>
									</thead>
									<tbody>
									  %LIST%
									</tbody>
								</table>
								<div class="popup" id="feeds-settings-%id%">
									<i class="popupclose flaticon-close-4"></i>
									<div class="section">
										<div class="networks-choice add-feed-step">
											<h1>Add feed to your stream</h1>
											<p class="desc">Choose one social network and then set up what content to show.</p>
											<ul class="networks-list">
												<li class="network-twitter" data-network="twitter" data-network-name="Twitter"><i class="flaticon-twitter"></i></li>
												<li class="network-facebook" data-network="facebook" data-network-name="Facebook"><i class="flaticon-facebook"></i></li>
												<li class="network-google" data-network="google" data-network-name="Google +"><i class="flaticon-google"></i></li>
												<li class="network-pinterest" data-network="pinterest" data-network-name="Pinterest"><i class="flaticon-pinterest"></i></li>
												<li class="network-instagram" data-network="instagram" data-network-name="Instagram"><i class="flaticon-instagram"></i></li>
												<li class="network-flickr" data-network="flickr" data-network-name="Flickr"><i class="flaticon-flickr"></i></li><br>
												<li class="network-tumblr" data-network="tumblr" data-network-name="Tumblr"><i class="flaticon-tumblr"></i></li>
												<li class="network-youtube" data-network="youtube" data-network-name="YouTube"><i class="flaticon-youtube"></i></li>
												<li class="network-vimeo" data-network="vimeo" data-network-name="Vimeo"><i class="flaticon-vimeo"></i></li>
												<li class="network-wordpress" data-network="wordpress" data-network-name="WordPress"><i class="flaticon-wordpress"></i></li>
												<li class="network-rss" data-network="rss" data-network-name="RSS"><i class="flaticon-rss"></i></li>
											</ul>
										</div>
										<div class="networks-content  add-feed-step">
											%FEEDS%
											<p class="feed-popup-controls add">
												<span id="networks-sbmt-%id%" class="admin-button green-button submit-button">Add feed</span><span class="space"></span><span class="admin-button grey-button button-go-back">Back to first step</span>
											</p>
											<p class="feed-popup-controls edit">
												<span id="networks-sbmt-%id%" class="admin-button green-button submit-button">Save changes</span>
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="section" id="stream-settings-%id%">
								<h1>Stream general settings</h1>
								<dl class="section-settings section-compact">
																	<dt>Items order</dt>
                  <dd>
                      <input id="stream-%id%-date-order" type="radio" name="stream-%id%-order" checked value="compareByTime"/>
                      <label for="stream-%id%-date-order">By Date</label>
                      <input id="stream-%id%-random-order" type="radio" name="stream-%id%-order" value="randomCompare"/>
                      <label for="stream-%id%-random-order">Random</label>
                  </dd>
									<dt>Display last
										<p class="desc">Leave fields empty for default values</p>
									</dt>
									<dd><input type="text"  name="stream-%id%-posts" value="20" class="short clearcache"/> posts <span class="space"></span><input type="text" class="short clearcache" name="stream-%id%-days"/> days</dd>

									<dt class="multiline">Cache
									<p class="desc">Caching stream data to reduce loading time</p></dt>
									<dd>
										<label for="stream-%id%-cache"><input id="stream-%id%-cache" class="switcher clearcache" type="checkbox" name="stream-%id%-cache" checked value="yep"/><div><div></div></div></label>
									</dd>
									<dt class="multiline">Cache lifetime
									<p class="desc">Make it longer if you rarely update source feed</p></dt>
									<dd>
										<label for="stream-%id%-cache-lifetime"><input id="stream-%id%-cache-lifetime" class="short clearcache" type="text" name="stream-%id%-cache-lifetime" value="10"/> minutes</label>
									</dd>

									<dt class="multiline">Show lightbox when clicked
									<p class="desc">Otherwise click will open original URL</p></dt>
									<dd>
										<label for="stream-%id%-gallery"><input id="stream-%id%-gallery" class="switcher" type="checkbox" checked name="stream-%id%-gallery" value="yep"/><div><div></div></div></label>
									</dd>

									<dt class="multiline">Private stream<p class="desc">Show only for logged in users</p></dt>
									<dd>
										<label for="stream-%id%-private"><input id="stream-%id%-private" class="switcher" type="checkbox" name="stream-%id%-private" value="yep"/><div><div></div></div></label>
									</dd>
									<dt>Hide stream on a desktop</dt>
									<dd>
										<label for="stream-%id%-hide-on-desktop"><input id="stream-%id%-hide-on-desktop" class="switcher" type="checkbox" name="stream-%id%-hide-on-desktop" value="yep"/><div><div></div></div></label>
									</dd>
									<dt>Hide stream on a mobile device</dt>
									<dd>
										<label for="stream-%id%-hide-on-mobile"><input id="stream-%id%-hide-on-mobile" class="switcher" type="checkbox" name="stream-%id%-hide-on-mobile" value="yep"/><div><div></div></div></label>
									</dd>
								</dl>
								<span id="stream-settings-sbmt-%id%" class="admin-button green-button submit-button">Save Changes</span>
							</div>

							<div class="section" id="cont-settings-%id%">
								<h1>Stream container settings</h1>
								<dl class="section-settings section-compact">
									<dt class="multiline">Stream heading
									<p class="desc">Leave empty to not show</p></dt>
									<dd>
										<input id="stream-%id%-heading" type="text" name="stream-%id%-heading" placeholder="Enter heading"/>
									</dd>
									<dt class="multiline">Heading and filter hover color
												<p class="desc">Click on field to open colorpicker</p>
									</dt>
									<dd>
										<input id="heading-color-%id%" data-color-format="rgba" name="stream-%id%-headingcolor" type="text" value="rgb(154, 78, 141)" tabindex="-1">
									</dd>
									<dt>Stream subheading</dt>
									<dd>
										<input id="stream-%id%-subheading" type="text" name="stream-%id%-subheading" placeholder="Enter subheading"/>
									</dd>
									<dt class="multiline">Subheading color
											<p class="desc">You can also paste color in input</p>
									</dt>
									<dd>
										<input id="subheading-color-%id%" data-color-format="rgba" name="stream-%id%-subheadingcolor" type="text" value="rgb(114, 112, 114)" tabindex="-1">
									</dd>
									<dt><span class="valign">Heading and subheading alignment</span></dt>
									<dd class="">
										<div class="select-wrapper">
											<select name="stream-%id%-hhalign" id="hhalign-%id%">
												<option value="center" selected>Centered</option>
												<option value="left">Left</option>
												<option value="right">Right</option>
	                    </select>
										</div>
									</dd>
									<dt class="multiline">Container background color
										<p class="desc">You can see it in preview below</p>
									</dt>
									<dd>
										<input data-prop="backgroundColor" id="bg-color-%id%" data-color-format="rgba" name="stream-%id%-bgcolor" type="text" value="rgb(240, 240, 240)" tabindex="-1">
									</dd>
									<dt>Include filter and search in grid</dt>
									<dd>
										<label for="stream-%id%-filter"><input id="stream-%id%-filter" class="switcher" type="checkbox" name="stream-%id%-filter" checked value="yep"/><div><div></div></div></label>
									</dd>
									<dt>Filters and controls color
									</dt>
									<dd>
										<input id="filter-color-%id%" data-color-format="rgba" name="stream-%id%-filtercolor" type="text" value="rgb(205, 205, 205)" tabindex="-1">
									</dd>
									<dt class="multiline">Slider on mobiles <p class="desc">On mobiles grid will turn into slider with 3 items per slide</p></dt>
									<dd>
										<label for="stream-%id%-mobileslider"><input id="stream-%id%-mobileslider" class="switcher" type="checkbox" name="stream-%id%-mobileslider" value="yep"/><div><div></div></div></label>
									</dd>
									<dt class="multiline">Animate grid items <p class="desc">When they appear in viewport (otherwise all items are visible immediately)</p></dt>
									<dd>
										<label for="stream-%id%-viewportin"><input id="stream-%id%-viewportin" class="switcher" type="checkbox" name="stream-%id%-viewportin" checked value="yep"/><div><div></div></div></label>
									</dd>

								</dl>
								<span id="stream-cont-sbmt-%id%" class="admin-button green-button submit-button">Save Changes</span>
							</div>
							<div class="section" id="stream-stylings-%id%">
								<div class="design-step-1">
									<h1 class="desc-following">Stream layout</h1>
									<p class="desc">Choose layout to have different sets of options</p>

									<div class="choose-wrapper">
										<input name="stream-%id%-layout" class="clearcache" id="stream-layout-grid-%id%" type="radio" value="grid"/><label for="stream-layout-grid-%id%"><span class="choose-button"><i class="flaticon-grid"></i>Normal view (grid)</span><br><span class="desc">Universal format for any page to achieve masonry style. Min-width 300px</span></label>
										<span class="or">Or</span>
										<input name="stream-%id%-layout" class="clearcache" id="stream-layout-compact-%id%" type="radio" value="compact"/><label for="stream-layout-compact-%id%"><span class="choose-button"><i class="flaticon-bars"></i>Compact view</span><br><span class="desc">Special layout to put your stream in sidebar (not wider than 300px).</span></label>
								  </div>
								</div>
								<div class="design-step-2 layout-grid">
									<h1>Grid stylings</h1>
									<dl class="section-settings section-compact">
									  <dt><span class="valign">Card dimensions</span></dt>
										<dd>Width: <input type="text" data-prop="width" id="width-%id%" name="stream-%id%-width" value="260" class="short clearcache"/> px <span class="space"></span> Margin: <input type="text" value="20" class="short" name="stream-%id%-margin"/> px</dd>
										<dt><span class="valign">Card theme</span></dt>
										<dd class="theme-choice">
											<input id="theme-classic-%id%" type="radio" class="clearcache" name="stream-%id%-theme" checked value="classic"/> <label for="theme-classic-%id%">Classic</label> <input class="clearcache" id="theme-flat-%id%" type="radio" name="stream-%id%-theme" value="flat"/> <label for="theme-flat-%id%">Modern</label>
										</dd>
									</dl>
									<dl class="classic-style style-choice section-settings section-compact">
										<dt><span class="valign">Classic card style</span></dt>
										<dd>
											<div class="select-wrapper">
												<select name="stream-%id%-gc-style" id="gc-style-%id%">
													<option value="style-1" selected>Centered meta, round icon</option>
													<option value="style-2">Centered meta, bubble icon</option>
													<option value="style-6">Centered meta, no social icon</option>
													<option value="style-3">Userpic, rounded icon</option>
													<option value="style-4">No userpic, rounded icon</option>
													<option value="style-5">No userpic, bubble icon</option>
		                    </select>
											</div>
										</dd>

										<dt class="multiline">Card background color
													<p class="desc">Click on field to open colorpicker</p>
										</dt>
										<dd>
											<input data-prop="backgroundColor" id="card-color-%id%" data-color-format="rgba" name="stream-%id%-cardcolor" type="text" value="rgb(255,255,255)" tabindex="-1">
										</dd>
										<dt class="multiline">Color for heading & name
												<p class="desc">Or paste rgb() string</p>
										</dt>
										<dd>
											<input data-prop="color" id="name-color-%id%" data-color-format="rgba" name="stream-%id%-namecolor" type="text" value="rgb(154, 78, 141)" tabindex="-1">
										</dd>
										<dt>Regular text color
										</dt>
										<dd>
											<input data-prop="color" id="text-color-%id%" data-color-format="rgba" name="stream-%id%-textcolor" type="text" value="rgb(85,85,85)" tabindex="-1">
										</dd>
										<dt>Links color</dt>
										<dd>
											<input data-prop="color" id="links-color-%id%" data-color-format="rgba" name="stream-%id%-linkscolor" type="text" value="rgb(94, 159, 202)" tabindex="-1">
										</dd>
										<dt class="multiline">Other text color
										<p class="desc">Nicknames, timestamps</p></dt>
										<dd>
											<input data-prop="color" id="other-color-%id%" data-color-format="rgba" name="stream-%id%-restcolor" type="text" value="rgb(132, 118, 129)" tabindex="-1">
										</dd>
										<dt>Card shadow</dt>
										<dd>
											<input data-prop="box-shadow" id="shadow-color-%id%" data-color-format="rgba" name="stream-%id%-shadow" type="text" value="rgba(0, 0, 0, 0.22)" tabindex="-1">
										</dd>
										<dt>Separator line color</dt>
										<dd>
											<input data-prop="border-color" id="bcolor-%id%" data-color-format="rgba" name="stream-%id%-bcolor" type="text" value="rgba(240, 237, 231, 0.4)" tabindex="-1">
										</dd>
										<dt><span class="valign">Text alignment</span></dt>
										<dd class="">
											<div class="select-wrapper">
												<select name="stream-%id%-talign" id="talign-%id%">
													<option value="left" selected>Left</option>
													<option value="center">Centered</option>
													<option value="right">Right</option>
		                    </select>
											</div>
										</dd>
										<dt class="hide">Preview</dt>
										<dd class="preview">
										  <h1>Live preview</h1>
											<div data-preview="bg-color" class="ff-stream-wrapper ff-layout-grid ff-theme-classic ff-style-1 shuffle">
												<div data-preview="card-color,shadow-color,width" class="ff-item ff-twitter shuffle-item filtered" style="visibility: visible; opacity:1;">
												  <h4 data-preview="name-color">Header example</h4>
												  <p data-preview="text-color">This is regular text paragraph, can be tweet, facebook post etc. This is example of <a href="#" data-preview="links-color">link in text</a>.</p>
												  <span class="ff-img-holder" style="max-height: 171px"><img src="' . FlowFlow::get_plugin_directory() . '/assets/67.png" style="width:100%;"></span>
												  <div class="ff-item-meta">
												    <span class="separator" data-preview="bcolor"></span>
												  	<span class="ff-userpic" style="background:url(' . FlowFlow::get_plugin_directory() . '/assets/chevy.jpeg)"><i class="ff-icon" data-overrideProp="border-color" data-preview="card-color"><i class="ff-icon-inner"></i></i></span><a data-preview="name-color" target="_blank" rel="nofollow" href="#" class="ff-name">Looks Awesome</a><a data-preview="other-color" target="_blank" rel="nofollow" href="#" class="ff-nickname">@looks_awesome</a><a data-preview="other-color" target="_blank" rel="nofollow" href="#" class="ff-timestamp">21m ago </a>
											    </div>
										    </div>
											</div>
										</dd>
									</dl>

									<dl class="flat-style style-choice section-settings section-compact">
										<dt><span class="valign">Modern card style</span></dt>
										<dd class="flat-style style-choice">
											<div class="select-wrapper">
												<select name="stream-%id%-gf-style" id="gf-style-%id%">
													<option value="style-3" selected>Cornered social icon</option>
													<option value="style-1">Rounded userpic</option>
													<option value="style-2">Square userpic</option>
		                    </select>
											</div>
										</dd>

										<dt class="multiline">Card background color
													<p class="desc">Click on field to open colorpicker</p>
										</dt>
										<dd>
											<input data-prop="backgroundColor" id="fcolor-%id%" data-color-format="rgba" name="stream-%id%-fcardcolor" type="text" value="rgb(64,68,71)" tabindex="-1">
										</dd>
										<dt class="multiline">Secondary background color
													<p class="desc">Depends on card content</p>
										</dt>
										<dd>
											<input data-prop="backgroundColor" id="fscolor-%id%" data-color-format="rgba" name="stream-%id%-fscardcolor" type="text" value="rgb(44,45,46)" tabindex="-1">
										</dd>
										<dt>Heading and regular text color
										</dt>
										<dd>
											<input data-prop="color" id="ftextcolor-%id%" data-color-format="rgba" name="stream-%id%-ftextcolor" type="text" value="rgb(255,255,255)" tabindex="-1">
										</dd>
										<dt>Card color for links & name
										</dt>
										<dd>
											<input data-prop="color" id="fnamecolor-%id%" data-color-format="rgba" name="stream-%id%-fnamecolor" type="text" value="rgb(94,191,255);" tabindex="-1">
										</dd>
										<dt class="multiline">Color for other texts
												<p class="desc">Nickname and timestamp</p>
										</dt>
										<dd>
											<input data-prop="color" id="frest-%id%" data-color-format="rgba" name="stream-%id%-frestcolor" type="text" value="rgb(175,195,208);" tabindex="-1">
										</dd>

									<dt>Separator line color</dt>
									<dd>
										<input data-prop="border-color" id="fbcolor-%id%" data-color-format="rgba" name="stream-%id%-fbcolor" type="text" value="rgba(255,255,255,0.4)" tabindex="-1">
									</dd>
									<dt class="multiline">Card border
									<p class="desc">If photo is merging to background</p></dt>
									<dd>
										<label for="stream-%id%-mborder-yep"><input id="stream-%id%-mborder-yep" class="switcher" type="checkbox" name="stream-%id%-mborder" value="yep"/><div><div></div></div></label>
									</dd>
									<dt><span class="valign">Text alignment</span></dt>
										<dd class="">
											<div class="select-wrapper">
												<select name="stream-%id%-ftalign" id="ftalign-%id%">
													<option value="center" selected>Centered</option>
													<option value="left" >Left</option>
													<option value="right">Right</option>
		                    </select>
											</div>
										</dd>
										<dt class="hide">Preview</dt>
										<dd class="preview">
										  <h1>Live preview</h1>
											<div data-preview="bg-color" class="ff-stream-wrapper ff-layout-grid ff-theme-flat ff-style-1 shuffle">
												<div data-preview="fcolor, width" class="ff-item ff-twitter shuffle-item filtered" style="visibility: visible; opacity:1;">
												  <div class="ff-item-cont">
												  <span class="overlay" data-preview="fscolor"></span>
												  <span class="ff-img-holder" style="max-height:162px"><img src="' . FlowFlow::get_plugin_directory() . '/assets/7.jpg" style="width:100%;"></span>

												  <p data-preview="ftextcolor, fbcolor">This is regular text paragraph, can be tweet, facebook post etc. This is example of <a href="#" data-preview="fnamecolor">link in text</a>. Good day!</p>

												  <div class="ff-item-meta">
												  	<span class="ff-userpic" style="background:url(' . FlowFlow::get_plugin_directory() . '/assets/Steve-Zissou.png)"><i class="ff-icon"><i class="ff-icon-inner"></i></i></span><a data-preview="fnamecolor" target="_blank" rel="nofollow" href="#" class="ff-name">Looks Awesome</a><a data-preview="frest" target="_blank" rel="nofollow" href="#" class="ff-nickname">@looks_awesome</a><a data-preview="frest" target="_blank" rel="nofollow" href="#" class="ff-timestamp">21m ago </a>
											    </div>
													</div>
										    </div>
											</div>
										</dd>
									</dl>

									<span id="stream-stylings-sbmt-%id%" class="admin-button green-button submit-button">Save Changes</span>
								</div>
								<div class="design-step-2 layout-compact">
									<h1>Compact stylings</h1>
									<dl class="section-settings section-compact">

										<dt><span class="valign">Item style</span></dt>
										<dd>
											<div class="select-wrapper">
											<select name="stream-%id%-compact-style" id="compact-style-%id%">
												<option value="c-style-1" selected>Text and meta in container</option>
												<option value="c-style-2">Text in bubble, meta separately</option>
	                                        </select>
										</div>
										</dd>

										<dt>Color for heading & name</dt>
										<dd>
											<input data-prop="color" id="cnamecolor-%id%" data-color-format="rgba" name="stream-%id%-cnamecolor" type="text" value="rgb(154, 78, 141)" tabindex="-1">
										</dd>
										<dt>Regular text color
										</dt>
										<dd>
											<input data-prop="color" id="ctextcolor-%id%" data-color-format="rgba" name="stream-%id%-ctextcolor" type="text" value="rgb(85,85,85)" tabindex="-1">
										</dd>
										<dt>Links color</dt>
										<dd>
											<input data-prop="color" id="clinkscolor-%id%" data-color-format="rgba" name="stream-%id%-clinkscolor" type="text" value="rgb(94, 159, 202)" tabindex="-1">
										</dd>
										<dt class="multiline">Other text color
										<p class="desc">Nicknames, timestamps</p></dt>
										<dd>
											<input data-prop="color" id="crestcolor-%id%" data-color-format="rgba" name="stream-%id%-crestcolor" type="text" value="rgb(132, 118, 129)" tabindex="-1">
										</dd>
										<dt>Item border color</dt>
										<dd>
											<input data-prop="border-color" id="cbcolor-%id%" data-color-format="rgba" name="stream-%id%-cbcolor" type="text" value="rgba(226,226,226,1)" tabindex="-1">
										</dd>
										<dt><span class="valign">Show in item meta</span></dt>
										<dd>
											<div class="select-wrapper">
											<select name="stream-%id%-cmeta" id="cmeta-%id%">
												<option value="upic" selected>User picture</option>
												<option value="icon">Social icon</option>
	                    </select>
										</div>
										</dd>
										<dt><span class="valign">Text alignment</span></dt>
										<dd class="">
											<div class="select-wrapper">
												<select name="stream-%id%-calign" id="calign-%id%">
													<option value="left" selected>Left</option>
													<option value="center" >Centered</option>
													<option value="right">Right</option>
		                    </select>
											</div>
										</dd>
											<dt class="multiline">Number of items to show in slide
													<p class="desc">Leave empty to show all at once in long container</p>
										</dt>
										<dd>
											<input class="short" id="cards-num-%id%" name="stream-%id%-cards-num" type="text" value="3" tabindex="-1">
										</dd>
										<dt class="multiline">Scroll top when user slides<p class="desc">Recommended when there are many items in one slide</p></dt>
									<dd>
										<label for="stream-%id%-scrolltop"><input id="stream-%id%-scrolltop" class="switcher" type="checkbox" name="stream-%id%-scrolltop" checked value="yep"/><div><div></div></div></label>
									</dd>
										<dt class="hide">Preview</dt>
										<dd class="preview  ff-layout-compact">
										  <h1>Live preview</h1>
											<div data-preview="bg-color" class="ff-stream-wrapper ff-c-style-1 ff-c-upic shuffle">
												<div data-preview="fcolor" class="ff-item ff-twitter shuffle-item filtered" style="visibility: visible; opacity:1;">
												  <div data-preview="cbcolor" class="ff-item-cont">

												  <span class="corner1" data-preview="cbcolor" data-overrideProp="border-top-color"></span>
												   <h4 data-preview="cnamecolor">Header example</h4>
												  <span class="ff-img-holder" style="max-height:152px"><img src="' . FlowFlow::get_plugin_directory() . '/assets/compact.jpg" style="width:100%;"></span>

												  <p data-preview="ctextcolor">This is regular text paragraph, can be tweet, facebook post etc. This is example of <a href="#" data-preview="clinkscolor">link in text</a>. Good day!</p>

												  <div class="ff-item-meta">
												  	<span class="ff-userpic" style="background:url(' . FlowFlow::get_plugin_directory() . '/assets/Steve-Zissou.png)"><i class="ff-icon"><i class="ff-icon-inner"></i></i></span><a data-preview="cnamecolor" target="_blank" rel="nofollow" href="#" class="ff-name">Looks Awesome</a><a data-preview="crestcolor" target="_blank" rel="nofollow" href="#" class="ff-nickname">@looks_awesome</a><a data-preview="crestcolor" target="_blank" rel="nofollow" href="#" class="ff-timestamp">21m ago </a>
											    </div>
											    												  <span class="corner2" data-preview="bg-color"  data-overrideProp="border-top-color"></span>

													</div>
										    </div>
											</div>
										</dd>
									</dl>
									<span id="stream-stylings-sbmt-%id%" class="admin-button green-button submit-button">Save Changes</span>
								</div>
								</div>
							<div class="section" id="css-%id%">
								<h1 class="desc-following">Stream custom CSS</h1>
								<p class="desc" style="margin-bottom:10px">
								  Prefix your selectors with <strong>#ff-stream-%id%</strong> to target this specific stream
								</p>
								<textarea  name="stream-%id%-css" cols="100" rows="10" id="stream-%id%-css"/> </textarea>
								<p style="margin-top:10px"><span id="stream-css-sbmt-%id%" class="admin-button green-button submit-button">Save Changes</span><p>
							</div>

						</div>
					',
					'twitterView' => '
						<div class="feed-view" data-feed-type="twitter" data-uid="%uid%">
							<h1>Content settings for Twitter feed</h1>
							<dl class="section-settings">
							    <dt>Timeline type </dt>
                   				<dd>
									<input id="%uid%-home-timeline-type" type="radio" name="%uid%-timeline-type" value="home_timeline" checked/>
                            		<label for="%uid%-home-timeline-type">Home timeline</label><br><br>
                            		<input id="%uid%-user-timeline-type" type="radio" name="%uid%-timeline-type" value="user_timeline" />
                            		<label for="%uid%-user-timeline-type">User timeline</label><br><br>
                            		<input id="%uid%-search-timeline-type" type="radio" name="%uid%-timeline-type" value="search"/>
                            		<label for="%uid%-search-timeline-type">Search results</label>
                   				</dd>
								<dt>Content to show</dt>
								<dd><input type="text" name="%uid%-content" placeholder="What content to stream"/>
																 <p class="desc">1. For home timeline enter you own nickname (without @)<br>
																 2. For user timeline enter nickname (without @) of any public Twitter<br>
																 3. For search enter any word or #hashtag (look <a href="https://dev.twitter.com/rest/public/search">here</a> for advanced terms)
																 </p>
</dd>
								<dt>Include retweets (if present)</dt>
								<dd>
									<label for="%uid%-retweets"><input id="%uid%-retweets" class="switcher" type="checkbox" name="%uid%-retweets" value="yep"/><div><div></div></div></label>
								</dd>
								<dt>Include replies (if present)</dt>
								<dd>
									<label for="%uid%-replies"><input id="%uid%-replies" class="switcher" type="checkbox" name="%uid%-replies" value="yep"/><div><div></div></div></label>
								</dd>
							</dl>
						</div>
					',
					'facebookView' => '
						<div class="feed-view"  data-feed-type="facebook" data-uid="%uid%">
							<h1>Content settings for Facebook feed</h1>
							<dl class="section-settings">
							    <dt>Timeline type </dt>
                   				<dd>
									<input id="%uid%-home-timeline-type" type="radio" name="%uid%-timeline-type" value="home_timeline" checked/>
                            		<label for="%uid%-home-timeline-type">News feed of token owner</label><br><br>
                            		<input id="%uid%-user-timeline-type" type="radio" name="%uid%-timeline-type" value="user_timeline" />
                            		<label for="%uid%-user-timeline-type">Posts of token owner</label><br><br>
                            		<input id="%uid%-page-timeline-type" type="radio" name="%uid%-timeline-type" value="page_timeline" />
                            		<label for="%uid%-page-timeline-type">Facebook public Page</label>
                   				</dd>
								<dt>
								  Content to show
								</dt>
								<dd><input type="text" name="%uid%-content" placeholder="What content to stream"/>
								 <p class="desc">1. For <strong>News feed</strong> enter your own nickname to stream what you see on facebook.com<br>
																 2. For <strong>Posts</strong> enter your ID that you can find out <a href="http://findmyfacebookid.com">here</a><br>
																 3. For <strong>Public page</strong> posts enter nickname of any public Facebook page eg. <strong>cnnbrkofficial</strong>
																  </p></dd>
								<dt>Hide the attached content</dt>
								<dd>
									<label for="%uid%-hide-attachment"><input id="%uid%-hide-attachment" class="switcher" type="checkbox" name="%uid%-hide-attachment" value="yep"/><div><div></div></div></label>
								</dd>
							</dl>
						</div>
					',
					'vimeoView' => '
						<div class="feed-view"  data-feed-type="vimeo" data-uid="%uid%">
							<h1>Content settings for Vimeo feed</h1>
							<dl class="section-settings">
							    <dt>Feed type </dt>
                   				<dd>
									<input id="%uid%-type-videos" type="radio" name="%uid%-timeline-type" value="videos" checked/>
                            		<label for="%uid%-type-videos">Own videos</label><br><br>
                            		<input id="%uid%-type-likes" type="radio" name="%uid%-timeline-type" value="likes" />
                            		<label for="%uid%-type-likes">Liked videos</label><br><br>
                            		<input id="%uid%-type-channel" type="radio" name="%uid%-timeline-type" value="channel" />
                            		<label for="%uid%-type-channel">Channel videos</label><br><br>
                            		<input id="%uid%-type-group" type="radio" name="%uid%-timeline-type" value="group" />
                            		<label for="%uid%-type-group">Group videos</label><br><br>
                            		<input id="%uid%-type-album" type="radio" name="%uid%-timeline-type" value="album" />
                            		<label for="%uid%-type-album">Album videos</label>
                   				</dd>
								<dt>
								  Content to show
								</dt>
								<dd><input type="text" name="%uid%-content" placeholder="What content to stream"/>
								 <p class="desc">Enter nickname of Vimeo user/album/channel (only users have <strong>liked</strong> videos feed)</p></dd>

							</dl>
						</div>
					',
					'googleView' => '
						<div class="feed-view" data-feed-type="google" data-uid="%uid%">
							<h1>Content settings for Google+ feed</h1>

							<dl class="section-settings">
								<dt>
								  Content to show
								</dt>
								<dd><input type="text" name="%uid%-content" placeholder="+UserName"/>
								 <p class="desc">Google username starting with plus</p>
								</dd>

								<dt>Hide the attached content</dt>
								<dd>
									<label for="%uid%-hide-attachment"><input id="%uid%-hide-attachment" class="switcher" type="checkbox" name="%uid%-hide-attachment" value="yep"/><div><div></div></div></label>
								</dd>
							</dl>
						</div>
					',
					'rssView' => '
						<div class="feed-view"  data-feed-type="rss" data-uid="%uid%">
							<h1>Content settings for RSS feed</h1>
							<dl class="section-settings">
								<dt class="">Content to show</dt>
								<dd class=""><input type="text" name="%uid%-content" placeholder="Enter RSS feed full URL"/></dd>
                                <dt>Rss channel name</dt><dd><input type="text" name="%uid%-channel-name" placeholder="Enter name to show in card"/></dd>
                                <dt>Hide caption</dt>
                                <dd>
									<label for="%uid%-hide-caption"><input id="%uid%-hide-caption" class="switcher" type="checkbox" name="%uid%-hide-caption" value="yep"/><div><div></div></div></label>
								</dd>
                               <!-- <dt>Rich text</dt>
                                <dd>
									<label for="%uid%-rich-text"><input id="%uid%-rich-text" class="switcher" type="checkbox" name="%uid%-rich-text" value="yep"/><div><div></div></div></label>-->
								</dd>
							</dl>
						</div>
					',
					'pinterestView' => '
						<div class="feed-view" data-feed-type="pinterest" data-uid="%uid%">
							<h1>Content settings for Pinterest feed</h1>
							<dl class="section-settings">
								<dt class="">Content to show</dt>
								<dd class=""><input type="text" name="%uid%-content" placeholder="What content to stream"/>
								<p class="desc">e.g. <strong>elainen</strong> (for user feed) or <strong>elainen/cute-animals</strong> (for user board).
																 </p></dd>
								<dt>Hide text</dt>
								<dd>
									<label for="%uid%-hide-text"><input id="%uid%-hide-text" class="switcher" type="checkbox" name="%uid%-hide-text" value="yep"/><div><div></div></div></label>
								</dd>
							</dl>
						</div>
					',
					'instagramView' => '
						<div class="feed-view" data-feed-type="instagram" data-uid="%uid%">
							<h1>Content settings for Instagram feed</h1>
							<dl class="section-settings">
								<dt>Timeline type</dt>
                   				<dd>
									<input id="%uid%-home-timeline-type" type="radio" checked name="%uid%-timeline-type" value="home_timeline"/>
                            		<label for="%uid%-home-timeline-type">Home</label><br><br>
                            		<input id="%uid%-user-timeline-type"  type="radio" name="%uid%-timeline-type" value="user_timeline"/>
                            		<label for="%uid%-user-timeline-type">User</label><br><br>
                            		<input id="%uid%-popular-timeline-type" type="radio" name="%uid%-timeline-type" value="popular"/>
                            		<label for="%uid%-popular-timeline-type">Popular</label><br><br>
                            		<input id="%uid%-search-timeline-type" type="radio" name="%uid%-timeline-type" value="tag"/>
                            		<label for="%uid%-search-timeline-type">Search by tag</label>
								</dt>
								<dt>Content to show</dt>
								<dd>
									<input type="text" name="%uid%-content" placeholder="What content to stream"/>
									<p class="desc">1. For home timeline enter you own nickname<br>
																 2. For user timeline enter nickname of any public Instagram account<br>
																 3. For popular enter any word<br>
																 4. For search by tag enter one word without #
																 </p>
								</dd>
								<dt>Hide text</dt>
								<dd>
									<label for="%uid%-hide-text"><input id="%uid%-hide-text" class="switcher" type="checkbox" name="%uid%-hide-text" value="yep"/><div><div></div></div></label>
								</dd>
							</dl>
						</div>
					',
					'wordpressView' => '
						<div class="feed-view" data-feed-type="wordpress" data-uid="%uid%">
							<h1>Content settings for WordPress feed</h1>
							<dl class="section-settings">
								<dt>Show latest</dt>
								<dd>
									<input id="%uid%-wordpress-posts" type="radio" name="%uid%-wordpress-type" checked value="posts"/> <label for="%uid%-wordpress-posts">Posts</label>
									<input id="%uid%-wordpress-comments" type="radio" name="%uid%-wordpress-type" value="comments"/> <label for="%uid%-wordpress-comments">Comments</label>
								</dd>
							</dl>
						</div>
					',
					'youtubeView' => '
						<div class="feed-view" data-feed-type="youtube" data-uid="%uid%">
							<h1>Content settings for YouTube feed</h1>
							<dl class="section-settings">

								<dt class="">Content to show</dt>
								<dd class=""><input type="text" name="%uid%-content" placeholder="What content to stream"/>
								<p class="desc">Enter YouTube username or channel ID eg. <strong>VEVO</strong><br/>!IMPORTANT some accounts have settings that restrict getting their videos and this can cause empty feed)</p></dd>
							</dl>
						</div>
					','flickrView' => '
						<div class="feed-view" data-feed-type="flickr" data-uid="%uid%">
							<h1>Content settings for Flickr feed</h1>
							<dl class="section-settings">
								<dt>Timeline type</dt>
                   				<dd>
									<input id="%uid%-user_timeline" type="radio" checked name="%uid%-timeline-type" value="user_timeline"/>
                            		<label for="%uid%-user_timeline">User timeline</label><br><br>
                            		<input id="%uid%-tag" type="radio" name="%uid%-timeline-type" value="tag"/>
                            		<label for="%uid%-tag">Tag</label>
								</dt>
								<dt class="">Content to show</dt>
								<dd class=""><input type="text" name="%uid%-content" placeholder="What content to stream"/>
									<p class="desc">1. For user timeline enter Flickr username<br>2. For tag enter word or words divided by comma</p>
								</dd>
								<dt>Hide text</dt>
								<dd>
									<label for="%uid%-hide-text"><input id="%uid%-hide-text" class="switcher" type="checkbox" name="%uid%-hide-text" value="yep"/><div><div></div></div></label>
								</dd>
							</dl>
						</div>
					','tumblrView' => '
						<div class="feed-view" data-feed-type="tumblr" data-uid="%uid%">
							<h1>Content settings for Tumblr feed</h1>
							<dl class="section-settings">
								<dt class="">Content to show</dt>
								<dd class=""><input type="text" name="%uid%-content" placeholder="What content to stream"/>
									<p class="desc">Enter Tumblr username to show images from tlog</p>
								</dd>
								<dt>Hide text</dt>
								<dd>
									<label for="%uid%-hide-text"><input id="%uid%-hide-text" class="switcher" type="checkbox" name="%uid%-hide-text" value="yep"/><div><div></div></div></label>
								</dd>
								<dt>Rich text</dt>
                            	<dd>
									<label for="%uid%-rich-text"><input id="%uid%-rich-text" class="switcher" type="checkbox" name="%uid%-rich-text" value="yep"/><div><div></div></div></label>
								</dd>
							</dl>
						</div>
					',
				);
				?>
					<script>
						var ff_templates = {
							view: '<?php echo trim(preg_replace('/\s+/', ' ', $templates['view'])); ?>',
							twitterView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['twitterView'])); ?>',
							facebookView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['facebookView'])); ?>',
							googleView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['googleView'])); ?>',
							rssView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['rssView'])); ?>',
							pinterestView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['pinterestView'])); ?>',
							instagramView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['instagramView'])); ?>',
							wordpressView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['wordpressView'])); ?>',
							youtubeView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['youtubeView'])); ?>',
							vimeoView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['vimeoView'])); ?>',
							flickrView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['flickrView'])); ?>',
							tumblrView : '<?php echo trim(preg_replace('/\s+/', ' ', $templates['tumblrView'])); ?>'
						}
					</script>
				<?php

				//echo $templates['view'];

				/*foreach ($options['streams'] as $key => $stream) {
					$id = $stream->id;
					$view = str_replace('%id%', $id, $templates['view']);
					$list = '';
					$feedsStr = '';

					if (isset($stream->feeds)) {
						$feeds = json_decode($stream->feeds);

//						FlowFlowAdmin::debug_to_console('stream' . $stream->id . ' feeds');
//						FlowFlowAdmin::debug_to_console($feeds);

						$length = count($feeds);

						for ($i = 0; $i < $length; $i++) {
								$feed = $feeds[$i];
								$uid = 's'.$id . '-f' . $feed->id;

							$info = '';

							foreach ($feed as $key => $val) {
								 $fval = str_replace(' timeline', '', str_replace('_', ' ', $val ));
								 $kval = ucfirst ( $key );
								 if ($key !== 'content') $fval = ucfirst ( $fval );
							   if ($key !== 'type' && $key !== 'id') $info = $info . str_replace('-', ' ', $kval) . ':<span class="highlight">' . str_replace(' timeline', '', str_replace('_', ' ', $fval )) . '</span>' ;
							}

							$list = $list .
							'<tr data-uid="' . $uid . '" data-network="' . $feed->type . '">
								<td class="controls"><i class="flaticon-pen"></i> <i class="flaticon-copy"></i> <i class="flaticon-trash"></i></td>
								<td class="td-feed"><i class="flaticon-' . $feed->type . '"></i>'. $feed->type . ' feed</td>
								<td>' . $info. '</td>
							</tr>';

							$feedsStr = $feedsStr . str_replace('%uid%', $uid, $templates[ $feed->type . 'View']);
						}
					}

					if (empty($list)) {
						$list = '<tr><td  class="empty-cell" colspan="3">Add at least one feed</td></tr>';
					}

					$view = str_replace('%LIST%', $list, $view);
					//$view = str_replace('%FEEDS%', $feedsStr, $view);

					echo $view;
//					$data = array('id' => $id);
//					call_user_func_array('FlowFlowAdmin::render_template', array(dirname( __FILE__ ) . '/stream.php', $data));

					$at = FFFacebookCacheManager::get()->getAccessToken();
				}*/

				?>
			</div>
			<div class="section-content" data-tab="general-tab">
				<div class="section" id="general-settings">
					<h1>General Settings</h1>
                    <dl class="section-settings">
						<dt>Date format</dt>
						<dd>
							<input id="general-settings-ago-format" class="clearcache" type="radio" name="flow_flow_options[general-settings-date-format]" <?php if (isset($options['general-settings-date-format']) && $options['general-settings-date-format'] == 'agoStyleDate') echo "checked"; ?> value="agoStyleDate"/>
							<label for="general-settings-ago-format">Short</label>
							<input id="general-settings-classic-format" class="clearcache" type="radio" name="flow_flow_options[general-settings-date-format]" <?php if (!isset($options['general-settings-date-format']) || $options['general-settings-date-format'] == 'classicStyleDate') echo "checked"; ?> value="classicStyleDate"/>
							<label for="general-settings-classic-format">Classic</label>
						</dd>
	                    <dt>Text in stream filter for 'All'</dt>
	                    <dd>
		                    <input id="stream-%id%-filterall" type="text" class="short" name="flow_flow_options[general-settings-filterall]" placeholder="Enter text" value="<?php echo $options['general-settings-filterall']?>"/>
	                    </dd>
						<dt>Open links in new window</dt>
						<dd>
							<label for="general-settings-open-links-in-new-window">
								<input id="general-settings-open-links-in-new-window" class="switcher clearcache" type="checkbox"
									   name="flow_flow_options[general-settings-open-links-in-new-window]"
										<?php if (!isset($options['general-settings-open-links-in-new-window']) || $options['general-settings-open-links-in-new-window'] == 'yep') echo "checked"; ?>
									    value="yep"/><div><div></div></div>
							</label>
						</dd>
	                    <dt class="multiline">Disable proxy server for pictures<p class="desc">Proxying improves performance</p></dt>
	                    <dd>
		                    <label for="general-settings-disable-proxy-server">
			                    <input id="general-settings-disable-proxy-server" class="clearcache switcher" type="checkbox"
			                           name="flow_flow_options[general-settings-disable-proxy-server]"
				                        <?php if (!isset($options['general-settings-disable-proxy-server']) || $options['general-settings-disable-proxy-server'] == 'yep') echo "checked"; ?>
			                            value="yep"/><div><div></div></div>
	                    </dd>

	                    <!--<dt class="multiline">SEO mode<p class="desc">When cache content is available plugin injects stream HTML synchronously and search bots index it</p></dt>
	                    <dd>
		                    <label for="general-settings-seo-mode">
			                    <input id="general-settings-seo-mode" class="switcher" type="checkbox"
			                           name="flow_flow_options[general-settings-seo-mode]"
				                    <?php /*if (isset($options['general-settings-seo-mode']) && $options['general-settings-seo-mode'] == 'yep') echo "checked"; */?>
			                           value="yep"/><div><div></div></div>

	                    </dd>-->

                    </dl>
                    <span id="general-settings-sbmt" class='admin-button green-button submit-button'>Save Changes</span>
				</div>
			</div>
			<div class="section-content" data-tab="auth-tab">
				<div class="section" id="auth-settings">
					<h1 class="desc-following">Twitter auth settings</h1>
					<p class="desc">Valid for all (public) twitter accounts. You need to authenticate one (and any) twitter account here. <a target="_blank" href="http://flow.looks-awesome.com/docs/Setup/Authenticate%20with%20Twitter">Follow setup guide</a></p>
					<dl class="section-settings">
						<dt class="vert-aligned">Access Token</dt>
						<dd>
							<input class="clearcache" type="text" name="flow_flow_options[oauth_access_token]" placeholder="Copy and paste from Twitter" value="<?php echo $options['oauth_access_token']?>"/>
						</dd>
						<dt class="vert-aligned">Access Token Secret</dt>
						<dd>
							<input class="clearcache" type="text" name="flow_flow_options[oauth_access_token_secret]" placeholder="Copy and paste from Twitter" value="<?php echo $options['oauth_access_token_secret']?>"/>						</dd>
						<dt class="vert-aligned">Consumer Key (API Key)</dt>
						<dd>
							<input class="clearcache" type="text" name="flow_flow_options[consumer_key]" placeholder="Copy and paste from Twitter" value="<?php echo $options['consumer_key']?>"/>
						</dd>
						<dt class="vert-aligned">Consumer Secret (API Secret)</dt>
						<dd>
							<input class="clearcache" type="text" name="flow_flow_options[consumer_secret]" placeholder="Copy and paste from Twitter" value="<?php echo $options['consumer_secret']?>"/>
						</dd>
                    </dl>
<!--					<p><span id="tw-auth-settings-sbmt" class='admin-button green-button submit-button'>Save Changes</span></p>-->

					<h1  class="desc-following">Facebook auth settings</h1>
					<p class="desc">Valid to pull any public FB page. <a target="_blank" href="http://flow.looks-awesome.com/docs/Setup/Authenticate%20with%20Facebook">Follow setup guide</a></p>
					<dl class="section-settings">
						<dt class="vert-aligned">Access Token</dt>
						<dd>
							<input class="clearcache" type="text" name="flow_flow_fb_auth_options[facebook_access_token]" placeholder="Copy and paste from Facebook" value="<?php echo $auth['facebook_access_token']?>"/>
<!--							--><?php //if(!empty($auth['facebook_access_token'])) echo '<p class="desc">Token active: ' . FFFacebookCacheManager::get()->getAccessToken() . '</p>';?>
						</dd>
						<dt class="vert-aligned">APP ID</dt>
						<dd>
							<input class="clearcache" type="text" name="flow_flow_fb_auth_options[facebook_app_id]" placeholder="Copy and paste from Facebook" value="<?php echo $auth['facebook_app_id']?>"/>
						</dd>
						<dt class="vert-aligned">APP Secret</dt>
						<dd>
							<input class="clearcache" type="text" name="flow_flow_fb_auth_options[facebook_app_secret]" placeholder="Copy and paste from Facebook" value="<?php echo $auth['facebook_app_secret']?>"/>
						</dd>
					</dl>
<!--					<p><span id="fb-auth-settings-sbmt" class='admin-button green-button submit-button'>Save Changes</span></p>-->


                    <h1 class="desc-following">Instagram auth settings</h1>
										<p class="desc">Valid to pull any public Instagram account feed or valid search term. <a target="_blank" href="http://flow.looks-awesome.com/docs/Setup/Authenticate%20with%20Instagram">Follow setup guide</a></p>
                    <dl class="section-settings">
                        <dt class="vert-aligned">Access Token</dt>
                        <dd>
                            <input class="clearcache" type="text" name="flow_flow_options[instagram_access_token]" placeholder="Copy and paste from Instagram" value="<?php echo $options['instagram_access_token']?>"/>
                        </dd>
                    </dl>
<!--					<p><span id="inst-auth-settings-sbmt" class='admin-button green-button submit-button'>Save Changes</span></p>-->

                    <h1 class="desc-following">Google+ auth settings</h1>
										<p class="desc">Valid to pull any public Google+ page feed. <a target="_blank" href="http://flow.looks-awesome.com/docs/Setup/Authenticate%20with%20Google">Follow setup guide</a></p>
                    <dl class="section-settings">
                        <dt class="vert-aligned">Api key</dt>
                        <dd>
                            <input class="clearcache" type="text" name="flow_flow_options[google_api_key]" placeholder="Copy and paste from Google+" value="<?php echo $options['google_api_key']?>"/>
                        </dd>
                    </dl>

					<p><span id="gp-auth-settings-sbmt" class='admin-button green-button submit-button'>Save Changes</span></p>
				</div>
			</div>
		</div>
	</div>

</form>
<?php
FlowFlowAdmin::debug_to_console('html generated');
echo("<script>jQuery(document).trigger('html_ready')</script>");

?>

