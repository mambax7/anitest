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

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}

global $xoopsTpl;
global $xoopsDB;
global $xoopsModuleConfig;

$id = $_GET['id'];
//query (find values for this dog (and format them))

$queryStrings = 'SELECT NAAM, user, roft FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE vader=' . $id . ' OR moeder=' . $id;
$results      = $GLOBALS['xoopsDB']->query($queryStrings);
$results1     = $GLOBALS['xoopsDB']->query($queryStrings);
$counts       = $GLOBALS['xoopsDB']->getRowsNum($results1);

$rows = $GLOBALS['xoopsDB']->fetchArray($results);
//echo "<pre>";print_r($rows);
if ($counts >= 1) {
    ?>
    <script>

        alert("This sugar glider has joeys and therefore cannot be deleted.Please contact the Pedigree Admin.[thepetglider@thepetglider.com]");
    </script>
    <?php
    redirect_header('index.php', 2, _MD_DATACHANGED);
}

$queryString = 'SELECT NAAM, user, roft FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $id;
$result      = $GLOBALS['xoopsDB']->query($queryString);

while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    //ID
    $id = $row['ID'];
    //name
    $naam     = htmlentities(stripslashes($row['NAAM']), ENT_QUOTES);
    $namelink = '<a href="dog.php?id=' . $row['ID'] . '">' . stripslashes($row['NAAM']) . '</a>';
    //user who entered the info
    $dbuser = $row['user'];
    $roft   = $row['roft'];
}

//create form
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$form = new XoopsThemeForm($naam, 'deletedata', 'deletepage.php', 'POST');
//hidden value current record owner
$form->addElement(new XoopsFormHidden('dbuser', $dbuser));
//hidden value dog ID
$form->addElement(new XoopsFormHidden('dogid', $_GET['id']));
$form->addElement(new XoopsFormHidden('curname', $naam));
$form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
$form->addElement(new XoopsFormLabel(_PED_DELE_SURE, 'Are you sure you want to delete this ' . $moduleConfig['animalType'] . ' : <b>' . $naam . '</b> ?'));
$pups = pups($_GET['id'], $roft);
$form->addElement(new XoopsFormLabel(_PED_DELE_WARN, 'Any ' . $moduleConfig['children'] . ' will also be orphaned by this action.<br><br>' . $pups));

$form->addElement(new XoopsFormButton('', 'button_id', _PED_BTN_DELE, 'submit'));
//add data (form) to smarty template
$xoopsTpl->assign('form', $form->render());

//footer
include XOOPS_ROOT_PATH . '/footer.php';

?>
