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

abstract class FFHttpRequestFeed extends FFBaseFeed{
    private static $USER_AGENT = "Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6";

	function __construct( $type ) {
		parent::__construct( $type );
	}

	public final function posts(){
		$data = FFFeedUtils::getFeedData($this->getUrl());
		if (sizeof($data['errors']) > 0){
			$this->errors[] = array(
	            'type' => $this->getType(),
	            'message' => $data['errors']
            );
			return array();
		}
		$result = array();
		foreach ($this->items($data['response']) as $item){
            $post = $this->prepare($item);
            $post->id = (string)$this->getId($item);
            $post->type = $this->getType();
            $post->header = (string)$this->getHeader($item);
            $post->screenname = (string)$this->getScreenName($item);
            $post->userpic = $this->getProfileImage($item);
            $post->system_timestamp = $this->getSystemDate($item);
            $post->timestamp = FFFeedUtils::classicStyleDate($post->system_timestamp);
            $post->text = (string)$this->getContent($item);
            $post->userlink = (string)$this->getUserlink($item);
            $post->permalink = (string)$this->getPermalink($item);
            if ($this->showImage($item)){
                $post->img = $this->getImage($item);
	            $post->media = $this->getMedia($item);
            }
            $post = $this->customize($post, $item);
            if (null != $post) $result[] = $post;
        }
        return $this->afterProcess($result);
    }

    protected abstract function getUrl();
    protected abstract function items($request);
    protected abstract function getId($item);
    protected abstract function getHeader($item);
    protected abstract function getScreenName($item);
    protected abstract function getProfileImage($item);
    protected abstract function getSystemDate($item);
    protected abstract function getContent($item);
    protected abstract function getUserlink($item);
    protected abstract function getPermalink($item);

    protected abstract function showImage($item);
    protected abstract function getImage($item);
    protected abstract function getMedia($item);

    /**
     * @param $item
     * @return stdClass
     */
    protected function prepare($item){
        return new stdClass();
    }

    /**
     * @param stdClass $post
     * @param $item
     *
     * @return stdClass
     */
    protected function customize($post, $item){
        return $post;
    }
}