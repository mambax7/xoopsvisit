<?php
/**
 * @copyright   The Xoops Project http://sourceforge.net/projects/xoops/
 * @license     http://www.gnu.org/licenses/gpl.txt GNU General Public License (GPL)
 * @package     content
 */

if(!defined('XOOPS_ROOT_PATH')) exit ;

function xoops_module_update_xoopsvisit(&$module) {
  global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModule;
  
  if(!TableExists($xoopsDB->prefix('visit'))){
    include_once XOOPS_ROOT_PATH.'/class/database/sqlutility.php';
    $reservedTables = array('avatar', 'avatar_users_link', 'block_module_link', 'xoopscomments', 'config', 'configcategory', 'configoption', 'image', 'imagebody', 'imagecategory', 'imgset', 'imgset_tplset_link', 'imgsetimg', 'groups','groups_users_link','group_permission', 'online', 'bannerclient', 'banner', 'bannerfinish', 'priv_msgs', 'ranks', 'session', 'smiles', 'users', 'newblocks', 'modules', 'tplfile', 'tplset', 'tplsource', 'xoopsnotifications', 'banner', 'bannerclient', 'bannerfinish');
    $sql_file = $module->getInfo('sqlfile');
    $sql_file_path = XOOPS_ROOT_PATH.'/modules/xoopsvisit/'.$sql_file['mysql'];
    $sql_query = fread(fopen($sql_file_path, 'r'), filesize($sql_file_path));
    $sql_query = trim($sql_query);
    SqlUtility::splitMySqlFile($pieces, $sql_query);
    $created_tables = array();
    foreach ($pieces as $piece) {
        // [0] contains the prefixed query
        // [4] contains unprefixed table name
        $prefixed_query = SqlUtility::prefixQuery($piece, $xoopsDB->prefix());
        if (!$prefixed_query) {
            $errs[] = "<b>$piece</b> is not a valid SQL!";
            $error = true;
            break;
        }
        // check if the table name is reserved
        if (!in_array($prefixed_query[4], $reservedTables)) {
            // not reserved, so try to create one
            if (!$xoopsDB->query($prefixed_query[0])) {
                $errs[] = $xoopsDB->error();
                $error = true;
                break;
            } else {

                if (!in_array($prefixed_query[4], $created_tables)) {
                    $msgs[] = '&nbsp;&nbsp;Table <b>'.$xoopsDB->prefix($prefixed_query[4]).'</b> created.';
                    $created_tables[] = $prefixed_query[4];
                } else {
                    $msgs[] = '&nbsp;&nbsp;Data inserted to table <b>'.$xoopsDB->prefix($prefixed_query[4]).'</b>.';
                }
            }
        } else {
            // the table name is reserved, so halt the installation
            $errs[] = '<b>'.$prefixed_query[4]."</b> is a reserved table!";
            $error = true;
            break;
        }
    }
    // if there was an error, delete the tables created so far, so the next installation will not fail
    if ($error == true) {
        foreach ($created_tables as $ct) {
            //echo $ct;
            $xoopsDB->query("DROP TABLE ".$xoopsDB->prefix($ct));
        }
    }
  }
  
  if (TableExists($xoopsDB->prefix('xv_count'))) {
    $result = $xoopsDB->queryF("DROP TABLE `".$xoopsDB->prefix('xv_count')."`;");
  }
  return true;
}

function FieldExists($fieldname, $table) {
	global $xoopsDB;
	$result=$xoopsDB->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");
	return($xoopsDB->getRowsNum($result) > 0);
}

function TableExists($tablename) {
	global $xoopsDB;
	$result=$xoopsDB->queryF("SHOW TABLES LIKE '$tablename'");
	return($xoopsDB->getRowsNum($result) > 0);
}
?>
