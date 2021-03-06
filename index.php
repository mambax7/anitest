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

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_index.tpl';

include XOOPS_ROOT_PATH . '/header.php';

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

index_main();

//footer
include XOOPS_ROOT_PATH . '/footer.php';

// Displays the "Main" tab of the module
function index_main()
{
    global $xoopsTpl, $moduleConfig;

    $usersearch = array();
    //create animal object
    $animal = new Animal();

    //test to find out how many user fields there are..
    $fields = $animal->numoffields();

    for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
        $userfield = new Field($fields[$i], $animal->getconfig());
        if ($userfield->active() && $userfield->hassearch()) {
            $fieldType   = $userfield->getSetting('FieldType');
            $fieldobject = new $fieldType($userfield, $animal);
            $function    = 'user' . $fields[$i] . $fieldobject->getsearchstring();
            //echo $function."<br>";
            $usersearch[] = array(
                'title'       => $userfield->getSetting('SearchName'),
                'searchid'    => 'user' . $fields[$i],
                'function'    => $function,
                'explenation' => $userfield->getSetting('SearchExplenation'),
                'searchfield' => $fieldobject->searchfield()
            );
        }
    }

    //add data to smarty template
    $xoopsTpl->assign('sselect', strtr(_PED_SELECT, array('[animalType]' => $moduleConfig['animalType'])));
    $xoopsTpl->assign('explain', _PED_EXPLAIN);
    $xoopsTpl->assign('sname', _PED_SEARCHNAME);
    $xoopsTpl->assign('snameex', strtr(_PED_SEARCHNAME_EX, array('[animalTypes]' => $moduleConfig['animalTypes'])));
    $xoopsTpl->assign('usersearch', $usersearch);
}
