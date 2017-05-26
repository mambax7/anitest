<?php
// -------------------------------------------------------------------------

use Xmf\Request;

require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_tools.tpl';
include XOOPS_ROOT_PATH . '/header.php';

global $field;

// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/class_field.php';
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('index.php', 3, _NOPERM . '<br>' . _PED_REGIST);
}

//add JS routines
echo '<script language="JavaScript" src="picker.js"></script>';

//set form to be empty
$form = '';

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

//if (isset($_GET['op'])) {
//    $op = $_GET['op'];
//} else {
//    $op = 'none';
//}

$op = Request::getCmd('op', 'none', 'GET');

//always check to see if a certain field was refferenced.
if (isset($_GET['field'])) {
    $field = $_GET['field'];
}

switch ($op) {
    case 'lang':
        lang();
        break;
    case 'langsave':
        langsave();
        break;
    case 'colours':
        colours();
        break;
    case 'savecolours':
        savecolours();
        break;
    case 'settings':
        settings();
        break;
    case 'settingssave':
        settingssave();
        break;
    case 'pro':
        pro();
        break;
    case 'userfields':
        userfields($field);
        $uf = true;
        break;
    case 'listuserfields':
        listuserfields();
        $uf = true;
        break;
    //    case 'togglelocked':
    //        togglelocked($field);
    //        break;
    case 'fieldmove':
        fieldmove($field, $_GET['move']);
        break;
    case 'deluserfield':
        deluserfield($_GET['id']);
        break;
    case 'restoreuserfield':
        restoreuserfield($_GET['id']);
        break;
    case 'editlookup':
        editlookup($_GET['id']);
        break;
    case 'lookupmove':
        lookupmove($field, $_GET['id'], $_GET['move']);
        break;
    case 'dellookupvalue':
        dellookupvalue($field, $_GET['id']);
        break;
    case 'addlookupvalue':
        addlookupvalue($field);
        break;
    case 'editlookupvalue':
        editlookupvalue($field, $_GET['id']);
        break;
    case 'savelookupvalue':
        savelookupvalue($field, $_GET['id']);
        break;
    case 'deleted':
        deleted();
        break;
    case 'delperm':
        delperm($_GET['id']);
        break;
    case 'delall':
        delall();
        break;
    case 'restore':
        restore($_GET['id']);
        break;
    case 'database':
        database();
        $db = true;
        break;
    case 'userq':
        userq();
        $db = true;
        break;
    case 'userqrun':
        userqrun($_GET['f']);
        $db = true;
        break;
    case 'dbanc':
        database_oa();
        $db = true;
        break;
    case 'fltypar':
        database_fp();
        $db = true;
        break;
    case 'credits':
        credits();
        break;
    case 'index':
        index();
        break;
    case 'online':
        online();
        break;
    default:
        userfields();
        $uf = true;
        break;
}

//create tools array
$tools[] = array('title' => 'General settings', 'link' => 'tools.php?op=settings', 'main' => '1');
//if ($moduleConfig['proversion'] == '1')
//{
//	$tools[] = array ( 'title' => "Pro-version settings", 'link' => "tools.php?op=pro", 'main' => "1" );
//}
$tools[] = array('title' => 'Language options', 'link' => 'tools.php?op=lang', 'main' => '1');
$tools[] = array('title' => 'Create user fields', 'link' => 'tools.php?op=userfields', 'main' => '1');
if (isset($uf)) {
    $tools[] = array('title' => 'List userfields', 'link' => 'tools.php?op=listuserfields', 'main' => '0');
}
$tools[] = array('title' => 'Create colours', 'link' => 'tools.php?op=colours', 'main' => '1');
$tools[] = array('title' => "Deleted pedigree's", 'link' => 'tools.php?op=deleted', 'main' => '1');
$tools[] = array('title' => 'Database tools', 'link' => 'tools.php?op=database', 'main' => '1');
if (isset($db)) {
    //create database submenu
    $tools[] = array('title' => 'Own ancestors', 'link' => 'tools.php?op=dbanc', 'main' => '0');
    $tools[] = array('title' => 'Incorrect gender', 'link' => 'tools.php?op=fltypar', 'main' => '0');
    $tools[] = array('title' => 'User Queries', 'link' => 'tools.php?op=userq', 'main' => '0');
}
$tools[] = array('title' => "Who's online", 'link' => 'tools.php?op=online', 'main' => '1');
$tools[] = array('title' => 'Credits', 'link' => 'tools.php?op=credits', 'main' => '1');
$tools[] = array('title' => 'Logout', 'link' => '../../user.php?op=logout', 'main' => '1');
//add data (form) to smarty template

$xoopsTpl->assign('tools', $tools);

//footer
include XOOPS_ROOT_PATH . '/footer.php';

function index()
{
    $form = '';
}

function colours()
{
    global $xoopsTpl, $moduleConfig;

    $colors  = explode(';', $moduleConfig['colourscheme']);
    $actlink = $colors[0];
    $even    = $colors[1];
    $odd     = $colors[2];
    $text    = $colors[3];
    $hovlink = $colors[4];
    $head    = $colors[5];
    $body    = $colors[6];
    $title   = $colors[7];

    $form = 'Use the fields below to change the colours of the pedigree database. We advice choosing a very light colour for the "Pedigree background colur".<hr>';
    $form .= '<FORM NAME="myForm" action=\'tools.php?op=savecolours\' method=\'POST\'>
	<table><tr><td>Text colour :</td><td><INPUT TYPE="text" id="text" name="text" value="' . $text . '" size="11" maxlength="7">
	<a href="javascript:TCP.popup(document.forms[\'myForm\'].elements[\'text\'])">
	<img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td></tr>

	
	<tr><td>Link colour :</td><td><INPUT TYPE="text" id="actlink" name="actlink" value="' . $actlink . '" size="11" maxlength="7">
	<a href="javascript:TCP.popup(document.forms[\'myForm\'].elements[\'actlink\'])">
	<img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td></tr>

	
	<tr><td>Pedigree background colour :</td><td><INPUT TYPE="text" id="even" name="even" value="' . $even . '" size="11" maxlength="7">
	<a href="javascript:TCP.popup(document.forms[\'myForm\'].elements[\'even\'])">
	<img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td></tr>

	
	<tr><td>Body background colour :</td><td><INPUT TYPE="text" id="body" name="body" value="' . $body . '" size="11" maxlength="7">
	<a href="javascript:TCP.popup(document.forms[\'myForm\'].elements[\'body\'])">
	<img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td></tr>
	<tr><td><INPUT TYPE="submit" value="submit"></td><td>&nbsp;</td></tr></table>
	</form>';
    $xoopsTpl->assign('form', $form);
}

function savecolours()
{
    global $xoopsDB;
    require_once __DIR__ . '/include/color.php';
    $color = new Image_Color();
    //create darker link hover colour
    $color->setColors($_POST['actlink'], $_POST['actlink']);
    $color->changeLightness(-100);
    $dark = $color->rgb2hex($color->color1);
    //create darker 'head' colour
    $color->setColors($_POST['even'], $_POST['even']);
    $color->changeLightness(-25);
    $head = $color->rgb2hex($color->color1);
    //create lighter female colour
    $color->setColors($_POST['even'], $_POST['even']);
    $color->changeLightness(25);
    $female = $color->rgb2hex($color->color1);

    $col = $_POST['actlink'] . ';' . $_POST['even'] . ';#' . $female . ';' . $_POST['text'] . ';#' . $dark . ';#' . $head . ';' . $_POST['body'] . ';' . $_POST['actlink'];

    $query = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('config') . " SET conf_value = '" . $col . "' WHERE conf_name = 'colourscheme'";
    $GLOBALS['xoopsDB']->query($query);
    redirect_header('tools.php?op=colours', 1, 'Your settings have been saved.');
}

function listuserfields()
{
    global $xoopsTpl, $xoopsDB, $form;
    $form    .= "Shown below are the user defined fields for this pedigree database.<br>Click on the name to edit the field.<br>Click on the 'X' to delete the field from the database.<hr>";
    $sql     = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " WHERE isActive = '1' ORDER BY 'order'";
    $result  = $GLOBALS['xoopsDB']->query($sql);
    $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);
    $count   = 0;
    $form    .= '<table>';
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form .= '<tr>';
        if ($count == 0) { //first row
            $form .= '<td style="width: 15px;">&nbsp;</td><td style="width: 15px;"><a href="tools.php?op=fieldmove&field='
                     . $row['ID']
                     . '&move=down"><img src="images/down.gif"></a></td><td><a href="tools.php?op=deluserfield&id='
                     . $row['ID']
                     . '"><img src="images/delete.gif" /></a>&nbsp;<a href="tools.php?op=userfields&field='
                     . $row['ID']
                     . '">'
                     . $row['FieldName']
                     . '</a></td>';
            if ($row['LookupTable'] == '1') {
                $form .= '<td>(<a href="tools.php?op=editlookup&id=' . $row['ID'] . '">edit Lookuptable</a>)</td>';
            } else {
                $form .= '<td>&nbsp;</td>';
            }
        } elseif ($count == $numrows - 1) { //last row
            $form .= '<td><a href="tools.php?op=fieldmove&field='
                     . $row['ID']
                     . '&move=up"><img src="images/up.gif"></a></td><td>&nbsp;</td><td><a href="tools.php?op=deluserfield&id='
                     . $row['ID']
                     . '"><img src="images/delete.gif" /></a>&nbsp;<a href="tools.php?op=userfields&field='
                     . $row['ID']
                     . '">'
                     . $row['FieldName']
                     . '</a></td>';
            if ($row['LookupTable'] == '1') {
                $form .= '<td>(<a href="tools.php?op=editlookup&id=' . $row['ID'] . '">edit Lookuptable</a>)</td>';
            } else {
                $form .= '<td>&nbsp;</td>';
            }
        } else { //other rows
            $form .= '<td><a href="tools.php?op=fieldmove&field='
                     . $row['ID']
                     . '&move=up"><img src="images/up.gif"></a></td><td><a href="tools.php?op=fieldmove&field='
                     . $row['ID']
                     . '&move=down"><img src="images/down.gif"></a></td><td><a href="tools.php?op=deluserfield&id='
                     . $row['ID']
                     . '"><img src="images/delete.gif" /></a>&nbsp;<a href="tools.php?op=userfields&field='
                     . $row['ID']
                     . '">'
                     . $row['FieldName']
                     . '</a></td>';
            if ($row['LookupTable'] == '1') {
                $form .= '<td>(<a href="tools.php?op=editlookup&id=' . $row['ID'] . '">edit Lookuptable</a>)</td>';
            } else {
                $form .= '<td>&nbsp;</td>';
            }
        }
        $form .= '</tr>';
        $count++;
    }
    $form   .= '</table>';
    $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " WHERE isActive = '0' ORDER BY 'ID'";
    $result = $GLOBALS['xoopsDB']->query($sql);
    if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) {
        $form .= '<hr>The following userfields have been deleted and can be restored.<br>Click on the name of the field to restore it.';
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
            $form .= '<li><a href="tools.php?op=restoreuserfield&id=' . $row['ID'] . '">' . $row['FieldName'] . '</a>';
        }
    }
    $xoopsTpl->assign('form', $form);
}

/**
 * @param $field
 * @param $move
 */
function fieldmove($field, $move)
{
    global $xoopsDB;
    //find next id
    $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " WHERE isActive = '1' ORDER BY 'order'";
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $valorder[] = $row['order'];
        $valid[]    = $row['ID'];
    }
    foreach ($valid as $key => $value) {
        //find current ID location
        if ($value == $field) {
            $x = $key;
        }
    }
    //currentorder
    $currentorder = $valorder[$x];
    $currentid    = $valid[$x];

    if ($move === 'down') {
        $nextorder = $valorder[$x + 1];
    } else {
        $nextorder = $valorder[$x - 1];
    }
    //move value with ID=nextid to original location
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " SET `order` = '127' WHERE `order` = '" . $nextorder . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " SET `order` = '" . $nextorder . "' WHERE `order` = '" . $currentorder . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    //move current value into nextvalue's spot
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " SET `order` = '" . $currentorder . "' WHERE `order` = '127'";
    $GLOBALS['xoopsDB']->queryF($sql);
    listuserfields();
}

/**
 * @param $field
 */
function deluserfield($field)
{
    global $xoopsDB;
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " SET isActive = '0' WHERE ID = " . $field;
    $GLOBALS['xoopsDB']->queryF($sql);
    listuserfields();
}

/**
 * @param $field
 */
function restoreuserfield($field)
{
    global $xoopsDB;
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . " SET isActive = '1' WHERE ID = " . $field;
    $GLOBALS['xoopsDB']->queryF($sql);
    listuserfields();
}

/**
 * @param $field
 */
function editlookup($field)
{
    global $xoopsDB, $xoopsTpl;
    $form    .= "Shown below are the user values for this lookupfield.<br>Click on the value to edit it.<br>Click on the 'X' to delete the value from the lookuptable.<hr>";
    $sql     = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . " ORDER BY 'order'";
    $result  = $GLOBALS['xoopsDB']->query($sql);
    $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);
    $count   = 0;
    $form    .= '<table>';
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form .= '<tr>';
        if ($count == 0) { //first row
            $form .= '<td style="width: 15px;">&nbsp;</td><td style="width: 15px;"><a href="tools.php?op=lookupmove&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '&move=down"><img src="images/down.gif"></a></td><td><a href="tools.php?op=dellookupvalue&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '"><img src="images/delete.gif" /></a>&nbsp;<a href="tools.php?op=editlookupvalue&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '">'
                     . $row['value']
                     . '</a></td>';
        } elseif ($count == $numrows - 1) { //last row
            $form .= '<td><a href="tools.php?op=lookupmove&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '&move=up"><img src="images/up.gif"></a></td><td>&nbsp;</td><td><a href="tools.php?op=dellookupvalue&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '"><img src="images/delete.gif" /></a>&nbsp;<a href="tools.php?op=editlookupvalue&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '">'
                     . $row['value']
                     . '</a></td>';
        } else { //other rows
            $form .= '<td><a href="tools.php?op=lookupmove&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '&move=up"><img src="images/up.gif"></a></td><td><a href="tools.php?op=lookupmove&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '&move=down"><img src="images/down.gif"></a></td><td><a href="tools.php?op=dellookupvalue&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '"><img src="images/delete.gif" /></a>&nbsp;<a href="tools.php?op=editlookupvalue&field='
                     . $field
                     . '&id='
                     . $row['ID']
                     . '">'
                     . $row['value']
                     . '</a></td>';
        }
        $form .= '</tr>';
        $count++;
    }
    $form .= '</table>';
    $form .= '<form method="post" action="tools.php?op=addlookupvalue&field=' . $field . '">';
    $form .= '<input type="text" name="value" style="width: 140px;">&nbsp;';
    $form .= '<input type="submit" value="Add value" />';
    $form .= '<hr>When deleting a value from this lookup field all animals with that value will be given the default value for this field.';
    $xoopsTpl->assign('form', $form);
}

/**
 * @param $field
 * @param $id
 * @param $move
 */
function lookupmove($field, $id, $move)
{
    global $xoopsDB;
    //find next id
    $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . " ORDER BY 'order'";
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $valorder[] = $row['order'];
        $valid[]    = $row['ID'];
    }
    foreach ($valid as $key => $value) {
        //find current ID location
        if ($value == $id) {
            $x = $key;
        }
    }
    //currentorder
    $currentorder = $valorder[$x];
    $currentid    = $valid[$x];

    if ($move === 'down') {
        $nextorder = $valorder[$x + 1];
    } else {
        $nextorder = $valorder[$x - 1];
    }
    //move value with ID=nextid to original location
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . " SET `order` = '127' WHERE `order` = '" . $nextorder . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . " SET `order` = '" . $nextorder . "' WHERE `order` = '" . $currentorder . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    //move current value into nextvalue's spot
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . " SET `order` = '" . $currentorder . "' WHERE `order` = '127'";
    $GLOBALS['xoopsDB']->queryF($sql);
    editlookup($field);
}

/**
 * @param $field
 * @param $id
 */
function editlookupvalue($field, $id)
{
    global $xoopsDB, $xoopsTpl;
    $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . ' WHERE ID =' . $id;
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form .= '<form method="post" action="tools.php?op=savelookupvalue&field=' . $field . '&id=' . $id . '">';
        $form .= '<input type="text" name="value" value="' . $row['value'] . '" style="width: 140px;">&nbsp;';
        $form .= '<input type="submit" value="Save value" />';
    }
    $xoopsTpl->assign('form', $form);
}

/**
 * @param $field
 * @param $id
 */
function savelookupvalue($field, $id)
{
    global $xoopsDB;
    $SQL = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . " SET value = '" . $_POST['value'] . "' WHERE ID = " . $id;
    $GLOBALS['xoopsDB']->queryF($SQL);
    redirect_header('tools.php?op=editlookup&id=' . $field, 2, 'The value has been saved.');
}

/**
 * @param $field
 * @param $id
 */
function dellookupvalue($field, $id)
{
    global $xoopsDB;
    $animal      = new Animal();
    $fields      = $animal->numoffields();
    $userfield   = new Field($field, $animal->getconfig());
    $fieldType   = $userfield->getSetting('FieldType');
    $fieldobject = new $fieldType($userfield, $animal);
    $default     = $fieldobject->defaultvalue;
    if ($default == $id) {
        redirect_header('tools.php?op=editlookup&id=' . $field, 3, 'This value cannot be deleted because it is the default value for userfield ' . $fieldobject->fieldname);
    }
    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . ' WHERE ID = ' . $id;
    $GLOBALS['xoopsDB']->queryF($sql);
    //change current values to default for deleted value
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' SET user' . $field . " = '" . $default . "' WHERE user" . $field . " = '" . $id . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_temp') . ' SET user' . $field . " = '" . $default . "' WHERE user" . $field . " = '" . $id . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_trash') . ' SET user' . $field . " = '" . $default . "' WHERE user" . $field . " = '" . $id . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    editlookup($field);
}

/**
 * @param $field
 */
function addlookupvalue($field)
{
    global $xoopsDB;
    $SQL    = 'SELECT ID FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . ' ORDER BY ID DESC LIMIT 1';
    $result = $GLOBALS['xoopsDB']->query($SQL);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $count = $row['ID'];
        $count++;
        $sql = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $field) . " VALUES ('" . $count . "', '" . $_POST['value'] . "', '" . $count . "')";
        $GLOBALS['xoopsDB']->queryF($sql);
    }
    redirect_header('tools.php?op=editlookup&id=' . $field, 2, 'The value has been added.');
}

function online()
{
    global $xoopsUser, $xoopsModule, $xoopsTpl, $form;
    $form          .= 'Shown below are the (registered) users currently using the pedigree database.<hr>';
    $onlineHandler = xoops_getHandler('online');
    mt_srand((double)microtime() * 1000000);
    // set gc probabillity to 10% for now..
    if (mt_rand(1, 100) < 11) {
        $onlineHandler->gc(300);
    }
    if (is_object($xoopsUser)) {
        $uid   = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
    } else {
        $uid   = 0;
        $uname = '';
    }
    if (is_object($xoopsModule)) {
        $onlineHandler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
    } else {
        $onlineHandler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
    }
    $onlines = $onlineHandler->getAll();
    if (false != $onlines) {
        $total = count($onlines);

        $members = '';
        for ($i = 0; $i < $total; $i++) {
            if ($onlines[$i]['online_uid'] > 0) {
                $form .= ' <a href="' . XOOPS_URL . '/userinfo.php?uid=' . $onlines[$i]['online_uid'] . '">' . $onlines[$i]['online_uname'] . '</a>';
            }
        }

        $xoopsTpl->assign('form', $form);
    }
}

/**
 * @param int $field
 */
function userfields($field = 0)
{
    global $xoopsTpl;
    require_once __DIR__ . '/include/checkoutwizard.php';

    $wizard = new CheckoutWizard();
    $action = $wizard->coalesce($_GET['action']);

    $wizard->process($action, $_POST, $_SERVER['REQUEST_METHOD'] === 'POST');
    // only processes the form if it was posted. this way, we
    // can allow people to refresh the page without resubmitting
    // form data

    if ($wizard->isComplete()) {
        if (!$wizard->getValue('field') == 0) { // field allready exists (editing mode)
            $form = '<p>The field properties have now been changed. Clicking the button below will clear the wizard and let you change another field.</p>';
        } else {
            $form = '<p>The field has now been created. Clicking the button below will clear the wizard and let you add another field.</p>';
        }
        $form .= '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?op=userfields&action=' . $wizard->resetAction . '">';
        $form .= '<input type="submit" value="Finished" /></form>';
    } else {
        $form = '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?op=userfields&action=' . $wizard->getStepName() . '">';
        if (!$field == 0) {
            $form .= '<input type="hidden" name="field" value="' . $field . '">';
        }
        $form .= '<h2>' . $wizard->getStepProperty('title') . ' - step ' . $wizard->getStepNumber() . '</h2>';
        if ($wizard->getStepName() === 'Fieldname') {
            $form .= '<table><tr><td width=25%>Field name:</td><td width=50%>';
            $form .= '<input type="text" name="name" value="' . htmlspecialchars($wizard->getValue('name')) . '" />';
            $form .= '</td><td width=25%>';
            if ($wizard->isError('name')) {
                $form .= $wizard->getError('name');
            }
            $form .= '</td></tr>';
            $form .= '<tr><td>Field explanation:</td><td>';
            $form .= '<textarea name="explain" rows="5" cols="15">' . htmlspecialchars($wizard->getValue('explain')) . '</textarea>';
            $form .= '</td><td>';
            if ($wizard->isError('explain')) {
                $form .= $wizard->getError('explain');
            }
            $form .= '</td></tr></table>';
            $form .= '<hr><i>Field name is the name that will be used throughout the pedigree database to reference this field.<br>Field explanation is the explanation which will be given on the edit page for this field.<br><br></i>';
        } elseif ($wizard->getStepName() === 'Fieldtype') {
            $form .= '<table><tr><td>';
            if ($wizard->getValue('fieldtype') == '') {
                $wizard->setValue('fieldtype', 'textbox');
            }
            foreach ($wizard->fieldtype as $v) {
                $form .= '<abbr title="' . $v['explain'] . '">?</abbr>&nbsp;&nbsp;';
                $form .= '<input name="fieldtype" type="radio" value="' . $v['value'] . '"';
                if ($wizard->getValue('fieldtype') == $v['value']) {
                    $form .= ' checked';
                }
                $form .= '>&nbsp;' . $v['description'] . '<br>';
            }
            $form .= '</td><td></table>';
        } elseif ($wizard->getStepName() === 'lookup') {
            $count = $wizard->getValue('fc');
            if ($count == '') {
                $i = 1;
            } else {
                $i = $count + 1;
            }

            $form .= '<input type="hidden" name="fc" value="' . $i . '">';
            $form .= '<table>';
            for ($x = 1; $x < $i; $x++) {
                $form .= '<tr><td>Value : (' . $x . ')</td><td>' . htmlspecialchars($wizard->getValue('lookup' . $x)) . '</td></tr>';
            }
            $form .= '<tr><td>Value : (' . $i . ')</td><td>';
            $form .= '<input type="text" name="lookup' . $i . '" value="' . htmlspecialchars($wizard->getValue('lookup' . $i)) . '" />';
            $form .= '<input type="hidden" name="id' . $i . '" value="' . $i . '" />';
            if ($wizard->isError('lookup')) {
                $form .= $wizard->getError('lookup');
            }
            $form .= '</td></tr></table>';
            $form .= '<input type="submit" name="addvalue" value="Add Value">';
        } elseif ($wizard->getStepName() === 'Settings') {
            $fieldtype = $wizard->getValue('fieldtype');
            //hassearch
            if ($fieldtype === 'textbox' || $fieldtype === 'textarea' || $fieldtype === 'dateselect' || $fieldtype === 'urlfield' || $fieldtype === 'radiobutton' || $fieldtype === 'selectbox') {
                $form .= '<input type="checkbox" name="hassearch" value="hassearch"';
                if ($wizard->getValue('hassearch') === 'hassearch') {
                    $form .= ' checked ';
                }
                $form .= ' />Field can be searched<br>';
            } else {
                $form .= '<input type="checkbox" name="hassearch" disabled="true" value="hassearch" />Field can be searched<br>';
            }
            //viewinpedigree
            $form .= '<input type="checkbox" name="viewinpedigree" value="viewinpedigree"';
            if ($wizard->getValue('viewinpedigree') === 'viewinpedigree') {
                $form .= ' checked ';
            }
            $form .= ' />Field will be shown in the pedigree<br>';
            //viewinadvanced
            if ($fieldtype === 'radiobutton' || $fieldtype === 'selectbox') {
                $form .= '<input type="checkbox" name="viewinadvanced" value="viewinadvanced"';
                if ($wizard->getValue('viewinadvanced') === 'viewinadvanced') {
                    $form .= ' checked ';
                }
                $form .= ' />Field will be shown in advanced information<br>';
            } else {
                $form .= '<input type="checkbox" name="viewinadvanced" disabled="true" value="viewinadvanced" />Field will be shown in advanced information<br>';
            }
            //viewinpie
            if ($fieldtype === 'radiobutton' || $fieldtype === 'selectbox') {
                $form .= '<input type="checkbox" name="viewinpie" value="viewinpie"';
                if ($wizard->getValue('viewinpie') === 'viewinpie') {
                    $form .= ' checked ';
                }
                $form .= ' />Field will be shown as a pie chart<br>';
            } else {
                $form .= '<input type="checkbox" name="viewinpie" disabled="true" value="viewinpie" />Field will be shown as a pie chart<br>';
            }
            //viewinlist
            if ($fieldtype === 'textbox' || $fieldtype === 'dateselect' || $fieldtype === 'urlfield' || $fieldtype === 'radiobutton' || $fieldtype === 'selectbox' || $fieldtype === 'textarea') {
                $form .= '<input type="checkbox" name="viewinlist" value="viewinlist"';
                if ($wizard->getValue('viewinlist') === 'viewinlist') {
                    $form .= ' checked ';
                }
                $form .= ' />Field will be shown in result list<br>';
            } else {
                $form .= '<input type="checkbox" name="viewinlist" disabled="true" value="viewinlist" />Field will be shown in result list<br>';
            }
        } elseif ($wizard->getStepName() === 'search') {
            $form              .= '<table><tr><td width=25%>Search name:</td><td width=50%>';
            $currentsearchname = $wizard->getValue('searchname');
            if ($currentsearchname == '') {
                $currentsearchname = htmlspecialchars($wizard->getValue('name'));
            } else {
                $currentsearchname = htmlspecialchars($wizard->getValue('searchname'));
            }
            $form .= '<input type="text" name="searchname" value="' . $currentsearchname . '" />';
            $form .= '</td><td width=25%>';
            if ($wizard->isError('searchname')) {
                $form .= $wizard->getError('searchname');
            }
            $form .= '</td></tr>';
            $form .= '<tr><td>Search explanation:</td><td>';
            $form .= '<textarea name="searchexplain" rows="5" cols="15">' . htmlspecialchars($wizard->getValue('searchexplain')) . '</textarea>';
            $form .= '</td><td>';
            if ($wizard->isError('searchexplain')) {
                $form .= $wizard->getError('searchexplain');
            }
            $form .= '</td></tr></table>';
            $form .= '<hr><i>Search name is the name that will be shown for this field on the search page.<br>Search explanation is the explanation which will be given on the search page for this field.</i>';
        } elseif ($wizard->getStepName() === 'defaultvalue') {
            if ($wizard->getValue('fieldtype') === 'selectbox' || $wizard->getValue('fieldtype') === 'radiobutton') {
                $count      = $wizard->getValue('fc');
                $form       .= 'Default value : <select size="1" name="defaultvalue">';
                $radioarray = $wizard->getValue('radioarray');
                for ($x = 0; $x < $count; $x++) {
                    $form .= '<option value="' . $radioarray[$x]['id'] . '"';
                    if ($wizard->getValue('defaultvalue') == $radioarray[$x]['id']) {
                        $form .= ' selected="selected" ';
                    }
                    $form .= '>' . $radioarray[$x]['value'] . '</option>';
                }
                $form .= '</select>';
            } else {
                $form .= 'Default value : <input type="text" name="defaultvalue" value="' . htmlspecialchars($wizard->getValue('defaultvalue')) . '" />';
            }
            $form .= '<hr><i>If there are allready animals in your database they will all be assigned this default value for this field.</i>';
        } elseif ($wizard->getStepName() === 'confirm') {
            if (!$wizard->getValue('field') == 0) { // field allready exists (editing mode)
                $form .= 'Please verify the entered details below and then click finish to change your field properties.';
            } else {
                $form .= 'Please verify the entered details below and then click finish to create your field.';
            }
            $form .= '<hr>Fieldname : <b>' . $wizard->getValue('name') . '</b><br>';
            $form .= 'Field explanation : <b>' . stripslashes($wizard->getValue('explain')) . '</b><br>';
            $form .= 'Field type : <b>' . $wizard->getValue('fieldtype') . '</b><br>';
            if ($wizard->getValue('fieldtype') === 'selectbox' || $wizard->getValue('fieldtype') === 'radiobutton') {
                $count = $wizard->getValue('fc');
                for ($x = 1; $x < $count + 1; $x++) {
                    $radioarray[] = array('id' => $wizard->getValue('id' . $x), 'value' => $wizard->getValue('lookup' . $x));
                }
                $val  = $wizard->getValue('defaultvalue');
                $form .= 'Default value : <b>' . $wizard->getValue('lookup' . $val) . '</b><br>';
            } else {
                $form .= 'Default value : <b>' . $wizard->getValue('defaultvalue') . '</b><br>';
            }
            if ($wizard->getValue('hassearch') === 'hassearch') {
                $form .= 'Field can be searched : <b>Yes</b><br>';
                $form .= 'Searchname : <b>' . $wizard->getValue('searchname') . '</b><br>';
                $form .= 'Search explanation : <b>' . $wizard->getValue('searchexplain') . '</b><br>';
            }
            if ($wizard->getValue('viewinpedigree') === 'viewinpedigree') {
                $form .= 'Field will be shown in the pedigree : <b>Yes</b><br>';
            }
            if ($wizard->getValue('viewinadvanced') === 'viewinadvanced') {
                $form .= 'Field will be shown on the advanced information page : <b>Yes</b><br>';
            }
            if ($wizard->getValue('viewinpie') === 'viewinpie') {
                $form .= 'Field will be shown as a pie chart : <b>Yes</b><br>';
            }
            if ($wizard->getValue('viewinlist') === 'viewinlist') {
                $form .= 'Field will be shown in search result list : <b>Yes</b><br>';
            }
            $form .= '<hr><i>You may change these settings at any time</i>';
        }
        if (!$wizard->isFirstStep()) {
            $form .= '<p><input type="submit" name="previous" value="&lt;&lt; Previous">&nbsp;';
        }
        $form .= '<input type="submit" name="reset" value="Cancel" />&nbsp;';
        $last = $wizard->isLastStep() ? 'Finish' : 'Next';
        $form .= '<input type="submit" value="' . $last . '&gt;&gt;" />';
        $form .= '</p></form>';
    }
    $xoopsTpl->assign('form', $form);
}

function credits()
{
    global $xoopsTpl;
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
    $form          = 'Pedigree database module<br><br><li>Programming : James Cotton<br/><li>Design & Layout : Ton van der Hagen<br><li>Version : '
                     . round($module->getVar('version') / 100, 2)
                     . '<br><br>Technical support :<br><li><a href="mailto:support@animalpedigree.com">support@animalpedigree.com<br><li><a href="http://www.animalpedigree.com">www.animalpedigree.com</a><hr>';

    $xoopsTpl->assign('form', $form);
}

function database()
{
    global $xoopsTpl;
    $form = 'Please use the menu items on the left to run preset database queries or request your own queries from <a href ="http://www.animalpedigree.com">AnimalPedigree.com</a>';
    $xoopsTpl->assign('form', $form);
}

function userq()
{
    global $xoopsTpl;
    $form = 'Shown below are your personal queries.<br/>To request a user query use the form at <a href ="http://www.animalpedigree.com">AnimalPedigree.com</a><hr>';
    $d    = XOOPS_ROOT_PATH . '/modules/animal/userqueries/';

    $dir = opendir($d);
    while ($f = readdir($dir)) {
        if (!preg_match("/\.jpg/", $f) && ('.' !== $f) && ('..' !== $f)) {
            $form .= "<li><a href='tools.php?op=userqrun&f={$f}'>{$f}</a>";
        }
    }
    $xoopsTpl->assign('form', $form);
}

/**
 * @param $file
 */
function userqrun($file)
{
    global $xoopsTpl, $xoopsDB;
    include XOOPS_ROOT_PATH . '/modules/animal/userqueries/' . $file;
    $xoopsTpl->assign('form', $form);
}

function database_oa()
{
    global $xoopsTpl, $xoopsDB;
    $form   = "For your pedigree database to work well it is important that the information contained within is correct.<br>It is possible create errors and achieve unexpected results by accidentily adding the wrong parents to an animal. If an animal is selected to be it's own parent or grandparent in infinite loop will be created when trying to view the pedigree. <br><br>The database has been searched and any animals below the line require your attention.<hr>";
    $sql    = 'SELECT d.id AS d_id, d.naam AS d_naam
			FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' d
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' m ON m.id = d.moeder
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' f ON f.id = d.vader
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' mm ON mm.id = m.moeder
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' mf ON mf.id = m.vader
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' fm ON fm.id = f.moeder
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' ff ON ff.id = f.vader
			WHERE 
			d.moeder = d.id
			OR d.vader = d.id
			OR m.moeder = d.id
			OR m.vader = d.id
			OR f.moeder = d.id
			OR f.vader = d.id
			OR mm.moeder = d.id
			OR mm.vader = d.id
			OR mf.moeder = d.id
			OR mf.vader = d.id
			OR fm.moeder = d.id
			OR fm.vader = d.id
			OR ff.moeder = d.id
			OR ff.vader = d.id
			';
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form .= '<li><a href="pedigree.php?pedid=' . $row['d_id'] . '">' . $row['d_naam'] . '</a> [own parent or grandparent]<br>';
    }
    $xoopsTpl->assign('form', $form);
}

function database_fp()
{
    global $xoopsTpl, $xoopsDB;
    $form   = 'For your pedigree database to work well it is important that the information contained within is correct.<br>It is possible create errors and achieve unexpected results by changing the gender of an animal. If you discover that a male in the database is really female or the other way around it is possible to create errors if accidentilly children have been connected to the wrong gender.<br><br>The database has been searched and any animals below the line require your attention.<hr>';
    $sql    = 'SELECT d.id AS d_id, d.naam AS d_naam, d.moeder AS d_moeder, m.roft AS m_roft
			FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' d
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " m ON m.id = d.moeder
			WHERE 
			d.moeder = m.id
			AND m.roft = '0' ";
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form .= '<li><a href="dog.php?id=' . $row['d_id'] . '">' . $row['d_naam'] . '</a> [mother seems to be male]<br>';
    }
    $sql    = 'SELECT d.id AS d_id, d.naam AS d_naam, d.vader AS d_vader, f.roft AS f_roft
			FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' d
			LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " f ON f.id = d.vader
			WHERE 
			d.vader = f.id
			AND f.roft = '1' ";
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form .= '<li><a href="dog.php?id=' . $row['d_id'] . '">' . $row['d_naam'] . '</a> [father seems to be female]<br>';
    }
    $xoopsTpl->assign('form', $form);
}

function pro()
{
    global $xoopsTpl;
    $form = 'Pro version settings go here.<hr>';
    $xoopsTpl->assign('form', $form);
}

function deleted()
{
    global $xoopsTpl, $xoopsDB, $moduleConfig;
    $form   = "Below the line are the animals which have been deleted from your database.<br><br>By clicking on the name you can reinsert them into the database.<br>By clicking on the 'X' in front of the name you can permanently delete the animal.<hr>";
    $sql    = 'SELECT ID, NAAM	FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_trash');
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form .= '<a href="tools.php?op=delperm&id=' . $row['ID'] . '"><img src="images/delete.gif" /></a>&nbsp;<a href="tools.php?op=restore&id=' . $row['ID'] . '">' . stripslashes($row['NAAM']) . '</a><br>';
    }
    if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) {
        $form .= '<hr><a href="tools.php?op=delall">Click here</a> to remove all these ' . $moduleConfig['animalTypes'] . ' permenantly ';
    }
    $xoopsTpl->assign('form', $form);
}

/**
 * @param $id
 */
function delperm($id)
{
    global $xoopsTpl, $xoopsDB;
    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_trash') . ' WHERE ID = ' . $id;
    $GLOBALS['xoopsDB']->queryF($sql);
    deleted();
}

function delall()
{
    global $xoopsTpl, $xoopsDB;
    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_trash');
    $GLOBALS['xoopsDB']->queryF($sql);
    deleted();
}

/**
 * @param $id
 */
function restore($id)
{
    global $xoopsTpl, $xoopsDB;
    $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_trash') . ' WHERE ID = ' . $id;
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        foreach ($row as $key => $values) {
            $queryvalues .= "'" . $values . "',";
        }
        $outgoing = substr_replace($queryvalues, '', -1);
        $query    = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' VALUES (' . $outgoing . ')';
        $GLOBALS['xoopsDB']->queryF($query);
        $delquery = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_trash') . ' WHERE ID = ' . $id;
        $GLOBALS['xoopsDB']->queryF($delquery);
        $form .= '<li><a href="pedigree.php?pedid=' . $row['ID'] . '">' . $row['NAAM'] . '</a> has been restored into the database.<hr>';
    }
    $xoopsTpl->assign('form', $form);
}

function settings()
{
    global $xoopsUser, $xoopsTpl, $moduleConfig;
    include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $form = new XoopsThemeForm('General settings', 'settings', 'tools.php?op=settingssave', 'POST', 1);
    $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
    $select  = new XoopsFormSelect('<b>Number of results per page</b>', 'perpage', $value = $moduleConfig['perpage'], $size = 1, $multiple = false);
    $options = array('50' => 50, '100' => 100, '250' => 250, '500' => 500, '1000' => 1000, '2000' => 2000, '5000' => 5000, '10000' => 10000);
    foreach ($options as $key => $values) {
        $select->addOption($key, $name = $values, $disabled = false);
    }
    unset($options);
    $form->addElement($select);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'This field is used to set the number of results a page will return from a search. If more results are returned extra pages will be created for easy browsing.<br>Set this number higher as your database grows and the number of pages increase.'));
    $radiowel = new XoopsFormRadio('<b>show Welcome screen ?</b>', 'showwelcome', $value = $moduleConfig['showwelcome']);
    $radiowel->addOption(1, $name = 'yes', $disabled = false);
    $radiowel->addOption(0, $name = 'no', $disabled = false);
    $form->addElement($radiowel);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Should the welcome page be shown ?<br><i>This setting (if set to no) will also remove the </i>Welcome<i> button from the menu.</i>'));
    $radio = new XoopsFormRadio('<b>Use owner/breeder fields</b>', 'ownerbreeder', $value = $moduleConfig['ownerbreeder']);
    $radio->addOption(1, $name = 'yes', $disabled = false);
    $radio->addOption(0, $name = 'no', $disabled = false);
    $form->addElement($radio);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN,
                                         'Use this field to set if you would like to use the owner/breeder fields of the database.<br>As the name suggests the owner/breeder fields let you record and display information about the owner and or breeder.<br>The owner/breeder menu items will also be affected by this setting.'));
    $radiobr = new XoopsFormRadio('<b>Show brother & sister field</b>', 'brothers', $value = $moduleConfig['brothers']);
    $radiobr->addOption(1, $name = 'yes', $disabled = false);
    $radiobr->addOption(0, $name = 'no', $disabled = false);
    $form->addElement($radiobr);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set if you would like to use the add a ' . $moduleConfig['litter'] . 'feature.<br>If your chosen animal only has one offspring at a time this feature will not be useful to you.'));
    $radiolit = new XoopsFormRadio('<b>Use add a ' . $moduleConfig['litter'] . ' feature</b>', 'uselitter', $value = $moduleConfig['uselitter']);
    $radiolit->addOption(1, $name = 'yes', $disabled = false);
    $radiolit->addOption(0, $name = 'no', $disabled = false);
    $form->addElement($radiolit);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set if you would like to display the brothers & sisters field on the detailed ' . $moduleConfig['animalType'] . ' information page.'));
    $radioch = new XoopsFormRadio('<b>Show ' . $moduleConfig['children'] . ' field</b>', 'pups', $value = $moduleConfig['pups']);
    $radioch->addOption(1, $name = 'yes', $disabled = false);
    $radioch->addOption(0, $name = 'no', $disabled = false);
    $form->addElement($radioch);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set if you would like to display the ' . $moduleConfig['children'] . ' field on the detailed ' . $moduleConfig['animalType'] . ' information page.'));
    $radiosoi = new XoopsFormRadio('<b>Show the image in the last row of the pedigree ? (great grandparents)</b>', 'lastimage', $value = $moduleConfig['lastimage']);
    $radiosoi->addOption(1, $name = 'yes', $disabled = false);
    $radiosoi->addOption(0, $name = 'no', $disabled = false);
    $form->addElement($radiosoi);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN,
                                         'A pedigree can become very long and hard to fit on the screen if all the images are set for all animals in the pedigree. Using this setting you can switch off showing the images for the last row of the pedigree (great grandparents).<br><i>Note: this only applies to the standard image of an animal. If you define additional picturefields they will be shown.</i>'));
    $form->addElement(new XoopsFormButton('', 'button_id', 'Submit', 'submit'));
    $xoopsTpl->assign('form', $form->render());
}

function settingssave()
{
    global $xoopsDB;
    $settings = array('perpage', 'ownerbreeder', 'brothers', 'uselitter', 'pups', 'showwelcome');
    foreach ($_POST as $key => $values) {
        if (in_array($key, $settings)) {
            $query = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('config') . " SET conf_value = '" . $values . "' WHERE conf_name = '" . $key . "'";
            $GLOBALS['xoopsDB']->query($query);
        }
    }
    redirect_header('tools.php?op=settings', 1, 'Your settings have been saved.');
}

function lang()
{
    global $xoopsUser, $xoopsTpl, $moduleConfig;
    include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $form = new XoopsThemeForm('Language options', 'language', 'tools.php?op=langsave', 'POST');
    $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
    $form->addElement(new XoopsFormText('<b>type of animal</b>', 'animalType', $size = 50, $maxsize = 255, $value = $moduleConfig['animalType']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the animal type which will be used in the application.<br><i>example : </i>snake, pigeon, dog, owl<br><br>The value should fit in the sentences below.<br>Please add optional information for this <b>'
                                                       . $moduleConfig['animalType']
                                                       . '</b>.<br>Select the first letter of the <b>'
                                                       . $moduleConfig['animalType']
                                                       . '</b>.'));
    $form->addElement(new XoopsFormText('<b>type of animal</b>', 'animalTypes', $size = 50, $maxsize = 255, $value = $value = $moduleConfig['animalTypes']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the animal type which will be used in the application.<br>This field is the plural of the previous field<br><i>example : </i>snakes, pigeons, dogs, owls<br><br>The value should fit in the sentence below.<br>No <b>'
                                                       . $moduleConfig['animalTypes']
                                                       . '</b> meeting your query have been found.'));
    $form->addElement(new XoopsFormText('<b>male</b>', 'male', $size = 50, $maxsize = 255, $value = $moduleConfig['male']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the name used for the male animal.<br><i>example : </i>male, buck, sire etc.'));
    $form->addElement(new XoopsFormText('<b>female</b>', 'female', $size = 50, $maxsize = 255, $value = $moduleConfig['female']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the name used for the female animal.<br><i>example : </i>female, vixen, dam etc.'));
    $form->addElement(new XoopsFormText('<b>children</b>', 'children', $size = 50, $maxsize = 255, $value = $moduleConfig['children']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the name used for children of this type of animal (' . $moduleConfig['animalTypes'] . ').<br><i>example : </i>pups, cubs, kittens etc.'));
    $form->addElement(new XoopsFormText('<b>mother</b>', 'mother', $size = 50, $maxsize = 255, $value = $moduleConfig['mother']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the name used for mother of this type of animal (' . $moduleConfig['animalTypes'] . ').<br><i>example : </i>dam, mare etc.'));
    $form->addElement(new XoopsFormText('<b>father</b>', 'father', $size = 50, $maxsize = 255, $value = $moduleConfig['father']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the name used for father of this type of animal (' . $moduleConfig['animalTypes'] . ').<br><i>example : </i>sire, stallion etc.'));
    $form->addElement(new XoopsFormText('<b>litter</b>', 'litter', $size = 50, $maxsize = 255, $value = $moduleConfig['litter']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the name used for a collection of newborn animals.<br><i>example : </i>litter, nest etc.'));
    $form->addElement(new XoopsFormTextArea('<b>Welcome text</b>', 'welcome', $value = $moduleConfig['welcome'], $rows = 15, $cols = 50));

    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, 'Use this field to set the text you would like to display for the welcome page.<br><br>You may use the follwing variables :<br>[animalType] = '
                                                       . $moduleConfig['animalType']
                                                       . '<br>[animalTypes] ='
                                                       . $moduleConfig['animalTypes']
                                                       . '<br>[numanimals] = number of animals in the database.'));
    $form->addElement(new XoopsFormButton('', 'button_id', 'Submit', 'submit'));
    $xoopsTpl->assign('form', $form->render());
}

function langsave()
{
    global $xoopsDB, $xoopsUser, $xoopsTpl;
    $form     = '';
    $settings = array('animalType', 'animalTypes', 'male', 'female', 'children', 'mother', 'father', 'litter', 'welcome');
    foreach ($_POST as $key => $values) {
        if (in_array($key, $settings)) {
            $query = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('config') . " SET conf_value = '" . $values . "' WHERE conf_name = '" . $key . "'";
            $GLOBALS['xoopsDB']->query($query);
        }
    }
    $form .= 'Your settings have been saved.<hr>';
    $xoopsTpl->assign('form', $form);
}
