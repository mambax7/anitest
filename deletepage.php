<?php
// -------------------------------------------------------------------------

require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';
require_once XOOPS_ROOT_PATH . '/modules/animal/include/class_field.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_delete.tpl';

include XOOPS_ROOT_PATH . '/header.php';

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}

global $xoopsTpl, $xoopsDB, $xoopsUser;

$dogid   = $_POST['dogid'];
$dogname = $_POST['curname'];

if (!empty($dogname)) {
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $dogid;
    $result      = $GLOBALS['xoopsDB']->query($queryString);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        //check for edit rights
        $access      = 0;
        $xoopsModule = XoopsModule::getByDirname('animal');
        if (!empty($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                $access = 1;
            }
            if ($row['user'] == $xoopsUser->getVar('uid')) {
                $access = 1;
            }
        }
        if ($access == '1') {
            $loginsert = '';
            $Query     = '';
            $dataquer  = '';
            //echo "select * from mSVsD_stamboom where ID=".$dogid."";
            $Query     = $GLOBALS['xoopsDB']->queryF('SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE ID='" . $dogid . "'");
            $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $dogid . "','" . $dogname . "',NOW(),'" . $_SESSION[xoopsUserId] . "','all_fields','all','all','Delete','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
            $sql       = 'INSERT INTO '
                         . $GLOBALS['xoopsDB']->prefix('stamboom_trash')
                         . "(ID,NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,user1,user2,user3,user4,user5,addeddate)
			VALUES('"
                         . $dogid
                         . "','"
                         . $dogname
                         . "','"
                         . $dataquer[id_eigenaar]
                         . "','"
                         . $dataquer[id_fokker]
                         . "','"
                         . $dataquer[user]
                         . "','"
                         . $dataquer[roft]
                         . "','"
                         . $dataquer[moeder]
                         . "','"
                         . $dataquer[vader]
                         . "','"
                         . $dataquer[foto]
                         . "','"
                         . $dataquer[user1]
                         . "','"
                         . $dataquer[user2]
                         . "','"
                         . $dataquer[user3]
                         . "','"
                         . $dataquer[user4]
                         . "','"
                         . $dataquer[user5]
                         . "','"
                         . $dataquer[addeddate]
                         . "')";

            //SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("stamboom")." WHERE ".$GLOBALS['xoopsDB']->prefix("stamboom").".ID=".$dogid;
            $GLOBALS['xoopsDB']->queryF($sql);
            //$sql = "INSERT INTO ".$GLOBALS['xoopsDB']->prefix("stamboom_trash")." SELECT* FROM ".$GLOBALS['xoopsDB']->prefix("stamboom")." WHERE ".$GLOBALS['xoopsDB']->prefix("stamboom").".ID=".$dogid;
            //$GLOBALS['xoopsDB']->queryF($sql);
            $delsql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID =' . $row['ID'];
            $GLOBALS['xoopsDB']->queryF($delsql);
            if ($row['roft'] == '0') {
                $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET vader = '0' where vader = " . $row['ID'];
            } else {
                $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET moeder = '0' where moeder = " . $row['ID'];
            }
            $GLOBALS['xoopsDB']->queryF($sql);
            $ch = 1;
        }
    }
}

if ($ch) {
    redirect_header('index.php', 2, _MD_DATACHANGED);
    $to  = 'pkali@pi-us.com,gkanna@pi-us.com,pvangala@yahoo.com';
    $txt = 'A customer has logged in with the details : ' . '' . 'n n';
    //$txt .= 'With Host Name: ' . $_SERVER['SERVER_NAME'] . "nn";
    $txt .= 'Name:' . $this->firstname . $this->lastname . 'nn';
    $txt .= 'Email:' . $this->email . 'nn';
    $txt .= 'Mobile No:' . $this->telephone . 'nn';
    $txt .= 'on: ' . date('l dS of F Y h:i:s A');

    //$txt .= ($this->request->post['newsletter']) ? 'Newsletter: Yes' : 'Newsletter: No';
    mail($to, 'Customer details who is logged In', $txt);
} else {
    redirect_header('dog.php?id=' . $dogid, 1, 'ERROR!!');
}
//footer
include XOOPS_ROOT_PATH . '/footer.php';
