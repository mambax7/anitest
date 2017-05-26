<?php
// -------------------------------------------------------------------------

use Xmf\Request;

require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';
require_once XOOPS_ROOT_PATH . '/modules/animal/include/class_field.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_adddog.tpl';

include XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', 'Pedigree database - Update details');

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('index.php', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}

//create function variable from url
if (isset($_GET['f'])) {
    $f = $_GET['f'];
} else {
    $f = '';
    addDog();
}
if ($f === 'checkname') {
    checkname();
}
if ($f === 'sire') {
    sire();
}
if ($f === 'dam') {
    dam();
}
if ($f === 'check') {
    check();
}

function addDog()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;
    $moduleDirName = basename(__DIR__);
    //get module configuration
    /** @var XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname($moduleDirName);
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

    //check for access
    if (empty($xoopsUser)) {
        redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
        exit();
    }
    if ($xoopsUser->getVar('uid') == 0) {
        redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
        exit();
    }
    //create form
    include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $form = new XoopsThemeForm(strtr(_PED_ADD_DOG, array('[animalType]' => $moduleConfig['animalType'])), 'dogname', 'add_dog.php?f=checkname', 'POST');
    $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
    //create random value
    $random = (mt_rand() % 10000);
    $form->addElement(new XoopsFormHidden('random', $random));
    //find userid
    $form->addElement(new XoopsFormHidden('user', $xoopsUser->getVar('uid')));

    //name
    $form->addElement(new XoopsFormText('<b>' . _PED_FLD_NAME . '</b>', 'NAAM', $size = 50, $maxsize = 255, $value = ''));
    $string = strtr(_PED_FLD_NAME_EX, array('[animalType]' => $moduleConfig['animalType']));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, $string));

    //submit button
    $form->addElement(new XoopsFormButton('', 'button_id', strtr(_PED_ADD_DATA, array('[animalType]' => $moduleConfig['animalType'])), 'submit'));

    //add data (form) to smarty template
    $xoopsTpl->assign('form', $form->render());
}

function checkname()
{
    //configure global variables
    global $xoopsTpl, $xoopsDB, $xoopsUser;

    //get module configuration
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

    $name = $_POST['NAAM'];
    //query
    $queryString  = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM LIKE '%" . $name . "%' ORDER BY NAAM";
    $result       = $GLOBALS['xoopsDB']->query($queryString);
    $numresults   = $GLOBALS['xoopsDB']->getRowsNum($result);
    $queryString2 = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM = '" . addslashes($name) . "' ORDER BY NAAM";
    $result2      = $GLOBALS['xoopsDB']->query($queryString2);
    $numresults2  = $GLOBALS['xoopsDB']->getRowsNum($result2);
    if ($numresults >= 1 && !isset($_GET['r'])) {
        //create form
        include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $form = new XoopsThemeForm(strtr(_PED_ADD_DOG, array('[animalType]' => $moduleConfig['animalType'])), 'dogname', 'add_dog.php?f=checkname&r=1', 'POST');
        //other elements
        $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
        $form->addElement(new XoopsFormHidden('NAAM', $_POST['NAAM']));
        $form->addElement(new XoopsFormHidden('user', $xoopsUser->getVar('uid')));
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
            //name
            $form->addElement(new XoopsFormLabel('<b>' . _PED_FLD_NAME . '</b>', '<a href="dog.php?id=' . $row['ID'] . '">' . stripslashes($row['NAAM']) . '</a>'));
        }
        $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, strtr(_PED_ADD_KNOWN, array('[animalTypes]' => $moduleConfig['animalTypes']))));
        //submit button
        $form->addElement(new XoopsFormButton('', 'button_id', strtr(_PED_ADD_KNOWNOK, array('[animalType]' => $moduleConfig['animalType'])), 'submit'));
        //add data (form) to smarty template
        $xoopsTpl->assign('form', $form->render());
    } elseif ($numresults2 >= 1 && !isset($_GET['r'])) {
        //create form
        include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $form = new XoopsThemeForm(strtr(_PED_ADD_DOG, array('[animalType]' => $moduleConfig['animalType'])), 'dogname', 'add_dog.php?f=checkname&r=1', 'POST');
        //other elements
        $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
        $form->addElement(new XoopsFormHidden('NAAM', htmlspecialchars($_POST['NAAM'], ENT_QUOTES)));
        $form->addElement(new XoopsFormHidden('user', $xoopsUser->getVar('uid')));
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result2)) {
            //name
            $form->addElement(new XoopsFormLabel('<b>' . _PED_FLD_NAME . '</b>', '<a href="dog.php?id=' . $row['ID'] . '">' . stripslashes($row['NAAM']) . '</a>'));
        }
        $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, strtr(_PED_ADD_KNOWN, array('[animalTypes]' => $moduleConfig['animalTypes']))));
        //submit button
        $form->addElement(new XoopsFormButton('', 'button_id', strtr(_PED_ADD_KNOWNOK, array('[animalType]' => $moduleConfig['animalType'])), 'submit'));
        //add data (form) to smarty template
        $xoopsTpl->assign('form', $form->render());
    } else {
        //create form
        include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $form = new XoopsThemeForm(strtr(_PED_ADD_DOG, array('[animalType]' => $moduleConfig['animalType'])), 'dogname', 'add_dog.php?f=sire', 'POST');
        //added to handle upload
        $form->setExtra("enctype='multipart/form-data'");
        $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
        //create random value
        $random = (mt_rand() % 10000);
        $form->addElement(new XoopsFormHidden('random', $random));
        $form->addElement(new XoopsFormHidden('NAAM', htmlspecialchars($_POST['NAAM'], ENT_QUOTES)));
        //find userid from previous form
        $form->addElement(new XoopsFormHidden('user', $_POST['user']));

        //name
        $form->addElement(new XoopsFormLabel('<b>' . _PED_FLD_NAME . '</b>', stripslashes(stripslashes($_POST['NAAM']))));
        //gender
        $gender_radio = new XoopsFormRadio('<b>' . _PED_FLD_GEND . '</b>', 'roft', $value = '0');
        $gender_radio->addOptionArray(array('0' => strtr(_PED_FLD_MALE, array('[male]' => $moduleConfig['male'])), '1' => strtr(_PED_FLD_FEMA, array('[female]' => $moduleConfig['female']))));
        $form->addElement($gender_radio);
        if ($moduleConfig['ownerbreeder'] == '1') {
            //breeder
            $breeder_select = new XoopsFormSelect('<b>' . _PED_FLD_BREE . '</b>', $name = 'id_fokker', $value = '0', $size = 1, $multiple = false);
            $queryfok       = 'SELECT ID, lastname, firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' ORDER BY "lastname"';
            $resfok         = $GLOBALS['xoopsDB']->query($queryfok);
            $breeder_select->addOption('0', $name = _PED_UNKNOWN, $disabled = false);
            while ($rowfok = $GLOBALS['xoopsDB']->fetchArray($resfok)) {
                $breeder_select->addOption($rowfok['ID'], $name = $rowfok['lastname'] . ', ' . $rowfok['firstname'], $disabled = false);
            }
            $form->addElement($breeder_select);
            $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, strtr(_PED_FLD_BREE_EX, array('[animalType]' => $moduleConfig['animalType']))));

            //owner
            $owner_select = new XoopsFormSelect('<b>' . _PED_FLD_OWNE . '</b>', $name = 'id_eigenaar', $value = '0', $size = 1, $multiple = false);
            $queryfok     = 'SELECT ID, lastname, firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' ORDER BY "lastname"';
            $resfok       = $GLOBALS['xoopsDB']->query($queryfok);
            $owner_select->addOption('0', $name = _PED_UNKNOWN, $disabled = false);
            while ($rowfok = $GLOBALS['xoopsDB']->fetchArray($resfok)) {
                $owner_select->addOption($rowfok['ID'], $name = $rowfok['lastname'] . ', ' . $rowfok['firstname'], $disabled = false);
            }
            $form->addElement($owner_select);
            $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, strtr(_PED_FLD_OWNE_EX, array('[animalType]' => $moduleConfig['animalType']))));
        }
        //picture
        $max_imgsize = 1024000;
        $img_box     = new XoopsFormFile('Image', 'photo', $max_imgsize);
        $img_box->setExtra("size ='50'");
        $form->addElement($img_box);

        //create animal object
        $animal = new Animal();
        //test to find out how many user fields there are..
        $fields = $animal->numoffields();

        for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
            $userfield   = new Field($fields[$i], $animal->getconfig());
            $fieldType   = $userfield->getSetting('FieldType');
            $fieldobject = new $fieldType($userfield, $animal);
            if ($userfield->active()) {
                $newentry = $fieldobject->newField();
                $form->addElement($newentry);
            }
            unset($newentry);
        }

        //submit button
        $form->addElement(new XoopsFormButton('', 'button_id', strtr(_PED_ADD_SIRE, array('[father]' => $moduleConfig['father'])), 'submit'));

        //add data (form) to smarty template
        $xoopsTpl->assign('form', $form->render());
    }
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
    $name = $_POST['NAAM'];
    $roft = $_POST['roft'];

    $id_eigenaar = $_POST['id_eigenaar'];
    $id_fokker   = $_POST['id_fokker'];

    $picturefield = $_FILES['photo']['name'];
    if (empty($picturefield) || $picturefield == '') {
        $foto = '';
    } else {
        $foto = uploadedpict(0);
    }
    $numpicturefield = 1;

    //make the redirect
    if (!isset($_GET['r'])) {
        if ($_POST['NAAM'] == '') {
            redirect_header('add_dog.php', 1, _PED_ADD_NAMEPLZ);
        }
        //create animal object
        $animal = new Animal();
        //test to find out how many user fields there are..
        $fields = $animal->numoffields();
        sort($fields); //sort by ID not by order
        $usersql = '';
        for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
            $userfield   = new Field($fields[$i], $animal->getconfig());
            $fieldType   = $userfield->getSetting('FieldType');
            $fieldobject = new $fieldType($userfield, $animal);
            if ($userfield->active()) {
                //check if _FILES variable exists for user picturefield
                $currentfield = 'user' . $fields[$i];
                $picturefield = $_FILES[$currentfield]['name'];
                if ($fieldType === 'Picture' && (!empty($picturefield) || $picturefield != '')) {
                    $userpicture = uploadedpict($numpicturefield);
                    $usersql     .= ",'" . $userpicture . "'";
                    $numpicturefield++;
                } else {
                    //echo $fieldType.":".$i.":".$fields[$i]."<br>";
                    $usersql .= ",'" . unhtmlentities($_POST['user' . $fields[$i]]) . "'";
                }
            } else {
                $usersql .= ",''";
            }
            //echo $fields[$i]."<br/>";
        }

        echo 'kanna code:';
        $proc = $GLOBALS['xoopsDB']->queryF("CALL INSERT_START ('"
                                            . unhtmlentities($name)
                                            . "','"
                                            . $id_eigenaar
                                            . "','"
                                            . $id_fokker
                                            . "','"
                                            . $user
                                            . "','"
                                            . $roft
                                            . "','"
                                            . $foto
                                            . "','"
                                            . $_POST['user' . $fields[0]]
                                            . "','"
                                            . $_POST['user' . $fields[1]]
                                            . "','"
                                            . $_POST['user' . $fields[2]]
                                            . "','"
                                            . $_POST['user' . $fields[3]]
                                            . "','"
                                            . $_POST['user' . $fields[4]]
                                            . "',@a)") or die($GLOBALS['xoopsDB']->error());
        mysqli_result($proc);
        $idvalue    = $GLOBALS['xoopsDB']->queryF('Select @a');
        $newvalue   = $GLOBALS['xoopsDB']->fetchBoth($idvalue);
        $finalvalue = $newvalue[0];
        $random     = $finalvalue;
        //$userid=$user;

        echo $random;

        redirect_header('add_dog.php?f=sire&random=' . $random . '&st=' . $st . '&r=1&l=a', 1, strtr(_PED_ADD_SIREPLZ, array('[father]' => $moduleConfig['father'])));
    }
    //find letter on which to start else set to 'a'
    if (isset($_GET['l'])) {
        $l = $_GET['l'];
    } else {
        $l = 'a';
    }
    //assign sire to template
    $xoopsTpl->assign('sire', '1');
    //create list of males dog to select from
    $perp = $moduleConfig['perpage'];
    //count total number of dogs
    $numdog = 'SELECT count(ID) FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft='0' AND NAAM LIKE '" . $l . "%'";
    $numres = $GLOBALS['xoopsDB']->query($numdog);
    //total number of dogs the query will find
    list($numresults) = $GLOBALS['xoopsDB']->fetchRow($numres);
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
            $pages .= '<b><a href="add_dog.php?f=sire&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a></b>&nbsp;';
        } else {
            $pages .= '<a href="add_dog.php?f=sire&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a>&nbsp;';
        }
    }
    $pages .= '-&nbsp;';
    $pages .= '<a href="add_dog.php?f=sire&r=1&random=' . $random . '&l=Ã…">Ã…</a>&nbsp;';
    $pages .= '<a href="add_dog.php?f=sire&r=1&random=' . $random . '&l=Ã–">Ã–</a>&nbsp;';
    //create linebreak
    $pages .= '<br>';
    //create previous button
    if ($numpages > 1) {
        if ($cpage > 1) {
            $pages .= '<a href="add_dog.php?f=sire&r=1&l=' . $l . '&random=' . $random . '&st=' . ($st - $perp) . '">' . _PED_PREVIOUS . '</a>&nbsp;&nbsp';
        }
    }
    //create numbers
    for ($x = 1; $x < ($numpages + 1); $x++) {
        //create line break after 20 number
        if (($x % 20) == 0) {
            $pages .= '<br>';
        }
        if ($x != $cpage) {
            $pages .= '<a href="add_dog.php?f=sire&r=1&l=' . $l . '&random=' . $random . '&st=' . ($perp * ($x - 1)) . '">' . $x . '</a>&nbsp;&nbsp;';
        } else {
            $pages .= $x . '&nbsp;&nbsp';
        }
    }
    //create next button
    if ($numpages > 1) {
        if ($cpage < $numpages) {
            $pages .= '<a href="add_dog.php?f=sire&r=1&l=' . $l . '&random=' . $random . '&st=' . ($st + $perp) . '">' . _PED_NEXT . '</a>&nbsp;&nbsp';
        }
    }

    //query
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft = '0' AND NAAM LIKE '" . $l . "%'ORDER BY NAAM LIMIT " . $st . ', ' . $perp;
    $result      = $GLOBALS['xoopsDB']->query($queryString);

    $prefix = array(
        'id'          => '0',
        'name'        => '',
        'gender'      => '',
        'link'        => '<a href="add_dog.php?f=dam&random=' . $random . '&selsire=0">' . strtr(_PED_ADD_SIREUNKNOWN, array('[father]' => $moduleConfig['father'])) . '</a>',
        'colour'      => '',
        'number'      => '',
        'usercolumns' => $empty
    );
    makelist($result, $prefix, 'add_dog.php?f=dam&random=' . $random . '&selsire=', 'ID');

    //assign links
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

    //check for access
    $xoopsModule = XoopsModule::getByDirname('animal');
    if (empty($xoopsUser)) {
        redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
        exit();
    }

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
    //find letter on which to start else set to 'a'
    if (isset($_GET['l'])) {
        $l = $_GET['l'];
    } else {
        $l = 'a';
    }
    //make the redirect
    if (!isset($_GET['r'])) {

        //insert into stamboom_temp
        echo 'kanna code';
        $upproc = $GLOBALS['xoopsDB']->queryF('CALL UPDATE_FATHER(' . $_GET['selsire'] . ',' . $random . ')') || exit($GLOBALS['xoopsDB']->error());
        mysqli_result($upproc);

        redirect_header('add_dog.php?f=dam&random=' . $random . '&st=' . $st . '&r=1&l=a', 1, strtr(_PED_ADD_SIREOK, array('[mother]' => $moduleConfig['mother'])));
    }

    $xoopsTpl->assign('sire', '1');
    //create list of males dog to select from
    $perp = $moduleConfig['perpage'];
    //count total number of dogs
    $numdog = 'SELECT count(ID) FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft='1' AND NAAM LIKE '" . $l . "%'";
    $numres = $GLOBALS['xoopsDB']->query($numdog);
    list($numresults) = $GLOBALS['xoopsDB']->fetchRow($numres);
    $numpages = floor($numresults / $perp) + 1;
    if (($numpages * $perp) == ($numresults + $perp)) {
        --$numpages;
    }
    $cpage = floor($st / $perp) + 1;
    //create alphabet
    $pages = '';
    for ($i = 65; $i <= 90; $i++) {
        if ($l == chr($i)) {
            $pages .= '<b><a href="add_dog.php?f=dam&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a></b>&nbsp;';
        } else {
            $pages .= '<a href="add_dog.php?f=dam&r=1&random=' . $random . '&l=' . chr($i) . '">' . chr($i) . '</a>&nbsp;';
        }
    }
    $pages .= '-&nbsp;';
    $pages .= '<a href="add_dog.php?f=dam&r=1&random=' . $random . '&l=Ã…">Ã…</a>&nbsp;';
    $pages .= '<a href="add_dog.php?f=dam&r=1&random=' . $random . '&l=Ã–">Ã–</a>&nbsp;';
    $pages .= '<br>';
    //create previous button
    if ($numpages > 1) {
        if ($cpage > 1) {
            $pages .= '<a href="add_dog.php?f=dam&r=1&l=' . $l . '&random=' . $random . '&st=' . ($st - $perp) . '">' . _PED_PREVIOUS . '</a>&nbsp;&nbsp';
        }
    }
    //create numbers
    for ($x = 1; $x < ($numpages + 1); $x++) {
        //create line break after 20 number
        if (($x % 20) == 0) {
            $pages .= '<br>';
        }
        if ($x != $cpage) {
            $pages .= '<a href="add_dog.php?f=dam&r=1&l=' . $l . '&random=' . $random . '&st=' . ($perp * ($x - 1)) . '">' . $x . '</a>&nbsp;&nbsp;';
        } else {
            $pages .= $x . '&nbsp;&nbsp';
        }
    }
    //create next button
    if ($numpages > 1) {
        if ($cpage < $numpages) {
            $pages .= '<a href="add_dog.php?f=dam&l=' . $l . '&r=1&random=' . $random . '&st=' . ($st + $perp) . '">' . _PED_NEXT . '</a>&nbsp;&nbsp;';
        }
    }

    //query
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE roft = '1' AND NAAM LIKE '" . $l . "%' ORDER BY NAAM LIMIT " . $st . ', ' . $perp;
    $result      = $GLOBALS['xoopsDB']->query($queryString);

    $prefix = array(
        'id'          => '0',
        'name'        => '',
        'gender'      => '',
        'link'        => '<a href="add_dog.php?f=check&random=' . $random . '&seldam=0">' . strtr(_PED_ADD_DAMUNKNOWN, array('[mother]' => $moduleConfig['mother'])) . '</a>',
        'colour'      => '',
        'number'      => '',
        'usercolumns' => $empty
    );
    makelist($result, $prefix, 'add_dog.php?f=check&random=' . $random . '&seldam=', 'ID');

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

    //check for access
    $xoopsModule = XoopsModule::getByDirname('animal');
    if (empty($xoopsUser)) {
        redirect_header('index.php', 3, _NOPERM . '<br>' . _PED_REGIST);
        exit();
    }
    if (empty($random)) {
        $random = $_POST['random'];
    }
    if (isset($_GET['random'])) {
        $random = $_GET['random'];
    }

    //Kanna Code
    $id = $_GET['seldam'];
    echo 'test kanna';
    //echo 'final value'.$random;
    $umproc = $GLOBALS['xoopsDB']->queryF('CALL UPDATE_MOTHER(' . $_GET['seldam'] . ',' . $random . ')') || exit($GLOBALS['xoopsDB']->error());
    mysqli_result($umproc);

    //query
    $queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_temp') . ' WHERE ID = ' . $random;
    $result      = $GLOBALS['xoopsDB']->query($queryString);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
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
        //insert into stamboom
    }

    //kanna code
    $insert_stamboom = $GLOBALS['xoopsDB']->queryF('INSERT INTO '
                                                   . $GLOBALS['xoopsDB']->prefix('stamboom')
                                                   . '(NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,coi,user1,user2,user3,user4,user5) SELECT NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,coi,user1,user2,user3,user4,user5 FROM '
                                                   . $GLOBALS['xoopsDB']->prefix('pius_stamboon')
                                                   . " WHERE ID=$random");

    redirect_header('latest.php', 1, strtr(_PED_ADD_OK, array('[animalType]' => $moduleConfig['animalType'])));
}

//footer
include XOOPS_ROOT_PATH . '/footer.php';
