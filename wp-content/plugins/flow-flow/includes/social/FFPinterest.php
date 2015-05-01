<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
require_once(AS_PLUGIN_DIR . 'includes/social/FFRss.php');
require_once(AS_PLUGIN_DIR . 'includes/social/FFFeedUtils.php');
require_once(AS_PLUGIN_DIR . 'includes/settings/FFSettingsUtils.php');

class FFPinterest extends FFRss {
    private $pin;
    private $pins = array();
    private $showText;
    private $nickname;
    private $additionalUrl;
    private $originalContent;

	public function __construct() {
		parent::__construct( 'pinterest' );
	}

	public function init($options, $stream, $feed) {
        parent::init($options, $stream, $feed);
        $sp = explode('/', $feed->content);
        if (sizeof($sp) < 2){
            $this->nickname = $feed->content;
            $this->url = "http://pinterest.com/{$feed->content}/feed.rss";
            $this->additionalUrl = "https://api.pinterest.com/v3/pidgets/users/{$feed->content}/pins/";
        }
        else {
            $this->nickname = $sp[0];
            $this->url = "http://pinterest.com/{$feed->content}/rss";
            $this->additionalUrl = "https://api.pinterest.com/v3/pidgets/boards/{$feed->content}/pins/";
        }
        $this->profileImage = plugin_dir_url(AS_PLUGIN_DIR).FlowFlow::$PLUGIN_SLUG.'/assets/avatar_default.png';
        $this->showText = FFSettingsUtils::notYepNope2ClassicStyle($feed->{'hide-text'}, true);
    }

    protected function items($request){
        $this->setAdditionalInfo();
        return parent::items($request);
    }

    protected function prepare($item){
        $this->originalContent = (string)$item->description;
        $pin = $this->pins[(string)$item->guid];
        if (isset($pin)){
            $this->pin = $pin;
        }
        return parent::prepare($item);
    }

    protected function getScreenName($item){
        return (isset($this->pin)) ?  $this->pin->pinner->full_name : parent::getScreenName($item);
    }

    protected function getProfileImage($item){
        $url = (isset($this->pin)) ? $this->pin->pinner->image_small_url : parent::getProfileImage($item);
        $url = str_replace('_30.', '_140.', $url);
        return $url;
    }

    protected function getContent($item){
        return ($this->showText) ? (isset($this->pin)) ? $this->pin->description : parent::getHeader($item) : '';
    }

    protected function getHeader($item){
        return '';
    }

    protected function getPermalink($item){
        return (string)$item->guid;
    }

    protected function getUserlink($item){
        return (isset($this->pin)) ? $this->pin->pinner->profile_url : 'http://www.pinterest.com/' . $this->nickname;
    }

    protected function customize($post, $item){
        $post = parent::customize($post, $item);
        $post->nickname = $this->nickname;
        return $post;
    }

    protected function showImage($item){
	    if (isset($this->pin) && isset($this->pin->images->{'237x'})){
		    $x237 = $this->pin->images->{'237x'};
		    $this->image = $this->createImage($x237->url, $x237->width, $x237->height);
		    $this->media = $this->createMedia(str_replace('237x', '736x', $x237->url));
	    } else {
		    $this->image = $this->createImage(FFFeedUtils::getUrlFromImg($this->originalContent));
		    $this->media = $this->createMedia($this->image['url'], $this->image['width'], $this->image['height']);
	    }
        return true;
    }

	private function setAdditionalInfo(){
        $data = FFFeedUtils::getFeedData($this->additionalUrl);
        if (sizeof($data['errors']) > 0){
            error_log('Pinterest has errors: '.$data['errors']);
        } else {
            $response = json_decode($data['response']);
            foreach ($response->data->pins as $pin){
                $this->pins["http://www.pinterest.com/pin/{$pin->id}/"] = $pin;
            }
        }
    }
}