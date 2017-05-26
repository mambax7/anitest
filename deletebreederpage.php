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

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_delete.tpl';

include XOOPS_ROOT_PATH . '/header.php';

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}

global $xoopsTpl, $xoopsDB, $xoopsUser;

$ownid     = $_POST['dogid'];
$ownername = $_POST['curname'];

if (!empty($ownername)) {
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' WHERE ID=' . $ownid;
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
            $delsql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' WHERE ID =' . $row['ID'];
            $GLOBALS['xoopsDB']->queryF($delsql);
            $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET id_eigenaar = '0' where id_eigenaar = " . $row['ID'];
            $GLOBALS['xoopsDB']->queryF($sql);
            $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET id_fokker = '0' where id_fokker = " . $row['ID'];
            $GLOBALS['xoopsDB']->queryF($sql);
            $ch = 1;
        }
    }
}

if ($ch) {
    redirect_header('index.php', 1, _MD_DATACHANGED);
} else {
    redirect_header('owner.php?ownid=' . $ownid, 1, 'ERROR!!');
}
//footer
include XOOPS_ROOT_PATH . '/footer.php';
