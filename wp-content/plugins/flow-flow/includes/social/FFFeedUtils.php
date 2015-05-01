<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * Flow-Flow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>
 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */

class FFFeedUtils{
    private static $USER_AGENT = "Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6";
    private static $proxy_refresh_time = 86400; //one day
    private static $length = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
    private static $phrase = array('s', 'm', 'h', 'day', 'week', 'month', 'year', 'decade');

    public static function agoStyleDate($date){
        $stf = 0;
        $cur_time = time();
        $diff = $cur_time - $date;

        for ($i = sizeof(self::$length) - 1; ($i >= 0) && (($no = $diff / self::$length[$i]) <= 1); $i--) ;
        if ($i < 0) $i = 0;
        $no = floor($no);

        switch ($i) {
            case 3:
                if ($no == 1) {
                    $value = 'Yesterday';
                    break;
                }
            case 4:
            case 5:
                $value = date("M j",$date);
                break;
            case 6:
            case 7:
                $value = date("j M Y",$date);
                break;
            default:
                $_time = $cur_time - ($diff % self::$length[$i]);
                $value = self::ago($no, $cur_time, $_time, $stf, $i);
        }
        return $value;
    }

    private static function ago($no, $cur_time, $_time, $stf, $i){
        $phrase = self::$phrase[$i];
//        if ($no != 1) {
//            $phrase .= 's';
//        }

        $value = sprintf("%d%s", $no, $phrase);
        if (($stf == 1) && ($i >= 1) && (($cur_time - $_time) > 0)) {
            $value .= time_ago($_time);
        }
        return $value . ' ago ';
    }

    public static function classicStyleDate($date){
        $cur_time = time();
        $diff = $cur_time - $date;
        for ($i = sizeof(self::$length) - 1; ($i >= 0) && (($no = $diff / self::$length[$i]) <= 1); $i--) ;
        if ($i < 0) $i = 0;

        if ($i > 5)
            return date("M j Y",$date);
        return date("M j H:i",$date);
    }

    /**
     * @param int $templateWidth
     * @param int $originalWidth
     * @param int $originalHeight
     * @return int|string
     */
    public static function getScaleHeight($templateWidth, $originalWidth, $originalHeight){
        if (isset($originalWidth) && isset($originalHeight)){
            $k = $templateWidth / $originalWidth;
            return round( $originalHeight * $k );
        }
        return '';
    }

    /**
     * @param string $url
     * @return array
     */
    public static function getFeedData($url){
        $c = curl_init();
        curl_setopt($c, CURLOPT_USERAGENT, self::$USER_AGENT);
        curl_setopt($c, CURLOPT_URL,$url);
        curl_setopt($c, CURLOPT_POST, 0);
        curl_setopt($c, CURLOPT_FAILONERROR, true);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);//if use self::curl_exec_follow when remove this line!
        curl_setopt($c, CURLOPT_AUTOREFERER, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($c, CURLOPT_VERBOSE, false);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        $page = curl_exec($c);
//        $page = self::curl_exec_follow($c);
        $error = curl_error($c);
        $errors = array();
        if (strlen($error) > 0){
            $errors[] = $error;
        }
        curl_close($c);
        return array('response' => $page, 'errors' => $errors, 'url' => $url);
    }


    /**
     * http://carlo.zottmann.org/2013/04/14/google-image-resizer/
     * @param string $url
     * @param string $width
     * @return string
     */
    public static function proxy($url, $width){
        $query = http_build_query(array(
            'container' => 'focus',
            'resize_w' => $width,
            'refresh' => self::$proxy_refresh_time,
            'url' => $url));
        return "https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?".$query;
    }

    /**
     * @param string $text
     * @return mixed
     */
    public static function removeEmoji($text) {
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        return $clean_text;
    }

	/**
	 * @param string $source
	 * @return mixed
	 */
	public static function wrapLinks($source){
		$pattern = '/(http:\/\/[a-z0-9\.\/]+)/i';
		$replacement = '<a href="$1">$1</a>';
		return preg_replace($pattern, $replacement, $source);
	}

	public static function getUrlFromImg($tag){
		preg_match("/\<img.+src\=(?:\"|\')(.+?)(?:\"|\')(?:.+?)\>/", $tag, $matches);
		return $matches[1];
	}

	private static function curl_exec_follow($ch, &$maxRedirect = null) {
		$mr = $maxRedirect === null ? 5 : intval($maxRedirect);

		if (filter_var(ini_get('open_basedir'), FILTER_VALIDATE_BOOLEAN) === false && filter_var(ini_get('safe_mode'), FILTER_VALIDATE_BOOLEAN) === false) {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
			curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		} else {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

			if ($mr > 0) {
				$original_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
				$newUrl = $original_url;

				$rch = curl_copy_handle($ch);

				curl_setopt($rch, CURLOPT_HEADER, true);
				curl_setopt($rch, CURLOPT_NOBODY, true);
				curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
				do {
					curl_setopt($rch, CURLOPT_URL, $newUrl);
					$header = curl_exec($rch);
					if (curl_errno($rch)) {
						$code = 0;
					} else {
						$code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
						if ($code == 301 || $code == 302) {
							preg_match('/Location:(.*?)\n/i', $header, $matches);
							$newUrl = trim(array_pop($matches));

							// if no scheme is present then the new url is a
							// relative path and thus needs some extra care
							if(!preg_match("/^https?:/i", $newUrl)){
								$newUrl = $original_url . $newUrl;
							}
						} else {
							$code = 0;
						}
					}
				} while ($code && --$mr);

				curl_close($rch);

				if (!$mr) {
					if ($maxRedirect === null)
						trigger_error('Too many redirects.', E_USER_WARNING);
					else
						$maxRedirect = 0;

					return false;
				}
				curl_setopt($ch, CURLOPT_URL, $newUrl);
			}
		}
		return curl_exec($ch);
	}
}