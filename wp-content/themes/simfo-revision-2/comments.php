<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'themify' ); ?></p>
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() || comments_open() ) : ?>

<?php themify_comment_before(); //hook ?>
<div id="comments" class="commentwrap">
<?php endif; // end commentwrap ?>
	<?php themify_comment_start(); //hook ?>

	<?php if ( have_comments() ) : ?>
	<h4 class="comment-title"><?php comments_number(__('No Comments','themify'), __('One Comment','themify'), __('% Comments','themify') );?></h4>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<div class="pagenav top clearfix">
			<?php paginate_comments_links( array('prev_text' => '&laquo;', 'next_text' => '&raquo;') );?>
		</div> 
		<!-- /.pagenav -->
	<?php endif; // check for comment navigation ?>

	<ol class="commentlist">
		<?php wp_list_comments('callback=themify_theme_comment'); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<div class="pagenav bottom clearfix">
			<?php paginate_comments_links( array('prev_text' => '&laquo;', 'next_text' => '&raquo;') );?>
		</div>
		<!-- /.pagenav -->
	<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>

<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

  <script type="text/javascript">
   function custom_focus(element) {
     if (element.value == element.defaultValue) {
       element.value = '';
     }
   }
   function custom_blur(element) {
     if (element.value == '') {
       element.value = element.defaultValue;
     }
   }
  </script>


<?php 
global $aria_req;
$custom_comment_form = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
    'author' => '<div class="shortcode col4-1 first"><p class="comment-form-author">' .
			'<input id="author" name="author" type="text"  onfocus="custom_focus(this);" onblur="custom_blur(this);"  value="Name' .
			esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' class="required" />' .
			'<label for="author">' . __( '' , 'themify' ) . '</label> ' .
			( $req ? '<!--/<span class="required">*</span>/-->' : '' ) .
			'</p>',
    'email'  => '<p class="comment-form-email">' .
			'<input id="email" name="email" type="text"   onfocus="custom_focus(this);" onblur="custom_blur(this);"   value="Email' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' class="required email" />' .
			'<label for="email">' . __( '' , 'themify' ) . '</label> ' .
			( $req ? '<!--/<span class="required">*</span>/-->' : '' ) .
			'</p>',
    'url'    =>  '<p class="comment-form-url">' .
			'<input id="url" name="url" type="text"   onfocus="custom_focus(this);" onblur="custom_blur(this);"   value="Website' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30"' . $aria_req . ' />' .
			'<label for="website">' . __( '' , 'themify' ) . '</label> ' .
			'</p></div>') ),
	'comment_field' => '<div class="shortcode col4-1 "><p class="comment-form-comment">' .
			'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="required" onfocus="custom_focus(this);" onblur="custom_blur(this);">Your Comment</textarea>' .
			'</p></div>',
	'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s">Log out?</a>', 'themify' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</p>',
	'title_reply' => __( 'comments' , 'themify' ),
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'cancel_reply_link' => __( 'Cancel' , 'themify' ),
	'label_submit' => __( 'Send Comment' , 'themify' ),
);
comment_form($custom_comment_form); 
?>

<?php if ( have_comments() || comments_open() ) : ?>
<?php themify_comment_end(); //hook ?>
</div>
<!-- /.commentwrap -->
<?php themify_comment_after(); //hook ?>
<?php endif; // end commentwrap ?>