<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
require_once(AS_PLUGIN_DIR . 'includes/social/FFBaseFeed.php');
require_once(AS_PLUGIN_DIR . 'includes/social/FFFeedUtils.php');

class FFComments extends FFBaseFeed{
    private $authors;
	private $profileImage;

	public function __construct() {
		parent::__construct( 'comments' );
	}

	public function init($options, $stream, $feed) {
        parent::init($options, $stream, $feed);
	    $this->profileImage = plugin_dir_url(AS_PLUGIN_DIR).FlowFlow::$PLUGIN_SLUG.'/assets/avatar_default.png';
    }

    public function posts(){
        $number = $this->getCount();
        $comments = get_comments( apply_filters( 'widget_comments_args', array(
            'number'      => $number,
            'status'      => 'approve',
            'post_status' => 'publish'
        ) ) );

        $result = array();
        foreach ($comments as $comment){
            $result[] = $this->parse($comment);
        }
        return $result;
    }

    public function useCache(){
        return false;
    }

    private function parse($comment){
        $tc = new stdClass();
        $tc->id = (string)$comment->comment_ID;
        $tc->type = $this->getType();
        $tc->nickname = $this->getAuthor($comment->user_id, 'nicename');
        $tc->screenname = trim($this->getAuthor($comment->user_id, 'user_full_name'));
        if (empty($tc->screenname)) $tc->screenname = (string)$comment->comment_author;
        $tc->system_timestamp = strtotime($comment->comment_date);
        $tc->timestamp = FFFeedUtils::classicStyleDate($tc->system_timestamp);
        $tc->text = $comment->comment_content;
	    $userpic = get_avatar($comment->user_id, 80, '');
	    $tc->userpic =  (strpos($userpic,'avatar-default') !== false) ? $this->profileImage : FFFeedUtils::getUrlFromImg($userpic);
        $tc->userlink = '';//$this->getAuthor($comment->user_id, 'url');
        $tc->permalink = get_comment_link($comment->comment_ID);
        return $tc;
    }

    private function getAuthor($author_id, $key){
        if (!isset($this->authors[$author_id])){
            $this->authors[$author_id] = array(
                'nicename' => (string)get_the_author_meta('nicename', $author_id),
                'url' => (string)get_the_author_meta('user_url', $author_id),
                'user_full_name' => (string)get_the_author_meta('user_firstname', $author_id) . ' ' . (string)get_the_author_meta('user_lastname', $author_id),
            );
        }
        return $this->authors[$author_id][$key];
    }
}