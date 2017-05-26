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

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_update.tpl';

include XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', 'Pedigree database - Update details');

//check for access
$xoopsModule = XoopsModule::getByDirname('animal');
if (empty($xoopsUser)) {
    redirect_header('javascript:history.go(-1)', 3, _NOPERM . '<br>' . _PED_REGIST);
    exit();
}
// ( $xoopsUser->isAdmin($xoopsModule->mid() ) )
?>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">

    var abc = "showns";
    var abcd = "showns";
    $(window).on("load", function () {

        $("#id_fokker").hide('fast');
        $("#id_eigenaar").hide('fast');
        //$('select').click(function() {
        //	alert("Handler for .click() called.");
        //});


        $("#id_fokker").click(function () {
            if (!(abc === "shown")) {
                //alert("Quickly type the first three characters  to narrow your search");
                abc = "shown";
                $("#id_fokker").focus();

            }
            $("#id_fokker").focus();
        });

        $("#id_eigenaar").click(function () {
            if (!(abcd === "shown")) {
                //alert("Quickly type the first three characters  to narrow your search");
                abcd = "shown";
                $("#id_eigenaar").focus();
            }
            $("#id_eigenaar").focus();
        });
    });

    //	$('#livefilter-input').click( function() {
    //	  $('#id_fokker').val();
    //	});
    /*	$(window).on("load", function () {
     $('#livefilter').change(function() { alert('sdf');
     if (!$("#id_fokker option[value='" + this.value + "']").length) {
     console.log(this.value + ' is a new value!');
     //$('<option>').val(this.value).text(this.value).appendTo($('#id_fokker'));
     $('#livefilter').val($("#id_fokker").val());
     }
     }); });*/


    $(document).ready(function () {

        $('#livefilter').prop('placeholder', "Type first three characters of breeder to narrow your search");
        $('#livefilter').prop('autocomplete', 'off');
        $('#livefilter').focus();
        $("#livefilter").keyup(function () {

            //var optionValue = $("select[name='country_select']").val();
            var id = $("#livefilter").val();
            //var dataString = 'id='+ id;
            //alert("datastring"+dataString);
            var texs = $("#livefilter").val();
            if (texs.length < 3) {
                $("#id_fokker").hide();
            }
            if (texs.length >= 3) {
                $.ajax({
                    type: "POST",
                    url: "getstate1.php",
                    data: "fid=" + id,
                    // beforeSend: function(){ $("#ajaxLoader").show(); },
                    // complete: function(){ $("#ajaxLoader").hide(); },
                    success: function (response) {
                        // alert(response);
                        //$("#livefilter").hide('fast');
                        $("#id_fokker").replaceWith(response);
                        $("#id_fokker").attr("size", "10");
                        //$("#id_fokker").focus();
                        $("#id_fokker").css("width", "325px");
                        $("#id_fokker").show('fast');
                        if ($("#id_fokker").html().length <= 30) {
                            // alert('No owner found for your search');
                            $("#id_fokker").html('<option disabled style="color:red; font-weight:bold;">No breeder found for your search</option>');
                            $("#livefilter").val('');
                            return;
                        }

                    }

                });
            }
        });

        $("#id_fokker").click(function () {
            //alert('sdfv');
            var value = $("#id_fokker option:selected").text();

            $("#livefilter").val(value);
            $("#id_fokker").hide('fast');


        });
    });
    $(document).ready(function () {
        $('#ownerfilter').prop('placeholder', "Type first three characters of owner to narrow your search");
        $('#ownerfilter').prop('autocomplete', 'off');
        $('#ownerfilter').focus();
        $("#ownerfilter").keyup(function () {
            var tex = $("#ownerfilter").val();
            //var optionValue = $("select[name='country_select']").val();
            var id = $("#ownerfilter").val();
            //var dataString = 'id='+ id;
            //alert("datastring"+dataString);
            if (tex.length < 2) {
                $("#id_eigenaar").hide();
            }
            if (tex.length >= 3) {
                $.ajax({
                    type: "POST",
                    url: "getstate2.php",
                    data: "fid=" + id,
                    // beforeSend: function(){ $("#ajaxLoader").show(); },
                    // complete: function(){ $("#ajaxLoader").hide(); },
                    success: function (response) {
                        // alert(response);
                        //$("#livefilter").hide('fast');
                        $("#id_eigenaar").replaceWith(response);
                        $("#id_eigenaar").attr("size", "10");
                        //$("#id_fokker").focus();
                        $("#id_eigenaar").css("width", "325px");
                        $("#id_eigenaar").show('fast');
                        //alert($("#id_eigenaar").html().length);
                        if ($("#id_eigenaar").html().length <= 30) {
                            /*if(tex.length==3){
                             alert('No owner found for your search');
                             }*/
                            $("#id_eigenaar").html('<option disabled style="color:red; font-weight:bold;">No owner found for your search</option>');
                            $("#ownerfilter").val('');
                        }

                    }

                });
            }
        });
        $("#id_eigenaar").click(function () {
            //alert('sdfv');
            var value = $("#id_eigenaar option:selected").text();

            $("#ownerfilter").val(value);
            $("#id_eigenaar").hide('fast');

        });


    });

</script>

<?php

global $xoopsTpl;
global $xoopsDB;
global $xoopsModuleConfig;

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

$myts = MyTextSanitizer::getInstance();

$fld = Request::getString('fld', '', 'GET');
$id  = Request::getInt('id', 0, 'GET');
//$fld = $_GET['fld'];
//query (find values for this dog (and format them))
$queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $id;
$result      = $GLOBALS['xoopsDB']->query($queryString);

while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    //ID
    $id = $row['ID'];
    //name
    $naam     = htmlentities(stripslashes($row['NAAM']), ENT_QUOTES);
    $namelink = '<a href="dog.php?id=' . $row['ID'] . '">' . stripslashes($row['NAAM']) . '</a>';
    //owner
    $queryeig = 'SELECT ID, lastname, firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' WHERE ID=' . $row['id_eigenaar'];
    $reseig   = $GLOBALS['xoopsDB']->query($queryeig);
    while ($roweig = $GLOBALS['xoopsDB']->fetchArray($reseig)) {
        $eig = '<a href="owner.php?ownid=' . $roweig['ID'] . '">' . $roweig['firstname'] . ' ' . $roweig['lastname'] . '</a>';
    }
    $curvaleig = $row['id_eigenaar'];
    //breeder
    $queryfok = 'SELECT ID, lastname, firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' WHERE ID=' . $row['id_fokker'];
    $resfok   = $GLOBALS['xoopsDB']->query($queryfok);
    while ($rowfok = $GLOBALS['xoopsDB']->fetchArray($resfok)) {
        $fok = '<a href="owner.php?ownid=' . $rowfok['ID'] . '">' . $rowfok['firstname'] . ' ' . $rowfok['lastname'] . '</a>';
    }
    $curvalfok = $row['id_fokker'];
    //gender
    if ($row['roft'] == '0') {
        $gender = '<img src="images/male.gif"> ' . _PED_FLD_MALE;
    } else {
        $gender = '<img src="images/female.gif"> ' . _PED_FLD_FEMA;
    }
    $curvalroft = $row['roft'];
    //Sire
    if ($row['vader'] != 0) {
        $querysire = 'SELECT NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $row['vader'];
        $ressire   = $GLOBALS['xoopsDB']->query($querysire);
        while ($rowsire = $GLOBALS['xoopsDB']->fetchArray($ressire)) {
            $sire = '<img src="images/male.gif"><a href="dog.php?id=' . $row['vader'] . '">' . stripslashes($rowsire['NAAM']) . '</a>';
        }
    }
    //Dam
    if ($row['moeder'] != 0) {
        $querydam = 'SELECT NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $row['moeder'];
        $resdam   = $GLOBALS['xoopsDB']->query($querydam);
        while ($rowdam = $GLOBALS['xoopsDB']->fetchArray($resdam)) {
            $dam = '<img src="images/female.gif"><a href="dog.php?id=' . $row['moeder'] . '">' . stripslashes($rowdam['NAAM']) . '</a>';
        }
    }
    //picture
    if ($row['foto'] != '') {
        $picture = '<img src=images/thumbnails/' . $row['foto'] . '_400.jpeg>';
        $foto    = $row['foto'];
    } else {
        $foto = '';
    }
    //user who entered the info
    $dbuser = $row['user'];
}

//create form
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$form = new XoopsThemeForm($naam, 'updatedata', 'updatepage.php', 'POST');
$form->setExtra("enctype='multipart/form-data'");
//hidden value current record owner
$form->addElement(new XoopsFormHidden('dbuser', $dbuser));
//hidden value dog ID
$form->addElement(new XoopsFormHidden('dogid', $id));
$form->addElement(new XoopsFormHidden('curname', $naam));
$form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
//name
if ($fld === 'nm' || $fld === 'all') {
    $form->addElement(new XoopsFormText('<b>' . _PED_FLD_NAME . '</b>', 'NAAM', $size = 50, $maxsize = 255, $value = $naam));
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, _PED_FLD_NAME_EX));
    $form->addElement(new XoopsFormHidden('dbtable', 'stamboom'));
    $form->addElement(new XoopsFormHidden('dbfield', 'NAAM'));
    $form->addElement(new XoopsFormHidden('curvalname', $naam));
} elseif //owner
($fld === 'ow' || $fld === 'all'
) {
    $form->addElement(new XoopsFormText('<b>' . _PED_FLD_OWNE . '</b>', 'ownerfilter', $size = 50, $maxsize = 255, $value = ''));
    $owner_select = new XoopsFormSelect('', $name = 'id_eigenaar', $value = null, $size = 1, $multiple = false);
    //$queryeig = "SELECT ID, lastname, firstname from ".$GLOBALS['xoopsDB']->prefix("eigenaar")." ORDER BY \"lastname\"";
    $reseig = $GLOBALS['xoopsDB']->query($queryeig);
    $owner_select->addOption(0, $name = _PED_UNKNOWN, $disabled = false);
    while ($roweig = $GLOBALS['xoopsDB']->fetchArray($reseig)) {
        $owner_select->addOption($roweig['ID'], $name = $roweig['lastname'] . ', ' . $roweig['firstname'], $disabled = false);
    }
    $form->addElement($owner_select);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, _PED_FLD_OWNE_EX));
    $form->addElement(new XoopsFormHidden('dbtable', 'stamboom'));
    $form->addElement(new XoopsFormHidden('dbfield', 'id_eigenaar'));
    $form->addElement(new XoopsFormHidden('curvaleig', $curvaleig));
}

//breeder
if ($fld === 'br' || $fld === 'all') {
    $form->addElement(new XoopsFormText('<b>' . _PED_FLD_BREE . '</b>', 'livefilter', $size = 50, $maxsize = 255, $value = ''));
    $breeder_select = new XoopsFormSelect('', $name = 'id_fokker', $value = null, $size = 1, $multiple = false);
    //$queryfok = "SELECT ID, lastname, firstname from ".$GLOBALS['xoopsDB']->prefix("eigenaar")." ORDER BY \"lastname\"";
    $resfok = $GLOBALS['xoopsDB']->query($queryfok);
    $breeder_select->addOption(0, $name = _PED_UNKNOWN, $disabled = false);
    while ($rowfok = $GLOBALS['xoopsDB']->fetchArray($resfok)) {
        $breeder_select->addOption($rowfok['ID'], $name = $rowfok['lastname'] . ', ' . $rowfok['firstname'], $disabled = false);
    }
    $form->addElement($breeder_select);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, _PED_FLD_BREE_EX));
    $form->addElement(new XoopsFormHidden('dbtable', 'stamboom'));
    $form->addElement(new XoopsFormHidden('dbfield', 'id_fokker'));
    $form->addElement(new XoopsFormHidden('curvalfok', $curvalfok));
}

//gender
if ($fld === 'sx' || $fld === 'all') {
    $gender_radio = new XoopsFormRadio('<b>' . _PED_FLD_GEND . '</b>', 'roft', $value = null);
    $gender_radio->addOptionArray(array('0' => _PED_FLD_MALE, '1' => _PED_FLD_FEMA));
    $form->addElement($gender_radio);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, _PED_FLD_GEND_EX));
    $form->addElement(new XoopsFormHidden('dbtable', 'stamboom'));
    $form->addElement(new XoopsFormHidden('dbfield', 'roft'));
    $form->addElement(new XoopsFormHidden('curvalroft', $curvalroft));
}

//picture
if ($fld === 'pc' || $fld === 'all') {
    $form->addElement(new XoopsFormLabel('Picture', $picture));
    $form->setExtra("enctype='multipart/form-data'");
    $img_box = new XoopsFormFile('Image', 'photo', 1024000);
    $img_box->setExtra("size ='50'");
    $form->addElement($img_box);
    $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, strtr(_PED_FLD_PICT_EX, array('[animalType]' => $moduleConfig['animalType']))));
    $form->addElement(new XoopsFormHidden('dbtable', 'stamboom'));
    $form->addElement(new XoopsFormHidden('dbfield', 'foto'));
    $form->addElement(new XoopsFormHidden('curvalpic', $foto));
}

//create animal object

$a      = (!isset($_GET['id']) ? $a = 1 : $a = $_GET['id']);
$animal = new Animal($a);

//test to find out how many user fields there are..
$fields = $animal->numoffields();

for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
    if ($_GET['fld'] == $fields[$i]) {
        $userfield = new Field($fields[$i], $animal->getconfig());
        if ($userfield->active()) {
            $fieldType   = $userfield->getSetting('FieldType');
            $fieldobject = new $fieldType($userfield, $animal);
            $edditable   = $fieldobject->editField();
            $form->addElement($edditable);
            $explain = $userfield->getSetting('FieldExplenation');
            $form->addElement(new XoopsFormLabel(_PED_EXPLAIN, $explain));
            $form->addElement(new XoopsFormHidden('dbtable', 'stamboom'));
            $form->addElement(new XoopsFormHidden('dbfield', 'user' . $fields[$i]));
        }
    }
}

//submit button
if ($fld) {
    $form->addElement(new XoopsFormButton('', 'button_id', _MA_PEDIGREE_BUT_SUB, 'submit'));
}
//add data (form) to smarty template
$xoopsTpl->assign('form', $form->render());

//footer
include XOOPS_ROOT_PATH . '/footer.php';

?>
