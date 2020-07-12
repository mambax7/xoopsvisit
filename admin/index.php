<?php
/**
 * Modules home administration
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

// Include module header
require_once 'header.php';
// Display header page
xoops_cp_header();
// Display tab navigation
$menu_handler->render( 0 );
// Initialize visit handler
$visit_handler = xoops_getmodulehandler( 'visit' );
// Count total
$total = $visit_handler->getCount();
// Count robot
$criteria = new Criteria('visit_robot', 1);
$robot = $visit_handler->getCount($criteria);
// Count today
$criteria = new Criteria('visit_date', date('Ymd'));
$today = $visit_handler->getCount($criteria);
// Count today without robot
$criteria = new CriteriaCompo(new Criteria('visit_date', date('Ymd')));
$criteria->add(new Criteria('visit_robot', 0));
$today_nrobot = $visit_handler->getCount($criteria);
// Initialize admin template
$tpl = new XoopsTpl();
// Assign general value
$tpl->assign('total', $total);
$tpl->assign('total_nrobot', $total-$robot);
$tpl->assign('robot', $robot);
$tpl->assign('today', $today);
$tpl->assign('today_nrobot', $today_nrobot);
// Assign charts value
$tpl->assign('chart_path', '../swf/ampie');
$tpl->assign('chart_file', 'ampie.swf');
$tpl->assign('chart_id', 'ampie');
$tpl->assign('chart_width', '400');
$tpl->assign('chart_height', '300');
$tpl->assign('chart_settingfile', '../swf/conf/ampie_settings.xml');
$tpl->assign('chart_data', _XOOPSVISIT_TOTAL.';'.($total-$robot).';true\n'._XOOPSVISIT_ROBOT.';'.$robot);
// Define stylesheet
$tpl->assign('stylesheet', '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getInfo('dirname').'/css/style.css">');
// Call template
echo $tpl->fetch(XOOPS_ROOT_PATH.'/modules/' . $xoopsModule->getVar('dirname','e') . '/admin/templates/admin_index.html');
// Display footer page
xoops_cp_footer();
?>