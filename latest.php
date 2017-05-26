<?php
// -------------------------------------------------------------------------

require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/class_field.php';
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';
//path taken

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_latest.tpl';

include XOOPS_ROOT_PATH . '/header.php';

$pages   = '';
$animals = [];

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

if (isset($st)) {
    $st = $_GET['st'];
} else {
    $st = 0;
}

$perp = $moduleConfig['perpage'];
global $xoopsTpl, $xoopsDB, $xoopsModuleConfig, $xoopsUser;

//iscurrent user a module admin ?
$modadmin    = false;
$xoopsModule = XoopsModule::getByDirname('animal');
if (!empty($xoopsUser)) {
    if ($xoopsUser->isAdmin($xoopsModule->mid())) {
        $modadmin = true;
    }
}

//count total number of animals
$numanimal = 'SELECT ID FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' LIMIT 500';
$numres    = $GLOBALS['xoopsDB']->query($numanimal);
//total number of animals the query will find
$numresults = $GLOBALS['xoopsDB']->getRowsNum($numres);
//total number of pages
$numpages = floor($numresults / $perp) + 1;
if (($numpages * $perp) == ($numresults + $perp)) {
    --$numpages;
}
//find current page
$cpage = floor($st / $perp) + 1;

//create numbers
for ($x = 1; $x < ($numpages + 1); $x++) {
    {
        $pages = $x . '&nbsp;&nbsp';
    }
}

//query
$queryString = 'SELECT d.id AS d_id, d.naam AS d_naam, d.roft AS d_roft, d.moeder AS d_moeder, d.vader AS d_vader, d.user AS d_user, f.id AS f_id, f.naam AS f_naam, m.id AS m_id, m.naam AS m_naam, u.uname AS u_uname FROM '
               . $GLOBALS['xoopsDB']->prefix('stamboom')
               . ' d LEFT JOIN '
               . $GLOBALS['xoopsDB']->prefix('stamboom')
               . ' f ON d.vader = f.id LEFT JOIN '
               . $GLOBALS['xoopsDB']->prefix('stamboom')
               . ' m ON d.moeder = m.id LEFT JOIN '
               . $GLOBALS['xoopsDB']->prefix('users')
               . ' u ON d.user = u.uid ORDER BY d.id DESC LIMIT '
               . $st
               . ', '
               . $perp;
$result      = $GLOBALS['xoopsDB']->query($queryString);

while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    //reset $gender
    $gender = '';
    if (!empty($xoopsUser)) {
        if ($row['d_user'] == $xoopsUser->getVar('uid') || $modadmin === true) {
            $gender = '<a href="dog.php?id=' . $row['d_id'] . '"><img src="images/edit.gif" alt=' . _PED_BTN_EDIT . '></a><a href="delete.php?id=' . $row['d_id'] . '"><img src="images/delete.gif" alt=' . _PED_BTN_DELE . '></a>';
        } else {
            $gender = '';
        }
    }

    if ($row['d_roft'] == 0) {
        $gender .= '<img src="images/male.gif">';
    } else {
        $gender .= '<img src="images/female.gif">';
    }
    //create string for parents
    if ($row['f_naam'] == '') {
        $dad = _PED_UNKNOWN;
    } else {
        $dad = '<a href="pedigree.php?pedid=' . $row['f_id'] . '">' . stripslashes($row['f_naam']) . '</a>';
    }
    if ($row['m_naam'] == '') {
        $mom = _PED_UNKNOWN;
    } else {
        $mom = '<a href="pedigree.php?pedid=' . $row['m_id'] . '">' . stripslashes($row['m_naam']) . '</a>';
    }
    $parents = $dad . ' x ' . $mom;
    //create array for animals
    $animals[] = array('id' => $row['d_id'], 'name' => stripslashes($row['d_naam']), 'gender' => $gender, 'parents' => $parents, 'addedby' => '<a href="../../userinfo.php?uid=' . $row['d_user'] . '">' . $row['u_uname'] . '</a>');
    //reset rights ready for the next dog
    $editdel = '0';
}

//add data to smarty template
//assign dog
$xoopsTpl->assign('dogs', $animals);

//find last shown number
if (($st + $perp) > $numresults) {
    $lastshown = $numresults;
} else {
    $lastshown = $st + $perp;
}
//create string
$matches     = strtr(_PED_MATCHES, array('[animalTypes]' => $moduleConfig['animalTypes']));
$nummatchstr = $numresults . $matches . ($st + 1) . '-' . $lastshown . ' (' . $numpages . ' pages)';
$xoopsTpl->assign('nummatch', $nummatchstr);
$xoopsTpl->assign('pages', $pages);
$xoopsTpl->assign('name', _PED_FLD_NAME);
$xoopsTpl->assign('parents', _PED_PA);
$xoopsTpl->assign('addedby', _PED_FLD_DBUS);
//comments and footer
include XOOPS_ROOT_PATH . '/footer.php';
