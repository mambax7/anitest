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

/*
// Get all HTTP post or get parameters into global variables that are prefixed with "param_"
//import_request_variables("gp", "param_");
extract($_GET, EXTR_PREFIX_ALL, "param");
extract($_POST, EXTR_PREFIX_ALL, "param");
*/

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_result.tpl';

include XOOPS_ROOT_PATH . '/header.php';

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

$perp = $moduleConfig['perpage'];

global $xoopsTpl;
global $xoopsDB;
global $xoopsModuleConfig;

if (!$st) {
    $st = 0;
}
if (!$com) {
    $com = 'vader';
}

//count total number of dogs
$numdog = 'SELECT count( ' . $com . ' ) AS X, ' . $com . ' FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ' . $com . ' !=0 GROUP BY ' . $com;
$numres = $GLOBALS['xoopsDB']->query($numdog);
//total number of dogs the query will find
$numresults = $GLOBALS['xoopsDB']->getRowsNum($numres);
//total number of pages
$numpages = floor($numresults / $perp) + 1;
if (($numpages * $perp) == ($numresults + $perp)) {
    --$numpages;
}
//find current page
$cpage = floor($st / $perp) + 1;
//create previous button
if ($numpages > 1) {
    if ($cpage > 1) {
        $pages .= '<a href="topstud.php?com=' . $com . '&st=' . ($st - $perp) . '">' . _PED_PREVIOUS . '</a>&nbsp;&nbsp;';
    }
}
//create numbers
for ($x = 1; $x < ($numpages + 1); $x++) {
    //create line break after 20 number
    if (($x % 20) == 0) {
        $pages .= '<br>';
    }
    if ($x != $cpage) {
        $pages .= '<a href="topstud.php?com=' . $com . '&st=' . ($perp * ($x - 1)) . '">' . $x . '</a>&nbsp;&nbsp;';
    } else {
        $pages .= $x . '&nbsp;&nbsp';
    }
}
//create next button
if ($numpages > 1) {
    if ($cpage < $numpages) {
        $pages .= '<a href="topstud.php?com=' . $com . '&st=' . ($st + $perp) . '">' . _PED_NEXT . '</a>&nbsp;&nbsp;';
    }
}
//query
$queryString = 'SELECT count( d.'
               . $com
               . ' ) AS X, d.'
               . $com
               . ', p.NAAM as p_NAAM, p.vader as p_vader, p.moeder as p_moeder, p.coi as p_coi, p.foto as p_foto FROM '
               . $GLOBALS['xoopsDB']->prefix('stamboom')
               . ' d LEFT JOIN '
               . $GLOBALS['xoopsDB']->prefix('stamboom')
               . ' p ON d.'
               . $com
               . ' = p.id WHERE d.'
               . $com
               . ' !=0 GROUP BY d.'
               . $com
               . ' ORDER BY X DESC LIMIT '
               . $st
               . ', '
               . $perp;
$result      = $GLOBALS['xoopsDB']->query($queryString);

while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    $numofcolumns = 2;
    if ($com === 'vader') {
        $gender = '<img src="images/male.gif">';
    } else {
        $gender = '<img src="images/male.gif">';
    }
    //read coi% information if exists or create link if not
    if ($row['p_coi'] == '' || $row['p_coi'] == '0') {
        $coi = '<a href="coi.php?s=' . $row['p_vader'] . '&d=' . $row['p_moeder'] . '&dogid=' . $row[$com] . '&detail=1">' . _PED_UNKNOWN . '</a>';
    } else {
        $coi = $row['p_coi'] . ' %';
    }
    //number of pups
    $dob = $row['X'];
    //create array for dogs
    if ($row['p_foto'] != '') {
        $camera = ' <img src="images/camera.png">';
    } else {
        $camera = '';
    }
    $name = stripslashes($row['p_NAAM']) . $camera;
    for ($i = 1; $i < $numofcolumns; $i++) {
        $columnvalue[] = array('value' => $coi);
        $columnvalue[] = array('value' => $row['X']);
    }
    $dogs[] = array('id' => $row[$com], 'name' => $name, 'gender' => $gender, 'link' => '<a href="pedigree.php?pedid=' . $row[$com] . '">' . $name . '</a>', 'colour' => '', 'number' => '', 'usercolumns' => $columnvalue);
    unset($columnvalue);
}
$columns[] = array('columnname' => 'Name', 'columnnumber' => 1);
$columns[] = array('columnname' => 'COI%', 'columnnumber' => 2);
$columns[] = array('columnname' => 'Offspring', 'columnnumber' => 3);

//add data to smarty template
//assign dog
$xoopsTpl->assign('dogs', $dogs);
$xoopsTpl->assign('columns', $columns);
$xoopsTpl->assign('numofcolumns', $numofcolumns);
$xoopsTpl->assign('tsarray', sorttable($numofcolumns));
//find last shown number
if (($st + $perp) > $numresults) {
    $lastshown = $numresults;
} else {
    $lastshown = $st + $perp;
}
//create string
$matches     = _PED_MATCHES;
$nummatchstr = $numresults . $matches . ($st + 1) . '-' . $lastshown . ' (' . $numpages . ' pages)';
$xoopsTpl->assign('nummatch', strtr($nummatchstr, array('[animalTypes]' => $moduleConfig['animalTypes'])));
$xoopsTpl->assign('pages', $pages);

//comments and footer
include XOOPS_ROOT_PATH . '/footer.php';
