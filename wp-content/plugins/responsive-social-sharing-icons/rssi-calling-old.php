<?php
function rssi_social_sharing_icons()
{
	$options = get_option('rssi_options');
	
	global $post;
	
	/*
	 * Edit below to reorder the buttons.
	 * NOTE: Lines prefixed with `//` are ignored.
	 *
	 **/
   $rssi_content .= '<ul class="rssi-icons clearfix" style="width:225px;">';
  
	if($options['show_email']) {
		$rssi_content .= '<li class="email">
						<a href="mailto:?subject='.urlencode(get_the_title()) .'&body=' .urlencode(get_permalink()). '">
							<span class="icon-envelope icon">
								
							</span>
							<span class="text">email</span>
						</a>
					</li>';
	}
	
	if($options['show_fb']) {
		$rssi_content .= '<li >
						<a href="https://www.facebook.com/sharer/sharer.php?u=' .urlencode(get_permalink() ) . ' " style="background-color:white; float:left; padding:0px;" target="_blank">



							<img style="float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAAUCAMAAADvNg5hAAAA7VBMVEX///87VaVIZLk9V6g6VKRFYLQ8VaZKZrxHY7c/WapJZbpJZbtGYrZBW608VqRHY7g8V6dFYbU5UqJBXa9AWqw9WKk5U6NIZLo/WalEX7JDXq9bcbZEX7NDXrE7VKE6Up+KmcdLZ708Vqc0S5HK0eRKZ7xgdbf8/P6nsdFNZK46UZazvdnw8ffY3euNnc6RoMqapch8jcI7U5z3+fzg5O+9xeDDyt+GlsdeeMN3h7hdcKj19vvz9Prl6PPM0+ims9mdqtOImMxSa7VQaLBHX6fQ1+ysuNyYpc5vgr9le7+Fk7xIYaxRZKHo7PVJXJkEp4X2AAACeElEQVQ4y1VP2XaiUBBsZNErixIggoAaIe4a96jZ93Xm/z9nqi+enEzVqaKrb9cD9LIzz8rMAuflc/NcpjPzDFMZGcYzb6CyiYvdC+0a1UbVrJplOFg1zWqjDHEuV8v8UhDb4yWuqjsqIYGlApxK1WJsILF4+zsX11Sr1Cy9+QPdqmFTK1VKP0IuIGf5CierUoly+kEeVSwgabqWVQHhFYjB+ThB5OqWTUdcQ03ddd326Hu01JuZ47qWbrkuC860QN5SoifH4mYohkRCT9xw0Kf+2OlRR0dKdEbCAtGVoijRQ5IYerZD5CdRuqDBxx3NUMyyVuqNsmzkqZmThWKUjWw91ZMoojRKj8XQn7BHUTSj+Wi5+IhpsJ7MveftarV9Xqw/J++H6VX+HaVpxEUvVUlCCFn3Uu/xhvr5Zzumm9m0P3y97u3pskN/XnuT8X46FV4TN2R7Xp2AVujbYWtNjud57eXD5ormMd3bF9RbHjpbuujQwlvQeJBT7Nkg2Tb+DGirvl8/EDlYXIyX6tdkGlPHvqTeYHXX4WKMML5/mz/agE++76PIqNfZFd+332hw2K82KPoorvNsL4t+3B/8nW/Qwg0JIVok0ZJfBwt/3Ce6fYxpJh6od9+/vqW7GcVCPFzRzbvPF4KCIPivqIVBKIQdf8GDEBTBcCgwC1yK8ImdL0itq1pODIeLW0UNVOwKHqdADTBLdJGlk9E1jJM20FIcuOaoRt1Qu92uamCSLidWsenW0UHRUAxFMQyHXXHYFMwMw+EAySzf5aW8omdHUzTMcHwhDWLHK4bijb+SBZCe6HaonZyenp4wNRCOrDHljr+/LyDwKf8HCmBMbLAlYIAAAAAASUVORK5CYII="/>



						</a>
					</li>';
	}
	
	if($options['show_linkedin']) {		
		$rssi_content .= '<li class="linkedin">
					<a href="http://www.linkedin.com/shareArticle?mini=true&url=' .  urlencode(get_permalink()) . '&title=' . urlencode(get_the_title() ) . '" >
						<span class="icon-linkedin icon">

						</span>
						<span class="text">linkedin</span>
					</a>
				</li>';
	}
	
	if($options['show_twitter']) {			
		$rssi_content .= '<li >
					<a href="http://twitter.com/home?status=' . urlencode(get_the_title() )  . ' - ' . urlencode(wp_get_shortlink() ). '" style="background-color:white; float:left; padding:0px 0px 0px 2px;  margin:0px 0px 0px 0px; "  target="_blank">




						<img style="float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAAUCAMAAADvNg5hAAAB/lBMVEXMzMz6+vrf39/+/v7k5OQzMzP19fXz8/Ph4eH4+Pj9/f35+fn39/f8/Pzg4ODj4+Pi4uL29vbu7u7o6Ojq6uvt7e4Aq/EAqvDn5+fs7Ozy8vLw8PAAqu/m5ubR0dHu8PLr6+sAp+oAjcTUpWQyMlGrZCzn8PLI4+95zO3l5eUAnNza2tr////u9PPm7vD09O3n6O3x7uza6uoitOrt6ucApOefzeaFw+MAoeOYyNzt7NUAlNEzMmWJMjHa7PPO7PDF5/Dn5+u12euX0urw7enD4ejv8eXm7uKcy+Ld3d2Gt9vu8dqxw9ZjodVxqNQAmdQ4pM/Ozs5Xrc51o8n16ceaprjs27LXwrIvcrKxsbFtnbAxTq6wqaNieqC9nHG0gUxvRDpRMzJjMjKl2PGq3PCZ1u5Yw+5Hwe7j6+3n6+vm5OQkr+PX3+IAoOBouNmIwNc1qtZ5utTP7tIAkMyyv8uGs8dIo8dUpsYvesaGsMQkmMTa2sGgsr8Qj79OmbafsbHVya+vv64wYKzGwKYyQqN6mZ8yQpwxYpvVt5YyUIkyMImln4bjx4LkwYEyQnzAqHqyrHjOq3hpd3cyRHdEUHa6iXXcsnFEZGt3amoyMWqaiGfYq2W4h2DLoF7JmV57UEPBhT1qMzJkUTF2MjGIRTCHYi+oRS+IYy6lUS64dSqLueVJAAACEUlEQVQ4y52U5ZPaYBCHc22WwDUVopAEQjiCU+wofi49955r3d3d3d3d/stu6LT9QmcOnt9ks/tOnnn3U4gas5OoGGcgTJhD9MrlUfuvpUNmYsi6urbymHDNmqrAfVdZqgmKVtpKr6dLdf/BrNWL/d+Y8CkfFE3IsaxRT7kPuwfPZk1RHQz6TGUZ741gRZFCBt3DO6j2fCaVCQ74qOjTR5/g+YtuqhzRb1ci+EJRkiW5NZh3D+/bKwqitoWSKdryGjZbRhdGpLknTaPv+zvmAEZU+cYizCbmAe41SjKKDHIgpQUHgpooCCmJMaiDDUxP8VZnEdJ3IP0Bjt6H/rswdXlxYnzh8REvwxgiz/A+TVQ0TREEZTdOGENU33ouLsG5+cKhz3D1FVzTYfY2eBr16Uic4VF02V123q/gbYIoaK04Yepgo8u+CeDmA4CJ3EfP+cmZMzpMTc6MJfTpnfgFipxBS1IRDZIyVwJFjuspwgmU0/zPQu+Fpb5ncPL010udPzxjCY5DkTWw+7YreGPSy/4GV2XZ2Dvozn0pNDXnvgNcb+h4A/CyhXsInnaWRdHmsO057s5nFEHZ5rXhZESl2ko1HlOpeltMsvNSfbMa56U2hyrhiQNFkiQDss/v929tkAPkf2BZo9rYXX8OUFy7DuPgeZ4LYLfcEMRQl3lN5elyEqQztKJiQk6SCFf16yDDvwAxJG99xs+p5wAAAABJRU5ErkJggg=="/>



					</a>
				</li>';
	}
	
	if($options['show_google']) { 		
		$rssi_content .= '<li >
					<a href="https://plus.google.com/share?url=' . urlencode(get_the_title() ) . ' - ' . urlencode( get_permalink() ) .'" style="background-color:white; float:left; padding:0px 0px 0px 5px;"  target="_blank">


						<img style="float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAVCAMAAABxCz6aAAAAnFBMVEXdSzndSje3nJnrUD3cRzXcQzHbPyzbQi/cRTP////nfXD0xL7gWkrupZzlcmT98vHytq/smY7ldmjaOCT++vr53tv42tbsnJLrlovqkYbka1ziZVXhX0/gVELaOyj65uP31dH30s320Mz1ysXzvrjpjYHuUD376+n76ujk4OD64t/Xz87vqqG8op64nJntoJftnZTohnrZYlTYMBup14OPAAAAy0lEQVQY03WQR3LDMAxFwQQAO1UsWV3uTu/3v1sWMTO0MnnLN/M/Cjj4Qw//I5RkZly4svFNEzB1IvdlrdtJJFIW9ziPlZVX4e0jCtplIABllHSoRsm2RqH6IvaS0QeY1obEyqxX9GutvTuxGuw2s+/qYvmr0CdG1+WbzuBPqXTGa93JJC5UsW+D2ehAwpXisuaH7mfiMXtmQIqFxwoUwLx74+SgVnskCnuH6ek+q495PsRonB7KARVcg0SYvmg63y44f8LT682Cl4dvraIMY5YUng4AAAAASUVORK5CYII="/>



					</a>
				</li>';
	}
	
	if($options['show_piniterest']) {			
		$rssi_content .= '<li class="pinterest">
					<a href="http://pinterest.com/pin/create/button/?url=' . urlencode(get_permalink() ) . '">
						<span class="icon-pinterest icon">

						</span>
						<span class="text">pinterest</span>
					</a>
				</li>';
	}
	$rssi_content .= '</ul>';
    
    return $rssi_content;
}

add_filter('the_content', 'rssi_check_conditions');

function rssi_check_conditions($content){

	$options = get_option('rssi_options');
	
	if($options['rssi_embed'] === "auto_embed") 
	{
		if($options['show_single'] && is_single()) {
			return $content.rssi_social_sharing_icons();
		}
		elseif($options['show_blog'] && is_home()) {
			return $content.rssi_social_sharing_icons();
		}
		elseif($options['show_page'] && is_page()) {
			return $content.rssi_social_sharing_icons();
		}
		return $content;
	}else{
		return $content;
	}
	
}

function rssi_social_icons(){
	$options = get_option('rssi_options');
	if($options['rssi_embed'] === "template_code") {
		return rssi_social_sharing_icons();
	}
}
// short code to put sharing icons
add_shortcode('rssi_social_icons', 'rssi_social_icons');
?>