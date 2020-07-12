<?php
/**
 * Module collector block
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
include_once XOOPS_ROOT_PATH.'/modules/xoopsvisit/include/functions.php';

function xoopsvisit_collector() {
  // Initialize xoopsvisit handler
  $visit_handler = xoops_getmodulehandler('visit', 'xoopsvisit');
  // Get time setting for cookie
  $time_conf = xoopsvisit_loadSetting('xv_time_conf');
  // Search if the cookie exist
  if(!isset($_COOKIE['xv-cookie'])){
    // If no cookie, create the cookie
    setcookie('xv-cookie', date('dmYHi'), time()+($time_conf), '/');
    // Create a record for this visit
    $visit =& $visit_handler->create();
    $visit->setVar('visit_referer', $visit->_referer);
    $visit->setVar('visit_useragent', $visit->_useragent);
    $visit->setVar('visit_ip', $visit->getIp());   
    $visit->setVar('visit_robot', ($visit->_type=='robot') ? 1 : 0);
    $visit->setVar('visit_date', date('Ymd'));
    $visit->setVar('visit_time', strftime('%H:%M:%S'));
    // Insert value to MySQL database
    $visit_handler->insert($visit, true);
  }
  // return NULL for have an invisble block
  return '';
}
?>