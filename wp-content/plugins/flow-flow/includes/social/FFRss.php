<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
require_once(AS_PLUGIN_DIR . 'includes/social/FFFeedUtils.php');
require_once(AS_PLUGIN_DIR . 'includes/social/FFHttpRequestFeed.php');

class FFRss extends FFHttpRequestFeed {
    protected $url;
	protected $image;
	protected $media;
	protected $userLink;
	protected $screenName;
	protected $profileImage;
	/** @var bool */
	private $isRichText = false;
	/** @var bool */
	private $hideCaption = false;

	public function __construct( $type = null ) {
		if (is_null($type)) $type = 'rss';
		parent::__construct( $type );
	}

	/**
     * @param FFGeneralSettings $options
     * @param FFStreamSettings $stream
     * @param $feed
     */
    public function init($options, $stream, $feed) {
        parent::init($options, $stream, $feed);
        $this->url = $feed->content;
	    if (isset($feed->{'rich-text'})) $this->isRichText = $feed->{'rich-text'};
	    if (isset($feed->{'hide-caption'})) $this->hideCaption = $feed->{'hide-caption'};
	    if (isset($feed->{'channel-name'})) $this->screenName = $feed->{'channel-name'};
	    $this->profileImage = plugin_dir_url(AS_PLUGIN_DIR).FlowFlow::$PLUGIN_SLUG.'/assets/avatar_default_rss.png';
    }

    protected function getUrl(){
        return $this->url;
    }

    protected function items($request){
        $pxml = new SimpleXMLElement($request);
        if (isset($pxml->channel)) {
            if (!isset($this->screenName) || strlen($this->screenName) == 0) {
                $this->screenName = (string)$pxml->channel->title;
            }
//            if (isset($pxml->channel->image)){
//                $this->profileImage = (string)$pxml->channel->image->url;
//            }
            if (isset($pxml->channel->link)){
                $this->userLink = $pxml->channel->link;
            }
            if (sizeof($pxml->channel->item) > $this->getCount())
                for ($i=0; $i < $this->getCount(); $i++)  $result[] = $pxml->channel->item[$i];
            else
                $result = $pxml->channel->item;
            return $result;
        }
        return array();
    }

	protected function prepare( $item ) {
		$this->image = null;
		$this->media = null;
		return parent::prepare( $item );
	}


	protected function getId($item){
        return $item->guid;
    }

    protected function getScreenName($item){
        return $this->screenName;
    }

    protected function getProfileImage($item){
        return $this->profileImage;
    }

    protected function getSystemDate($item){
        return strtotime($item->pubDate);
    }

    protected function getContent($item){
	    if ($this->isRichText){
		    $content = $item->children('content', true);
		    foreach ($content->encoded as $encoded) {
			    return $encoded;
		    }
	    }
        return FFFeedUtils::wrapLinks(strip_tags($item->description));
    }

    protected function getHeader($item){
        return $this->hideCaption ? '' : $item->title;
    }

    protected function getUserlink($item){
        return $this->userLink;
    }

    protected function getPermalink($item){
        return $item->link;
    }

    protected function showImage($item){
        if (isset($item->enclosure) && 'image/jpeg' == (string)$item->enclosure['type']){
	        $this->image = $this->createImage((string)$item->enclosure['url']);
	        $this->media = $this->createMedia($this->image['url'], $this->image['width'], $this->image['height']);
	        return true;
        }
	    return false;
    }

    protected function getImage($item){
        return $this->image;
    }

	protected function getMedia( $item ) {
		return $this->media;
	}
}