<?php

if ($_POST['id_eigenaar'] == '' && $_POST['button_id'] === 'Change_owner') {
    //echo "id_eigenaar is empty";
    $_POST['id_eigenaar'] = 0;
}

if ($_POST['id_fokker'] == '' && $_POST['button_id'] === 'Change_breeder') {
    $_POST['id_fokker'] = 0;
}

require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';
require_once XOOPS_ROOT_PATH . '/modules/animal/include/class_field.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_update.tpl';

include XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', 'Pedigree database - Update details');

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}
// ( $xoopsUser->isAdmin($xoopsModule->mid() ) )

global $xoopsTpl;
global $xoopsDB;
global $xoopsModuleConfig;

//possible variables (specific variables are found in the specified IF statement
$dogid = $_POST['dogid'];
if (isset($_POST['ownerid'])) {
    $dogid = $_POST['ownerid'];
}
$table   = $_POST['dbtable'];
$field   = $_POST['dbfield'];
$dogname = $_POST['curname'];
$name    = $_POST['NAAM'];
$gender  = $_POST['roft'];

$a      = (!isset($_POST['dogid']) ? $a = '' : $a = $_POST['dogid']);
$animal = new Animal($a);

$fields = $animal->numoffields();

for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
    if ($_POST['dbfield'] == 'user' . $fields[$i]) {
        $userfield = new Field($fields[$i], $animal->getconfig());
        if ($userfield->active()) {
            $currentfield = 'user' . $fields[$i];
            $picturefield = $_FILES[$currentfield]['name'];
            if (empty($picturefield) || $picturefield == '') {
                $newvalue = $_POST['user' . $fields[$i]];
            } else {
                $newvalue = uploadedpict(0);
            }
            $loginsert = '';
            $Query     = '';
            $dataquer  = '';
            $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$dogid'");
            $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

            if ($dataquer[$field] != $newvalue) {
                $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $dogid . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','" . $field . "','" . $dataquer[$field] . "','" . $newvalue . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
                $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
            }
            $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $newvalue . "' WHERE ID='" . $dogid . "'";
            $GLOBALS['xoopsDB']->queryF($sql);
            $notificationHandler = xoops_getHandler('notification');
            $notificationHandler->triggerEvent('dog', $dogid, 'change_data', $extra_tags = array());
            $ch = 1;
        }
    }
}

//name
if (!empty($name)) {
    $curval    = $_POST['curvalname'];
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE ID='" . $dogid . "'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
    if ($dataquer[NAAM] != $name) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $dogid . "','" . $name . "',NOW(),'" . $_SESSION[xoopsUserId] . "','NAAM','" . $dataquer[NAAM] . "','" . $name . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $name . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $date = '';
    $date = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET updated_date=NOW() WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($date);
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('dog', $dogid, 'change_data', $extra_tags = array());
    $ch = 1;
}
//owner
if (isset($_POST['id_eigenaar'])) {
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$dogid'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

    if ($dataquer[id_eigenaar] != $_POST['id_eigenaar']) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $dogid . "','" . $dataquer[NAAM] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Owner','" . $dataquer[id_eigenaar] . "','" . $_POST['id_eigenaar'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $curval = $_POST['curvaleig'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['id_eigenaar'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $date = '';
    $date = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET updated_date=NOW() WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($date);
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('dog', $dogid, 'change_data', $extra_tags = array());
    $ch = 1;
}
//breeder
if (isset($_POST['id_fokker'])) {
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$dogid'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
    //echo $dataquer[id_fokker].'!='.$_POST[id_fokker];
    //print_r($_SESSION);
    if ($dataquer[id_fokker] != $_POST['id_fokker']) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $dogid . "','" . $dataquer[NAAM] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Breeder','" . $dataquer[id_fokker] . "','" . $_POST['id_fokker'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $curval = $_POST['curvalfok'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['id_fokker'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $date = '';
    $date = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET updated_date=NOW() WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($date);
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('dog', $dogid, 'change_data', $extra_tags = array());
    $ch = 1;
}
//gender
if (!empty($_POST['roft']) || $_POST['roft'] == '0') {
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$dogid'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

    if ($dataquer[roft] != $_POST['roft']) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $dogid . "','" . $dataquer[NAAM] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','roft','" . $dataquer[roft] . "','" . $_POST['roft'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $curval = $_POST['curvalroft'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['roft'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $date = '';
    $date = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET updated_date=NOW() WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($date);
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('dog', $dogid, 'change_data', $extra_tags = array());
    $ch = 1;
}
//sire - dam
if (isset($_GET['gend'])) {
    $curval = $_GET['curval'];
    //$curname = getname($curval);
    $table = 'stamboom';
    if ($_GET['gend'] == '0') {
        $loginsert = '';
        $Query     = '';
        $dataquer  = '';
        $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$curval'");
        $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

        if ($dataquer[vader] != $_GET['thisid']) {
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $curval . "','" . $dataquer[NAAM] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Father','" . $dataquer[vader] . "','" . $_GET['thisid'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
        }
        $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . " SET vader='" . $_GET['thisid'] . "' WHERE ID='" . $curval . "'";
        $GLOBALS['xoopsDB']->queryF($sql);
        $date = '';
        $date = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET updated_date=NOW() WHERE ID='" . $curval . "'";
        $GLOBALS['xoopsDB']->queryF($date);
    } else {
        $loginsert = '';
        $Query     = '';
        $dataquer  = '';
        $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$curval'");
        $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

        if ($dataquer[moeder] != $_GET['thisid']) {
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $curval . "','" . $dataquer[NAAM] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Mother','" . $dataquer['moeder'] . "','" . $_GET['thisid'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
        }
        $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . " SET moeder='" . $_GET['thisid'] . "' WHERE ID='" . $curval . "'";
        $GLOBALS['xoopsDB']->queryF($sql);
        $date = '';
        $date = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET updated_date=NOW() WHERE ID='" . $curval . "'";
        $GLOBALS['xoopsDB']->queryF($date);
    }
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('dog', $dogid, 'change_data', $extra_tags = array());
    $ch    = 1;
    $dogid = $curval;
}
//picture
if ($_POST['dbfield'] === 'foto') {
    $curval    = $_POST['curvalpic'];
    $foto      = uploadedpict(0);
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$dogid'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

    if ($dataquer[foto] != $foto) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $dogid . "','" . $dataquer[NAAM] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','foto','" . $dataquer['foto'] . "','" . $foto . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . " SET foto='" . $foto . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $date = '';
    $date = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET updated_date=NOW() WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($date);
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('dog', $dogid, 'change_data', $extra_tags = array());
    $ch = 1;
}

//eigenaar
//lastname
if (isset($_POST['naaml'])) {
    $curval = $_POST['curvalnamel'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['naaml'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//firstname
if (isset($_POST['naamf'])) {
    $curval = $_POST['curvalnamef'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['naamf'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//streetname
if (isset($_POST['street'])) {
    $curval = $_POST['curvalstreet'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['street'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//housenumber
if (isset($_POST['housenumber'])) {
    $curval = $_POST['curvalhousenumber'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['housenumber'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//postcode
if (isset($_POST['postcode'])) {
    $curval = $_POST['curvalpostcode'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['postcode'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//city
if (isset($_POST['city'])) {
    $curval = $_POST['curvalcity'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['city'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//phonenumber
if (isset($_POST['phonenumber'])) {
    $curval = $_POST['curvalphonenumber'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['phonenumber'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//email
if (isset($_POST['email'])) {
    $curval = $_POST['curvalemail'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['email'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}
//website
if (isset($_POST['web'])) {
    $curval = $_POST['curvalweb'];
    $sql    = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix($table) . ' SET ' . $field . "='" . $_POST['web'] . "' WHERE ID='" . $dogid . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $chow = 1;
}

//check for access and completion
if ($ch) {
    redirect_header('dog.php?id=' . $dogid, 1, _MD_DATACHANGED);
} elseif ($chow) {
    redirect_header('owner.php?ownid=' . $dogid, 1, _MD_DATACHANGED);
} else {
    foreach ($_POST as $key => $values) {
        $filesval .= $key . ' : ' . $values . '<br>';
    }

    redirect_header('dog.php?id=' . $dogid, 15, 'ERROR!!<br>' . $filesval);

    //redirect_header("dog.php?id=".$dogid,1,_MD_DATACHANGED);
}
//footer
include XOOPS_ROOT_PATH . '/footer.php';
