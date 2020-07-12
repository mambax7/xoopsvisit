<?php
/**
 * Module administration header file
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
include_once '../../../mainfile.php';
// Xoops class
include_once XOOPS_ROOT_PATH . '/class/template.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsmodule.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
// Include class
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';
// Module functions and class
include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname', 'e') . '/include/functions.php';
include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname', 'e') . '/class/visit.php';
// Include language file
xoopsvisit_loadLanguage('admin', 'system');
xoopsvisit_loadLanguage('admin', $xoopsModule->getVar('dirname', 'e'));
xoopsvisit_loadLanguage('modinfo', $xoopsModule->getVar('dirname', 'e'));
// Get menu tab handler
$menu_handler = &xoops_getmodulehandler( 'menu' );
// Define top navigation
$menu_handler->addMenuTop( XOOPS_URL . "/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid', 'e'), _XOOPSVISIT_PREFERENCES );
$menu_handler->addMenuTop( XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=" . $xoopsModule->getVar('dirname', 'e'), _XOOPSVISIT_UPDATE );
// Define main tab navigation
foreach ( $xoopsModule->getAdminMenu() as $menu ) {
  $menu_handler->addMenuTabs( $menu['link'], $menu['title'] );
}
?>
