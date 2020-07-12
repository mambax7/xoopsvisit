<?php
/**
 * @copyright   The Xoops Project http://sourceforge.net/projects/xoops/
 * @license     http://www.gnu.org/licenses/gpl.txt GNU General Public License (GPL)
 * @package     xoopsvisit
 */

// Main
$modversion['name']                   = _XOOPSVISIT_MODULE_NAME;
$modversion['version']                = '1.1';
$modversion['description']            = _XOOPSVISIT_MODULE_DESC;
$modversion['credits']                = 'MusS';
$modversion['author']                 = 'MusS';
$modversion['help']                   = '';
$modversion['license']                = 'http://www.gnu.org/licenses/gpl.txt';
$modversion['official']               = '0';
$modversion['image']                  = 'xoopsvisit.png';
$modversion['dirname']                = 'xoopsvisit';
// XoopsInfo
$modversion['developer_website_url'] 	= 'http://xoops.foreach.fr';
$modversion['developer_website_name']	= 'ForXoops';
$modversion['download_website']		    = 'http://xoops.foreach.fr/modules/wfdownloads/viewcat.php?cid=1';
$modversion['status_fileinfo'] 		    = 'http://xoops.foreach.fr/xoopsvisit.ini';
$modversion['demo_site_url']		      = 'http://xoops.foreach.fr';
$modversion['demo_site_name']		      = 'ForXoops';
$modversion['support_site_url']		    = 'http://www.frxoops.org';
$modversion['support_site_name']	    = 'Xoops France';
$modversion['submit_bug']		          = 'http://www.frxoops.org/modules/newbb/';
$modversion['submit_feature'] 		    = 'http://www.frxoops.org/modules/newbb/';
// SQL File & tables
$modversion['sqlfile']['mysql']       = 'sql/mysql.sql';
$modversion['tables'][1]              = 'visit';
// Update
$modversion['onUpdate']               = 'include/update.php';
// Admin
$modversion['hasAdmin']               = 1;
$modversion['adminindex']             = 'admin/index.php';
$modversion['adminmenu']              = 'admin/menu.php';
// Menus
$modversion['hasMain']                = 0;
// Templates
$i=1;
$modversion['templates'][$i]['file']       = 'xoopsvisit_charts.html';
$modversion['templates'][$i]['description']= '';

// Blocks
$i=1;
$modversion['blocks'][$i]['file']         = "collector.php";
$modversion['blocks'][$i]['name']         = _XOOPSVISIT_COLLECTOR;
$modversion['blocks'][$i]['description']  = _XOOPSVISIT_COLLECTOR_DESC;
$modversion['blocks'][$i]['show_func']    = "xoopsvisit_collector";
$modversion['blocks'][$i]['template']     = "xoopsvisit_collector.html";
$i++;
$modversion['blocks'][$i]['file']         = "counter.php";
$modversion['blocks'][$i]['name']         = _XOOPSVISIT_COUNTER;
$modversion['blocks'][$i]['description']  = _XOOPSVISIT_COUNTER_DESC;
$modversion['blocks'][$i]['show_func']    = "xoopsvisit_counter_show";
$modversion['blocks'][$i]['edit_func']    = "xoopsvisit_counter_edit";
$modversion['blocks'][$i]['options']      = "1|6|small|1|6|small|1|6|small|1|0";
$modversion['blocks'][$i]['template']     = "xoopsvisit_counter.html";
// Setting
$i=1;
$modversion['config'][$i]['name']       = 'xv_robot_count';
$modversion['config'][$i]['title']      = '_XOOPSVISIT_ROBOTS';
$modversion['config'][$i]['description']= '_XOOPSVISIT_ROBOTS_DESC';
$modversion['config'][$i]['formtype']   = 'yesno';
$modversion['config'][$i]['valuetype']  = 'int';
$modversion['config'][$i]['default']    = '0';
$i++;
$modversion['config'][$i]['name']       = 'xv_time_conf';
$modversion['config'][$i]['title']      = '_XOOPSVISIT_TIME_CONF';
$modversion['config'][$i]['description']= '_XOOPSVISIT_TIME_CONF_DESC';
$modversion['config'][$i]['formtype']   = 'textbox';
$modversion['config'][$i]['valuetype']  = 'text';
$modversion['config'][$i]['default']    = '3600';
?>
