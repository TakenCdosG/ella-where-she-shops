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
require_once(AS_PLUGIN_DIR . 'includes/settings/FFStreamSettings.php');

class FFCacheManager {
    /**
     * @param array $streams
     * @return void
     */
    public static function clean(array $streams){
        global $wpdb;
        $prefix = $wpdb->prefix;
        foreach ($streams as $id){
            $wpdb->query("DELETE FROM `{$prefix}options` WHERE `option_name` LIKE '_transient_" . self::_cacheName($id, '%') . "'");
            $wpdb->query("DELETE FROM `{$prefix}options` WHERE `option_name` LIKE '_transient_" . self::_lifeTimeName($id) . "'");
            $wpdb->query("DELETE FROM `{$prefix}options` WHERE `option_name` LIKE '_transient_timeout_" . self::_lifeTimeName($id) . "'");
        }
    }

    /**
     * @param string $streamId
     * @param string $feedId
     * @return string
     */
    private static function _cacheName($streamId, $feedId){
        return FlowFlow::$PLUGIN_SLUG_DOWN . "_cache_s_{$streamId}_f_{$feedId}";
    }

    /**
     * @param string $streamId
     * @return string
     */
    private static function _lifeTimeName($streamId){
        return FlowFlow::$PLUGIN_SLUG_DOWN . "_cache__time_s_" . $streamId;
    }

    private $force;
    /** @var  FFStreamSettings */
    private $stream;
    private $errors;
    private $streamTime;
    private $updateLifeTime = false;

    function __construct($force = false){
        $this->force = $force;
    }

    /**
     * @return bool
     */
    public function forceLoadCache() {
        return $this->force;
    }

    /**
     * @param array $feeds
     * @param bool $disableCache
     * @return array
     */
    public function posts($feeds, $disableCache){
        $result = array();
        $this->errors = array();
        $expiredLifeTime = $this->expiredLifeTime();
        foreach ($feeds as $feed) {
            $result[] = $disableCache ? $feed->posts() : $this->posts4feed($feed, $expiredLifeTime);
            $this->errors += $feed->errors();
        }
        if ($this->updateLifeTime){
            set_transient(self::_lifeTimeName($this->stream->getId()), $this->streamTime, $this->stream->getCacheLifeTime());
        }
        return $result;
    }

    public function errors(){
        return $this->errors;
    }

    /**
     * @param FFFeed $feed
     * @param bool $expiredLifeTime
     *
     * @return array
     */
    private function posts4feed($feed, $expiredLifeTime){
        if (!$feed->useCache()){
            return $this->force ? array() : $feed->posts();
        }

        if ($this->force){
            if ($expiredLifeTime){
                set_transient(self::_lifeTimeName($this->stream->getId()), $this->streamTime, 7*60);
                $this->set($feed, $this->getSafePosts($feed));
            }
            return array();
        }

        $result = $this->get($feed);
        if (false === $result) {
            $result = $this->set($feed, $this->getSafePosts($feed));
        }
        return $result;
    }

    /**
     * @param FFStreamSettings $stream
     * @return void
     */
    public function setStream($stream) {
        $this->stream = $stream;
        $this->streamTime = date("M d H:i s", time());
    }

    /**
     * @param FFFeed $feed
     * @return mixed
     */
    private function get($feed){
        return unserialize(base64_decode(get_transient(self::_cacheName($this->stream->getId(), $feed->id()))));
    }

    /**
     * @param FFFeed $feed
     * @param $value
     * @return mixed
     */
    private function set($feed, $value) {
        if (sizeof($value) > 0) {
            set_transient(self::_cacheName($this->stream->getId(), $feed->id()), base64_encode(serialize($value)));
            $this->updateLifeTime = true;
        }
        return $value;
    }

    /**
     * @return bool
     */
    private function expiredLifeTime(){
        if (!$this->stream->useCache()) {
            return true;
        }
        return (false === ($v = get_transient(self::_lifeTimeName($this->stream->getId()))));
    }

    /**
     * @param FFFeed $feed
     * @return array
     */
    private function getSafePosts($feed){
        try { return $feed->posts(); }
        catch (Exception $e) {
            $this->log('error','Feed: ' . $feed->id() . ' ERROR:' . $e->getMessage());
            error_log('Cache:: Feed: ' . $feed->id() . ' ERROR:' . $e->getMessage());
            error_log('Cache:: Feed: ' . $feed->id() . ' ERROR:' .$e->getTraceAsString());
            return array();
        }
    }

    private function log($key = '', $msg) {
        set_transient(FlowFlow::$PLUGIN_SLUG_DOWN . "_cache__log_" . $key . time(), $key . ' ' . $msg);
    }
}