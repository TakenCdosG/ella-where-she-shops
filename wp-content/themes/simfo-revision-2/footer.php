<?php
/** Themify Default Variables
 @var object */
	global $themify; ?>
	
	<?php themify_layout_after(); //hook ?>
	</div>
	<!-- /body -->
		
	<div id="footerwrap">
    
    	<?php themify_footer_before(); //hook ?>
		<footer id="footer" class="pagewidth clearfix">
        	<?php themify_footer_start(); //hook ?>

			<?php get_template_part( 'includes/footer-widgets'); ?>
	
			<p class="back-top"><a href="#header">&uarr;</a></p>
		
			<?php if (function_exists('wp_nav_menu')) {
				wp_nav_menu(array('theme_location' => 'footer-nav' , 'fallback_cb' => '' , 'container'  => '' , 'menu_id' => 'footer-nav' , 'menu_class' => 'footer-nav')); 
			} ?>
	
			<?php echo themify_logo_image('footer_logo', 'footer-logo'); ?>
			<!-- /footer-logo -->

			<div class="footer-text clearfix">
				<?php themify_the_footer_text(); ?>
				<?php themify_the_footer_text('right'); ?>
			</div>
			<!-- /footer-text --> 

				<!--/<div style="padding:5px 0px 0px 0px; border:1px solid #7D7D7D; width:100%;"><iframe src="http://apps.twinesocial.com/YoungWomenLEAD?format=embed&eh=http://youngwomenlead.com/ywl-social-hub/&ref=&ift=7cc662c5" frameborder="0" height="572" width="100%" style="width:100%;" scrolling="yes"></iframe></div>/-->
				
				<div>
					<div class="shortcode col4-1 first">
						<div style=" text-align:center; margin:30px 0px 0px 0px;">
							<form action="https://www.snapretail.com/retailer/ConsumerSignupForm.aspx/Save?DataCollectionType=EmbeddedWebForm" method="post"><input id="Token" name="Token" type="hidden" value="chnfKvRwDzx4LjGf23aubw">
								<div class="collectEmailFormGroupBasic">
									<input data-val="true" data-val-required="Required" id="EmailAddress" name="EmailAddress" placeholder="Sign up to Be in the Know" type="text" value="" style="float:left; padding:0px 0px 0px 5px;  height:30px !important; margin:0px 0px 0px 0px; font-size:7pt; width:170px; color:black !important; font-family:tahoma, sans-serif !important; ">
									<button type="submit" class="btn" style="float:left; border-radius:0px; padding:0px 0px 0px 0px; margin:0px 0px 0px 0px; border:0px solid #652D8A !important; width: 24px !important; height: 32px !important;	background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAgCAMAAAA/gEgKAAAAQlBMVEVlLYphK4RkLIhfKoJjLIdiLIZdKYBaKHuYgKhcKX7///9vO5Lg1ej18ffTw96Vc6uBUp/q4++8pMytj8GOZamjgbmMqqS7AAAAm0lEQVQoz73SyxKCMBBE0RZFQ+cp4P//qjMmBRVrsqUXLO4pigWD/LIHp8+lWwOpz7+JCWi+d1NSkHzrprTA1T4f+0kFzY9zQvIKnHTJ07EqDbSjTqWBds2nzB34VJr04AODtwAbmUxAIjcT/JvcLcBORhMC+bFgJVcYkMngDZBPxwIDUGKGCfAYAK6DSWH8a8fHMDyf4cENT/QLzW4LKQeIJ+4AAAAASUVORK5CYII=');"></button>
								</div>
								<span class="field-validation-valid" data-valmsg-for="EmailAddress" data-valmsg-replace="true"></span>
							</form>
						</div>
					</div>
					<div class="shortcode col2-1">
						<div style="color:#652D8A; font-family:'Montserrat', sans-serif; font-size:8pt; text-align:center;"><br /><br />&copy; Ella Where She Shops. All rights reserved. Site developed by <a target="_blank" href="http://www.thinkcreativegroup.com" style="color:#652D8A; text-decoration:none;">THINK creative group</a></div>
					</div>
					<div class="shortcode col4-1">
						<div style="text-align:center;">
							<img src="data:image/png;base64,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"/>
						</div>
					</div>
				</div>

            <?php themify_footer_end(); //hook ?>
		</footer>
		<!-- /#footer --> 
        <?php themify_footer_after(); //hook ?>

	</div>
	<!-- /#footerwrap -->
	
</div>
<!-- /#pagewrap -->

<?php
/**
 *  Stylesheets and Javascript files are enqueued in theme-functions.php
 */
?>

<?php themify_body_end(); // hook ?>
<!-- wp_footer -->
<?php wp_footer(); ?>





</body>
</html>