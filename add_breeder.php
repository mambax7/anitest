<?php
// -------------------------------------------------------------------------

use Xmf\Request;

require_once __DIR__ . '/../../mainfile.php';
$moduleDirName = basename(__DIR__);
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_adddog.tpl';

include XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', 'Pedigree database - Add owner/breeder');

//check for access
$xoopsModule = XoopsModule::getByDirname($moduleDirName);
if (empty($xoopsUser)) {
    redirect_header('index.php', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}

$f = isset($_GET['f']) ? $_GET['f'] : '';
if ($f === 'check') {
    check();
}

function check()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB, $xoopsModuleConfig;
    //check for access
    $xoopsModule = XoopsModule::getByDirname($moduleDirName);
    if (empty($xoopsUser)) {
        redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
    }
    $achternaam = Request::getString('achternaam', '', 'POST');
    $voornaam   = Request::getString('voornaam', '', 'POST');
    $email      = Request::getEmail('email', '', 'POST');
    $website    = Request::getUrl('website', '', 'POST');
    $user       = Request::getString('user', '', 'POST');

    //insert into eigenaar
    $query = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " VALUES (NULL,'" . $voornaam . "','" . $achternaam . "','','','','','','" . $email . "','" . $website . "','" . $user . "')";
    $GLOBALS['xoopsDB']->queryF($query);
    redirect_header('index.php', 1, 'The data has been stored.');
}

global $xoopsTpl, $xoopsUser, $xoopsDB;
//check for access
$xoopsModule = XoopsModule::getByDirname($moduleDirName);
if (empty($xoopsUser)) {
    redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}
//create form
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$form = new XoopsThemeForm(_PED_ADD_OWNER, 'breedername', 'add_breeder.php?f=check', 'POST');
$form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
$form->addElement(new XoopsFormHidden('user', $xoopsUser->getVar('uid')));
//lastname
$form->addElement(new XoopsFormText('<b>' . _PED_FLD_OWN_LNAME . '</b>', 'achternaam', $size = 50, $maxsize = 255, $value = ''));

//firstname
$form->addElement(new XoopsFormText('<b>' . _PED_FLD_OWN_FNAME . '</b>', 'voornaam', $size = 50, $maxsize = 255, $value = ''));

//email
$form->addElement(new XoopsFormText('<b>' . _PED_FLD_OWN_EMAIL . '</b>', 'email', $size = 50, $maxsize = 255, $value = ''));

//website
$form->addElement(new XoopsFormText('<b>' . _PED_FLD_OWN_WEB . '</b>', 'website', $size = 50, $maxsize = 255, $value = ''));
$form->addElement(new XoopsFormLabel(_PED_EXPLAIN, _PED_FLD_OWN_WEB_EX));

//submit button
$form->addElement(new XoopsFormButton('', 'button_id', _PED_ADD_OWNER, 'submit'));

//add data (form) to smarty template
$xoopsTpl->assign('form', $form->render());

//footer
include XOOPS_ROOT_PATH . '/footer.php';
