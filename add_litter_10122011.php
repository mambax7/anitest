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

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_addlitter.tpl';

include XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', 'Pedigree database - add a litter');

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('index.php', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

if (!isset($f)) {
    addlitter();
} else {
    if ($f === 'sire') {
        sire();
    }
    if ($f === 'dam') {
        dam();
    }
    if ($f === 'check') {
        check();
    }
}

function addlitter()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;

    //get module configuration
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

    //create form
    $form   = "<form name='dogname' id='dogname' action='add_litter.php?f=sire' method='POST' onsubmit='return xoopsFormValidate_dogname();'>";
    $form   .= $GLOBALS['xoopsSecurity']->getTokenHTML();
    $form   .= "<input type='hidden' name='user' id='user' value='" . $xoopsUser->getVar('uid') . "' />";
    $random = (mt_rand() % 1000);
    $form   .= "<input type='hidden' name='random' id='random' value='" . $random . "' />";
    //create form contents
    for ($count = 1; $count < 21; $count++) {
        $name   = "<input type='text' name='NAAM" . $count . "' id='NAAM" . $count . "' size='100' maxlength='255' value='' />";
        $gender = "<input type='radio' name='roft" . $count . "' value='0' checked /><img src=\"images/male.gif\"><input type='radio' name='roft" . $count . "' value='1' /><img src=\"images/female.gif\">";
        $dogs[] = array('number' => $count, 'name' => $name, 'gender' => $gender);
    }

    if ($moduleConfig['ownerbreeder'] == '1') {
        //breeder
        $breeder  = "<select  size='1' name='id_fokker' id='id_fokker'>";
        $queryfok = 'SELECT ID, firstname, lastname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' ORDER BY lastname';
        $resfok   = $GLOBALS['xoopsDB']->query($queryfok);
        $breeder  .= "<option value='0'>Onbekend</option>";
        while ($rowfok = $GLOBALS['xoopsDB']->fetchArray($resfok)) {
            $breeder .= "<option value='" . $rowfok['ID'] . "'>" . $rowfok['lastname'] . ', ' . $rowfok['firstname'] . '</option>';
        }
        $breeder .= '</select>';
    }

    //submit button
    $father = strtr(_PED_ADD_SIRE, array('[father]' => $moduleConfig['father']));
    $submit = "<input type='submit' class='formButton' name='button_id'  id='button_id' value='" . $father . "' />";
    //add data (form) to smarty template
    $xoopsTpl->assign('form', $form);
    $xoopsTpl->assign('dogs', $dogs);
    $xoopsTpl->assign('formtit', strtr(_PED_ADD_LITTER, array('[litter]' => $moduleConfig['litter'])));
    $xoopsTpl->assign('submit', $submit);
}

function sire()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;

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
    $user = $_POST['user'];
    if (empty($random)) {
        $random = $_POST['random'];
    }
    if (isset($_GET['random'])) {
        $random = $_GET['random'];
    }
    if (empty($st)) {
        $st = 0;
    }
    if (isset($_GET['st'])) {
        $st = $_GET['st'];
    }
    for ($count = 1; $count < 21; $count++) {
        $namelitter = 'NAAM' . $count;
        $roftlitter = 'roft' . $count;
        //check for an empty name
        if ($_POST[$namelitter] !== '') {
            $name .= ':' . $_POST[$namelitter];
            $roft .= ':' . $_POST[$roftlitter];
        } else {
            if ($count == '1') {
                redirect_header('add_litter.php', 3, _PED_ADD_NAMEPLZ);
            }
        }
    }
    if (isset($_POST['id_fokker'])) {
        $id_fokker = $_POST['id_fokker'];
    } else {
        $id_fokker = '0';
    }

    //make the redirect
    if (!isset($_GET['r'])) {
        //create animal object
        $animal = new Animal();
        //test to find out how many user fields there are..
        $fields = $animal->numoffields();
        sort($fields);
        $usersql = '';
        for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
            $userfield   = new Field($fields[$i], $animal->getconfig());
            $fieldType   = $userfield->getSetting('FieldType');
            $fieldobject = new $fieldType($userfield, $animal);
            $defvalue    = $fieldobject->defaultvalue;
            $usersql     .= ",'" . $defvalue . "'";
            //echo $fields[$i]."<br/>";
        }

        //insert into stamboom_temp
        $query = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('stamboom_temp') . " VALUES ('" . $random . "','" . unhtmlentities($name) . "','" . $id_eigenaar . "','" . $id_fokker . "','" . $user . "','" . $roft . "','','','', ''" . $usersql . ')';
        $GLOBALS['xoopsDB']->query($query);
        //echo $query; die();
        redirect_header('add_litter.php?f=sire&random=' . $random . '&st=' . $st . '&r=1&l=a', 1, strtr(_PED_ADD_SIREPLZ, array('[father]' => $moduleConfig['father'])));
    }
    //find letter on which to start else set to 'a'
    if (isset($_GET['l'])) {
        $l = $_GET['l'];
    } else {
        $l = 'a';
    }
    //assign 'sire' to the template
    $xoopsTpl->assign('sire', '1');
    //create list of males dog to select from
    $perp = $moduleConfig['perpage'];
    //count total number of dogs
    $numdog = 'SELECT ID FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft='0' AND NAAM LIKE '" . $l . "%'";
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
        if ($l == chr($i)) {
            $pages .= '<b><a href="add_litter.php?f=sire&r=1&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a></b>&nbsp;';
        } else {
            $pages .= '<a href="add_litter.php?f=sire&r=1&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a>&nbsp;';
        }
    }
    $pages .= '-&nbsp;';
    $pages .= '<a href="add_litter.php?f=sire&r=1&random=' . $random . '&l=�">�</a>&nbsp;';
    $pages .= '<a href="add_litter.php?f=sire&r=1&random=' . $random . '&l=�">�</a>&nbsp;';
    //create linebreak
    $pages .= '<br>';
    //create previous button
    if ($numpages > 1) {
        if ($cpage > 1) {
            $pages .= '<a href="add_litter.php?f=sire&r=1&l=' . $l . '&random=' . $random . '&st=' . ($st - $perp) . '">' . _PED_PREVIOUS . '</a>&nbsp;&nbsp';
        }
    }
    //create numbers
    for ($x = 1; $x < ($numpages + 1); $x++) {
        //create line break after 20 number
        if (($x % 20) == 0) {
            $pages .= '<br>';
        }
        if ($x != $cpage) {
            $pages .= '<a href="add_litter.php?f=sire&r=1&l=' . $l . '&random=' . $random . '&st=' . ($perp * ($x - 1)) . '">' . $x . '</a>&nbsp;&nbsp;';
        } else {
            $pages .= $x . '&nbsp;&nbsp';
        }
    }
    //create next button
    if ($numpages > 1) {
        if ($cpage < $numpages) {
            $pages .= '<a href="add_litter.php?f=sire&r=1&l=' . $l . '&random=' . $random . '&st=' . ($st + $perp) . '">' . _PED_NEXT . '</a>&nbsp;&nbsp';
        }
    }
    //query
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft = '0' AND NAAM LIKE '" . $l . "%' ORDER BY NAAM LIMIT " . $st . ', ' . $perp;
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
    $dogs [] = array(
        'id'          => '0',
        'name'        => '',
        'gender'      => '',
        'link'        => '<a href="add_litter.php?f=dam&random=' . $random . '&selsire=0">' . strtr(_PED_ADD_SIREUNKNOWN, array('[father]' => $moduleConfig['father'])) . '</a>',
        'colour'      => '',
        'number'      => '',
        'usercolumns' => $empty
    );

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
        $dogs[] = array(
            'id'          => $row['ID'],
            'name'        => $name,
            'gender'      => '<img src="images/male.gif">',
            'link'        => '<a href="add_litter.php?f=dam&random=' . $random . '&selsire=' . $row['ID'] . '">' . $name . '</a>',
            'colour'      => '',
            'number'      => '',
            'usercolumns' => $columnvalue
        );
    }

    //add data to smarty template
    //assign dog
    $xoopsTpl->assign('dogs', $dogs);
    $xoopsTpl->assign('columns', $columns);
    $xoopsTpl->assign('numofcolumns', $numofcolumns);
    $xoopsTpl->assign('tsarray', sorttable($numofcolumns));
    $xoopsTpl->assign('nummatch', strtr(_PED_ADD_SELSIRE, array('[father]' => $moduleConfig['father'])));
    $xoopsTpl->assign('pages', $pages);
}

function dam()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;

    //get module configuration
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

    if (empty($random)) {
        $random = $_POST['random'];
    }
    if (isset($_GET['random'])) {
        $random = $_GET['random'];
    }
    if (empty($st)) {
        $st = 0;
    }
    if (isset($_GET['st'])) {
        $st = $_GET['st'];
    }
    //make the redirect
    if (!isset($_GET['r'])) {
        //insert into stamboom_temp
        $query = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom_temp') . ' SET vader =' . $_GET['selsire'] . ' WHERE ID=' . $random;
        $GLOBALS['xoopsDB']->queryf($query);
        redirect_header('add_litter.php?f=dam&random=' . $random . '&st=' . $st . '&r=1', 1, strtr(_PED_ADD_SIREOK, array('[mother]' => $moduleConfig['mother'])));
    }
    //find letter on which to start else set to 'a'
    if (isset($_GET['l'])) {
        $l = $_GET['l'];
    } else {
        $l = 'a';
    }
    //assign sire to the template
    $xoopsTpl->assign('sire', '1');
    //create list of males dog to select from
    $perp = $moduleConfig['perpage'];
    //count total number of dogs
    $numdog = 'SELECT ID FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft='1' AND NAAM LIKE '" . $l . "%'";
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
        if ($l == chr($i)) {
            $pages .= '<b><a href="add_litter.php?f=dam&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a></b>&nbsp;';
        } else {
            $pages .= '<a href="add_litter.php?f=dam&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a>&nbsp;';
        }
    }
    $pages .= '-&nbsp;';
    $pages .= '<a href="add_litter.php?f=dam&r=1&random=' . $random . '&l=�">�</a>&nbsp;';
    $pages .= '<a href="add_litter.php?f=dam&r=1&random=' . $random . '&l=�">�</a>&nbsp;';
    //create linebreak
    $pages .= '<br>';
    //create previous button
    if ($numpages > 1) {
        if ($cpage > 1) {
            $pages .= '<a href="add_litter.php?f=dam&r=1&l=' . $l . '&random=' . $random . '&st=' . ($st - $perp) . '">' . _PED_PREVIOUS . '</a>&nbsp;&nbsp';
        }
    }
    //create numbers
    for ($x = 1; $x < ($numpages + 1); $x++) {
        //create line break after 20 number
        if (($x % 20) == 0) {
            $pages .= '<br>';
        }
        if ($x != $cpage) {
            $pages .= '<a href="add_litter.php?f=dam&r=1&l=' . $l . '&random=' . $random . '&st=' . ($perp * ($x - 1)) . '">' . $x . '</a>&nbsp;&nbsp;';
        } else {
            $pages .= $x . '&nbsp;&nbsp';
        }
    }
    //create next button
    if ($numpages > 1) {
        if ($cpage < $numpages) {
            $pages .= '<a href="add_litter.php?f=dam&r=1&l=' . $l . '&random=' . $random . '&st=' . ($st + $perp) . '">' . _PED_NEXT . '</a>&nbsp;&nbsp';
        }
    }
    //query
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft = '1' AND NAAM LIKE '" . $l . "%' ORDER BY NAAM LIMIT " . $st . ', ' . $perp;
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
    $dogs [] = array(
        'id'          => '0',
        'name'        => '',
        'gender'      => '',
        'link'        => '<a href="add_litter.php?f=check&random=' . $random . '&seldam=0">' . strtr(_PED_ADD_DAMUNKNOWN, array('[mother]' => $moduleConfig['mother'])) . '</a>',
        'colour'      => '',
        'number'      => '',
        'usercolumns' => $empty
    );

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
        $dogs[] = array(
            'id'          => $row['ID'],
            'name'        => $name,
            'gender'      => '<img src="images/female.gif">',
            'link'        => '<a href="add_litter.php?f=check&random=' . $random . '&seldam=' . $row['ID'] . '">' . $name . '</a>',
            'colour'      => '',
            'number'      => '',
            'usercolumns' => $columnvalue
        );
    }

    //add data to smarty template
    //assign dog
    $xoopsTpl->assign('dogs', $dogs);
    $xoopsTpl->assign('columns', $columns);
    $xoopsTpl->assign('numofcolumns', $numofcolumns);
    $xoopsTpl->assign('tsarray', sorttable($numofcolumns));
    $xoopsTpl->assign('nummatch', strtr(_PED_ADD_SELDAM, array('[mother]' => $moduleConfig['mother'])));
    $xoopsTpl->assign('pages', $pages);
}

function check()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;

    //get module configuration
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

    if (empty($random)) {
        $random = $_POST['random'];
    }
    if (isset($_GET['random'])) {
        $random = $_GET['random'];
    }
    //query
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_temp') . ' WHERE ID = ' . $random;
    $result      = $GLOBALS['xoopsDB']->query($queryString);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        //pull data apart.
        if ($row['NAAM'] !== '') {
            $genders = explode(':', $row['roft']);
            $names   = explode(':', $row['NAAM']);
            for ($c = 1; $c < count($names); $c++) {
                //create animal object
                $animal = new Animal();
                //test to find out how many user fields there are..
                $fields = $animal->numoffields();
                sort($fields);
                $usersql = '';
                for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
                    $userfield   = new Field($fields[$i], $animal->getconfig());
                    $fieldType   = $userfield->getSetting('FieldType');
                    $fieldobject = new $fieldType($userfield, $animal);
                    if ($userfield->active()) {
                        $usersql .= ",'" . addslashes($row['user' . $fields[$i]]) . "'";
                    } else {
                        $usersql .= ",'" . $fieldobject->defaultvalue . "'";
                    }
                    //echo $fields[$i]."<br/>";
                }

                //insert into stamboom_temp
                $query = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " VALUES ('','" . addslashes($names[$c]) . "','0','" . $row['id_fokker'] . "','" . $row['user'] . "','" . $genders[$c] . "','" . $_GET['seldam'] . "','" . $row['vader'] . "','',''" . $usersql . ')';
                $GLOBALS['xoopsDB']->queryf($query);
                //echo $query; die();
            }
        }
        $sqlquery = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_temp') . " WHERE ID='" . $random . "'";
        $GLOBALS['xoopsDB']->queryf($sqlquery);
    }
    redirect_header('latest.php', 1, strtr(_PED_ADD_LIT_OK, array('[animalTypes]' => $moduleConfig['animalTypes'])));
}

//footer
include XOOPS_ROOT_PATH . '/footer.php';
