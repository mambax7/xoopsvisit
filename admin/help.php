<?php
/**
 * @copyright   The Xoops Project http://sourceforge.net/projects/xoops/
 * @license     http://www.gnu.org/licenses/gpl.txt GNU General Public License (GPL)
 * @package     xoopsvisit
 */

// Include module header
require_once 'header.php';
// Display header page
xoops_cp_header();
// Display tab navigation
$menu_handler->render( 1 );
// Initialize Template
$tpl = new XoopsTpl();
$tpl->assign('module_name', $xoopsModule->getVar('name'));
$tpl->assign('module_version', $xoopsModule->getInfo('version'));
$tpl->assign('module_author', $xoopsModule->getInfo('author'));
$tpl->assign('stylesheet', '<link rel="stylesheet" type="text/css" media="all" href="' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'e') . '/css/admin.css">');
// Call template
if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname', 'e') . '/language/' . $xoopsConfig['language'] . '/help.html') ) {
  echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname', 'e') . '/language/' . $xoopsConfig['language'] . '/help.html');
}else{
  echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname', 'e') . '/language/english/help.html');
}
// Display footer page
xoops_cp_footer();
?>
