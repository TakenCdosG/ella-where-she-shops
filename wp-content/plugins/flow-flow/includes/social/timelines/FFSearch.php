<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
require_once(AS_PLUGIN_DIR . 'includes/social/timelines/FFTimeline.php');

class FFSearch implements FFTimeline{
    private static $URL = 'https://api.twitter.com/1.1/search/tweets.json';

    private $count;
    private $searchQuery;
    private $resultType;

    public function init($stream, $feed){
        $this->count = $stream->getCountOfPosts();
        $this->searchQuery = $feed->content;
        $this->resultType = 'mixed';
    }

    public function getUrl(){
        return self::$URL;
    }

    public function getField() {
        $q = urlencode($this->searchQuery);
        $getfield = "?q={$q}&count={$this->count}&result_type={$this->resultType}&include_entities=true";
        return $getfield;
    }
}