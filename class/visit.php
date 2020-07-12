<?php
/**
 * Module class visit
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 * @since       2.0.18
 */

if (!class_exists('XoopsPersistableObjectHandler')) {
  include_once XOOPS_ROOT_PATH.'/modules/xoopsvisit/class/object.php';
}

class XoopsVisit extends XoopsObject{

  var $_referer;
  var $_useragent;
  var $_browser;
  var $_browser_version;
  var $_robot;

  /**
   * Constructor
   */
  function XoopsVisit(){
    // Initialize variables
    $this->_referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
    $this->_useragent = (isset($_SERVER["HTTP_USER_AGENT"])) ? $_SERVER['HTTP_USER_AGENT'] : '';
    //$this->_useragent = "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)";
    // Initialize Object
    $this->initVar('visit_id', XOBJ_DTYPE_INT, NULL, false);
    $this->initVar('visit_referer', XOBJ_DTYPE_TXTBOX, $this->_referer);
    $this->initVar('visit_useragent', XOBJ_DTYPE_TXTBOX, $this->_useragent);
    $this->initVar('visit_ip', XOBJ_DTYPE_TXTBOX, '');
    $this->initVar('visit_robot', XOBJ_DTYPE_INT, 0);
    $this->initVar('visit_date', XOBJ_DTYPE_OTHER);
    $this->initVar('visit_time', XOBJ_DTYPE_OTHER);
    $this->getBrowser();
  }
  
  /**
   * search the IP adress for the visitor
   * 
   */
  function getIP() {
    if(getenv('HTTP_CLIENT_IP')) {
      $ip = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
      $ip = getenv('HTTP_X_FORWARDED_FOR');
    } else {
      $ip = getenv('REMOTE_ADDR');
    }
    return $ip;
  }
  
  /**
   * resolve browser type and version
   *
   * @author  TOTH Richard
   */
  function getBrowser(){
    if (eregi("msnbot",$this->_useragent)){
      $this->_browser = "MSN Bot";
      $this->_type = "robot";
      if (eregi("msnbot/0.11",$this->_useragent)) {$this->_browser_version = "0.11";}
      elseif (eregi("msnbot/0.30",$this->_useragent)) {$this->_browser_version = "0.3";}
      elseif (eregi("msnbot/1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
    }
    elseif (eregi("almaden",$this->_useragent))
    {
      $this->_browser = "IBM Almaden Crawler";
      $this->_type = "robot";
    }
    elseif (eregi("BecomeBot",$this->_useragent))
    {
      $this->_browser = "BecomeBot";
      if (eregi("becomebot/1.23",$this->_useragent)) {$this->_browser_version = "1.23";}
      $this->_type = "robot";
    }
    elseif (eregi("Link-Checker-Pro",$this->_useragent))
    {
      $this->_browser = "Link Checker Pro";
      $this->_type = "robot";
    }
    elseif (eregi("ia_archiver",$this->_useragent))
    {
      $this->_browser = "Alexa";
      $this->_type = "robot";
    }
    elseif ((eregi("googlebot",$this->_useragent)) || (eregi("google",$this->_useragent)))
    {
      $this->_browser = "Google Bot";
      $this->_type = "robot";
      if ((eregi("googlebot/2.1",$this->_useragent)) || (eregi("google/2.1",$this->_useragent))) {$this->_browser_version = "2.1";}
    }
    elseif (eregi("surveybot",$this->_useragent))
    {
      $this->_browser = "Survey Bot";
      $this->_type = "robot";
      if (eregi("surveybot/2.3",$this->_useragent)) {$this->_browser_version = "2.3";}
    }
    elseif (eregi("zyborg",$this->_useragent))
    {
      $this->_browser = "ZyBorg";
      $this->_type = "robot";
      if (eregi("zyborg/1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
    }
    elseif (eregi("w3c-checklink",$this->_useragent))
    {
      $this->_browser = "W3C Checklink";
      $this->_type = "robot";
      if (eregi("checklink/3.6",$this->_useragent)) {$this->_browser_version = "3.6";}
    }
    elseif (eregi("linkwalker",$this->_useragent))
    {
      $this->_browser = "LinkWalker";
      $this->_type = "robot";
    }
    elseif (eregi("fast-webcrawler",$this->_useragent))
    {
      $this->_browser = "Fast WebCrawler";
      $this->_type = "robot";
      if (eregi("webcrawler/3.8",$this->_useragent)) {$this->_browser_version = "3.8";}
    }
    elseif ((eregi("yahoo",$this->_useragent)) && (eregi("slurp",$this->_useragent)))
    {
      $this->_browser = "Yahoo! Slurp";
      $this->_type = "robot";
    }
    elseif (eregi("naverbot",$this->_useragent))
    {
      $this->_browser = "NaverBot";
      $this->_type = "robot";
      if (eregi("dloader/1.5",$this->_useragent)) {$this->_browser_version = "1.5";}
    }
    elseif (eregi("converacrawler",$this->_useragent))
    {
      $this->_browser = "ConveraCrawler";
      $this->_type = "robot";
      if (eregi("converacrawler/0.5",$this->_useragent)) {$this->_browser_version = "0.5";}
    }
    elseif (eregi("w3c_validator",$this->_useragent))
    {
      $this->_browser = "W3C Validator";
      $this->_type = "robot";
      if (eregi("w3c_validator/1.305",$this->_useragent)) {$this->_browser_version = "1.305";}
    }
    elseif (eregi("innerprisebot",$this->_useragent))
    {
      $this->_browser = "Innerprise";
      $this->_type = "robot";
      if (eregi("innerprise/1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
    }
    elseif (eregi("topicspy",$this->_useragent))
    {
      $this->_browser = "Topicspy Checkbot";
      $this->_type = "robot";
    }
    elseif (eregi("poodle predictor",$this->_useragent))
    {
      $this->_browser = "Poodle Predictor";
      $this->_type = "robot";
      if (eregi("poodle predictor 1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
    }
    elseif (eregi("ichiro",$this->_useragent))
    {
      $this->_browser = "Ichiro";
      $this->_type = "robot";
      if (eregi("ichiro/1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
    }
    elseif (eregi("link checker pro",$this->_useragent))
    {
      $this->_browser = "Link Checker Pro";
      $this->_type = "robot";
      if (eregi("link checker pro 3.2.16",$this->_useragent)) {$this->_browser_version = "3.2.16";}
    }
    elseif (eregi("grub-client",$this->_useragent))
    {
      $this->_browser = "Grub client";
      $this->_type = "robot";
      if (eregi("grub-client-2.3",$this->_useragent)) {$this->_browser_version = "2.3";}
    }
    elseif (eregi("gigabot",$this->_useragent))
    {
      $this->_browser = "Gigabot";
      $this->_type = "robot";
      if (eregi("gigabot/2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
    }
    elseif (eregi("psbot",$this->_useragent))
    {
      $this->_browser = "PSBot";
      $this->_type = "robot";
      if (eregi("psbot/0.1",$this->_useragent)) {$this->_browser_version = "0.1";}
    }
    elseif (eregi("mj12bot",$this->_useragent))
    {
      $this->_browser = "MJ12Bot";
      $this->_type = "robot";
      if (eregi("mj12bot/v0.5",$this->_useragent)) {$this->_browser_version = "0.5";}
    }
    elseif (eregi("nextgensearchbot",$this->_useragent))
    {
      $this->_browser = "NextGenSearchBot";
      $this->_type = "robot";
      if (eregi("nextgensearchbot 1",$this->_useragent)) {$this->_browser_version = "1";}
    }
    elseif (eregi("tutorgigbot",$this->_useragent))
    {
      $this->_browser = "TutorGigBot";
      $this->_type = "robot";
      if (eregi("bot/1.5",$this->_useragent)) {$this->_browser_version = "1.5";}
    }
    elseif (ereg("NG",$this->_useragent))
    {
      $this->_browser = "Exabot NG";
      $this->_type = "robot";
      if (eregi("ng/2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
    }
    elseif (eregi("gaisbot",$this->_useragent))
    {
      $this->_browser = "Gaisbot";
      $this->_type = "robot";
      if (eregi("gaisbot/3.0",$this->_useragent)) {$this->_browser_version = "3.0";}
    }
    elseif (eregi("xenu link sleuth",$this->_useragent))
    {
      $this->_browser = "Xenu Link Sleuth";
      $this->_type = "robot";
      if (eregi("xenu link sleuth 1.2",$this->_useragent)) {$this->_browser_version = "1.2";}
    }
    elseif (eregi("turnitinbot",$this->_useragent))
    {
      $this->_browser = "TurnitinBot";
      $this->_type = "robot";
      if (eregi("turnitinbot/2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
    }
    elseif (eregi("iconsurf",$this->_useragent))
    {
      $this->_browser = "IconSurf";
      $this->_type = "robot";
      if (eregi("iconsurf/2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
    }
    elseif (eregi("zoe indexer",$this->_useragent))
    {
      $this->_browser = "Zoe Indexer";
      $this->_type = "robot";
      if (eregi("v1.x",$this->_useragent)) {$this->_browser_version = "1";}
    }
    elseif (eregi("amaya",$this->_useragent))
    {
      $this->_browser = "amaya";
      $this->_type = "browser";
      if (eregi("amaya/5.0",$this->_useragent)) {$this->_browser_version = "5.0";}
      elseif (eregi("amaya/5.1",$this->_useragent)) {$this->_browser_version = "5.1";}
      elseif (eregi("amaya/5.2",$this->_useragent)) {$this->_browser_version = "5.2";}
      elseif (eregi("amaya/5.3",$this->_useragent)) {$this->_browser_version = "5.3";}
      elseif (eregi("amaya/6.0",$this->_useragent)) {$this->_browser_version = "6.0";}
      elseif (eregi("amaya/6.1",$this->_useragent)) {$this->_browser_version = "6.1";}
      elseif (eregi("amaya/6.2",$this->_useragent)) {$this->_browser_version = "6.2";}
      elseif (eregi("amaya/6.3",$this->_useragent)) {$this->_browser_version = "6.3";}
      elseif (eregi("amaya/6.4",$this->_useragent)) {$this->_browser_version = "6.4";}
      elseif (eregi("amaya/7.0",$this->_useragent)) {$this->_browser_version = "7.0";}
      elseif (eregi("amaya/7.1",$this->_useragent)) {$this->_browser_version = "7.1";}
      elseif (eregi("amaya/7.2",$this->_useragent)) {$this->_browser_version = "7.2";}
      elseif (eregi("amaya/8.0",$this->_useragent)) {$this->_browser_version = "8.0";}
    }
    elseif ((eregi("aol",$this->_useragent)) && !(eregi("msie",$this->_useragent)))
    {
      $this->_browser = "AOL";
      $this->_type = "browser";
      if ((eregi("aol 7.0",$this->_useragent)) || (eregi("aol/7.0",$this->_useragent))) {$this->_browser_version = "7.0";}
    }
    elseif ((eregi("aweb",$this->_useragent)) || (eregi("amigavoyager",$this->_useragent)))
    {
      $this->_browser = "AWeb";
      $this->_type = "browser";
      if (eregi("voyager/1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
      elseif (eregi("voyager/2.95",$this->_useragent)) {$this->_browser_version = "2.95";}
      elseif ((eregi("voyager/3",$this->_useragent)) || (eregi("aweb/3.0",$this->_useragent))) {$this->_browser_version = "3.0";}
      elseif (eregi("aweb/3.1",$this->_useragent)) {$this->_browser_version = "3.1";}
      elseif (eregi("aweb/3.2",$this->_useragent)) {$this->_browser_version = "3.2";}
      elseif (eregi("aweb/3.3",$this->_useragent)) {$this->_browser_version = "3.3";}
      elseif (eregi("aweb/3.4",$this->_useragent)) {$this->_browser_version = "3.4";}
      elseif (eregi("aweb/3.9",$this->_useragent)) {$this->_browser_version = "3.9";}
    }
    elseif (eregi("beonex",$this->_useragent))
    {
      $this->_browser = "Beonex";
      $this->_type = "browser";
      if (eregi("beonex/0.8.2",$this->_useragent)) {$this->_browser_version = "0.8.2";}
      elseif (eregi("beonex/0.8.1",$this->_useragent)) {$this->_browser_version = "0.8.1";}
      elseif (eregi("beonex/0.8",$this->_useragent)) {$this->_browser_version = "0.8";}
    }
    elseif (eregi("camino",$this->_useragent))
    {
      $this->_browser = "Camino";
      $this->_type = "browser";
      if (eregi("camino/0.7",$this->_useragent)) {$this->_browser_version = "0.7";}
    }
    elseif (eregi("cyberdog",$this->_useragent))
    {
      $this->_browser = "Cyberdog";
      $this->_type = "browser";
      if (eregi("cybergog/1.2",$this->_useragent)) {$this->_browser_version = "1.2";}
      elseif (eregi("cyberdog/2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
      elseif (eregi("cyberdog/2.0b1",$this->_useragent)) {$this->_browser_version = "2.0b1";}
    }
    elseif (eregi("dillo",$this->_useragent))
    {
      $this->_browser = "Dillo";
      $this->_type = "browser";
      if (eregi("dillo/0.6.6",$this->_useragent)) {$this->_browser_version = "0.6.6";}
      elseif (eregi("dillo/0.7.2",$this->_useragent)) {$this->_browser_version = "0.7.2";}
      elseif (eregi("dillo/0.7.3",$this->_useragent)) {$this->_browser_version = "0.7.3";}
      elseif (eregi("dillo/0.8",$this->_useragent)) {$this->_browser_version = "0.8";}
    }
    elseif (eregi("doris",$this->_useragent))
    {
	$this->_browser = "Doris";
	$this->_type = "browser";
	if (eregi("doris/1.10",$this->_useragent)) {$this->_browser_version = "1.10";}
}
elseif (eregi("emacs",$this->_useragent))
{
	$this->_browser = "Emacs";
	$this->_type = "browser";
	if (eregi("emacs/w3/2",$this->_useragent)) {$this->_browser_version = "2";}
	elseif (eregi("emacs/w3/3",$this->_useragent)) {$this->_browser_version = "3";}
	elseif (eregi("emacs/w3/4",$this->_useragent)) {$this->_browser_version = "4";}
}
elseif (eregi("firebird",$this->_useragent))
{
	$this->_browser = "Firebird";
	$this->_type = "browser";
	if ((eregi("firebird/0.6",$this->_useragent)) || (eregi("browser/0.6",$this->_useragent))) {$this->_browser_version = "0.6";}
	elseif (eregi("firebird/0.7",$this->_useragent)) {$this->_browser_version = "0.7";}
    }
    elseif (eregi("firefox",$this->_useragent))
    {
      $this->_browser = "Firefox";
      $this->_type = "browser";
      if (eregi("firefox/0.9.1",$this->_useragent)) {$this->_browser_version = "0.9.1";}
      elseif (eregi("firefox/0.10",$this->_useragent)) {$this->_browser_version = "0.10";}
      elseif (eregi("firefox/0.9",$this->_useragent)) {$this->_browser_version = "0.9";}
      elseif (eregi("firefox/0.8",$this->_useragent)) {$this->_browser_version = "0.8";}
      elseif (eregi("firefox/1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
      elseif (eregi("firefox/2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
    }
elseif (eregi("frontpage",$this->_useragent))
{
	$this->_browser = "FrontPage";
	$this->_type = "browser";
	if ((eregi("express 2",$this->_useragent)) || (eregi("frontpage 2",$this->_useragent))) {$this->_browser_version = "2";}
	elseif (eregi("frontpage 3",$this->_useragent)) {$this->_browser_version = "3";}
	elseif (eregi("frontpage 4",$this->_useragent)) {$this->_browser_version = "4";}
	elseif (eregi("frontpage 5",$this->_useragent)) {$this->_browser_version = "5";}
	elseif (eregi("frontpage 6",$this->_useragent)) {$this->_browser_version = "6";}
}
elseif (eregi("galeon",$this->_useragent))
{
	$this->_browser = "Galeon";
	$this->_type = "browser";
	if (eregi("galeon 0.1",$this->_useragent)) {$this->_browser_version = "0.1";}
	elseif (eregi("galeon/0.11.1",$this->_useragent)) {$this->_browser_version = "0.11.1";}
	elseif (eregi("galeon/0.11.2",$this->_useragent)) {$this->_browser_version = "0.11.2";}
	elseif (eregi("galeon/0.11.3",$this->_useragent)) {$this->_browser_version = "0.11.3";}
	elseif (eregi("galeon/0.11.5",$this->_useragent)) {$this->_browser_version = "0.11.5";}
	elseif (eregi("galeon/0.12.8",$this->_useragent)) {$this->_browser_version = "0.12.8";}
	elseif (eregi("galeon/0.12.7",$this->_useragent)) {$this->_browser_version = "0.12.7";}
	elseif (eregi("galeon/0.12.6",$this->_useragent)) {$this->_browser_version = "0.12.6";}
	elseif (eregi("galeon/0.12.5",$this->_useragent)) {$this->_browser_version = "0.12.5";}
	elseif (eregi("galeon/0.12.4",$this->_useragent)) {$this->_browser_version = "0.12.4";}
	elseif (eregi("galeon/0.12.3",$this->_useragent)) {$this->_browser_version = "0.12.3";}
	elseif (eregi("galeon/0.12.2",$this->_useragent)) {$this->_browser_version = "0.12.2";}
	elseif (eregi("galeon/0.12.1",$this->_useragent)) {$this->_browser_version = "0.12.1";}
	elseif (eregi("galeon/0.12",$this->_useragent)) {$this->_browser_version = "0.12";}
	elseif ((eregi("galeon/1",$this->_useragent)) || (eregi("galeon 1.0",$this->_useragent))) {$this->_browser_version = "1.0";}
}
elseif (eregi("ibm web browser",$this->_useragent))
{
	$this->_browser = "IBM Web Browser";
	$this->_type = "browser";
	if (eregi("rv:1.0.1",$this->_useragent)) {$this->_browser_version = "1.0.1";}
}
elseif (eregi("chimera",$this->_useragent))
{
	$this->_browser = "Chimera";
	$this->_type = "browser";
	if (eregi("chimera/0.7",$this->_useragent)) {$this->_browser_version = "0.7";}
	elseif (eregi("chimera/0.6",$this->_useragent)) {$this->_browser_version = "0.6";}
	elseif (eregi("chimera/0.5",$this->_useragent)) {$this->_browser_version = "0.5";}
	elseif (eregi("chimera/0.4",$this->_useragent)) {$this->_browser_version = "0.4";}
}
elseif (eregi("icab",$this->_useragent))
{
	$this->_browser = "iCab";
     		$this->_type = "browser";
	if (eregi("icab/2.7.1",$this->_useragent)) {$this->_browser_version = "2.7.1";}
	elseif (eregi("icab/2.8.1",$this->_useragent)) {$this->_browser_version = "2.8.1";}
	elseif (eregi("icab/2.8.2",$this->_useragent)) {$this->_browser_version = "2.8.2";}
	elseif (eregi("icab 2.9",$this->_useragent)) {$this->_browser_version = "2.9";}
	elseif (eregi("icab 2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
}
elseif (eregi("konqueror",$this->_useragent))
{
	$this->_browser = "Konqueror";
	$this->_type = "browser";
	if (eregi("konqueror/3.1",$this->_useragent)) {$this->_browser_version = "3.1";}
	elseif (eregi("konqueror/3.3",$this->_useragent)) {$this->_browser_version = "3.3";}
	elseif (eregi("konqueror/3.2",$this->_useragent)) {$this->_browser_version = "3.2";}
	elseif (eregi("konqueror/3",$this->_useragent)) {$this->_browser_version = "3.0";}
	elseif (eregi("konqueror/2.2",$this->_useragent)) {$this->_browser_version = "2.2";}
	elseif (eregi("konqueror/2.1",$this->_useragent)) {$this->_browser_version = "2.1";}
	elseif (eregi("konqueror/1.1",$this->_useragent)) {$this->_browser_version = "1.1";}
}
elseif (eregi("liberate",$this->_useragent))
{
	$this->_browser = "Liberate";
	$this->_type = "browser";
	if (eregi("dtv 1.2",$this->_useragent)) {$this->_browser_version = "1.2";}
	elseif (eregi("dtv 1.1",$this->_useragent)) {$this->_browser_version = "1.1";}
}
elseif (eregi("desktop/lx",$this->_useragent))
{
	$this->_browser = "Lycoris Desktop/LX";
	$this->_type = "browser";
}
elseif (eregi("netbox",$this->_useragent))
{
	$this->_browser = "NetBox";
	$this->_type = "browser";
	if (eregi("netbox/3.5",$this->_useragent)) {$this->_browser_version = "3.5";}
}
elseif (eregi("netcaptor",$this->_useragent))
{
	$this->_browser = "Netcaptor";
	$this->_type = "browser";
	if (eregi("netcaptor 7.0",$this->_useragent)) {$this->_browser_version = "7.0";}
	elseif (eregi("netcaptor 7.1",$this->_useragent)) {$this->_browser_version = "7.1";}
	elseif (eregi("netcaptor 7.2",$this->_useragent)) {$this->_browser_version = "7.2";}
	elseif (eregi("netcaptor 7.5",$this->_useragent)) {$this->_browser_version = "7.5";}
	elseif (eregi("netcaptor 6.1",$this->_useragent)) {$this->_browser_version = "6.1";}
}
elseif (eregi("netpliance",$this->_useragent))
{
	$this->_browser = "Netpliance";
	$this->_type = "browser";
}
elseif (eregi("netscape",$this->_useragent)) // (1) netscape nie je prilis detekovatelny....
{
	$this->_browser = "Netscape";
	$this->_type = "browser";
	if (eregi("netscape/7.1",$this->_useragent)) {$this->_browser_version = "7.1";}
	elseif (eregi("netscape/7.2",$this->_useragent)) {$this->_browser_version = "7.2";}
	elseif (eregi("netscape/7.0",$this->_useragent)) {$this->_browser_version = "7.0";}
	elseif (eregi("netscape6/6.2",$this->_useragent)) {$this->_browser_version = "6.2";}
	elseif (eregi("netscape6/6.1",$this->_useragent)) {$this->_browser_version = "6.1";}
	elseif (eregi("netscape6/6.0",$this->_useragent)) {$this->_browser_version = "6.0";}
}
elseif ((eregi("mozilla/5.0",$this->_useragent)) && (eregi("rv:",$this->_useragent)) && (eregi("gecko/",$this->_useragent))) // mozilla je troschu zlozitejsia na detekciu
{
	$this->_browser = "Mozilla";
	$this->_type = "browser";
	if (eregi("rv:1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
	elseif (eregi("rv:1.1",$this->_useragent)) {$this->_browser_version = "1.1";}
	elseif (eregi("rv:1.2",$this->_useragent)) {$this->_browser_version = "1.2";}
	elseif (eregi("rv:1.3",$this->_useragent)) {$this->_browser_version = "1.3";}
	elseif (eregi("rv:1.4",$this->_useragent)) {$this->_browser_version = "1.4";}
	elseif (eregi("rv:1.5",$this->_useragent)) {$this->_browser_version = "1.5";}
	elseif (eregi("rv:1.6",$this->_useragent)) {$this->_browser_version = "1.6";}
	elseif (eregi("rv:1.7",$this->_useragent)) {$this->_browser_version = "1.7";}
	elseif (eregi("rv:1.8",$this->_useragent)) {$this->_browser_version = "1.8";}
}
elseif (eregi("offbyone",$this->_useragent))
{
	$this->_browser = "OffByOne";
	$this->_type = "browser";
	if (eregi("mozilla/4.7",$this->_useragent)) {$this->_browser_version = "3.4";}
}
elseif (eregi("omniweb",$this->_useragent))
{
	$this->_browser = "OmniWeb";
	$this->_type = "browser";
	if (eregi("omniweb/4.5",$this->_useragent)) {$this->_browser_version = "4.5";}
	elseif (eregi("omniweb/4.4",$this->_useragent)) {$this->_browser_version = "4.4";}
	elseif (eregi("omniweb/4.3",$this->_useragent)) {$this->_browser_version = "4.3";}
	elseif (eregi("omniweb/4.2",$this->_useragent)) {$this->_browser_version = "4.2";}
	elseif (eregi("omniweb/4.1",$this->_useragent)) {$this->_browser_version = "4.1";}
}
elseif (eregi("opera",$this->_useragent))
{
	$this->_browser = "Opera";
	$this->_type = "browser";
	if ((eregi("opera/7.21",$this->_useragent)) || (eregi("opera 7.21",$this->_useragent))) {$this->_browser_version = "7.21";}
	elseif ((eregi("opera/8.0",$this->_useragent)) || (eregi("opera 8.0",$this->_useragent))) {$this->_browser_version = "8.0";}
	elseif ((eregi("opera/7.60",$this->_useragent)) || (eregi("opera 7.60",$this->_useragent))) {$this->_browser_version = "7.60";}
	elseif ((eregi("opera/7.54",$this->_useragent)) || (eregi("opera 7.54",$this->_useragent))) {$this->_browser_version = "7.54";}
	elseif ((eregi("opera/7.53",$this->_useragent)) || (eregi("opera 7.53",$this->_useragent))) {$this->_browser_version = "7.53";}
	elseif ((eregi("opera/7.52",$this->_useragent)) || (eregi("opera 7.52",$this->_useragent))) {$this->_browser_version = "7.52";}
	elseif ((eregi("opera/7.51",$this->_useragent)) || (eregi("opera 7.51",$this->_useragent))) {$this->_browser_version = "7.51";}
	elseif ((eregi("opera/7.50",$this->_useragent)) || (eregi("opera 7.50",$this->_useragent))) {$this->_browser_version = "7.50";}
	elseif ((eregi("opera/7.23",$this->_useragent)) || (eregi("opera 7.23",$this->_useragent))) {$this->_browser_version = "7.23";}
	elseif ((eregi("opera/7.22",$this->_useragent)) || (eregi("opera 7.22",$this->_useragent))) {$this->_browser_version = "7.22";}
	elseif ((eregi("opera/7.20",$this->_useragent)) || (eregi("opera 7.20",$this->_useragent))) {$this->_browser_version = "7.20";}
	elseif ((eregi("opera/7.11",$this->_useragent)) || (eregi("opera 7.11",$this->_useragent))) {$this->_browser_version = "7.11";}
	elseif ((eregi("opera/7.10",$this->_useragent)) || (eregi("opera 7.10",$this->_useragent))) {$this->_browser_version = "7.10";}
	elseif ((eregi("opera/7.03",$this->_useragent)) || (eregi("opera 7.03",$this->_useragent))) {$this->_browser_version = "7.03";}
	elseif ((eregi("opera/7.02",$this->_useragent)) || (eregi("opera 7.02",$this->_useragent))) {$this->_browser_version = "7.02";}
	elseif ((eregi("opera/7.01",$this->_useragent)) || (eregi("opera 7.01",$this->_useragent))) {$this->_browser_version = "7.01";}
	elseif ((eregi("opera/7.0",$this->_useragent)) || (eregi("opera 7.0",$this->_useragent))) {$this->_browser_version = "7.0";}
	elseif ((eregi("opera/6.12",$this->_useragent)) || (eregi("opera 6.12",$this->_useragent))) {$this->_browser_version = "6.12";}
	elseif ((eregi("opera/6.11",$this->_useragent)) || (eregi("opera 6.11",$this->_useragent))) {$this->_browser_version = "6.11";}
	elseif ((eregi("opera/6.1",$this->_useragent)) || (eregi("opera 6.1",$this->_useragent))) {$this->_browser_version = "6.1";}
	elseif ((eregi("opera/6.	0",$this->_useragent)) || (eregi("opera 6.0",$this->_useragent))) {$this->_browser_version = "6.0";}
	elseif ((eregi("opera/5.12",$this->_useragent)) || (eregi("opera 5.12",$this->_useragent))) {$this->_browser_version = "5.12";}
	elseif ((eregi("opera/5.0",$this->_useragent)) || (eregi("opera 5.0",$this->_useragent))) {$this->_browser_version = "5.0";}
	elseif ((eregi("opera/4",$this->_useragent)) || (eregi("opera 4",$this->_useragent))) {$this->_browser_version = "4";}
}
elseif (eregi("oracle",$this->_useragent))
{
	$this->_browser = "Oracle PowerBrowser";
	$this->_type = "browser";
	if (eregi("(tm)/1.0a",$this->_useragent)) {$this->_browser_version = "1.0a";}
	elseif (eregi("oracle 1.5",$this->_useragent)) {$this->_browser_version = "1.5";}
}
elseif (eregi("phoenix",$this->_useragent))
{
	$this->_browser = "Phoenix";
	$this->_type = "browser";
	if (eregi("phoenix/0.4",$this->_useragent)) {$this->_browser_version = "0.4";}
	elseif (eregi("phoenix/0.5",$this->_useragent)) {$this->_browser_version = "0.5";}
}
elseif (eregi("planetweb",$this->_useragent))
{
	$this->_browser = "PlanetWeb";
	$this->_type = "browser";
	if (eregi("planetweb/2.606",$this->_useragent)) {$this->_browser_version = "2.6";}
	elseif (eregi("planetweb/1.125",$this->_useragent)) {$this->_browser_version = "3";}
}
elseif (eregi("powertv",$this->_useragent))
{
	$this->_browser = "PowerTV";
	$this->_type = "browser";
	if (eregi("powertv/1.5",$this->_useragent)) {$this->_browser_version = "1.5";}
}
elseif (eregi("prodigy",$this->_useragent))
{
	$this->_browser = "Prodigy";
	$this->_type = "browser";
	if (eregi("wb/3.2e",$this->_useragent)) {$this->_browser_version = "3.2e";}
	elseif (eregi("rv: 1.",$this->_useragent)) {$this->_browser_version = "1.0";}
}
elseif ((eregi("voyager",$this->_useragent)) || ((eregi("qnx",$this->_useragent))) && (eregi("rv: 1.",$this->_useragent))) // aj voyager je trosku zlozitejsi na detekciu
{
	$this->_browser = "Voyager";
     $this->_type = "browser";
	if (eregi("2.03b",$this->_useragent)) {$this->_browser_version = "2.03b";}
	elseif (eregi("wb/win32/3.4g",$this->_useragent)) {$this->_browser_version = "3.4g";}
}
elseif (eregi("quicktime",$this->_useragent))
{
	$this->_browser = "QuickTime";
	$this->_type = "browser";
	if (eregi("qtver=5",$this->_useragent)) {$this->_browser_version = "5.0";}
	elseif (eregi("qtver=6.0",$this->_useragent)) {$this->_browser_version = "6.0";}
	elseif (eregi("qtver=6.1",$this->_useragent)) {$this->_browser_version = "6.1";}
	elseif (eregi("qtver=6.2",$this->_useragent)) {$this->_browser_version = "6.2";}
	elseif (eregi("qtver=6.3",$this->_useragent)) {$this->_browser_version = "6.3";}
	elseif (eregi("qtver=6.4",$this->_useragent)) {$this->_browser_version = "6.4";}
	elseif (eregi("qtver=6.5",$this->_useragent)) {$this->_browser_version = "6.5";}
}
elseif (eregi("safari",$this->_useragent))
{
	$this->_browser = "Safari";
	$this->_type = "browser";
	if (eregi("safari/48",$this->_useragent)) {$this->_browser_version = "0.48";}
	elseif (eregi("safari/49",$this->_useragent)) {$this->_browser_version = "0.49";}
	elseif (eregi("safari/51",$this->_useragent)) {$this->_browser_version = "0.51";}
	elseif (eregi("safari/60",$this->_useragent)) {$this->_browser_version = "0.60";}
	elseif (eregi("safari/61",$this->_useragent)) {$this->_browser_version = "0.61";}
	elseif (eregi("safari/62",$this->_useragent)) {$this->_browser_version = "0.62";}
	elseif (eregi("safari/63",$this->_useragent)) {$this->_browser_version = "0.63";}
	elseif (eregi("safari/64",$this->_useragent)) {$this->_browser_version = "0.64";}
	elseif (eregi("safari/65",$this->_useragent)) {$this->_browser_version = "0.65";}
	elseif (eregi("safari/66",$this->_useragent)) {$this->_browser_version = "0.66";}
	elseif (eregi("safari/67",$this->_useragent)) {$this->_browser_version = "0.67";}
	elseif (eregi("safari/68",$this->_useragent)) {$this->_browser_version = "0.68";}
	elseif (eregi("safari/69",$this->_useragent)) {$this->_browser_version = "0.69";}
	elseif (eregi("safari/70",$this->_useragent)) {$this->_browser_version = "0.70";}
	elseif (eregi("safari/71",$this->_useragent)) {$this->_browser_version = "0.71";}
	elseif (eregi("safari/72",$this->_useragent)) {$this->_browser_version = "0.72";}
	elseif (eregi("safari/73",$this->_useragent)) {$this->_browser_version = "0.73";}
	elseif (eregi("safari/74",$this->_useragent)) {$this->_browser_version = "0.74";}
	elseif (eregi("safari/80",$this->_useragent)) {$this->_browser_version = "0.80";}
	elseif (eregi("safari/83",$this->_useragent)) {$this->_browser_version = "0.83";}
	elseif (eregi("safari/84",$this->_useragent)) {$this->_browser_version = "0.84";}
	elseif (eregi("safari/85",$this->_useragent)) {$this->_browser_version = "0.85";}
	elseif (eregi("safari/90",$this->_useragent)) {$this->_browser_version = "0.90";}
	elseif (eregi("safari/92",$this->_useragent)) {$this->_browser_version = "0.92";}
	elseif (eregi("safari/93",$this->_useragent)) {$this->_browser_version = "0.93";}
	elseif (eregi("safari/94",$this->_useragent)) {$this->_browser_version = "0.94";}
	elseif (eregi("safari/95",$this->_useragent)) {$this->_browser_version = "0.95";}
	elseif (eregi("safari/96",$this->_useragent)) {$this->_browser_version = "0.96";}
	elseif (eregi("safari/97",$this->_useragent)) {$this->_browser_version = "0.97";}
	elseif (eregi("safari/125",$this->_useragent)) {$this->_browser_version = "1.25";}
}
elseif (eregi("sextatnt",$this->_useragent))
{
	$this->_browser = "Tango";
	$this->_type = "browser";
	if (eregi("sextant v3.0",$this->_useragent)) {$this->_browser_version = "3.0";}
}
elseif (eregi("sharpreader",$this->_useragent))
{
	$this->_browser = "SharpReader";
	$this->_type = "browser";
	if (eregi("sharpreader/0.9.5",$this->_useragent)) {$this->_browser_version = "0.9.5";}
}
elseif (eregi("elinks",$this->_useragent))
{
	$this->_browser = "ELinks";
	$this->_type = "browser";
	if (eregi("0.3",$this->_useragent)) {$this->_browser_version = "0.3";}
	elseif (eregi("0.4",$this->_useragent)) {$this->_browser_version = "0.4";}
	elseif (eregi("0.9",$this->_useragent)) {$this->_browser_version = "0.9";}
}
elseif (eregi("links",$this->_useragent))
{
	$this->_browser = "Links";
	$this->_type = "browser";
	if (eregi("0.9",$this->_useragent)) {$this->_browser_version = "0.9";}
	elseif (eregi("2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
	elseif (eregi("2.1",$this->_useragent)) {$this->_browser_version = "2.1";}
}
elseif (eregi("lynx",$this->_useragent))
{
	$this->_browser = "Lynx";
	$this->_type = "browser";
	if (eregi("lynx/2.3",$this->_useragent)) {$this->_browser_version = "2.3";}
	elseif (eregi("lynx/2.4",$this->_useragent)) {$this->_browser_version = "2.4";}
	elseif ((eregi("lynx/2.5",$this->_useragent)) || (eregi("lynx 2.5",$this->_useragent))) {$this->_browser_version = "2.5";}
	elseif (eregi("lynx/2.6",$this->_useragent)) {$this->_browser_version = "2.6";}
	elseif (eregi("lynx/2.7",$this->_useragent)) {$this->_browser_version = "2.7";}
	elseif (eregi("lynx/2.8",$this->_useragent)) {$this->_browser_version = "2.8";}
}
elseif (eregi("webexplorer",$this->_useragent))
{
	$this->_browser = "WebExplorer";
	$this->_type = "browser";
	if (eregi("dll/v1.1",$this->_useragent)) {$this->_browser_version = "1.1";}
}
elseif (eregi("wget",$this->_useragent))
{
	$this->_browser = "WGet";
	$this->_type = "browser";
	if (eregi("Wget/1.9",$this->_useragent)) {$this->_browser_version = "1.9";}
	if (eregi("Wget/1.8",$this->_useragent)) {$this->_browser_version = "1.8";}
}
elseif (eregi("webtv",$this->_useragent))
{
	$this->_browser = "WebTV";
	$this->_type = "browser";
	if (eregi("webtv/1.0",$this->_useragent)) {$this->_browser_version = "1.0";}
	elseif (eregi("webtv/1.1",$this->_useragent)) {$this->_browser_version = "1.1";}
	elseif (eregi("webtv/1.2",$this->_useragent)) {$this->_browser_version = "1.2";}
	elseif (eregi("webtv/2.2",$this->_useragent)) {$this->_browser_version = "2.2";}
	elseif (eregi("webtv/2.5",$this->_useragent)) {$this->_browser_version = "2.5";}
	elseif (eregi("webtv/2.6",$this->_useragent)) {$this->_browser_version = "2.6";}
	elseif (eregi("webtv/2.7",$this->_useragent)) {$this->_browser_version = "2.7";}
}
elseif (eregi("yandex",$this->_useragent))
{
	$this->_browser = "Yandex";
	$this->_type = "browser";
	if (eregi("/1.01",$this->_useragent)) {$this->_browser_version = "1.01";}
	elseif (eregi("/1.03",$this->_useragent)) {$this->_browser_version = "1.03";}
}
elseif ((eregi("mspie",$this->_useragent)) || ((eregi("msie",$this->_useragent))) && (eregi("windows ce",$this->_useragent)))
{
	$this->_browser = "Pocket Internet Explorer";
	$this->_type = "browser";
	if (eregi("mspie 1.1",$this->_useragent)) {$this->_browser_version = "1.1";}
	elseif (eregi("mspie 2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
	elseif (eregi("msie 3.02",$this->_useragent)) {$this->_browser_version = "3.02";}
}
elseif (eregi("UP.Browser/",$this->_useragent))
{
	$this->_browser = "UP Browser";
	$this->_type = "browser";
	if (eregi("Browser/7.0",$this->_useragent)) {$this->_browser_version = "7.0";}
    }
    elseif (eregi("msie",$this->_useragent))
    {
      $this->_browser = "Internet Explorer";
      $this->_type = "browser";
      if (eregi("msie 7.0",$this->_useragent)) {$this->_browser_version = "7.0";}
      elseif (eregi("msie 6.0",$this->_useragent)) {$this->_browser_version = "6.0";}
      elseif (eregi("msie 5.5",$this->_useragent)) {$this->_browser_version = "5.5";}
      elseif (eregi("msie 5.01",$this->_useragent)) {$this->_browser_version = "5.01";}
      elseif (eregi("msie 5.23",$this->_useragent)) {$this->_browser_version = "5.23";}
      elseif (eregi("msie 5.22",$this->_useragent)) {$this->_browser_version = "5.22";}
      elseif (eregi("msie 5.2.2",$this->_useragent)) {$this->_browser_version = "5.2.2";}
      elseif (eregi("msie 5.1b1",$this->_useragent)) {$this->_browser_version = "5.1b1";}
      elseif (eregi("msie 5.17",$this->_useragent)) {$this->_browser_version = "5.17";}
      elseif (eregi("msie 5.16",$this->_useragent)) {$this->_browser_version = "5.16";}
      elseif (eregi("msie 5.12",$this->_useragent)) {$this->_browser_version = "5.12";}
      elseif (eregi("msie 5.0b1",$this->_useragent)) {$this->_browser_version = "5.0b1";}
      elseif (eregi("msie 5.0",$this->_useragent)) {$this->_browser_version = "5.0";}
      elseif (eregi("msie 5.21",$this->_useragent)) {$this->_browser_version = "5.21";}
      elseif (eregi("msie 5.2",$this->_useragent)) {$this->_browser_version = "5.2";}
      elseif (eregi("msie 5.15",$this->_useragent)) {$this->_browser_version = "5.15";}
      elseif (eregi("msie 5.14",$this->_useragent)) {$this->_browser_version = "5.14";}
      elseif (eregi("msie 5.13",$this->_useragent)) {$this->_browser_version = "5.13";}
      elseif (eregi("msie 4.5",$this->_useragent)) {$this->_browser_version = "4.5";}
      elseif (eregi("msie 4.01",$this->_useragent)) {$this->_browser_version = "4.01";}
      elseif (eregi("msie 4.0b2",$this->_useragent)) {$this->_browser_version = "4.0b2";}
      elseif (eregi("msie 4.0b1",$this->_useragent)) {$this->_browser_version = "4.0b1";}
      elseif (eregi("msie 4",$this->_useragent)) {$this->_browser_version = "4.0";}
      elseif (eregi("msie 3",$this->_useragent)) {$this->_browser_version = "3.0";}
      elseif (eregi("msie 2",$this->_useragent)) {$this->_browser_version = "2.0";}
      elseif (eregi("msie 1.5",$this->_useragent)) {$this->_browser_version = "1.5";}
    }
    elseif (eregi("iexplore",$this->_useragent))
    {
      $this->_browser = "Internet Explorer";
      $this->_type = "browser";
    }
    elseif (eregi("mozilla",$this->_useragent))
    {
      $this->_browser = "Netscape";
      $this->_type = "browser";
      if (eregi("mozilla/4.8",$this->_useragent)) {$this->_browser_version = "4.8";}
      elseif (eregi("mozilla/4.7",$this->_useragent)) {$this->_browser_version = "4.7";}
      elseif (eregi("mozilla/4.6",$this->_useragent)) {$this->_browser_version = "4.6";}
      elseif (eregi("mozilla/4.5",$this->_useragent)) {$this->_browser_version = "4.5";}
      elseif (eregi("mozilla/4.0",$this->_useragent)) {$this->_browser_version = "4.0";}
      elseif (eregi("mozilla/3.0",$this->_useragent)) {$this->_browser_version = "3.0";}
      elseif (eregi("mozilla/2.0",$this->_useragent)) {$this->_browser_version = "2.0";}
    }
  }

}

class XoopsvisitVisitHandler extends XoopsPersistableObjectHandler{

  function XoopsvisitVisitHandler($db){
    parent::XoopsPersistableObjectHandler($db, 'visit', 'XoopsVisit', 'visit_id');
  }

  /**
   * Manage the online user
   *
   * @return  array
   */
  function getOnline(){
    global $xoopsUser, $xoopsModule;
    // Use online table for current stats
    $online_handler =& xoops_gethandler('online');
    mt_srand((double)microtime()*1000000);
    if (mt_rand(1, 100) < 11) { // 11 % de taux de refresh
      $online_handler->gc(300); // 300 secondes
    }
    if (is_object($xoopsUser)) {
      $uid = $xoopsUser->getVar('uid');
      $uname = $xoopsUser->getVar('uname');
    } else {
      $uid = 0;
      $uname = '';
    }
    // Write log in online table
    if (is_object($xoopsModule)) {
      $online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
    } else {
      $online_handler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
    }
    // Get all online user
    $onlines = $online_handler->getAll();
    if (false != $onlines) {
      $total = count($onlines);
      $guests = 0;
      $members = 0;
      for ($i = 0; $i < $total; $i++) {
        if ($onlines[$i]['online_uid'] > 0) {
          $members++;
        } else {
          $guests++;
        }
      }
    }
    $online['total']    = $total;
    $online['guests']   = $guests;
    $online['members']  = $members;
    return $online;
  }
}
?>