<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
require_once(AS_PLUGIN_DIR . 'includes/social/FFHttpRequestFeed.php');
require_once(AS_PLUGIN_DIR . 'includes/cache/FFFacebookCacheManager.php');

class FFFacebook extends FFHttpRequestFeed{
    /** @var  string */
    private $url;
    /** @var  string | bool */
    private $accessToken;
    /** @var bool */
    private $showAttachment;
    /** @var bool */
    private $hideStatus = true;
	private $image;
	private $media;

	public function __construct() {
		parent::__construct( 'facebook' );
	}

	/**
     * @param FFGeneralSettings $options
     * @param FFStreamSettings $stream
     * @param $feed
     */
    public function init($options, $stream, $feed) {
      parent::init($options, $stream, $feed);
      $this->accessToken = FFFacebookCacheManager::get()->getAccessToken();
      if (isset($feed->{'timeline-type'})) {
        switch ($feed->{'timeline-type'}) {
          case 'user_timeline':
	          $userId = (string)$feed->content;
	          $userId = $this->getUserPageId($userId);
	          $this->url = "https://graph.facebook.com/{$userId}/posts?access_token={$this->accessToken}&limit={$this->getCount()}";
	          break;
          case 'page_timeline':
                $userId = (string)$feed->content;
                $this->url = "https://graph.facebook.com/{$userId}/posts?access_token={$this->accessToken}&limit={$this->getCount()}";
	            $this->hideStatus = false;
                break;
            default:
                $this->url = "https://graph.facebook.com/me/home?access_token={$this->accessToken}&limit={$this->getCount()}";
        }
      }
      $this->showAttachment = FFSettingsUtils::notYepNope2ClassicStyle($feed->{'hide-attachment'});
    }

    protected function getUrl() {
        return $this->url;
    }

    protected function items( $request ) {
        if (false !== $this->accessToken){
            $pxml = json_decode($request);
            if (isset($pxml->data)) {
                $tmp = array();
                foreach ($pxml->data as $item) {
	                if ($this->filter($item)) {
		                $tmp[] = $item;
	                }
                }
                return $tmp;
            }
        }
        return array();
    }

	protected function prepare( $item ) {
		$this->image = null;
		$this->media = null;
		return parent::prepare( $item );
	}

	protected function getHeader($item){
        return '';
    }

    protected function showImage($item){
        if ($item->type == 'photo'){
	        $url = "https://graph.facebook.com/{$item->object_id}/picture?width={$this->getImageWidth()}&type=normal";
	        $this->image = $this->createImage($url);
	        $url = "https://graph.facebook.com/{$item->object_id}/picture?width=600&type=normal";
	        $this->media = $this->createMedia($url);
	        return true;
        }
	    if (($item->type == 'video') && ($item->status_type == 'added_video')){
		    $this->image = $this->createImage($item->picture);
		    $this->media = $this->createMedia('http://www.facebook.com/video/embed?video_id=' . $item->object_id, 600,
			    FFFeedUtils::getScaleHeight(600, $this->image['width'], $this->image['height']), 'video');
		    return true;
	    }
	    return false;
    }

    protected function getImage( $item ) {
        return $this->image;
    }

	protected function getMedia( $item ) {
		return $this->media;
	}

	protected function getScreenName($item){
        return $item->from->name;
    }

    protected function getContent($item){
	    if (isset($item->message)) return FFFeedUtils::wrapLinks(self::wrapHashTags($item->message, $item->id));
	    if (isset($item->story)) return (string)$item->story;
    }

    protected function getProfileImage( $item ) {
        return "https://graph.facebook.com/{$item->from->id}/picture?width=80&height=80";
    }

    protected function getId( $item ) {
        return $item->id;
    }

    protected function getSystemDate( $item ) {
        return strtotime($item->created_time);
    }

    protected function getUserlink( $item ) {
        return 'https://www.facebook.com/'.$item->from->id;
    }

    protected function getPermalink( $item ) {
        $parts = explode('_', $item->id);
        return 'https://www.facebook.com/'.$parts[0].'/posts/'.$parts[1];
        if (isset($item->link)) return $item->link;
    }

    protected function customize( $post, $item ) {
        if ($this->showAttachment){
            if ($item->type == 'link'){
                $attachments = array();
                if (isset($item->picture)){
                    $image = $item->picture;
                    $parts = parse_url($image);
                    if (isset($parts['query'])){
                        parse_str($parts['query'], $attr);
                        if (isset($attr['url'])){
                            $image = $attr['url'];
                        }
                    }
                    $attachments[] = $this->createAttachment($item->link, $item->name, $image);
                }
                $post->attachments = $attachments;
            } else if ($item->type == 'video'){
                //TODO
            }
        }
        $post = parent::customize( $post, $item );
//        if (!$this->showAttachment && empty($post->text) && !isset($post->img)){
//            return null;
//        }
        return $post;
    }

    private function filter( $item ) {
        if ($item->type == 'status' && $this->hideStatus) return false;
        if ($item->type == 'photo' && isset($item->status_type) && $item->status_type == 'tagged_in_photo') return false;
        return true;
    }

	/**
	 * @param string $text
	 * @param string $id
	 *
	 * @return mixed
	 */
	private function wrapHashTags($text, $id){
		return preg_replace('/#([\\d\\w]+)/', '<a href="https://www.facebook.com/hashtag/$1?source=feed_text&story_id='.$id.'">$0</a>', $text);
	}

    private function getUserPageId($content) {
        $url="http://graph.facebook.com/{$content}?fields=id";
        $content=file_get_contents($url);
        $x=json_decode($content);
        return (string)$x->id;
    }
}