<?php
/**
 * Modules internal functions
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
 * @since       2.0.18
 * @version     $Id:
 */
if (!defined('XOOPS_ROOT_PATH')) die();
/**
 * XOOPS language loader wrapper
 *
 * Temporay solution, not encouraged to use
 *
 * @param   string  $name       Name of language file to be loaded, without extension
 * @param   string  $domain     Module dirname; global language file will be loaded if $domain is set to 'global' or not specified
 * @param   string  $language   Language to be loaded, current language content will be loaded if not specified
 * @return  boolean
 * @todo    expand domain to multiple categories, e.g. module:system, framework:filter, etc.
 *
 */
function xoopsvisit_loadLanguage( $name, $domain = '', $language = null ) 
{
    $language = empty($language) ? $GLOBALS['xoopsConfig']['language'] : $language;
    $path = XOOPS_ROOT_PATH . '/' . ( (empty($domain) || 'global' == $domain) ? '' : "modules/{$domain}/" ) . 'language';
    if ( !( $ret = @include_once "{$path}/{$language}/{$name}.php" ) ) {
        $ret = include_once "{$path}/english/{$name}.php";
    }
    return $ret;
}

/**
 * Returns a module's option
 *
 * @author    Instant Zero (http://xoops.instant-zero.com)
 * @copyright (c) Instant Zero
 *
 * @param   string  $option	    module option's name
 * @param   string  $repmodule  module directory
 *
 * @return  string  setting value
 */
function xoopsvisit_loadSetting($option, $repmodule='xoopsvisit'){
  global $xoopsModuleConfig, $xoopsModule;
  static $tbloptions= Array();
  if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
    return $tbloptions[$option];
  }
  $retval = false;
  if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
    if(isset($xoopsModuleConfig[$option])) {
      $retval= $xoopsModuleConfig[$option];
    }
  } else {
    $module_handler =& xoops_gethandler('module');
    $module =& $module_handler->getByDirname($repmodule);
    $config_handler =& xoops_gethandler('config');
    if ($module) {
      $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
      if(isset($moduleConfig[$option])) {
        $retval= $moduleConfig[$option];
      }
    }
  }
  $tbloptions[$option]=$retval;
  return $retval;
}

function getImageExtension($image_folder){
  $rep = XOOPS_ROOT_PATH."/modules/xoopsvisit/images/templates/".$image_folder."/";
  $dir = opendir($rep);
  $ext = '';
  while ($f = readdir($dir)) {
    if(is_file($rep.$f)) {
      $ext = getExtension($f);
      if ($ext != '') {
        closedir($dir);
        return $ext;
      }
    }
  }
  closedir($dir);
  return $ext;
}

function getExtension ($file){
  $tab = explode(".",$file);
  // retourne les caractere apres le dernier .
  return $tab[count($tab)-1];
}
?>
