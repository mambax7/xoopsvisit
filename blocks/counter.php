<?php
/**
 * Module counter block
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
function xoopsvisit_counter_show($options){
  global $xoTheme;
  $block = array();
  //
  $xoTheme->addStylesheet(XOOPS_URL.'/modules/xoopsvisit/css/style.css', null);
  // Initialize xoopsvisit handler
  $visit_handler = xoops_getmodulehandler('visit', 'xoopsvisit');
  // Get setting for robot
  $count_robot = xoopsvisit_loadSetting('xv_robot_count');
  // Construct the block array  
  if($options[0]){  // Display the total visit
    // Get the total
    if(!$count_robot){
      $crietria = new Criteria('visit_robot', 0);
    } else {
      $criteria = null;
    }
    $total = $visit_handler->getCount($crietria) + $options[10];
    // Get image directory
    $directory = $options[2];
    $img_ext = getImageExtension($directory);
    // Count the number of digit for the total
    $min_digit  = intval($options[1]);
    $nb_digit   = strlen($total);
    // Add some zero before for have the min digit size
    if($min_digit && $nb_digit < $min_digit) {
      $diff = $min_digit - $nb_digit;
      for ($i = 0; $i < $diff; $i++) {
        $total = "0" . $total;
      }
      $nb_digit = $min_digit;
    }
    // add total counter to block array
    $block['total_lng'] = _XV_BLK_TOTAL;
    $block['total_img'] = '';
    for ($i = 0; $i < $nb_digit; $i++) {
      $digit = substr($total, $i, 1);
      $block['total_img'] .= "<img src='".XOOPS_URL."/modules/xoopsvisit/images/templates/".$directory."/".$digit.".".$img_ext."' alt='".$total._XV_BLK_VISIT."' title='".$total._XV_BLK_VISIT."' />";
    }
  }
  if($options[3]){  // Display the total for the current date visit
    // Get the total for today
    $criteria = new CriteriaCompo();
    if(!$count_robot){
      $crietria = new Criteria('visit_robot', 0);
    }
    $criteria->add(new Criteria('visit_robot', 0));
    $criteria->add(new Criteria('visit_date', date('Ymd')));
    $today = $visit_handler->getCount($criteria);
    // Get image directory
    $directory = $options[5];
    $img_ext = getImageExtension($directory);
    // Count the number of digit for the total
    $min_digit  = intval($options[4]);
    $nb_digit   = strlen($today);
    // Add some zero before for have the min digit size
    if($min_digit && $nb_digit < $min_digit) {
      $diff = $min_digit - $nb_digit;
      for ($i = 0; $i < $diff; $i++) {
        $today = "0" . $today;
      }
      $nb_digit = $min_digit;
    }
    // add total counter to block array
    $block['today_lng'] = _XV_BLK_TODAY;
    $block['today_img'] = '';
    for ($i = 0; $i < $nb_digit; $i++) {
      $digit = substr($today, $i, 1);
      $block['today_img'] .= "<img src='".XOOPS_URL."/modules/xoopsvisit/images/templates/".$directory."/".$digit.".".$img_ext."' alt='".$today._XV_BLK_VISIT."' title='".$today._XV_BLK_VISIT."' />";
    }
  }
  if($options[6]){  // Display the user visit for the current date visit
    // Get the total for today
    $visit = new XoopsVisit();
    $criteria = new CriteriaCompo();
    if(!$count_robot){
      $crietria = new Criteria('visit_robot', 0);
    }
    $criteria->add(new Criteria('visit_date', date('Ymd')));
    $criteria->add(new Criteria('visit_ip', $visit->getIP()));
    $criteria->add(new Criteria('visit_useragent', $visit->_useragent));
    $user = $visit_handler->getCount($criteria);
    // Get image directory
    $directory = $options[8];
    $img_ext = getImageExtension($directory);
    // Count the number of digit for the total
    $min_digit  = intval($options[7]);
    $nb_digit   = strlen($user);
    // Add some zero before for have the min digit size
    if($min_digit && $nb_digit < $min_digit) {
      $diff = $min_digit - $nb_digit;
      for ($i = 0; $i < $diff; $i++) {
        $user = "0" . $user;
      }
      $nb_digit = $min_digit;
    }
    // add total counter to block array
    $block['user_lng'] = _XV_BLK_USER;
    $block['user_img'] = '';
    for ($i = 0; $i < $nb_digit; $i++) {
      $digit = substr($user, $i, 1);
      $block['user_img'] .= "<img src='".XOOPS_URL."/modules/xoopsvisit/images/templates/".$directory."/".$digit.".".$img_ext."' alt='".$user._XV_BLK_VISIT."' title='".$user._XV_BLK_VISIT."' />";
    }
  }
  if($options[9]){ // Display online information
    $online = $visit_handler->getOnline();
    $block['online_total']  = sprintf(_ONLINEPHRASE, '<span class="bold">'.$online['total'].'</span>');
    $block['online_guests'] = $online['guests'];
    $block['online_members']= $online['members'];
    $block['lang_members']  = _MEMBERS;
    $block['lang_guests']   = _GUESTS;
  }
  // Just an adds for ForXoops site :-)
  //$block['link'] = "<div class='hide'>Xoops*Visit is developed by MusS (http://xoops.foreach.fr/)</div>";
  
  return $block;
}

function xoopsvisit_counter_edit($options){
  include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
  // Get the list of directory which contains images
  $dirlist = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH.'/modules/xoopsvisit/images/templates/');
  
  $form = "<div class='bold'>Total counter:</div>";
  $form .= "<table><tr>";
  $form .= "<td class='width20'>"._XV_BLK_DISPLAY."</td><td>";
  $chk = "";
  if ($options[0]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[0]' value='1'".$chk." /> "._YES."&nbsp;";
  $chk = "";
  if ($options[0]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[0]' value='0' /> "._NO;
  $form .= "</td>";
  $form .= "</tr><tr>";
  $form .= "<td class='width20'>"._XV_BLK_NBDIGIT."</td><td><input type='text' name='options[1]' value='".$options[1]."' /></td>";
  $form .= "</tr><tr>";
  $form .= "<td class='width20'>"._XV_BLK_IMAGE."</td><td><select name='options[2]'>";
  foreach($dirlist as $dir){
    $form .= "<option value='".$dir."'";
    if ($options[2] == $dir) $form .= " selected='selected'";
    $form .= ">".$dir."</option>\n";
  } 
  $form .= "</select></td>";
  $form .= "</table>";
  $form .= "<br />";
  
  $form .= "<div class='bold'>Today counter:</div>";
  $form .= "<table><tr>";
  $form .= "<td class='width20'>"._XV_BLK_DISPLAY."</td><td>";
  $chk = "";
  if ($options[3]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[3]' value='1'".$chk." /> "._YES."&nbsp;";
  $chk = "";
  if ($options[3]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[3]' value='0' /> "._NO;
  $form .= "</td>";
  $form .= "</tr><tr>";
  $form .= "<td class='width20'>"._XV_BLK_NBDIGIT."</td><td><input type='text' name='options[4]' value='".$options[4]."' /></td>";
  $form .= "</tr><tr>";
  $form .= "<td class='width20'>"._XV_BLK_IMAGE."</td><td><select name='options[5]'>";
  foreach($dirlist as $dir){
    $form .= "<option value='".$dir."'";
    if ($options[5] == $dir) $form .= " selected='selected'";
    $form .= ">".$dir."</option>\n";
  } 
  $form .= "</select></td>";
  $form .= "</table>";
  $form .= "<br />";
  
  $form .= "<div class='bold'>User counter:</div>";
  $form .= "<table><tr>";
  $form .= "<td class='width20'>"._XV_BLK_DISPLAY."</td><td>";
  $chk = "";
  if ($options[6]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[6]' value='1'".$chk." /> "._YES."&nbsp;";
  $chk = "";
  if ($options[6]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[6]' value='0' /> "._NO;
  $form .= "</td>";
  $form .= "</tr><tr>";
  $form .= "<td class='width20'>"._XV_BLK_NBDIGIT."</td><td><input type='text' name='options[7]' value='".$options[7]."' /></td>";
  $form .= "</tr><tr>";
  $form .= "<td class='width20'>"._XV_BLK_IMAGE."</td><td><select name='options[8]'>";
  foreach($dirlist as $dir){
    $form .= "<option value='".$dir."'";
    if ($options[8] == $dir) $form .= " selected='selected'";
    $form .= ">".$dir."</option>\n";
  } 
  $form .= "</select></td>";
  $form .= "</table>";
  $form .= "<br />";
  
  $form .= "<div class='bold'>Online counter:</div>";
  $form .= "<table><tr>";
  $form .= "<td class='width20'>"._XV_BLK_DISPLAY."</td><td>";
  $chk = "";
  if ($options[9]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[9]' value='1'".$chk." /> "._YES."&nbsp;";
  $chk = "";
  if ($options[9]) $chk = " checked='checked'";
  $form .= "<input type='radio' name='options[9]' value='0' /> "._NO;
  $form .= "</td></tr></table>";
  $form .= _XV_BLK_OLDCOUNTER.'&nbsp;<input type="text" name="options[10]" value="'.$options[10].'" />';

  return $form;
}

?>
