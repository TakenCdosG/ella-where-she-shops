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
require_once(AS_PLUGIN_DIR . 'includes/settings/FFSettingsUtils.php');

class FFGoogle extends FFHttpRequestFeed{
    private $apiKey;
    private $content;
    private $showAttachment;
	private $media;
	private $image;

	public function __construct() {
		parent::__construct( 'google' );
	}

	/**
     * @param FFGeneralSettings $options
     * @param FFStreamSettings $stream
     * @param $feed
     */
    public function init($options, $stream, $feed){
        parent::init($options, $stream, $feed);
        $this->content = $feed->content;
        $original = $options->original();
        $this->apiKey = $original['google_api_key'];
        $this->showAttachment = FFSettingsUtils::notYepNope2ClassicStyle($feed->{'hide-attachment'});
    }

    protected function getUrl(){
        return "https://www.googleapis.com/plus/v1/people/{$this->content}/activities/public?key={$this->apiKey}&maxResults={$this->getCount()}&prettyprint=false&fields=items(id,actor,object(attachments(displayName,fullImage,id,image,objectType,url),id,content,objectType,url),published,title,url)";
    }

    protected function items($request){
        $pxml = json_decode($request);
        if (isset($pxml->items)) {
            return $pxml->items;
        }
        return array();
    }

    protected function prepare( $item ) {
	    $this->image = null;
	    $this->media = null;
        $post = parent::prepare( $item );
        if ($this->showAttachment && isset($item->object->attachments) && sizeof($item->object->attachments) > 0){
            $attachments = '';
            foreach ($item->object->attachments as $attach){
                if ( $attach->objectType == 'article'){
                    $url = $attach->url;
                    $displayName = $attach->displayName;
                    if (isset($url) && isset($displayName)){
	                    $at = $this->getAttachedImage($attach);
	                    $image = $this->createImage($at['url'], $at['width'], $at['height']);
                        $attachments[] = $this->createAttachment($url, $displayName, $image);
                    }
                }
            }
            $post->attachments = $attachments;
        }
        return $post;
    }


    protected function getId($item){
        return $item->id;
    }

    protected function getScreenName($item){
        return $item->actor->displayName;
    }

    protected function getProfileImage($item){
        return $item->actor->image->url;
    }

    protected function getSystemDate($item){
        return strtotime($item->published);
    }

    protected function getContent($item){
        if (isset($item->object->originalContent) && !empty($item->object->originalContent)) {
            return $item->object->originalContent;
        }
        return $item->object->content;
    }

    protected function getHeader($item){
        return '';
    }

    protected function getUserlink($item){
        return $item->actor->url;
    }

    protected function getPermalink($item){
        return $item->url;
    }

    protected function showImage($item){
	    if (isset($item->object->attachments)
	        && sizeof($item->object->attachments) > 0
	        && $item->object->attachments[0]->objectType == 'photo'
	        && (null != ($image = $this->getAttachedImage($item->object->attachments[0])))){
		    $this->image = $this->createImage($image['url'], $image['width'], $image['height']);
		    $this->media = $this->createMedia($image['url'], $image['width'], $image['height']);
			return true;
	    }
        return false;
    }

    protected function getImage($item) {
		return $this->image;
    }

	protected function getMedia( $item ) {
		return $this->media;
	}

	protected function customize( $post, $item ) {
        $post->nickname = $this->content;
        return parent::customize( $post, $item );
    }

    /**
     * @param stdClass $attach
     * @return array|boolean
     */
    private function getAttachedImage($attach){
	    if (isset($attach->fullImage->url) && isset($attach->fullImage->width) && isset($attach->fullImage->height)){
		    return array('url' => $attach->fullImage->url, 'width' => $attach->fullImage->width, 'height' => $attach->fullImage->height);
	    }
	    $url = (isset($attach->fullImage->url)) ? $attach->fullImage->url : $attach->image->url;
	    if (isset($url)){
		    if (isset($attach->fullImage->width) && isset($attach->fullImage->height)){
			    return array('url' => $url, 'width' => $attach->fullImage->width, 'height' => $attach->fullImage->height);
		    }
		    else if (isset($attach->image->width) && isset($attach->image->height)){
			    return array('url' => $url, 'width' => $attach->image->width, 'height' => $attach->image->height);
		    }

		    if (isset($attach->image->url) && isset($attach->image->width) && isset($attach->image->height)){
			    $url = $attach->image->url;
			    if (isset($attach->fullImage->url)){
				    $url = $attach->fullImage->url;
			    }
			    return array('url' => $url, 'width' => $attach->image->width, 'height' => $attach->image->height);
		    }
		    return array('url' => $url, 'width' => null, 'height' => null);
	    }
        return null;
    }
}