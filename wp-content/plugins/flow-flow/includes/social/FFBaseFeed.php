<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
require_once(AS_PLUGIN_DIR . 'includes/social/FFFeed.php');
require_once(AS_PLUGIN_DIR . 'includes/social/FFFeedUtils.php');

require_once(AS_PLUGIN_DIR . 'includes/cache/FFImageSizeCacheManager.php');

abstract class FFBaseFeed implements FFFeed{
    private $id;
    /** @var FFImageSizeCacheManager */
    private $cache;
    private $count;
    private $imageWidth;
    private $useProxyServer;
	private $type;

    protected $errors;

	function __construct( $type ) {
		$this->type = $type;
	}

	public function getType(){
		return $this->type;
	}

	public function id(){
        return $this->id;
    }

    public function getCount(){
        return $this->count;
    }

    /**
     * @return int
     */
    public function getImageWidth(){
        return $this->imageWidth;
    }

    /**
     * @return int
     */
    public function getAllowableWidth(){
        return 200;
    }

    /**
     * @param FFGeneralSettings $options
     * @param FFStreamSettings $stream
     * @param $feed
     * @return void
     */
    public function init($options, $stream, $feed){
        $this->id = $feed->id;
        $this->errors = array();
        $this->useProxyServer = $options->useProxyServer();
        $this->count = $stream->getCountOfPosts();
        $this->imageWidth = $stream->getImageWidth();
        $this->cache = FFImageSizeCacheManager::get();
    }

    /**
     * @return array
     */
    public function errors() {
        return $this->errors;
    }

    /**
     * @param $url
     * @param $width
     * @param $height
     * @return array
     */
    protected function createImage($url, $width = null, $height = null){
        if ($width == null || $height == null){
            $size = $this->cache->size($url);
            $width = $size['width'];
            $height = $size['height'];
        }
        $tWidth = $this->getImageWidth();
        if ($this->useProxyServer && ($width + 50) > $tWidth) $url = FFFeedUtils::proxy($url, $tWidth);
        return array('url' => $url, 'width' => $tWidth, 'height' => FFFeedUtils::getScaleHeight($tWidth, $width, $height));
    }

	protected function createMedia($url, $width = null, $height = null, $type = 'image'){
		if ($type == 'html'){
			return array('type' => $type, 'html' => $url);
		}
		if ($width == null || $height == null){
			$size = $this->cache->size($url);
			$width = $size['width'];
			$height = $size['height'];
		}
		return array('type' => $type, 'url' => $url, 'width' => $width, 'height' => $height);
	}

    /**
     * @param string $link
     * @param string $name
     * @param mixed $image
     * @param mixed $width
     * @param mixed $height
     * @return array
     */
    protected function createAttachment($link, $name, $image = null, $width = null, $height = null){
        if ($image != null){
            if (is_string($image)) $image = $this->createImage($image, $width, $height);
            if ($image['width'] > $this->getAllowableWidth())
                return array( 'type' => 'article', 'url' => $link, 'displayName' => $name, 'image' => $image);
        }
        return array( 'type' => 'article', 'url' => $link, 'displayName' => $name);
    }

    /**
     * @param $result array
     * @return array
     */
    protected function afterProcess($result){
        $this->cache->save();
        return $result;
    }

    public function useCache(){
        return true;
    }
} 