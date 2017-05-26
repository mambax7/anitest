<?php
// -------------------------------------------------------------------------

use Xmf\Request;

require_once __DIR__ . '/../../mainfile.php';


if (!isset($moduleDirName)) {
    $moduleDirName = basename(__DIR__);
}

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}

// Load language files
$moduleHelper->loadLanguage('templates');
$moduleHelper->loadLanguage('main');


// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_virtual.tpl';

include XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', 'Pedigree database - Virtual Mating');

//create function variable from url
//if (isset($_GET['f'])) {
//    $f = $_GET['f'];
//}
//if (!isset($f)) {
$f = Request::getString('f', '', 'GET');

if (empty($f)) {
    virt();
} elseif ($f === 'dam') {
    dam();
} elseif ($f === 'check') {
    check();
}
?>
<!--<script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#fathertext").focus();
        $("#vader").hide('fast');
        $("#moeder").hide('fast');
        $("#fatherdetails").hide('fast');
        $("#motherdetails").hide('fast');

        $('#virtual').click(function () {
            var fathe = $("#fatherid").val();

            var mothe = $("#motherid").val();

            if (fathe == '0') {
                alert("Please select a father");
                $("#fathertext").focus();
                return;
            }


            if (mothe == '0') {
                alert("Please select a mother");
                $("#mothertext").focus();
                return;
            }

            document.location = 'vm_coi.php?s=' + fathe + '&d=' + mothe +  '&dogid=&detail=1';

        });
        $('#reset').click(function () {
            document.location = 'virtual.php';

        });

    });
    $(document).ready(function () {
        //$("#fathertext").typeWatch({ highlight: true, wait: 500, captureLength: -1, callback: finished });
        $('#fathertext').css('width', '420px');
        $('#fathertext').prop('placeholder', "Type a minimum of three characters of father to narrow your search");

        $("#fathertext").keyup(function () {
            var textlen = $("#fathertext").val();
            if (textlen.length <= 3) {
                $("#vader").hide();
            }
            if (textlen.length >= 3) {
                //var optionValue = $("select[name='country_select']").val();
                var idf1 = $("#fathertext").val();
                //var dataString = 'id='+ id;
                //alert("datastring"+dataString);
                //alert(id);
                $.ajax({
                    type: "POST",
                    url: "getfather.php",
                    data: "fid=" + idf1,
                    // beforeSend: function(){ $("#ajaxLoader").show(); },
                    // complete: function(){ $("#ajaxLoader").hide(); },

                    success: function (response) {

                        //alert(response);
                        //$("#livefilter").hide('fast');
                        $("#vader").replaceWith(response);  //$("#vader").attr("size","10");
                        //$("#id_fokker").focus();

                        $("#vader").css("width", "100%");
                        $("#vader").show('fast');
                        //alert($("#vader").html().length);
                        if ($("#vader").tpl().length <= 500) {
                            $('#fatherid').val(0);
                            $('#fatherdetails').hide('fast');

                        }
                        /*alert($("#vader").html().length);
                         if($('.father').val().length){
                         alert('dfv');
                         }*/

                    }
                });
            }


        });


    });

    //mother
    $(document).ready(function () {
        $('#mothertext').css('width', '420px');
        $('#mothertext').prop('placeholder', "Type a minimum of three characters of mother to narrow your search");
        $("#mothertext").keyup(function () {

            var textlens = $("#mothertext").val();
            if (textlens.length <= 3) {
                $("#moeder").hide('fast');
            }
            if (textlens.length >= 3) {
                //var optionValue = $("select[name='country_select']").val();
                var idm1 = $("#mothertext").val();
                //var dataString = 'id='+ id;
                //alert("datastring"+dataString);

                $.ajax({
                    type: "POST",
                    url: "getmother.php",
                    data: "mid=" + idm1,
                    // beforeSend: function(){ $("#ajaxLoader").show(); },
                    // complete: function(){ $("#ajaxLoader").hide(); },
                    success: function (response) {
                        //alert(response);
                        //$("#livefilter").hide('fast');
                        $("#moeder").replaceWith(response);
                        $("#moeder").attr("size", "10");
                        //$("#id_fokker").focus();

                        $("#moeder").css("width", "100%");
                        $("#moeder").show('fast');
                        if ($("#moeder").html().length <= 500) {
                            $('#motherid').val(0);
                            $("#motherdetails").hide('fast');
                        }
                    }

                });
            }
        });
    });
</script>
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        try {
            $("input[type='text']").each(function () {
                $(this).attr("autocomplete", "off");
            });
        }
        catch (e) {
        }
    });
</script>

<?php
function virt()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;

    //get module configuration
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

    /*if (isset($_GET['st'])) { $st=$_GET['st']; }
    else { $st=0; }
    if (isset($_GET['l'])) { $l=$_GET['l']; }
    else { $l="A"; }

    $xoopsTpl->assign("sire", "1");
    //create list of males dog to select from
    $perp = $moduleConfig['perpage'];
    //count total number of dogs
    $numdog = "SELECT count(d.id) FROM ".$GLOBALS['xoopsDB']->prefix("stamboom")." d LEFT JOIN ".$GLOBALS['xoopsDB']->prefix("stamboom")." m ON m.id = d.moeder LEFT JOIN ".$GLOBALS['xoopsDB']->prefix("stamboom")." f ON f.id = d.vader WHERE d.roft = '0' and d.moeder != '0' and d.vader != '0' and m.moeder != '0' and m.vader != '0' and f.moeder != '0' and f.vader != '0' and d.naam LIKE '".$l."%'";
    $numres = $GLOBALS['xoopsDB']->query($numdog);
    //total number of dogs the query will find
    list($numresults) = $GLOBALS['xoopsDB']->fetchRow($numres);
    //total number of pages
    $numpages = (floor($numresults/$perp))+1;
    if (($numpages * $perp) == ($numresults + $perp))
        {	$numpages = $numpages - 1; }
    //find current page
    $cpage = (floor($st/$perp))+1;
    //create alphabet
    $pages ="";
    for($i=65; $i<=90; $i++)
    {
        if ($l == chr($i))
        {
            $pages .= "<b><a href=\"virtual.php?r=1&st=0&l=".chr($i)."\">".chr($i)."</a></b>&nbsp;";
        }
        else
        {
            $pages .= "<a href=\"virtual.php?r=1&st=0&l=".chr($i)."\">".chr($i)."</a>&nbsp;";
        }
    }
    $pages .="-&nbsp;";
    $pages .= "<a href=\"virtual.php?r=1&st=0&l=Ã\">Ã</a>&nbsp;";
    $pages .= "<a href=\"virtual.php?r=1&st=0&l=Ã\">Ã</a>&nbsp;";
    $pages .= "<br>";
    //create previous button
    if ($numpages > 1)
    {
        if ($cpage > 1)
        {
            $pages .= "<a href=\"virtual.php?r=1&&l=".$l."st=".($st-$perp)."\">"._PED_PREVIOUS."</a>&nbsp;&nbsp";
        }
    }
    //create numbers
    for ($x=1; $x<($numpages+1); $x++)
    {
        //create line break after 20 number
        if (($x % 20) == 0)
        { $pages .= "<br>"; }
        if ($x != $cpage)
        { $pages .= "<a href=\"virtual.php?r=1&l=".$l."&st=".($perp*($x-1))."\">".$x."</a>&nbsp;&nbsp;"; }
        else
        { $pages .= $x."&nbsp;&nbsp";  }
    }
    //create next button
    if ($numpages > 1)
    {
        if ($cpage < ($numpages))
        {
            $pages .= "<a href=\"virtual.php?r=1&l=".$l."&st=".($st+$perp)."\">"._PED_NEXT."</a>&nbsp;&nbsp";
        }
    }

    //query
    $queryString = "SELECT d.*, d.id AS d_id, d.naam AS d_naam FROM ".$GLOBALS['xoopsDB']->prefix("stamboom")." d LEFT JOIN ".$GLOBALS['xoopsDB']->prefix("stamboom")." m ON m.id = d.moeder LEFT JOIN ".$GLOBALS['xoopsDB']->prefix("stamboom")." f ON f.id = d.vader WHERE d.roft = '0' and d.moeder != '0' and d.vader != '0' and m.moeder != '0' and m.vader != '0' and f.moeder != '0' and f.vader != '0' and d.naam LIKE '".$l."%' ORDER BY d.naam LIMIT ".$st.", ".$perp;
    $result = $GLOBALS['xoopsDB']->query($queryString);

    $animal = new Animal( );
    //test to find out how many user fields there are...
    $fields = $animal->numoffields();
    $numofcolumns = 1;
    $columns[] = array ('columnname' => "Name");
    for ($i = 0, $iMax = count($fields); $i < $iMax; $i++)
    {
        $userfield = new Field( $fields[$i], $animal->getconfig() );
        $fieldType = $userfield->getSetting( "FieldType" );
        $fieldobject = new $fieldType( $userfield, $animal );
        if ($userfield->active() && $userfield->inlist())
        {
            $columns[] = array ('columnname' => $fieldobject->fieldname, 'columnnumber' => $userfield->getID());
            $numofcolumns++;
        }
    }

    while ($row = $GLOBALS['xoopsDB']->fetchArray($result))
    {
        //create picture information
        if ($row['foto'] != '')
        { $camera = " <img src=\"images/camera.png\">"; }
        else { $camera = ""; }
        $name = stripslashes($row['d_naam']).$camera;
        //empty array
        unset($columnvalue);
        //fill array
        for ($i = 1; $i < ($numofcolumns); $i++)
        {
            $x = $columns[$i]['columnnumber'];
            //format value - cant use object because of query count
            if (substr($row['user'.$x], 0, 7) == 'http://')
            {
                $value = "<a href=\"".$row['user'.$x]."\">".$row['user'.$x]."</a>";
            }
            else { $value = $row['user'.$x]; }
            $columnvalue[] = array ('value' => $value);
        }
        $dogs[] = array ('id' => $row['d_id'], 'name' => $name, 'gender' => '<img src="images/male.gif">', 'link' => "<a href=\"virtual.php?f=dam&selsire=".$row['d_id']."\">".$name."</a>",'colour' => "", 'number' => "", 'usercolumns' => $columnvalue);
    }
    */
    //add data to smarty template
    //assign dog
    if (isset($dogs)) {
        $xoopsTpl->assign('dogs', $dogs);
    }
    //    $xoopsTpl->assign('columns', $columns);
    //    $xoopsTpl->assign('numofcolumns', $numofcolumns);
    //    $xoopsTpl->assign('tsarray', sorttable($numofcolumns));
    //    $xoopsTpl->assign('nummatch', strtr(_PED_ADD_SELSIRE, array('[father]' => $moduleConfig['father'])));
    //    $xoopsTpl->assign('pages', $pages);

    $xoopsTpl->assign('virtualtitle', strtr(_PED_VIRUTALTIT, array('[mother]' => $moduleConfig['mother'])));
    $xoopsTpl->assign('virtualstory', strtr(_PED_VIRUTALSTOS, array('[mother]' => $moduleConfig['mother'], '[father]' => $moduleConfig['father'], '[children]' => $moduleConfig['children'])));
    //$xoopsTpl->assign("nextaction", "<b>".strtr(_PED_VIRT_SIRE, array( '[father]' => $moduleConfig['father']))."</b>" );

    include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $form = new XoopsThemeForm('Select Father & Mother for the virtual mating.'/*strtr(_PED_ADD_DOG, array( '[animalType]' => $moduleConfig['animalType'] ))*/, 'dogname', 'virtual.php?f=check', 'POST');
    //added to handle upload
    $form->setExtra("enctype='multipart/form-data'");
    $form->addElement(new XoopsFormText('<b>Select Father'/*"<b>".strtr(_PED_FLD_FATH, array( '[father]' => $moduleConfig['father'] ))*/, 'fathertext', $size = 50, $maxsize = 255, $value = ''));
    $father_select = new XoopsFormSelect('', $name = 'vader', $value = '0', $size = 1, $multiple = false);
    $queryfather   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' ';
    $fatherz       = $GLOBALS['xoopsDB']->query($queryfather);
    $father_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);
    /*while($fetchfather=$GLOBALS['xoopsDB']->fetchArray($fatherz))
    {
    //$father_select->addoption($fetchfather[ID],$name=$fetchfather[NAAM],$disabled=false);
    }*/
    $form->addElement($father_select);
    $form->addElement(new XoopsFormText('', 'fatherdetails', $size = 70, $maxsize = 255, $value = ''));
    $form->addElement(new XoopsFormHidden('fatherid', '0'));
    //$father_seelect = new XoopsFormSelect("", $name="fatherdetails", $value='', $size=1, $multiple=false);
    //$form->addElement ($father_seelect);

    $form->addElement(new XoopsFormText('<b>Select Mother'/*"<b>".strtr(_PED_FLD_MOTH, array( '[mother]' => $moduleConfig['mother'] ))*/, 'mothertext', $size = 50, $maxsize = 255, $value = ''));
    $mother_select = new XoopsFormSelect('', $name = 'moeder', $value = '0', $size = 1, $multiple = false);
    $querymother   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' ';
    $motherz       = $GLOBALS['xoopsDB']->query($querymother);
    $mother_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);
    /*while($fetchmother=$GLOBALS['xoopsDB']->fetchArray($motherz))
    {
    //$mother_select->addoption($fetchmother[ID],$name=$fetchmother[NAAM],$disabled=false);
    }*/
    $form->addElement($mother_select);
    $form->addElement(new XoopsFormText('', 'motherdetails', $size = 70, $maxsize = 255, $value = ''));
    $form->addElement(new XoopsFormHidden('motherid', '0'));
    //submit button
    //$form->addElement(new XoopsFormButton('', 'button_id', strtr(_PED_ADD_SIRE, array( '[father]' => $moduleConfig['father'] )), 'submit'));

    $form->addElement(new XoopsFormButton('', 'virtual', 'Calculate Coefficient', 'button'));
    $form->addElement(new XoopsFormButton('', 'reset', 'Reset', 'button'));

    //add data (form) to smarty template
    $xoopsTpl->assign('form', $form->render());
}

function dam()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;

    //get module configuration
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

    if (isset($_GET['st'])) {
        $st = $_GET['st'];
    } else {
        $st = 0;
    }
    if (isset($_GET['l'])) {
        $l = $_GET['l'];
    } else {
        $l = 'A';
    }
    $selsire = $_GET['selsire'];

    $xoopsTpl->assign('sire', '1');
    //create list of males dog to select from
    $perp = $moduleConfig['perpage'];
    //count total number of dogs
    $numdog = 'SELECT count(d.id) FROM '
              . $GLOBALS['xoopsDB']->prefix('stamboom')
              . ' d LEFT JOIN '
              . $GLOBALS['xoopsDB']->prefix('stamboom')
              . ' m ON m.id = d.moeder LEFT JOIN '
              . $GLOBALS['xoopsDB']->prefix('stamboom')
              . " f ON f.id = d.vader WHERE d.roft = '1' AND d.moeder != '0' AND d.vader != '0' AND m.moeder != '0' AND m.vader != '0' AND f.moeder != '0' AND f.vader != '0' AND d.naam LIKE '"
              . $l
              . "%'";
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
    //create the alphabet
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=a">A</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=b">B</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=c">C</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=d">D</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=e">E</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=f">F</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=g">G</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=h">H</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=i">I</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=j">J</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=k">K</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=l">L</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=m">M</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=n">N</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=o">O</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=p">P</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=q">Q</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=r">R</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=s">S</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=t">T</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=u">U</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=v">V</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=w">W</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=x">X</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=y">Y</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=z">Z</a>&nbsp;';
    $pages .= '-&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=�">�</a>&nbsp;';
    $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&st=0&l=�">�</a>&nbsp;';
    //create linebreak
    $pages .= '<br>';
    //create previous button
    if ($numpages > 1) {
        if ($cpage > 1) {
            $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&l=' . $l . '&st=' . ($st - $perp) . '">' . _PED_PREVIOUS . '</a>&nbsp;&nbsp';
        }
    }
    //create numbers
    for ($x = 1; $x < ($numpages + 1); $x++) {
        //create line break after 20 number
        if (($x % 20) == 0) {
            $pages .= '<br>';
        }
        if ($x != $cpage) {
            $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&l=' . $l . '&st=' . ($perp * ($x - 1)) . '">' . $x . '</a>&nbsp;&nbsp;';
        } else {
            $pages .= $x . '&nbsp;&nbsp';
        }
    }
    //create next button
    if ($numpages > 1) {
        if ($cpage < $numpages) {
            $pages .= '<a href="virtual.php?f=dam&selsire=' . $selsire . '&l=' . $l . '&st=' . ($st + $perp) . '">' . _PED_NEXT . '</a>&nbsp;&nbsp';
        }
    }

    //query
    $queryString = 'SELECT d.*, d.id AS d_id, d.naam AS d_naam FROM '
                   . $GLOBALS['xoopsDB']->prefix('stamboom')
                   . ' d LEFT JOIN '
                   . $GLOBALS['xoopsDB']->prefix('stamboom')
                   . ' m ON m.id = d.moeder LEFT JOIN '
                   . $GLOBALS['xoopsDB']->prefix('stamboom')
                   . " f ON f.id = d.vader WHERE d.roft = '1' AND d.moeder != '0' AND d.vader != '0' AND m.moeder != '0' AND m.vader != '0' AND f.moeder != '0' AND f.vader != '0' AND d.naam LIKE '"
                   . $l
                   . "%' ORDER BY d.naam LIMIT "
                   . $st
                   . ', '
                   . $perp;
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

    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        //create picture information
        if ($row['foto'] != '') {
            $camera = ' <img src="images/camera.png">';
        } else {
            $camera = '';
        }
        $name = stripslashes($row['d_naam']) . $camera;
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
            'id'          => $row['d_id'],
            'name'        => $name,
            'gender'      => '<img src="images/female.gif">',
            'link'        => '<a href="virtual.php?f=check&selsire=' . $selsire . '&seldam=' . $row['d_id'] . '">' . $name . '</a>',
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

    $xoopsTpl->assign('virtualtitle', _PED_VIRUTALTIT);
    $xoopsTpl->assign('virtualstory', strtr(_PED_VIRUTALSTO, array('[mother]' => $moduleConfig['mother'], '[father]' => $moduleConfig['father'], '[children]' => $moduleConfig['children'], '[animalTypes]' => $moduleConfig['animalTypes'])));
    $xoopsTpl->assign('nextaction', '<b>' . strtr(_PED_VIRT_DAM, array('[mother]' => $moduleConfig['mother'])) . '</b>');

    //find father
    $query  = 'SELECT ID, NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $selsire;
    $result = $GLOBALS['xoopsDB']->query($query);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $vsire = stripslashes($row['NAAM']);
    }
    $xoopsTpl->assign('virtualsiretitle', strtr(_PED_VIRTUALSTIT, array('[father]' => $moduleConfig['father'])));
    $xoopsTpl->assign('virtualsire', $vsire);
}

function check()
{
    global $xoopsTpl, $xoopsUser, $xoopsDB;
    echo '<pre>';
    print_r($_POST);
    //get module configuration
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('animal');
    $configHandler = xoops_getHandler('config');
    $moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
    echo $_POST[fatherid];
    echo $_POST[fatherid];

    if (isset($_POST[fatherid])) {
        echo $selsire = $_POST[fatherid];
    }    //$_GET['selsire'];
    if (isset($_POST[motherid])) {
        echo $seldam = $_POST[motherid];
    } //$_GET['seldam'];

    $xoopsTpl->assign('virtualtitle', _PED_VIRUTALTIT);
    $xoopsTpl->assign('virtualstory', strtr(_PED_VIRUTALSTO, array('[mother]' => $moduleConfig['mother'], '[father]' => $moduleConfig['father'], '[children]' => $moduleConfig['children'])));
    //find father
    $query  = 'SELECT ID, NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $selsire;
    $result = $GLOBALS['xoopsDB']->query($query);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $vsire = stripslashes($row['NAAM']);
    }
    $xoopsTpl->assign('virtualsiretitle', strtr(_PED_VIRTUALSTIT, array('[father]' => $moduleConfig['father'])));
    $xoopsTpl->assign('virtualsire', $vsire);
    //find mother
    $query  = 'SELECT ID, NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $seldam;
    $result = $GLOBALS['xoopsDB']->query($query);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $vdam = stripslashes($row['NAAM']);
    }
    $xoopsTpl->assign('virtualdamtitle', strtr(_PED_VIRTUALDTIT, array('[mother]' => $moduleConfig['mother'])));
    $xoopsTpl->assign('virtualdam', $vdam);

    $xoopsTpl->assign('form', '<a href="vm_coi.php?s=' . $selsire . '&d=' . $seldam . '&dogid=&detail=1">' . _PED_VIRTUALBUT . '</a>');
}

//footer
include XOOPS_ROOT_PATH . '/footer.php';

?>
