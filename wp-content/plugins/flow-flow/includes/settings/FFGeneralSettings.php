<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */

class FFGeneralSettings {
    private $options;
    private $auth_options;

    public function __construct($options, $auth_options) {
        $this->options = $options;
        $this->auth_options = $auth_options;
    }

    public function isAgoStyleDate(){
        return $this->dateStyle() == 'agoStyleDate';
    }

    public function dateStyle() {
        $value = $this->options["general-settings-date-format"];
        if (isset($value)) {
            return $value;
        }
        return 'agoStyleDate';
    }

    public function getStreamById($id) {
        foreach ($this->getAllStreams() as $stream) {
            if ($stream->id == $id) {
                return $stream;
            }
        }
    }

    public function getAllStreams() {
        if (!isset($this->options['streams'])){
            return array();
        }
        return $this->options['streams'];
    }

    public function original() {
        return $this->options;
    }

    public function originalAuth(){
        return $this->auth_options;
    }

    public function useProxyServer(){
        $value = $this->options["general-settings-disable-proxy-server"];
        return FFSettingsUtils::notYepNope2ClassicStyle($value, true);
    }

	public function isSEOMode(){
		$value = $this->options["general-settings-seo-mode"];
		return FFSettingsUtils::YepNope2ClassicStyle($value, false);
	}
}