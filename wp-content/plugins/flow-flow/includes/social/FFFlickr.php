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

class FFFlickr extends FFRss{
	private static $authors = array();

	private $user_id;
	private $nickname;
	private $showText;

	public function __construct() {
		parent::__construct( 'flickr' );
	}

	public function init( $options, $stream, $feed ) {
		parent::init( $options, $stream, $feed );

		$content = $feed->content;
		switch ($feed->{'timeline-type'}) {
			case 'user_timeline':
				$this->user_id = $content;
				$this->prepareAuthorData($content);
				break;
			case 'tag':
				$this->url = "https://api.flickr.com/services/feeds/photos_public.gne?tags={$content}&format=rss_200";
//				$num = $this->getCount();
//				$tags = str_replace(',', '+', $content);
//				$this->url = "http://www.degraeve.com/flickr-rss/rss.php?tags={$tags}brasilia+architecture&tagmode=all&sort=relevance&num={$num}";
				break;
		}
		$this->showText = FFSettingsUtils::notYepNope2ClassicStyle($feed->{'hide-text'}, true);
	}

	protected function prepare($item) {
		$tm = parent::prepare($item);
		$this->prepareAuthorData($this->getNickname($item));
		$this->prepareMediaData($item);
		return $tm;
	}

	protected function getHeader( $item ) {
		return '';
	}

	protected function getUserlink( $item ) {
		$id = $this->getNickname($item);
		return "https://www.flickr.com/photos/{$id}/";
	}

	protected function getContent( $item ) {
		$text = '';
		if ($this->showText){
			$text = FFFeedUtils::wrapLinks(strip_tags($item->title));
			if ($text == 'Untitled') return '';
		}
		return $text;
	}

	protected function showImage( $item ) {
		return true;
	}

	protected function customize( $post, $item ) {
		$post->nickname = $this->nickname;
		return parent::customize( $post, $item );
	}

	private function prepareAuthorData($user_name){
		if (array_key_exists($user_name, self::$authors)){
			$this->profileImage = self::$authors[$user_name][0];
			$this->screenName = self::$authors[$user_name][1];
			$this->nickname = self::$authors[$user_name][2];
			$this->url = self::$authors[$user_name][3];
		}
		else {
			$page = file_get_contents("https://www.flickr.com/photos/{$user_name}/");
			$doc = new DOMDocument();
			@$doc->loadHTML($page);
			$finder = new DOMXPath($doc);
			$result = $finder->query("//img[@class='sn-avatar-mask']/@src");
			$this->profileImage = ($result->length > 0) ? $result->item( 0 )->textContent : plugin_dir_url(AS_PLUGIN_DIR).FlowFlow::$PLUGIN_SLUG.'/assets/avatar_default.png';

			$result = $finder->query("//span[@class='character-name-holder']");
			$this->screenName = ($result->length > 0) ? trim(strip_tags($result->item( 0 )->textContent)) : $user_name;

			$result = $finder->query("//div[@class=\"person\"]/h2");
			$this->nickname = ($result->length > 0) ? trim(strip_tags($result->item( 0 )->textContent)) : $user_name;

			$result = $finder->query("//link[@type=\"application/rss+xml\"]/@href");
			$this->url = ($result->length > 0) ? 'https://api.flickr.com' . trim($result->item( 0 )->textContent) : "https://api.flickr.com/services/feeds/photos_public.gne?id={$user_name}&format=rss_200";
			self::$authors[$user_name] = array($this->profileImage, $this->screenName, $this->nickname, $this->url);
		}
	}

	/**
	 * @param SimpleXMLElement $item
	 * @return void
	 */
	private function prepareMediaData( $item ) {
		$media = $item->children('media', true);
		foreach($media->content as $thumbnail) {
			$attributes = $thumbnail[0]->attributes();
			$url = (string)$attributes->url;
			$height = (string)$attributes->height;
			$width = (string)$attributes->width;
		}
		$this->image = $this->createImage($url, $width, $height);
		$this->media = $this->createMedia($url, $width, $height);
	}

	/**
	 * @param SimpleXMLElement $item
	 * @return string
	 */
	private function getNickname($item){
		if (isset($this->user_id))
			return $this->user_id;
		$result = explode('/', $item->author->attributes('flickr', true)->profile);
		return $result[4];
	}
}