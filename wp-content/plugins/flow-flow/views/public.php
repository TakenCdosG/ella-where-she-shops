<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>
 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */

$id = $stream->id;
//$seo = $this->generalSettings->isSEOMode();
$seo = false;
$disableCache = isset($_REQUEST['disable-cache']);
?>

<style id="ff-dynamic-styles-<?php echo $id ?>">
	#ff-stream-<?php echo $id ?> .ff-header h1,#ff-stream-<?php echo $id ?> .ff-controls-wrapper > span:hover {
		color: <?php echo $stream->headingcolor ?>;
	}
	#ff-stream-<?php echo $id ?> .ff-filter:hover {
		background-color: <?php echo $stream->headingcolor ?> !important;
	}
	#ff-stream-<?php echo $id ?> .ff-controls-wrapper > span:hover {
		border-color: <?php echo $stream->headingcolor ?> !important;
	}
	#ff-stream-<?php echo $id ?> .ff-header h2 {
		color: <?php echo $stream->subheadingcolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-filter-holder .ff-filter, #ff-stream-<?php echo $id ?>  .ff-filter-holder:before {
		background-color: <?php echo $stream->filtercolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-filter-holder .ff-search input {
		border-color: <?php echo $stream->filtercolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-filter-holder .ff-search:after {
		color: <?php echo $stream->filtercolor ?>;
	}

	#ff-stream-<?php echo $id ?>,
	#ff-stream-<?php echo $id ?> .ff-search input,
	#ff-stream-<?php echo $id ?>.ff-layout-compact .picture-item__inner {
		background-color: <?php echo $stream->bgcolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-c-style-2 .ff-item-cont:after {
	<!--		border-top-color:--><?php //echo $stream->bgcolor ?><!--;-->
	}

	#ff-stream-<?php echo $id ?> .ff-header h1, #ff-stream-<?php echo $id ?> .ff-header h2 {
		text-align: <?php echo $stream->hhalign ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-controls-wrapper, #ff-stream-<?php echo $id ?> .ff-controls-wrapper > span {
		border-color: <?php echo $stream->filtercolor ?>;
	}
	#ff-stream-<?php echo $id ?> .ff-controls-wrapper, #ff-stream-<?php echo $id ?> .ff-controls-wrapper > span {
		color: <?php echo $stream->filtercolor ?>;
	}

	<?php if($stream->layout == 'grid'): ?>
	#ff-stream-<?php echo $id ?> .ff-item, #ff-stream-<?php echo $id ?> .shuffle__sizer{
		width:  <?php echo $stream->width ?>px;
	}
	#ff-stream-<?php echo $id ?> .ff-item {
		margin-bottom: <?php echo $stream->margin ?>px !important;
	}
	#ff-stream-<?php echo $id ?> .shuffle__sizer {
		margin-left: <?php echo $stream->margin ?>px !important;
	}
	<?php endif; ?>

	<?php if($stream->layout == 'grid' && $stream->theme == 'classic'): ?>
	#ff-stream-<?php echo $id ?>  .picture-item__inner {
		background: <?php echo $stream->cardcolor ?>;
		color: <?php echo $stream->textcolor ?>;
		box-shadow: 0 1px 4px 0 <?php echo $stream->shadow ?>;
	}
	#ff-stream-<?php echo $id ?>  .ff-slideshow {
		color: <?php echo $stream->textcolor ?>;
	}
	#ff-stream-<?php echo $id ?> .ff-slideshow li {
		background: <?php echo $stream->cardcolor ?>;
	}
	#ff-stream-<?php echo $id ?> .ff-icon {
		border-color: <?php echo $stream->cardcolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-style-2 .ff-icon:after {
		text-shadow: -1px 0 <?php echo $stream->cardcolor ?>, 0 1px <?php echo $stream->cardcolor ?>, 1px 0 <?php echo $stream->cardcolor ?>, 0 -1px <?php echo $stream->cardcolor ?>;
	}
	#ff-stream-<?php echo $id ?>  a {
		color: <?php echo $stream->linkscolor ?>;
	}

	#ff-stream-<?php echo $id ?>  h4,
	#ff-stream-<?php echo $id ?> .ff-name {
		color: <?php echo $stream->namecolor ?>;
	}

	#ff-stream-<?php echo $id ?> a.ff-nickname,
	#ff-stream-<?php echo $id ?> a.ff-timestamp {
		color: <?php echo $stream->restcolor ?> !important;
	}

	#ff-stream-<?php echo $id ?> .ff-item {
		text-align: <?php echo $stream->talign ?>;
	}
	#ff-stream-<?php echo $id ?> .ff-theme-classic.ff-style-1 .ff-item-meta:before,
	#ff-stream-<?php echo $id ?> .ff-theme-classic.ff-style-2 .ff-item-meta:before,
	#ff-stream-<?php echo $id ?> .ff-theme-classic.ff-style-6 .ff-item-meta:before,
	#ff-stream-<?php echo $id ?> .ff-slideshow .ff-item-meta {
		border-color: <?php echo $stream->bcolor ?>;
	}
	<?php endif; ?>
	<?php if($stream->layout == 'grid' && $stream->theme == 'flat'): ?>
	#ff-stream-<?php echo $id ?> .picture-item__inner {
		background: <?php echo $stream->fcardcolor ?>;
		color: <?php echo $stream->ftextcolor ?>;
	}

	#ff-stream-<?php echo $id ?>  .ff-slideshow {
		color: <?php echo $stream->ftextcolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-slideshow li {
		background: <?php echo $stream->fcardcolor ?>;
	}
	#ff-stream-<?php echo $id ?> h4 {
		color: <?php echo $stream->ftextcolor ?>;
	}

	#ff-stream-<?php echo $id ?> a {
		color: <?php echo $stream->fnamecolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-name {
		color: <?php echo $stream->fnamecolor ?>;
	}

	#ff-stream-<?php echo $id ?> a.ff-nickname, #ff-stream-<?php echo $id ?> a.ff-timestamp {
		color: <?php echo $stream->frestcolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-theme-flat h4,
	#ff-stream-<?php echo $id ?> .ff-theme-flat p,
	#ff-stream-<?php echo $id ?> .ff-slideshow .ff-item-meta {
		border-color: <?php echo $stream->fbcolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-item {
		text-align: <?php echo $stream->ftalign ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-style-1 .ff-no-image  .ff-item-cont:before,
	#ff-stream-<?php echo $id ?> .ff-style-3 .ff-item-cont:before{
		background: <?php echo $stream->fscardcolor ?>;
	}
	<?php endif; ?>
	<?php if($stream->mborder == 'yep'): ?>
	#ff-stream-<?php echo $id ?> .picture-item__inner {
		border: 1px solid #eee;
	}
	<?php endif; ?>


	<?php if($stream->layout == 'compact'): ?>

	#ff-stream-<?php echo $id ?> .ff-slideshow li {
		background: <?php echo $stream->bgcolor ?>;
	}
	#ff-stream-<?php echo $id ?> .ff-item {
		text-align: <?php echo $stream->calign ?>;
	}
	#ff-stream-<?php echo $id ?>  .picture-item__inner,#ff-stream-<?php echo $id ?>  .ff-slideshow {
		color: <?php echo $stream->ctextcolor ?>;
	}

	#ff-stream-<?php echo $id ?> a {
		color: <?php echo $stream->clinkscolor ?>;
	}

	#ff-stream-<?php echo $id ?>  h4,
	#ff-stream-<?php echo $id ?> .ff-name {
		color: <?php echo $stream->cnamecolor ?>;
	}

	#ff-stream-<?php echo $id ?> a.ff-nickname,
	#ff-stream-<?php echo $id ?> a.ff-timestamp {
		color: <?php echo $stream->crestcolor ?> !important;
	}

	#ff-stream-<?php echo $id ?>  .ff-c-style-2 .ff-item-cont:after {
		border-top-color: <?php echo $stream->bgcolor ?>;
	}
	#ff-stream-<?php echo $id ?> .ff-item-cont,
	#ff-stream-<?php echo $id ?> .ff-slideshow .ff-item-meta {
		border-color: <?php echo $stream->cbcolor ?>;
	}

	#ff-stream-<?php echo $id ?> .ff-c-style-2 .ff-item-cont:before {
		border-top-color: <?php echo $stream->cbcolor ?>;
	}
	<?php endif; ?>

	<?php
	  if(!empty($stream->css)) echo $stream->css;
	 ?>


</style>

<div class="ff-stream ff-loading" id="ff-stream-<?php echo $id ?>">
</div>
<?php if ($seo || isset($_REQUEST['debug'])){
	if (isset($_REQUEST['debug'])) define(WP_DEBUG, true);
	if (!isset($_REQUEST['stream-id'])) $_REQUEST['stream-id'] = $id;?>
	<script type="text/javascript">
		(function ( $ ) {
			"use strict";
			try {
				var opts = window.FlowFlowOpts;
				if (!opts) return
				var $stream = FlowFlow.buildStreamWith(<?php echo FlowFlow::get_instance()->processRequest()?>);
				var $cont = $("#ff-stream-" + '<?php echo $id ?>');
				var streamOpts = opts['streams']['id' + '<?php echo $id ?>'];
				var num = streamOpts.layout === 'compact' ? streamOpts['cards-num'] : false;
				$cont.addClass('ff-layout-' + streamOpts.layout);
				if (streamOpts.layout === 'compact') {
					FlowFlow.adjustImgHeight($stream, $cont.width() - 72); // todo remove hardcode
				}
				$cont.append($stream);
				if (typeof $stream !== 'string') FlowFlow.setupGrid($cont.find('.ff-stream-wrapper'), num, streamOpts.scrolltop === 'yep', streamOpts.gallery === 'yep');
				setTimeout(function(){
					$cont.removeClass('ff-loading')
				}, 100);
			} catch (e) {

			}
		}(jQuery));
	</script>
	<?php
	if (isset($_REQUEST['debug'])) {
		echo '<h1>DEBUG!!!</h1>';
		printf('<h2>%d queries. %s seconds.</h2>', get_num_queries(), timer_stop(0, 3));
	}
} else { ?>
	<script type="text/javascript">
		(function ( $ ) {
			"use strict";
			if (/MSIE 8/.test(navigator.userAgent)) return;

			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			var data = {
				'action': 'fetch_posts',
				'stream-id': '<?php echo $stream->id; ?>',
				'disable-cache': '<?php echo $disableCache; ?>'};

			var opts = window.FlowFlowOpts;
			var isMobile = /android|blackBerry|iphone|ipad|ipod|opera mini|iemobile/i.test(navigator.userAgent);
			var streamOpts = opts['streams']['id' + data['stream-id']];
			var $cont = $("#ff-stream-"+data['stream-id']);
			var wh = $(window).height();
			$cont.addClass('ff-layout-' + streamOpts.layout)
			if (streamOpts.layout == 'grid' && !isMobile) $cont.css('minHeight', '1000px');

			if (!opts) return

			$.post(ajaxurl, data, function(response){
				try {
					var $stream = FlowFlow.buildStreamWith(JSON.parse(response));
					var num = streamOpts.layout === 'compact' || (streamOpts.mobileslider === 'yep' && isMobile)? (streamOpts.mobileslider === 'yep' ? 3 : streamOpts['cards-num']) : false;
					var w;

					if (streamOpts.layout === 'compact') {
						w = $cont.parent().width();
						FlowFlow.adjustImgHeight($stream, (w > 300 ? 300 : w) - 72); // todo remove hardcode
					}

					$cont.append($stream);

					if (typeof $stream !== 'string') FlowFlow.setupGrid($cont.find('.ff-stream-wrapper'), num, streamOpts.scrolltop === 'yep', streamOpts.gallery === 'yep');

					setTimeout(function(){
						$cont.removeClass('ff-loading');
					}, 100);

				} catch (e) {
					//console.log('stream build error', e.message)
				}

			})
			return false;

		}(jQuery));
	</script>
<?php } ?>
