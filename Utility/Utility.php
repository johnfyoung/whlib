<?php
/**
 * Utility.php
 *
 * @package WHLib
 * @author johny
 * @copyright Copyright (c) 2016, Williams Helde
 * @link http://www.williams-helde.com
 */

namespace WHLib\Utility;



class Utility {

var $freedomains = array(

  /* Default domains included */
"aol.com", "att.net", "comcast.net", "facebook.com", "gmail.com", "gmx.com", "googlemail.com",
"google.com", "hotmail.com", "hotmail.co.uk", "mac.com", "me.com", "mail.com", "msn.com",
"live.com", "sbcglobal.net", "verizon.net", "yahoo.com", "yahoo.co.uk","sprynet.com","sprynet.net",

  /* Other global domains */
"email.com", "games.com" /* AOL */, "gmx.net", "hush.com", "hushmail.com", "inbox.com",
"lavabit.com", "love.com" /* AOL */, "pobox.com", "rocketmail.com" /* Yahoo */,
"safe-mail.net", "wow.com" /* AOL */, "ygm.com" /* AOL */, "ymail.com" /* Yahoo */, "zoho.com",

  /* United States ISP domains */
"bellsouth.net", "charter.net", "cox.net", "earthlink.net", "juno.com",

  /* British ISP domains */
"btinternet.com", "virginmedia.com", "blueyonder.co.uk", "freeserve.co.uk", "live.co.uk",
"ntlworld.com", "o2.co.uk", "orange.net", "sky.com", "talktalk.co.uk", "tiscali.co.uk",
"virgin.net", "wanadoo.co.uk", "bt.com",

  /* Chinese ISP domains */
"sina.com", "qq.com",

  /* French ISP domains */
"hotmail.fr", "live.fr", "laposte.net", "yahoo.fr", "wanadoo.fr", "orange.fr", "gmx.fr", "sfr.fr", "neuf.fr", "free.fr",

  /* German ISP domains */
"gmx.de", "hotmail.de", "live.de", "online.de", "t-online.de" /* T-Mobile */, "web.de", "yahoo.de",

  /* Russian ISP domains */
"mail.ru", "rambler.ru", "yandex.ru",

  /* Belgian ISP domains */
"hotmail.be", "live.be", "skynet.be", "voo.be", "tvcablenet.be",

  /* Argentinian ISP domains */
"hotmail.com.ar", "live.com.ar", "yahoo.com.ar", "fibertel.com.ar", "speedy.com.ar", "arnet.com.ar",

  /* Domains used in Mexico */

'hotmail.com', 'gmail.com', 'yahoo.com.mx', 'live.com.mx', 'yahoo.com', 'hotmail.es', 'live.com', 'hotmail.com.mx', 'prodigy.net.mx', 'msn.com'

);

  /**
   * Test to see if an email is not
   */
  public function is_free_domain($domain) {
    $result = in_array($domain,$this->freedomains);
    if($result == false) {
      $result = preg_match('/.*(yahoo|live\.com|hotmail|prodigy|gmail).*/',$domain);
    }

    return $result;
  }

  static public function escape_regex_specialchars($str) {
    //[\^$.|?*+()
    $result = $str;
    $result = str_replace('.', '\.', $result);
    $result = str_replace("'", "\'", $result);
    $result = str_replace("*", "\*", $result);
    $result = str_replace("$", "\$", $result);
    $result = str_replace("^", "\^", $result);
    $result = str_replace("[", "\[", $result);
    $result = str_replace("]", "\]", $result);
    $result = str_replace("(", "\(", $result);
    $result = str_replace(")", "\)", $result);
    $result = str_replace("+", "\+", $result);
    $result = str_replace("|", "\|", $result);

    return $result;
  }

  static public function objects_to_arrays($object_array) {
    $result = array();

    foreach($object_array as $obj) {
      $result[] = get_object_vars($obj);
    }

    return $result;
  }
/*
  static public function render($path, $data) {
    ob_start();
    extract($data);
    require($path);
    return ob_get_clean();
  }

  static public function pagination_link($url, $page_id, $page_number) {
    return $url ."?". $page_id ."=". $page_number;
  }*/

} 