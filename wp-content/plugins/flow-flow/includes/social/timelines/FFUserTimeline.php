<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
require_once(AS_PLUGIN_DIR . 'includes/settings/FFSettingsUtils.php');
require_once(AS_PLUGIN_DIR . 'includes/social/timelines/FFTimeline.php');

class FFUserTimeline implements FFTimeline{
    private static $URL = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

    private $count;
    private $screenName;
    private $include_rts;
    private $exclude_replies;

    public function init($stream, $feed){
        $this->count = $stream->getCountOfPosts();
        $this->screenName = $feed->content;
        $this->exclude_replies = (string)FFSettingsUtils::notYepNope2ClassicStyle($feed->replies);
        $this->include_rts = (string)FFSettingsUtils::YepNope2ClassicStyle($feed->retweets);
    }

    public function getUrl(){
        return self::$URL;
    }

    public function getField(){
        $getfield = "?screen_name={$this->screenName}&count={$this->count}&exclude_replies={$this->exclude_replies}&include_rts={$this->include_rts}";
        return $getfield;
    }
}