<?php
// -------------------------------------------------------------------------

require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}

//needed for generation of pie charts
ob_start();
include XOOPS_ROOT_PATH . '/modules/animal/include/class_eq_pie.php';
require_once XOOPS_ROOT_PATH . '/modules/animal/include/class_field.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_edit.tpl';

include XOOPS_ROOT_PATH . '/header.php'; ?>
<!--<script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#email").focus();
    });
</script>

<script type="text/javascript">

    var abc = "showns";
    var abcd = "showns";
    $(window).on("load", function () {

        $("#id_fokker").hide('fast');
        $("#id_eigenaar").hide('fast');
        $("#vader").hide('fast');
        $("#moeder").hide('fast');
        $("#fatherdetails").hide('fast');
        $("#motherdetails").hide('fast');


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


    $(document).ready(function () {
        $('#livefilter').prop('placeholder', "Type characters of breeder to narrow your search");
        $("#livefilter").keyup(function () {


            var id = $("#livefilter").val();
            var tex = $("#livefilter").val();

            if (tex.length < 3) {
                $("#id_fokker").val(0);
                $("#id_fokker").hide();
            }

            if (tex.length >= 3) {
                $.ajax({
                    type: "POST",
                    url: "getstate1.php",
                    data: "fid=" + id,

                    success: function (response) {

                        $("#id_fokker").replaceWith(response);
                        $("#id_fokker").attr("size", "10");

                        $("#id_fokker").css("width", "325px");
                        $("#id_fokker").show('fast');

                    }

                });
            }
        });
        $("#id_fokker").click(function () {

            var value = $("#id_fokker option:selected").text();
            var valeue = $("#id_fokker option:selected").val();

            $("#livefilter").val(value);
            $("#id_fokkers").val(valeue);
            $("#id_fokker").hide('fast');
        });
    });
    $(document).ready(function () {
        $('#ownerfilter').prop('placeholder', "Type characters of owner to narrow your search");
        $("#ownerfilter").keyup(function () {

            var id = $("#ownerfilter").val();
            var texs = $("#ownerfilter").val();

            if (texs.length < 3) {
                $("#id_eigenaar").val(0);
                $("#id_eigenaar").hide();
            }
            if (texs.length >= 3) {

                $.ajax({
                    type: "POST",
                    url: "getstate2.php",
                    data: "fid=" + id,

                    success: function (response) {

                        $("#id_eigenaar").replaceWith(response);
                        $("#id_eigenaar").attr("size", "10");

                        $("#id_eigenaar").css("width", "325px");
                        $("#id_eigenaar").show('fast');

                    }

                });
            }
        });
        $("#id_eigenaar").click(function () {

            var value = $("#id_eigenaar option:selected").text();
            var valuue = $("#id_eigenaar option:selected").val();

            $("#ownerfilter").val(value);
            $("#id_eigenaars").val(valuue);
            $("#id_eigenaar").hide('fast');
        });
    });

    //father search

    $(document).ready(function () {

        $('#fathertext').prop('placeholder', "Type a minimum of three characters of father to narrow your search");
        $("#fathertext").keyup(function () {
            var textlen = $("#fathertext").val();
            if (textlen.length < 3) {
                $('#fatherid').val(0);
                $("#vader").hide();
            }
            if (textlen.length >= 3) {
                var idf1 = $("#fathertext").val();

                $.ajax({
                    type: "POST",
                    url: "getfather.php",
                    data: "fid=" + idf1,
                    success: function (response) {
                        $("#vader").replaceWith(response);
                        $("#vader").css("width", "100%");
                        $("#vader").show('fast');
                        if ($("#vader").html().length <= 500) {
                            //alert($('#fatherid').val(0));
                            $('#fatherdetails').hide('fast');
                        }
                        if ($("#fathertext").val() == '') {
                            $('#fatherid').val(0);
                            //$("#motherdetails").hide('fast');
                        }

                    }
                });
            }
        });

        $('#button_idd').click(function () {
            var ontext = $("#ownerfilter").val();
            var brtext = $("#livefilter").val();
            // alert(brtext);
            // alert(ontext.length);
            if (brtext.length < 3) {
                // alert('here');
                $('#id_fokkers').val(0);

            }
            if (ontext.length < 3) {
                //alert('here');
                $('#id_eigenaars').val(0);

            }
            if ($("#fathertext").val().length < 3) {
                $('#fatherid').val(0);
                //$("#motherdetails").hide('fast');
            }
            if ($("#mothertext").val().length < 3) {
                $('#motherid').val(0);
                //$("#motherdetails").hide('fast');
            }
            $('#button_idd').prop('type', 'submit');
        });
    });

    // mother search

    $(document).ready(function () {
        $('#mothertext').prop('placeholder', "Type a minimum of three characters of mother to narrow your search");
        $("#mothertext").keyup(function () {
            var textlens = $("#mothertext").val();
            if (textlens.length < 3) {
                $('#motherid').val(0);
                $("#moeder").hide('fast');
            }
            if (textlens.length >= 3) {
                var idm1 = $("#mothertext").val();
                $.ajax({
                    type: "POST",
                    url: "getmother.php",
                    data: "mid=" + idm1,
                    success: function (response) {
                        $("#moeder").replaceWith(response);
                        $("#moeder").attr("size", "10");
                        $("#moeder").css("width", "100%");
                        $("#moeder").show('fast');
                        if ($("#moeder").html().length <= 500) {
                            $('#motherid').val(0);
                            $("#motherdetails").hide('fast');
                        }
                        if ($("#mothertext").val() == '') {
                            $('#motherid').val(0);
                            //$("#motherdetails").hide('fast');
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

// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';

global $xoopsTpl, $xoopsDB;

//get module configuration
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('animal');
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

if (isset($_GET['f'])) {
    if ($_GET['f'] === 'save') {
        save();
    }
} else {
    edit();
}

function save()
{
    global $xoopsDB, $moduleConfig;
    $a      = (!isset($_POST['id']) ? $a = '' : $a = $_POST['id']);
    $animal = new Animal($a);
    $fields = $animal->numoffields();
    for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
        $userfield = new Field($fields[$i], $animal->getconfig());
        if ($userfield->active()) {
            $currentfield = 'user' . $fields[$i];
            $picturefield = $_FILES[$currentfield]['name'];
            if (empty($picturefield) || $picturefield == '') {
                $newvalue = $_POST['user' . $fields[$i]];
            } else {
                $newvalue = uploadedpict(0);
            }

            $loginsert = '';
            $Query     = '';
            $dataquer  = '';
            $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
            $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
            if ($dataquer['user' . $fields[$i]] != $newvalue) {
                $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','user" . $fields[$i] . "','" . $dataquer['user' . $fields[$i]] . "','" . $newvalue . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
                $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
                $sql       = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' SET user' . $fields[$i] . "='" . $newvalue . "' WHERE ID='" . $a . "'";
                $GLOBALS['xoopsDB']->queryF($sql);
            }
        }
    }
    //echo "<pre>";print_r($_POST); exit;
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
    if ($dataquer[NAAM] != $_POST['NAAM']) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','NAAM','" . $dataquer[NAAM] . "','" . $_POST['NAAM'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }

    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET NAAM = '" . $_POST['NAAM'] . "', roft = '" . $_POST['roft'] . "' WHERE ID='" . $a . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
    if ($dataquer[roft] != $_POST['roft']) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','roft','" . $dataquer[roft] . "','" . $_POST['roft'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $picturefield = $_FILES['photo']['name'];
    if (empty($picturefield) || $picturefield == '') {
        //llalalala
    } else {
        $foto = uploadedpict(0);
        $sql  = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET foto='" . $foto . "' WHERE ID='" . $a . "'";

        $loginsert = '';
        $Query     = '';
        $dataquer  = '';
        $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
        $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
        if ($dataquer[foto] != $foto) {
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','foto','" . $dataquer[foto] . "','" . $foto . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
        }
    }
    $GLOBALS['xoopsDB']->queryF($sql);
    if ($moduleConfig['ownerbreeder'] == '1') {
        $queri     = '';
        $loginsert = '';
        $Query     = '';
        $dataquer  = '';
        //echo "select * from ".$GLOBALS['xoopsDB']->prefix("stamboom")." where ID='$a'";
        $Query    = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
        $dataquer = $GLOBALS['xoopsDB']->fetchBoth($Query);
        if ($dataquer[id_eigenaar] != $_POST['id_eigenaars']) { //print_r($_POST); exit;
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Owner','" . $dataquer[id_eigenaar] . "','" . $_POST['id_eigenaars'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
        }
        $loginsert = '';
        $Query     = '';
        $dataquer  = '';
        $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
        $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
        //echo $dataquer[id_fokker].'!='.$_POST[id_fokkers];
        if ($dataquer[id_fokker] != $_POST['id_fokkers']) {
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Breeder','" . $dataquer[id_fokker] . "','" . $_POST['id_fokkers'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
        }
        $loginsert = '';
        $Query     = '';
        $dataquer  = '';
        $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
        $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
        if ($dataquer[vader] != $_POST['fatherid']) {
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Father','" . $dataquer[vader] . "','" . $_POST['fatherid'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
        }
        $loginsert = '';
        $Query     = '';
        $dataquer  = '';
        $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$a'");
        $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);
        if ($dataquer[moeder] != $_POST['motherid']) {
            $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $a . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Mother','" . $dataquer[moeder] . "','" . $_POST['motherid'] . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
            $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
        }
        $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET id_eigenaar = '" . $_POST['id_eigenaar'] . "', id_fokker = '" . $_POST['id_fokker'] . "', vader = '" . $_POST['fatherid'] . "', moeder = '" . $_POST['motherid'] . "' WHERE ID='" . $a . "'";
        $GLOBALS['xoopsDB']->queryF($sql);
    }
    redirect_header('dog.php?id=' . $a, 2, 'Your changes have been saved');
}

/**
 * @param int $id
 */
function edit($id = 0)
{
    global $xoopsTpl, $xoopsDB, $moduleConfig;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID=' . $id;
    $result = $GLOBALS['xoopsDB']->query($sql);
    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
        $form = new XoopsThemeForm('Edit ' . $row['NAAM'], 'dogname', 'edit.php?f=save', 'POST');
        $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
        $form->addElement(new XoopsFormHidden('id', $id));
        $form->addElement(new XoopsFormHidden('id_eigenaars', $row['id_eigenaar']));
        $form->addElement(new XoopsFormHidden('id_fokkers', $row['id_fokker']));
        //name
        $naam = htmlentities(stripslashes($row['NAAM']), ENT_QUOTES);
        $form->addElement(new XoopsFormText('<b>' . _PED_FLD_NAME . '</b>', 'NAAM', $size = 50, $maxsize = 255, $value = $naam));
        //gender
        $roft         = $row['roft'];
        $gender_radio = new XoopsFormRadio('<b>' . _PED_FLD_GEND . '</b>', 'roft', $value = $roft);
        $gender_radio->addOptionArray(array('0' => strtr(_PED_FLD_MALE, array('[male]' => $moduleConfig['male'])), '1' => strtr(_PED_FLD_FEMA, array('[female]' => $moduleConfig['female']))));
        $form->addElement($gender_radio);
        //father
        $sql       = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE ID='" . $row['vader'] . "'";
        $resfather = $GLOBALS['xoopsDB']->query($sql);
        $numfields = $GLOBALS['xoopsDB']->getRowsNum($resfather);
        if (!$numfields == '0') {
            while ($rowfetch = $GLOBALS['xoopsDB']->fetchArray($resfather)) {
                //$form->addElement(new XoopsFormLabel("<b>".strtr(_PED_FLD_FATH, array( '[father]' => $moduleConfig['father'] ))."</b>","<img src=\"images/male.gif\"><a href=\"seldog.php?curval=".$row['ID']."&gend=1&letter=a\">".$rowfetch['NAAM']."</a>"));
                $father = $rowfetch['NAAM'];
                $form->addElement(new XoopsFormText('<b>' . strtr(_PED_FLD_FATH, array('[father]' => $moduleConfig['father'])) . '</b>', 'fathertext', $size = 50, $maxsize = 255, $value = $father));
                $father_select = new XoopsFormSelect('', $name = 'vader', $value = '0', $size = 1, $multiple = false);
                $queryfather   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . '';
                $fatherz       = $GLOBALS['xoopsDB']->query($queryfather);
                $father_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);
                /*while($fetchfather=$GLOBALS['xoopsDB']->fetchArray($fatherz))
                {
                //$father_select->addoption($fetchfather[ID],$name=$fetchfather[NAAM],$disabled=false);
                }*/
                $form->addElement($father_select);
                $form->addElement(new XoopsFormText('', 'fatherdetails', $size = 70, $maxsize = 255, $value = ''));
                $fatherid = $rowfetch['ID'];
                $form->addElement(new XoopsFormHidden('fatherid', $value = $fatherid));
            }
        } else {
            //$form->addElement(new XoopsFormLabel("<b>".strtr(_PED_FLD_FATH, array( '[father]' => $moduleConfig['father'] ))."</b>","<img src=\"images/male.gif\"><a href=\"seldog.php?curval=".$row['ID']."&gend=1&letter=a\">Unknown</a>"));

            $form->addElement(new XoopsFormText('<b>' . strtr(_PED_FLD_FATH, array('[father]' => $moduleConfig['father'])) . '</b>', 'fathertext', $size = 50, $maxsize = 255, $value = ''));
            $father_select = new XoopsFormSelect('', $name = 'vader', $value = '0', $size = 1, $multiple = false);
            $queryfather   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . '';
            $fatherz       = $GLOBALS['xoopsDB']->query($queryfather);
            $father_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);
            /*while($fetchfather=$GLOBALS['xoopsDB']->fetchArray($fatherz))
            {
            //$father_select->addoption($fetchfather[ID],$name=$fetchfather[NAAM],$disabled=false);
            }*/
            $form->addElement($father_select);
            $form->addElement(new XoopsFormText('', 'fatherdetails', $size = 70, $maxsize = 255, $value = ''));

            $form->addElement(new XoopsFormHidden('fatherid', '0'));
        }
        //mother
        $sql       = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE ID='" . $row['moeder'] . "'";
        $resmother = $GLOBALS['xoopsDB']->query($sql);
        $numfields = $GLOBALS['xoopsDB']->getRowsNum($resmother);
        if (!$numfields == '0') {
            while ($rowfetch = $GLOBALS['xoopsDB']->fetchArray($resmother)) {
                //$form->addElement(new XoopsFormLabel("<b>".strtr(_PED_FLD_MOTH, array( '[mother]' => $moduleConfig['mother'] ))."</b>","<img src=\"images/female.gif\"><a href=\"seldog.php?curval=".$row['ID']."&gend=0&letter=a\">".$rowfetch['NAAM']."</a>"));

                $mother = $rowfetch['NAAM'];
                $form->addElement(new XoopsFormText('<b>' . strtr(_PED_FLD_MOTH, array('[mother]' => $moduleConfig['mother'])) . '</b>', 'mothertext', $size = 50, $maxsize = 255, $value = $mother));
                $mother_select = new XoopsFormSelect('', $name = 'moeder', $value = '0', $size = 1, $multiple = false);
                $querymother   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . '';
                $motherz       = $GLOBALS['xoopsDB']->query($querymother);
                $mother_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);
                /*while($fetchmother=$GLOBALS['xoopsDB']->fetchArray($motherz))
                {
                //$mother_select->addoption($fetchmother[ID],$name=$fetchmother[NAAM],$disabled=false);
                }*/
                $form->addElement($mother_select);
                $form->addElement(new XoopsFormText('', 'motherdetails', $size = 70, $maxsize = 255, $value = ''));
                $motherid = $rowfetch['ID'];
                $form->addElement(new XoopsFormHidden('motherid', $value = $motherid));
            }
        } else {
            //$form->addElement(new XoopsFormLabel("<b>".strtr(_PED_FLD_MOTH, array( '[mother]' => $moduleConfig['mother'] ))."</b>","<img src=\"images/female.gif\"><a href=\"seldog.php?curval=".$row['ID']."&gend=0&letter=a\">Unknown</a>"));

            $form->addElement(new XoopsFormText('<b>' . strtr(_PED_FLD_MOTH, array('[mother]' => $moduleConfig['mother'])) . '</b>', 'mothertext', $size = 50, $maxsize = 255, $value = ''));
            $mother_select = new XoopsFormSelect('', $name = 'moeder', $value = '0', $size = 1, $multiple = false);
            $querymother   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . '';
            $motherz       = $GLOBALS['xoopsDB']->query($querymother);
            $mother_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);
            /*while($fetchmother=$GLOBALS['xoopsDB']->fetchArray($motherz))
            {
            //$mother_select->addoption($fetchmother[ID],$name=$fetchmother[NAAM],$disabled=false);
            }*/
            $form->addElement($mother_select);
            $form->addElement(new XoopsFormText('', 'motherdetails', $size = 70, $maxsize = 255, $value = ''));
            $form->addElement(new XoopsFormHidden('motherid', '0'));
        }
        //owner/breeder
        //
        $ownerid   = '';
        $breederid = '';
        $ownerid   = $row['id_eigenaar'];
        $breederid = $row['id_fokker'];
        // echo $owner=$row['NAAM'];
        $own = '';
        $sql = '';
        if ($row['id_eigenaar'] != 0) {
            $sql      = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " WHERE ID='" . $row['id_eigenaar'] . "'";
            $ownerz   = $GLOBALS['xoopsDB']->query($sql);
            $fetchown = $GLOBALS['xoopsDB']->fetchArray($ownerz);
            $own      = $fetchown['lastname'] . ',' . $fetchown['firstname'];
        } else {
            $own = '';
        }

        $form->addElement(new XoopsFormText('<b>' . _PED_FLD_OWNE . '</b>', 'ownerfilter', $size = 50, $maxsize = 255, $value = $own));
        //$form->addElement(new XoopsFormText("<b>"._PED_FLD_OWNE."</b>", 'ownerfilter', $size=50, $maxsize=255, $value=''));
        //
        if ($moduleConfig['ownerbreeder'] == '1') {
            //$owner_select = new XoopsFormSelect("<b>"._PED_FLD_OWNE."</b>", $name="id_eigenaar", $value=$row['id_eigenaar'], $size=1, $multiple=false);
            $owner_select = new XoopsFormSelect('', $name = 'id_eigenaar', $value = $ownerid, $size = 1, $multiple = false);
            //$queryeig = "SELECT ID, lastname, firstname from ".$GLOBALS['xoopsDB']->prefix("eigenaar")." ORDER BY \"lastname\"";
            /*$queryeig = "SELECT ID, lastname, firstname from ".$GLOBALS['xoopsDB']->prefix("eigenaar")."  where firstname!='' or lastname!='' ORDER BY  lastname,firstname  asc";
            $reseig = $GLOBALS['xoopsDB']->query($queryeig);
            $owner_select -> addOption( 0, $name=_PED_UNKNOWN, $disabled=false );
            while ($roweig = $GLOBALS['xoopsDB']->fetchArray($reseig))
            {

            }*/
            $owner_select->addOption($row['id_eigenaar'], $name = $own, $disabled = false);
            $form->addElement($owner_select);
            //breeder
            //
            $breed = '';
            $sql   = '';
            if ($row[id_fokker] != 0) {
                $sql        = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " WHERE ID='" . $row[id_fokker] . "'";
                $breedrz    = $GLOBALS['xoopsDB']->query($sql);
                $fetchbreed = $GLOBALS['xoopsDB']->fetchArray($breedrz);
                $breed      = $fetchbreed['lastname'] . ',' . $fetchbreed['firstname'];
            } else {
                $breed = '';
            }

            $form->addElement(new XoopsFormText('<b>' . _PED_FLD_BREE . '</b>', 'livefilter', $size = 50, $maxsize = 255, $value = $breed));
            //

            //$breeder_select = new XoopsFormSelect("<b>"._PED_FLD_BREE."</b>", $name="id_fokker", $value=$row['id_fokker'], $size=1, $multiple=false);
            $breeder_select = new XoopsFormSelect('', $name = 'id_fokker', $value = $breederid, $size = 1, $multiple = false);
            //$queryfok = "SELECT ID, lastname, firstname from ".$GLOBALS['xoopsDB']->prefix("eigenaar")." ORDER BY \"lastname\"";
            //$queryfok = "SELECT ID, lastname, firstname from ".$GLOBALS['xoopsDB']->prefix("eigenaar")."  where firstname!='' or lastname!='' ORDER BY  lastname,firstname  asc";
            /*$resfok = $GLOBALS['xoopsDB']->query($queryfok);
            $breeder_select -> addOption( 0, $name=_PED_UNKNOWN, $disabled=false );
            while ($rowfok = $GLOBALS['xoopsDB']->fetchArray($resfok))
            {
                $breeder_select -> addOption( $rowfok['ID'], $name=$rowfok['lastname'].", ".$rowfok['firstname'], $disabled=false );
            }*/
            $breeder_select->addOption($row['id_fokker'], $name = $breed, $disabled = false);
            $form->addElement($breeder_select);
        }
        //picture
        if ($row['foto'] != '') {
            $picture = '<img src=images/thumbnails/' . $row['foto'] . '_400.jpeg>';
            $form->addElement(new XoopsFormLabel('<b>Picture</b>', $picture));
        } else {
            $picture = '';
        }
        $form->setExtra("enctype='multipart/form-data'");
        $img_box = new XoopsFormFile('<b>Image</b>', 'photo', 1024000);
        $img_box->setExtra("size ='50'");
        $form->addElement($img_box);
        //userfields
        //create animal object
        $animal = new Animal($id);
        //test to find out how many user fields there are..
        $fields = $animal->numoffields();
        for ($i = 0, $iMax = count($fields); $i < $iMax; $i++) {
            $userfield = new Field($fields[$i], $animal->getconfig());
            if ($userfield->active()) {
                $fieldType   = $userfield->getSetting('FieldType');
                $fieldobject = new $fieldType($userfield, $animal);
                $edditable   = $fieldobject->editField();
                $form->addElement($edditable);
            }
        }
    }

    //$form->addElement(new XoopsFormText("<b>".strtr(_PED_FLD_FATH, array( '[father]' => $moduleConfig['father'] ))."</b>", '', $size=50, $maxsize=255, $value=''));
    //$form->addElement(new XoopsFormText("<b>".strtr(_PED_FLD_MOTH, array( '[mother]' => $moduleConfig['mother'] ))."</b>", '', $size=50, $maxsize=255, $value=''));
    $form->addElement(new XoopsFormButton('', 'button_idd', _PED_BUT_SUB, 'button'));
    $xoopsTpl->assign('form', $form->render());
}

//comments and footer
include XOOPS_ROOT_PATH . '/footer.php';

?>
