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

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_welcome.tpl';
include XOOPS_ROOT_PATH . '/header.php';

global $xoopsTpl, $xoopsDB, $myts;

$myts = MyTextSanitizer::getInstance(); // MyTextSanitizer object

//query to count dogs
$result = $GLOBALS['xoopsDB']->query('SELECT count(*) FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom'));
list($numdogs) = $GLOBALS['xoopsDB']->fetchRow($result);

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

$word = $myts->displayTarea(strtr($moduleConfig['welcome'], array('[numanimals]' => $numdogs, '[animalType]' => $moduleConfig['animalType'], '[animalTypes]' => $moduleConfig['animalTypes'])));

$xoopsTpl->assign('welcome', _PED_WELCOME);
$xoopsTpl->assign('word', $word);
//comments and footer
include XOOPS_ROOT_PATH . '/footer.php';
