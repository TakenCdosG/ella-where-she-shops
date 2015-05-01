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
require_once(AS_PLUGIN_DIR . 'includes/social/FFTwitterAPIExchange.php');
require_once(AS_PLUGIN_DIR . 'includes/social/timelines/FFSearch.php');
require_once(AS_PLUGIN_DIR . 'includes/social/timelines/FFUserTimeline.php');
require_once(AS_PLUGIN_DIR . 'includes/social/timelines/FFHomeTimeline.php');

class FFTwitter extends FFBaseFeed{
    private static $GET = "GET";

    private $timeline;
    private $restService;
	private $media;

	public function __construct() {
		parent::__construct( 'twitter' );
	}

	public function init($options, $stream, $feed){
        parent::init($options, $stream, $feed);
        $original = $options->original();
        $this->restService = new FFTwitterAPIExchange(array(
            'oauth_access_token' => $original['oauth_access_token'],
            'oauth_access_token_secret' => $original['oauth_access_token_secret'],
            'consumer_key' => $original['consumer_key'],
            'consumer_secret' => $original['consumer_secret']
        ));
        $this->timeline = $this->getTimeline($stream, $feed);
    }

    public function posts(){
        $json = json_decode($this->restService
            ->setGetfield($this->timeline->getField())
            ->buildOauth($this->timeline->getUrl(), self::$GET)
            ->performRequest(), $assoc = TRUE);

        if (isset($json['errors'])) {
            foreach ($json['errors'] as $error) {
                $msg = $error['message'];
                $this->errors[] = "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>{$msg}</em></p>";
            }
            return array();
        }
        return $this->parseRequest($json);
    }

    private function parseRequest($json) {
        $tmp = $json;
        $result = array();

        if (isset($json['statuses'])) {
            $tmp = $json['statuses'];
        }
        if (isset($tmp) && is_array($tmp)){
            foreach ($tmp as $t) {
	            $this->media = null;
                $tc = new stdClass();
                $tc->id = (string)$t['id'];
                $tc->type = $this->getType();
                $tc->nickname = '@'.$t['user']['screen_name'];
                $tc->screenname = (string)$t['user']['name'];
                $tc->userpic = str_replace('.jpg', '_200x200.jpg', str_replace('_normal', '', (string)$t['user']['profile_image_url']));
                $tc->system_timestamp = strtotime($t['created_at']);
                $tc->timestamp = FFFeedUtils::classicStyleDate($tc->system_timestamp);
                $tc->text = $this->getText($t);
                $tc->userlink = 'https://twitter.com/'.$t['user']['screen_name'];
                $tc->permalink = $tc->userlink . '/status/' . $tc->id;
	            $tc->media = $this->media;
                $result[] = $tc;
            }
        }
        return $result;
    }

    private function getTimeline($stream, $feed){
        $timeline = null;
        switch ($feed->{'timeline-type'}) {
            case 'home_timeline':
                $timeline = new FFHomeTimeline();
                break;
            case 'user_timeline':
                $timeline = new FFUserTimeline();
                break;
            default:
                $timeline = new FFSearch();
        }
        $timeline->init($stream, $feed);
        return $timeline;
    }

    private function getText($tweet){
        if (!isset($tweet['entities'])){
            return (string) $tweet['text'];
        }
        for ($i = 0; $i < mb_strlen($tweet['text']); $i++) {
            $ch = mb_substr($tweet['text'], $i, 1);
            if ($ch <> "\n") $ChAr[] = $ch; else $ChAr[] = "\n<br/>";
        }
        $entities = $tweet['entities'];
        if (isset($entities['user_mentions']))
            foreach ($entities['user_mentions'] as $entity) {
                $ChAr[$entity['indices'][0]] = "<a href='https://twitter.com/" . $entity['screen_name'] . "'>" . $ChAr[$entity['indices'][0]];
                $ChAr[$entity['indices'][1] - 1] .= "</a>";
            }
        if (isset($entities['hashtags']))
            foreach ($entities['hashtags'] as $entity) {
                $ChAr[$entity['indices'][0]] = "<a href='https://twitter.com/search?q=%23" . $entity['text'] . "'>" . $ChAr[$entity['indices'][0]];
                $ChAr[$entity['indices'][1] - 1] .= "</a>";
            }
        if (isset($entities['urls']))
            foreach ($entities['urls'] as $entity) {
                $ChAr[$entity['indices'][0]] = "<a href='" . $entity['expanded_url'] . "'>" . $entity['display_url'] . "</a>";
                for ($i = $entity['indices'][0] + 1; $i < $entity['indices'][1]; $i++) $ChAr[$i] = '';
            }
        if (isset($entities['media']))
            foreach ($entities['media'] as $entity) {
                $ChAr[$entity['indices'][0]] = "<a href='" . $entity['expanded_url'] . "'>";
                if ($entity['type'] == 'photo') {
                    $sizes = $entity['sizes']['small'];
                    $image = $this->createImage($entity['media_url_https'], $sizes['w'],$sizes['h']);
                    $ChAr[$entity['indices'][0]] .= "<img src='" . $image['url'] . "' style='width:" . $image['width'] . "px;height:" . $image['height'] . "px'/>";
	                $sizes = $entity['sizes']['large'];//medium or large ???
	                $this->media = $this->createMedia($entity['media_url_https'], $sizes['w'],$sizes['h']);
                } else {
                    $ChAr[$entity['indices'][0]] .= $entity['display_url'];
                }
                $ChAr[$entity['indices'][0]] .= "</a>";
                for ($i = $entity['indices'][0] + 1; $i < $entity['indices'][1]; $i++) $ChAr[$i] = '';
            }
        return implode('', $ChAr);
    }
}