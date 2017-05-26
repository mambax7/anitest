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

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_sel.tpl';

include XOOPS_ROOT_PATH . '/header.php';

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

if (!$st) {
    $st = 0;
}
$curval = $_GET['curval'];
$letter = $_GET['letter'];
$gend   = $_GET['gend'];
if (!$letter) {
    $letter = 'a';
}
if (!$gend) {
    $gend = 0;
}

$perp = $moduleConfig['perpage'];

global $xoopsTpl;
global $xoopsDB;
global $xoopsModuleConfig;

$xoopsTpl->assign('page_title', _MI_PEDIGREE_TITLE);

//count total number of dogs
$numdog = 'SELECT ID FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM LIKE '" . $letter . "%' AND roft = '" . $gend . "'";
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
//create alphabet
$pages = '';
for ($i = 65; $i <= 90; $i++) {
    if ($letter == chr($i)) {
        $pages .= '<b><a href="seldog.php?gend=' . $gend . '&curval=' . $curval . '&letter=' . chr($i) . '">' . chr($i) . '</a></b>&nbsp;';
    } else {
        $pages .= '<a href="seldog.php?gend=' . $gend . '&curval=' . $curval . '&letter=' . chr($i) . '">' . chr($i) . '</a>&nbsp;';
    }
}
$pages .= '-&nbsp;';
$pages .= '<a href="seldog.php?gend=' . $gend . '&curval=' . $curval . '&letter=�">�</a>&nbsp;';
$pages .= '<a href="seldog.php?gend=' . $gend . '&curval=' . $curval . '&letter=�">�</a>&nbsp;';
//create linebreak
$pages .= '<br>';
//create previous button
if ($numpages > 1) {
    if ($cpage > 1) {
        $pages .= '<a href="seldog.php?gend=' . $gend . '&curval=' . $curval . '&letter=' . $letter . '&st=' . ($st - $perp) . '">' . _PED_PREVIOUS . '</a>&nbsp;&nbsp';
    }
}
//create numbers
for ($x = 1; $x < ($numpages + 1); $x++) {
    //create line break after 20 number
    if (($x % 20) == 0) {
        $pages .= '<br>';
    }
    if ($x != $cpage) {
        $pages .= '<a href="seldog.php?gend=' . $gend . '&curval=' . $curval . '&letter=' . $letter . '&st=' . ($perp * ($x - 1)) . '">' . $x . '</a>&nbsp;&nbsp';
    } else {
        $pages .= $x . '&nbsp;&nbsp';
    }
}
//create next button
if ($numpages > 1) {
    if ($cpage < $numpages) {
        $pages .= '<a href="seldog.php?gend=' . $gend . '&curval=' . $curval . '&letter=' . $letter . '&st=' . ($st + $perp) . '">' . _PED_NEXT . '</a>&nbsp;&nbsp';
    }
}

//query
$queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM LIKE '" . $letter . "%' AND roft = '" . $gend . "' ORDER BY NAAM LIMIT " . $st . ', ' . $perp;
$result      = $GLOBALS['xoopsDB']->query($queryString);

$animal = new Animal();
//test to find out how many user fields there are...
$fields       = $animal->numoffields();
$numofcolumns = 1;
$columns[]    = array('columnname' => 'Name');
for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
    $userfield   = new Field($fields[$i], $animal->getconfig());
    $fieldType   = $userfield->getSetting('FieldType');
    $fieldobject = new $fieldType($userfield, $animal);
    if ($userfield->active() && $userfield->inlist()) {
        $columns[] = array('columnname' => $fieldobject->fieldname, 'columnnumber' => $userfield->getID());
        $numofcolumns++;
    }
}

for ($i = 1; $i < $numofcolumns; $i++) {
    $empty[] = array('value' => '');
}
if ($gend == '0') {
    $dogs [] = array(
        'id'          => '0',
        'name'        => '',
        'gender'      => '',
        'link'        => '<a href="updatepage.php?gend=' . $gend . '&curval=' . $curval . '&thisid=0">' . strtr(_PED_ADD_SIREUNKNOWN, array('[father]' => $moduleConfig['father'])) . '</a>',
        'colour'      => '',
        'number'      => '',
        'usercolumns' => $empty
    );
} else {
    $dogs [] = array(
        'id'          => '0',
        'name'        => '',
        'gender'      => '',
        'link'        => '<a href="updatepage.php?gend=' . $gend . '&curval=' . $curval . '&thisid=0">' . strtr(_PED_ADD_DAMUNKNOWN, array('[mother]' => $moduleConfig['mother'])) . '</a>',
        'colour'      => '',
        'number'      => '',
        'usercolumns' => $empty
    );
}

while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    //create picture information
    if ($row['foto'] != '') {
        $camera = ' <img src="images/camera.png">';
    } else {
        $camera = '';
    }
    $name = stripslashes($row['NAAM']) . $camera;
    //empty array
    unset($columnvalue);
    //fill array
    for ($i = 1; $i < $numofcolumns; $i++) {
        $x = $columns[$i]['columnnumber'];
        //format value - cant use object because of query count
        if (substr($row['user' . $x], 0, 7) === 'http://') {
            $value = '<a href="' . $row['user' . $x] . '">' . $row['user' . $x] . '</a>';
        } else {
            $value = $row['user' . $x];
        }
        $columnvalue[] = array('value' => $value);
    }
    if ($gend == '0') {
        $dogs[] = array(
            'id'          => $row['ID'],
            'name'        => $name,
            'gender'      => '<img src="images/male.gif">',
            'link'        => '<a href="updatepage.php?gend=' . $gend . '&curval=' . $curval . '&thisid=' . $row['ID'] . '">' . $name . '</a>',
            'colour'      => '',
            'number'      => '',
            'usercolumns' => $columnvalue
        );
    } else {
        $dogs[] = array(
            'id'          => $row['ID'],
            'name'        => $name,
            'gender'      => '<img src="images/female.gif">',
            'link'        => '<a href="updatepage.php?gend=' . $gend . '&curval=' . $curval . '&thisid=' . $row['ID'] . '">' . $name . '</a>',
            'colour'      => '',
            'number'      => '',
            'usercolumns' => $columnvalue
        );
    }
}

//add data to smarty template
//assign dog
$xoopsTpl->assign('dogs', $dogs);
$xoopsTpl->assign('columns', $columns);
$xoopsTpl->assign('numofcolumns', $numofcolumns);
$xoopsTpl->assign('tsarray', sorttable($numofcolumns));
//add data to smarty template
if ($gend == '0') {
    $seltitparent = strtr(_PED_FLD_FATH, array('[father]' => $moduleConfig['father']));
} else {
    $seltitparent = strtr(_PED_FLD_MOTH, array('[mother]' => $moduleConfig['mother']));
}
$seltitle = _PED_SEL . $seltitparent . _PED_FROM . getname($curval);

$xoopsTpl->assign('seltitle', $seltitle);

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
$xoopsTpl->assign('curval', $curval);
//comments and footer
include XOOPS_ROOT_PATH . '/footer.php';
