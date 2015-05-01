<!doctype html>
<html <?php echo themify_get_html_schema(); ?> <?php language_attributes(); ?>>
<head>
<?php
/** Themify Default Variables
 @var object */
	global $themify; ?>
<link rel='stylesheet' id='google-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600|Montserrat:400,700' type='text/css' media='all'>
<link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>

<meta charset="<?php bloginfo( 'charset' ); ?>" />


<title itemprop="name"><?php wp_title(); ?></title>

<?php
/**
 *  Stylesheets and Javascript files are enqueued in theme-functions.php
 */
?>

<!-- wp_header -->
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php themify_body_start(); //hook ?>
<div id="pagewrap" class="hfeed site">

	<div id="headerwrap">
	
    	<?php themify_header_before(); //hook ?>
		<header id="header" class="pagewidth">
        	<?php themify_header_start(); //hook ?>

			<hgroup>

				<div>
					<div class="shortcode col3-1 first">
						<div>
							<br /><a href="/"><img border="0" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAABVCAMAAAAPIs0EAAAAXVBMVEX///9lLYpvOpFWZCL18viylsTYyuKMYqeAi1ni1+nFsNOffLaCVaB4R5nV2MiqsZCVb6/s5fDPvdq7o8ypib2QmW66wKVhbjD09fHf4tVrdz7q7OOgqIN2gUzKzrpcUjcvAAAJkElEQVR42uya647jIAyFAWEQN4lL3v9Zd5K2cRICuNWuxKz6/RrlMgmnto+BsP8AVZwW/EnQYNgXMtJGwa8EkOwLBeX4PQLYlyE28DaOfemTL/JpvQBA9PyJZV86JM2RsOR0qIrhcZBNjFEP2D9C/dD1ATioVxK7UPjKpGZsrPMc0a78ZRlT8XzDW0L4OXz6VUHFpgN7hjPRyrurFUDUPwCeHqLi2AiU2C9I7J41iwubjBx7pmcuFy/+dJomodH8RDO8NmJiLdb/k9lMrKW5j8bR2lpqT3nGUoU2q3H8QeilqJ4shSUIvhM0FPUEjoHmJF5bYcfZu/9EIoKyev2jrR9035f/kNg02F0S4WyqC+N+NjN2lM9vrRk4DCZK+GmLdaylXzD9F56qjTF+D7HccMVdtRh38co+RrXJMnhIwEqAaSga+kXJesj1daaZzME+vZSDHEcCJDyXxSgC0Ri8wmOiVt1h+vZYJspg41G+LgmNQ1iGKD2ugTLe3GhqpRxeNUpgvrApyILehlj+pByO6VdmEtJ3kVe1zM0DhGF9jFhzYI4FrYIdwxDp0TwWKCoDaIEGPRTen4VJlQ8Yqn7zzOMcRgZFvyYijwpWXdf09ZgURP2mWYqREUsOWT/NEZL7RAy/I3m9UZ4Upeo3iwNLjynzxsUq8BO+yPF9Tg4bkUJ6GSumWUx9Ds1LYrLj+LITWAz7I06+EePxGoCma+Wo8jTxx+I7+uVLsBoLAEWNbjatslYqHTxFGTfRUvTyjn4yfLSCaUTjGWo7XikaKTkj5tAvk/XDRqR8pJ+ThEZEYms36CbFHP0LoWWoDFJ/pl8rnqHKTUOwDz/JBA74SmZE8Op3Tcq1TuhrU82BUHL0HPMPxgKOgSzgX9XPy6uh+f5/m2wvGD2BfLl40+Tb+lUttMHV/fYmyVybILic8XEEmgwbWclWjfBN/UzVnbhhwREz7YEEHB2FeGm/FGh+IFTttNkOy4Z+oV5WEKmdvo9n+Tns94mJTjI6FuMJJyJIvR6x6WQanYiXtT8so/R1s9jHZ4TXGNIi+C1eVhMNamO9Hk1t952t/NXQp3La8ybx2hY32vEobw67/np5mCp9P2LhO7gzuVFA84upw62rQqMTiW0LLuP0RUNTcye5Psu3HN/+oa7qBqCMjYUA2dyhTHrgvliT57PpZgQiXq9gSVSnVLV3uSjUvUEtnfDTifwRpmazogIfEk4WLCRhIot7S+3wK8MX+wUC7uEnNG+BvXGqSp10nVImbjMYKOEn46/46tf4V4xZxqR1evD9W7muPJjQ6UTM3cCVJ4WfwPDnk34w+EMWKN+LpJSy8CKb2m4YAt1OpNT1UjpOqX6w/3pZiXkz2PIHIBmR81iMr9ahBiWwCPTUcfoKSK+dgynbGMc52icJs8l9CRPotkeVLYz3qpPHDX0rJlqq/sPM2exICAJBeCRAR9AE1Pd/1j2Mm0+did0cyFjHDbuyBVQ3/cMFK/c0K9JBjaJ+kcB+HytYZdSi3VRUhOG5/KU268aeq1QEKrVqx/NeMzVIKn/7H/byrFA1YJ65PVuA76do2QiBNVvl1jOv5J7cM0IcvZ3AOCnbjwSnQB+V5Yb4/u5tP9eDCVSPNx9h4XpqITBm6ldV5J0/H4bhyQR6nIN22g3bjxR7Elx1qzCXU82sez0QpD7bfw0bqRIIbDUH1b2zCDt9zlItE1MoxDJnKWGpr+6YCZM2wMu56E0nkPHm/AzYZsWGVDrXznA59bXcy0Cux47VYQt01M1Bn3laoOymJ9205d2h9IwgbqQ+zYhijyxhOaDPeC4wOPnOiUkyKEB1O0Dacu94IsYsUJoYHFpce+irE9/S2t0JAfNdlLoHMG5N9KHr6tkFznp+C/QRJxq81tYy5RDHF4jLJqeUbA9wENvokzEpPoxPzF6SWG1VDTP0neTilj4J8fssWA1y9r8iEDWbF3TKpe85oHMPbeQUqp8g+L2wBlehHg8j86K1WBKJ+BmBHjVzK3fot0T7i1Usx1Z+j7UakiaYwImc1KJcJmO3sbROdjDHxjt6zO5TTEZ+VkKsb9kJxR29sHi5cq8WwZzdxYTia13Wx4Vq7PXotQedoaFv3ObvM66cMP0JAU8C6V4wc3yFE307+VNYV9qm8Iushr1PPLtgSnX2hglKePVFZ48NyxIAWpV57ilDH/89QBzsGPtkVNa7dfFLPhKUo/HZpmlbbhN/ZSU7enqVQRLusRtki99vdgxtY7BH/ZJHoC8YgxjX++huSQnRWzK804e367aqaJgyVEPqcogDygRqwmhgDNRHdhSJVo689YWtmf3diNylAeo/8fXX3tk2tw3CcFxXpQ7X9UyzRAgw+Pt/zJ2EY11an9Ntyeb0+n8RQIeffhECHOy8dGD96EI4u412xyWEb8dPeFT3/LY//dUdqoO6PtxYh6fVabgMUm8rDaym/ennDu6ntdUAN38bhcmC/V106J5Vx+4A/1LP9wBoEfpyZeVxiz9AbBMgQNdalXWkG3nU6tb6oQDvo12n+oJu927M9grf+lO9fYUnAf6HOg1Ju/12V3dtWrry8wWOTxt6kcAjabqHIRQ3FQFHks/cn7O+qDlo4p1Ia2jOR7O6ASYlQnSj5CiowWtCbRM7UkUm2WiQTSVJoCkxZhpaXo+Xznut4aLnNb1upwEHTAA9CqRKCqox0MRl733DgeQ9YY0XVtXA2fuctVLD1aihk2rjzA/JFy4gR+vBkoBcfGEOzeY9MSeAyOy9Y5i13yY/iBgACrLmLgBaQaRXG6yKKeAATQZwLphc1eQ9wIQU5TQqDmqTPNNcaRHgaUP8AKoDyBmTgFgHqFCWAKZPAcyLACkLP6V2BggFFwC+zBOEjY1xPcYBRy5AuTlKLyJnBQOYMMzWaE2Y/TABpF5U/VxIYE04hzgBDFIryC4Nc+EZoLCOmUv6sHThaYN/DpFwDBipAhc9eWxyVtDrkIsOzHG2WnwfCNG1SpO8FcAIZuQSlVJTA9jPX+QEMHr0ttcHUCYiCDjiCGtNWFTThdUQeuZhpQlbd+3AmvCiB4oIVDFkfASClDFAxIwA6zEw5mpVPvixvwLQ4uVyDMzUbH0/WA/HBbavEXGQdklXAGonvAAwijFeBdiPiwD7qRd2mLRke30YgBErTHBWxoF6tZWjWc2rXAiZhyvjQEIaC9eFcWCWcSCGZjOXziFU7OEBRBqzhcDaTEQdxKWFmchYNdzbTKQszUSiz8gUpymIJdATI1OCZjOPJcQ6wm/qF1lQc3QbnMygAAAAAElFTkSuQmCC"/></a>
						</div>
					</div>
					<div class="shortcode col3-2">
						<div style="color:#652D8A; font-family:'Montserrat', sans-serif; font-size:large; text-align:center;">
						<br />
						(203) 453-4799 • 
						<a href="https://www.google.com/maps/dir/''/90+Broad+St,+Guilford,+CT+06437" style="color:#652D8A; text-decoration:none;" target="_blank">90 Broad Street, Guilford, CT</a>
						</div>
						<div style="color:#767675;  font-family:'Montserrat', sans-serif;  font-size:normal;  text-align:center;"><br />M-F: 10-6, SA: 10-5, SU: 11-4<br /><br /><br /></div>
					</div>
				</div>

				<?php echo themify_logo_image('site_logo'); ?>
	
				<?php if ( $site_desc = get_bloginfo( 'description' ) ) : ?>
					<?php global $themify_customizer; ?>
					<div id="site-description" class="site-description"><?php echo class_exists( 'Themify_Customizer' ) ? $themify_customizer->site_description( $site_desc ) : $site_desc; ?></div>
				<?php endif; ?>
			</hgroup>

            <div id="main-nav-wrap">

                <div id="menu-icon" class="mobile-button"></div>

                <nav>

                    <?php
					if ( function_exists( 'themify_custom_menu_nav' ) ) {
						themify_custom_menu_nav();
					} else {
						wp_nav_menu( array(
							'theme_location' => 'main-nav',
							'fallback_cb'    => 'themify_default_main_nav',
							'container'      => '',
							'menu_id'        => 'main-nav',
							'menu_class'     => 'main-nav'
						));
					}
					?>
                    <!-- /#main-nav --> 
                </nav>
			</div>
            <!-- /main-nav-wrap -->
	
		<?php if(!themify_check('setting-exclude_search_form')): ?>
			<div id="searchform-wrap">
				<div id="search-icon" class="mobile-button"></div>
				<?php get_search_form(); ?>
			</div>
			<!-- /#searchform-wrap -->
		<?php endif ?>
            
			<div class="social-widget">
				<?php dynamic_sidebar('social-widget'); ?>
	
				<?php if(!themify_check('setting-exclude_rss')): ?>
					<div class="rss"><a href="<?php if(themify_get('setting-custom_feed_url') != ""){ echo themify_get('setting-custom_feed_url'); } else { bloginfo('rss2_url'); } ?>">RSS</a></div>
				<?php endif ?>
			</div>
			<!-- /.social-widget -->

			<?php themify_header_end(); //hook ?>
		</header>
		<!-- /#header -->
        <?php themify_header_after(); //hook ?>
				
	</div>
	<!-- /#headerwrap -->
	
	<div id="body" class="clearfix">
    <?php themify_layout_before(); //hook ?>