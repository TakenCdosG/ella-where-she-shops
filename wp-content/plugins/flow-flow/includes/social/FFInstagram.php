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
require_once(AS_PLUGIN_DIR . 'includes/settings/FFStreamSettings.php');
require_once(AS_PLUGIN_DIR . 'includes/settings/FFSettingsUtils.php');

class FFInstagram extends FFBaseFeed {
    private $url;
    private $showText;

	public function __construct() {
		parent::__construct( 'instagram' );
	}

	public function init($options, $stream, $feed) {
        parent::init($options, $stream, $feed);
        $original = $options->original();
        $accessToken = $original['instagram_access_token'];
        $this->showText = FFSettingsUtils::notYepNope2ClassicStyle($feed->{'hide-text'}, true);
        if (isset($feed->{'timeline-type'})) {
            switch ($feed->{'timeline-type'}) {
                case 'user_timeline':
                    $userId = $this->getUserId($feed->content, $accessToken);
                    $this->url = "https://api.instagram.com/v1/users/{$userId}/media/recent/?access_token={$accessToken}&count={$this->getCount()}";
                    break;
                case 'popular':
                    $this->url = "https://api.instagram.com/v1/media/popular?access_token={$accessToken}&count={$this->getCount()}";
                    break;
                case 'licked':
                    $this->url = "https://api.instagram.com/v1/users/self/media/liked?access_token={$accessToken}&count={$this->getCount()}";
                    break;
                case 'tag':
                    $this->url = "https://api.instagram.com/v1/tags/{$feed->content}/media/recent?access_token={$accessToken}&count={$this->getCount()}";
                    break;
                default:
                    $this->url = "https://api.instagram.com/v1/users/self/feed?access_token={$accessToken}&count={$this->getCount()}";
            }
        }
    }

    public function posts() {
        $result = array();
        $data = FFFeedUtils::getFeedData($this->url);
        if (sizeof($data['errors']) > 0){
            $this->errors[] = $data['errors'];
            return array();
        }
        if (isset($data['response']) && is_string($data['response'])){
            $page = json_decode($data['response']);
            foreach ($page->data as $post) {
                $result[] = $this->parsePost($post);
            }
        } else error_log('FFInstagram has returned the empty data.');
        return $result;
    }

    private function parsePost($post) {
        $tc = new stdClass();
        $tc->id = (string)$post->id;
        $tc->type = $this->getType();
        $tc->nickname = (string)$post->user->username;
        $tc->screenname = FFFeedUtils::removeEmoji((string)$post->user->full_name);
        $tc->userpic = (string)$post->user->profile_picture;
        $tc->system_timestamp = $post->created_time;
        $tc->timestamp = FFFeedUtils::classicStyleDate($tc->system_timestamp);
        $tc->img = $this->createImage($post->images->low_resolution->url,
            $post->images->low_resolution->width, $post->images->low_resolution->height);
        $tc->text = $this->getCaption($post);
        $tc->userlink = 'http://instagram.com/' . $tc->nickname;
        $tc->permalink = (string)$post->link;

	    if (isset($post->type) && $post->type == 'video'){
		    $tc->media = array('type' => 'video/mp4', 'url' => $post->videos->standard_resolution->url,
			      'width' => 600,
			      'height' => FFFeedUtils::getScaleHeight(600, $post->videos->standard_resolution->width, $post->videos->standard_resolution->height));
	    } else {
		    $tc->media = $this->createMedia($post->images->standard_resolution->url,
			    $post->images->standard_resolution->width, $post->images->standard_resolution->height);
	    }

        return $tc;
    }

    private function getCaption($post){
        return (isset($post->caption->text) && $this->showText) ? FFFeedUtils::removeEmoji((string)$post->caption->text) : '';
    }

    private function getUserId($content, $accessToken){
        $request = wp_remote_get("https://api.instagram.com/v1/users/search?q={$content}&access_token={$accessToken}");
        $response = wp_remote_retrieve_body( $request );
        $json = json_decode($response);
        if(sizeof($json->data) == 0) {
            $this->errors[] = array('msg' => 'Username not found', 'log' => $response);
            return $content;
        }
        else {
            return (string)$json->data[0]->id;
        }
    }
}