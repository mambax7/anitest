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

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_adddog.tpl';

include XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', 'Pedigree database - Update details'); ?>
<link rel="stylesheet" href="stylesheets/ui.css">
<link rel="stylesheet" href="stylesheets/ui.progress-bar.css">
<link media="only screen and (max-device-width: 480px)" href="stylesheets/ios.css" type="text/css" rel="stylesheet"/>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
<!--<script type="text/javascript" src="jquery.loader.js"></script>-->


<!-- <script src="javascripts/progress.js" type="text/javascript" charset="utf-8"></script>-->
<!--
<style type="text/css">
/* popup_box DIV-Styles*/
#popup_box { 
display:none; /* Hide the DIV */
position:fixed;
_position:absolute; /* hack for internet explorer 6 */
height:300px;
width:600px;
background:#FFFFFF;
left: 300px;
top: 150px;
z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
margin-left: 15px;

/* additional features, can be omitted */
border:2px solid #ff0000;
padding:15px;
font-size:15px;
-moz-box-shadow: 0 0 5px #ff0000;
-webkit-box-shadow: 0 0 5px #ff0000;
box-shadow: 0 0 5px #ff0000;

}

#container {
background: #d2d2d2; /*Sample*/
width:100%;
height:100%;
}

a{
cursor: pointer;
text-decoration:none;
}

/* This is for the positioning of the Close Link */
#popupBoxClose {
font-size:20px;
line-height:15px;
right:5px;
top:5px;
position:absolute;
color:#6fa5e2;
font-weight:500;
}
</style>-->
<script type="text/javascript">

    function uplodimg() {


        loadPopupBox();

        $('#popupBoxClose').click(function () {
            unloadPopupBox();
        });

        $('#container').click(function () {
            unloadPopupBox();
        });

        function unloadPopupBox() {	// TO Unload the Popupbox
            $('#popup_box').fadeOut("slow");
            $("#container").css({ // this is just for style
                "opacity": "1"
            });
        }

        function loadPopupBox() {	// To Load the Popupbox
            $('#popup_box').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "0.3"
            });
        }
    }
    var imgflag = '';
    $(document).ready(function () {

        var button = $('#button_ids').replaceWith('<input type="button" id="button_ids" name="button_ids" value="submit"/> <input type="button" id="buttonids" name="buttonids" value="Back to menu"/>');
        /*$('#button_ids').click(function(){
         $('#ormimage').css('display','block');
         });*/
//alert(button);
        $('#buttonids').click(function () {
            document.location = 'add_dog.php';
        });

        $('#photoimg').click(function () {
//$('#popup_box').css('display','block');
            //		$('#ormimage').css('display','block');
            $('#photoimg').replaceWith('<input type="hidden" name="MAX_FILE_SIZE" value="1024000" /><input type="file" size="57" name="photos" id="photos" /><input type="hidden" name="xoops_upload_file[]" id="xoops_upload_file[]" value="photos" />');
            $('#photos').trigger('click');
//document.getElementById('photos').focus();
            imgflag = 1;
        });
        //alert($("input[type='file']").val());


        /*
         $('#photos').click(function(){
         var data=$('#photos').val();
         if(data==''){
         $.ajax({
         type: "POST",
         url: "ajaximage.php",
         data: "fid="+ data,
         success: function(response){
         alert(response);
         }
         });
         }
         });*/
        $(".head").css('width', '100px');
        $("#user4").prop('rows', '3');
        $("#user4").prop('cols', '52');
        $("#user5").prop('rows', '3');
        $("#user5").prop('cols', '52');
        $("#user3").css('width', '437px');
        $("#NAAM").focus();
        $("#NAAM").prop("autocomplete", "off");
        $("#fathertext").css("width", "437px");
        $("#mothertext").css("width", "437px");
        $("#fathertext").prop("autocomplete", "off");
        $("#mothertext").prop("autocomplete", "off");
        $("#photo").prop("size", "57");
        //$("#roft0").css("width","50px");
        $("#roft1").css("margin-left", "25px");
    });


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
        //$("#fathertext").typeWatch({ highlight: true, wait: 500, captureLength: -1, callback: finished });
        $('#fathertext').prop('placeholder', "Type a minimum of three characters of father to narrow your search");
        $("#fathertext").keyup(function () {
            var textlen = $("#fathertext").val();
            if (textlen.length < 3) {
                $("#vader").hide();
                $('#fatherdetails').hide('fast');
            }
            if (textlen.length >= 3) {
                //var optionValue = $("select[name='country_select']").val();
                var idf1 = $("#fathertext").val();
                $.ajax({
                    type: "POST",
                    url: "getfather.php",
                    data: "fid=" + idf1,
                    success: function (response) {
                        $("#vader").replaceWith(response);  //$("#vader").attr("size","10");
                        $("#vader").css("width", "90%");
                        $("#vader").css("overflow-x", "scroll");
                        $("#vader").show('fast');
                        if ($("#vader").html().length <= 500) {
                            $('#fatherid').val(0);
                            $('#fatherdetails').hide('fast');
                        }
                    }
                });
            }

        });

        $('#mothertext').prop('placeholder', "Type a minimum of three characters of mother to narrow your search");
        $("#mothertext").keyup(function () {

            var textlens = $("#mothertext").val();
            if (textlens.length < 3) {
                $("#moeder").hide('fast');
                $('#motherdetails').hide('fast');
            }
            if (textlens.length >= 3) {
                //var optionValue = $("select[name='country_select']").val();
                var idm1 = $("#mothertext").val();

                $.ajax({
                    type: "POST",
                    url: "getmother.php",
                    data: "mid=" + idm1,
                    success: function (response) {
                        $("#moeder").replaceWith(response);
                        $("#moeder").prop("size", "10");
                        $("#moeder").css("width", "90%");
                        $("#moeder").css("overflow-x", "scroll");
                        $("#moeder").show('fast');
                        if ($("#moeder").html().length <= 500) {
                            $('#motherid').val(0);
                            $("#motherdetails").hide('fast');
                        }
                    }

                });
            }
        });

        $('#livefilter').prop('placeholder', "Type first three characters of breeder to narrow your search");
        $("#livefilter").prop('size', '70');
        $("#livefilter").prop('autocomplete', 'off');
        $("#livefilter").keyup(function () {
            var start = new Date().getTime();

            var id = $("#livefilter").val();
            var bretex = $("#livefilter").val();
            if (bretex.length < 3) {
                $("#id_fokker").hide();
            }
            if (bretex.length >= 3) {

                $.ajax({
                    type: "POST",
                    url: "getstate1.php",
                    data: "fid=" + id,
                    success: function (response) {
                        $("#id_fokker").replaceWith(response);
                        $("#id_fokker").prop("size", "10");
                        //$("#id_fokker").focus();
                        $("#id_fokker").css("width", "441px");
                        $("#id_fokker").css("display", "block");
                        $("#id_fokker").css("color", "black");
                        if ($("#id_fokker").html().length <= 30) {
                            $("#id_fokker").html('<option disabled style="color:red; font-weight:bold;">No breeder found for your search</option>');
                            $("#livefilter").val('');
                        }
                    }

                });
            }
        });
        /*
         $("#id_fokker").click(function(){
         var value=$("#id_fokker option:selected").text();
         $("#livefilter").val(value);
         $("#id_fokker").hide('fast');
         });*/
        $("input").keyup(function (evt) {
            //Deterime where our character code is coming from within the event
            var charCode = evt.charCode || evt.keyCode;
            if (charCode == 13) { //Enter key's keycode
                //alert('here');
                return false;
            }
        });

        $('#ownerfilter').prop('placeholder', "Type first three characters of owner to narrow your search");
        $("#ownerfilter").prop('size', '70');
        $("#ownerfilter").prop('autocomplete', 'off');
        $("#ownerfilter").keyup(function () {

            //var optionValue = $("select[name='country_select']").val();
            var id = $("#ownerfilter").val();
            //var dataString = 'id='+ id;
            //alert("datastring"+dataString);
            var brestex = $("#ownerfilter").val();
            if (brestex.length < 3) {
                $("#id_eigenaar").hide();
            }
            if (brestex.length >= 3) {

                $.ajax({
                    type: "POST",
                    url: "getstate2.php",
                    data: "fid=" + id,
                    // beforeSend: function(){ $("#ajaxLoader").show(); },
                    // complete: function(){ $("#ajaxLoader").hide(); },
                    success: function (response) {
                        //alert(response);
                        //$("#livefilter").hide('fast');
                        $("#id_eigenaar").replaceWith(response);
                        $("#id_eigenaar").prop("size", "10");
                        //$("#id_fokker").focus();
                        $("#id_eigenaar").css("width", "441px");
                        $("#id_eigenaar").show('fast');
                        if ($("#id_eigenaar").html().length <= 30) {
                            //alert('No owner found for your search');
                            $("#id_eigenaar").html('<option disabled style="color:red; font-weight:bold;">No owner found for your search</option>');
                            $("#ownerfilter").val('');
                        }

                    }

                });
            }
        });
        /*$("#id_eigenaar").click(function(){
         alert('sdfv');
         var value=$("#id_eigenaar option:selected").text();

         $("#ownerfilter").val(value);
         $("#id_eigenaar").hide('fast');
         });
         */

        $('#button_ids').click(function () {
            //alert('sdf');
            var fatder = $('#fathertext').val();
            var modder = $('#mothertext').val();

            if (fatder.length == 0) {
                $('#fatherid').val(0);
            }
            if (modder.length == 0) {
                $('#motherid').val(0);
            }
            $('#dognames').removeProp('onsubmit');
            $('#button_ids').prop('type', 'submit');
            //alert(document.URL);
            var str = document.URL;
            var substr = str.split('?');
            if (imgflag == 1) {
                $('#container').css("display", 'block');
                $('.outer').css("display", 'none');

                (function ($) {
                    // Simple wrapper around jQuery animate to simplify animating progress from your app
                    // Inputs: Progress as a percent, Callback
                    // TODO: Add options and jQuery UI support.
                    $.fn.animateProgress = function (progress, callback) {
                        return this.each(function () {
                            $(this).animate({
                                width: progress + '%'
                            }, {
                                duration: 2000,

                                // swing or linear
                                easing: 'swing',

                                // this gets called every step of the animation, and updates the label
                                step: function (progress) {
                                    var labelEl = $('.ui-label', this),
                                        valueEl = $('.value', labelEl);

                                    if (Math.ceil(progress) < 20 && $('.ui-label', this).is(":visible")) {
                                        labelEl.hide();
                                    } else {
                                        if (labelEl.is(":hidden")) {
                                            labelEl.fadeIn();
                                        }
                                    }

                                    if (Math.ceil(progress) == 100) {
                                        labelEl.text('Done');
                                        setTimeout(function () {
                                            labelEl.fadeOut();
                                        }, 1000);
                                    } else {
                                        valueEl.text(Math.ceil(progress) + '%');
                                    }
                                },
                                complete: function (scope, i, elem) {
                                    if (callback) {
                                        callback.call(this, i, elem);
                                    }
                                }
                            });
                        });
                    };
                })(jQuery);

                $(function () {
                    // Hide the label at start
                    $('#progress_bar .ui-progress .ui-label').hide();
                    // Set initial value
                    $('#progress_bar .ui-progress').css('width', '7%');

                    // Simulate some progress
                    $('#progress_bar .ui-progress').animateProgress(40, function () {
                        $(this).animateProgress(99, function () {
                            setTimeout(function () {

                                //$('#conti').html('updating father completed');

                                $('#progress_bar .ui-progress').animateProgress(100, function () {
                                    $('#main_content').slideDown();
                                    $('#fork_me').fadeIn();
                                });
                            }, 8000);
                        });
                    });

                });


                /*setTimeout(function() {
                 $('#conti').text('Adding Father...');
                 },2000);
                 setTimeout(function() {
                 $('#conti').text('Adding Mother....');
                 },4000);*/
                setTimeout(function () {
                    $('#conti').text('Congratulations!!   Adding the joey is completed.');
                }, 14000);
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-374977-27']);
                _gaq.push(['_trackPageview']);

                (function () {
                    var ga = document.createElement('script');
                    ga.type = 'text/javascript';
                    ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ga, s);
                })();
            }
            //$('#dognames').submit();
            //alert('sdf');
            return;
            //$('#button_ids').prop('type','submit');
        });
        /*try {
         $("input[type='text']").each(function(){
         $(this).attr("autocomplete","off");
         });
         }
         catch (e)
         { }*/

        $('.outer').click(function () {
            $('#id_fokker').hide('fast');
            $('#id_eigenaar').hide('fast');
        });


    });
</script>
<!-- <script src="javascripts/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="javascripts/progress.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-374977-27']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>-->
<?php
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
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#livefilter").focus();
    });
</script>
<?php
function addDog()
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
    $form->addElement(new XoopsFormLabel('<b>' . _PED_EXPLAIN . '</b>', $string));

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
    $queryString  = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM LIKE '" . $name . "%' ORDER BY NAAM";
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
        //,,echo _PED_ADD_KNOWNOK.','.$moduleConfig['animalType'];
        $form->addElement(new XoopsFormButton('', 'button_id', strtr(_PED_ADD_KNOWNOK, array('[animalType]' => $moduleConfig['animalType'])), 'submit'));
        //$form->addElement(new XoopsFormButton('', 'cancel_id', 'Back to menu', 'button'));

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
        $form->addElement(new XoopsFormHidden('some_target', $xoopsUser->getVar('uid')));
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result2)) {
            //name
            $form->addElement(new XoopsFormLabel('<b>' . _PED_FLD_NAME . '</b>', '<a href="dog.php?id=' . $row['ID'] . '">' . stripslashes($row['NAAM']) . '</a>'));
        }
        $form->addElement(new XoopsFormLabel('<b>' . _PED_EXPLAIN . '</b>', strtr(_PED_ADD_KNOWN, array('[animalTypes]' => $moduleConfig['animalTypes']))));
        //submit button
        $form->addElement(new XoopsFormButton('', 'button_id', strtr(_PED_ADD_KNOWNOK, array('[animalType]' => $moduleConfig['animalType'])), 'submit'));
        $xoopsTpl->assign('form', $form->render());
    } else {
        //create form
        //echo $ipaddress=$_SERVER['REMOTE_ADDR'];
        include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $form = new XoopsThemeForm(strtr(_PED_ADD_DOG, array('[animalType]' => $moduleConfig['animalType'])), 'dognames', 'add_dog.php?f=sire', 'POST');
        //added to handle upload
        $form->setExtra("enctype='multipart/form-data'");
        $form->addElement(new XoopsFormHiddenToken($name = 'XOOPS_TOKEN_REQUEST', $timeout = 360));
        //create random value
        $random = (mt_rand() % 10000);
        $form->addElement(new XoopsFormHidden('random', $random));
        $form->addElement(new XoopsFormHidden('NAAM', htmlspecialchars($_POST['NAAM'], ENT_QUOTES)));
        //find userid from previous form
        $form->addElement(new XoopsFormHidden('user', $_POST['user']));
        //$form->addElement(new XoopsFormHidden('xoops_upload_file[]', 'photo'));

        //rajesh code start
        $form->addElement(new XoopsFormLabel('<b>' . _PED_FLD_NAME . '</b>', stripslashes(stripslashes($_POST['NAAM']))));
        //gender
        $gender_radio = new XoopsFormRadio('<b>' . _PED_FLD_GEND . '</b>', 'roft', $value = '0');
        $gender_radio->addOptionArray(array('0' => strtr(_PED_FLD_MALE, array('[male]' => $moduleConfig['male'])), '1' => strtr(_PED_FLD_FEMA, array('[female]' => $moduleConfig['female']))));
        $form->addElement($gender_radio);
        $form->addElement(new XoopsFormText('<b>' . _PED_FLD_BREE . "</b><br><p style='width:140px;'>Leave blank if unknown</p>", 'livefilter', $size = 70, $maxsize = 255, $value = ''));
        if ($moduleConfig['ownerbreeder'] == '1') {
            //breeder
            $breeder_select = new XoopsFormSelect('', $name = 'id_fokker', $value = '0', $size = 1, $multiple = false);
            $queryfok       = 'SELECT ID, lastname, firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . "  WHERE firstname!='' OR lastname!='' ORDER BY  lastname, firstname ASC";
            $rsesfok        = $GLOBALS['xoopsDB']->query($queryfok);
            $breeder_select->addOption('0', $name = _PED_UNKNOWN, $disabled = false);
            $form->addElement($breeder_select);

            $form->addElement(new XoopsFormText('<b>' . _PED_FLD_OWNE . "</b><br><p style='width:140px;'>Leave blank if unknown</p>", 'ownerfilter', $size = 70, $maxsize = 255, $value = ''));
            $owner_select = new XoopsFormSelect('', $name = 'id_eigenaar', $value = '0', $size = 1, $multiple = false);
            //$queryfok = "SELECT ID, lastname, firstname from ".$GLOBALS['xoopsDB']->prefix("eigenaar")."  where firstname!='' or lastname!='' ORDER BY  firstname,lastname  asc";
            $queryfok = 'SELECT ID, lastname, firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . "  WHERE firstname!='' OR lastname!='' ORDER BY  lastname,firstname  ASC";
            $resfok   = $GLOBALS['xoopsDB']->query($queryfok);
            $owner_select->addOption('0', $name = _PED_UNKNOWN, $disabled = false);

            $form->addElement($owner_select);
            $form->addElement(new XoopsFormLabel('<b>' . _PED_EXPLAIN . '</b>', strtr(_PED_FLD_OWNE_EX, array('[animalType]' => $moduleConfig['animalType']))));
        }
        //picture
        $form->addElement(new XoopsFormButton('Picture', 'photoimg', 'choose image', 'button'));
        /*/$form->addElement(new XoopsFormText("<b>".Picture."</b>", 'photoimg', $size=70, $maxsize=255, $value=''));
        $max_imgsize = 1024000;
        $img_box = new XoopsFormFile("<b>Image</b>", "photo", $max_imgsize);
        $img_box->setExtra( "size ='58'") ;
        $form->addElement($img_box);*/

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
                echo $form->addElement($newentry);
            }
            unset($newentry);
        }

        $form->addElement(new XoopsFormText('<b>' . strtr(_PED_FLD_FATH, array('[father]' => $moduleConfig['father'])) . "</b><br><p style='width:140px;'>Leave blank if unknown</p>", 'fathertext', $size = 50, $maxsize = 255, $value = ''));
        $father_select = new XoopsFormSelect('', $name = 'vader', $value = '0', $size = 1, $multiple = false);
        $queryfather   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . '';
        $fatherz       = $GLOBALS['xoopsDB']->query($queryfather);
        $father_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);

        $form->addElement($father_select);
        $form->addElement(new XoopsFormText('', 'fatherdetails', $size = 70, $maxsize = 255, $value = ''));
        $form->addElement(new XoopsFormHidden('fatherid', '0'));

        $form->addElement(new XoopsFormText('<b>' . strtr(_PED_FLD_MOTH, array('[mother]' => $moduleConfig['mother'])) . "</b><br><p style='width:140px;'>Leave blank if unknown</p>", 'mothertext', $size = 50, $maxsize = 255, $value = ''));
        $mother_select = new XoopsFormSelect('', $name = 'moeder', $value = '0', $size = 1, $multiple = false);
        $querymother   = 'SELECT ID,NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . '';
        $motherz       = $GLOBALS['xoopsDB']->query($querymother);
        $mother_select->addoption(0, $name = _PED_UNKNOWN, $disabled = false);

        $form->addElement($mother_select);
        $form->addElement(new XoopsFormText('', 'motherdetails', $size = 70, $maxsize = 255, $value = ''));
        $form->addElement(new XoopsFormHidden('motherid', '0'));

        $form->addElement(new XoopsFormButton('', 'button_ids', 'submit', 'button'));
        //add data (form) to smarty template
        $xoopsTpl->assign('form', $form->render());
    }
}

function sire()
{ //echo time();
    //echo gettimeofday();//echo "before sire function".date();
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
    $moeder      = $_POST['motherid'];
    $vader       = $_POST['fatherid'];
    //print_r( $_FILES);
    $picturefield = $_FILES['photos']['name'];
    if (empty($picturefield) || $picturefield == '') {
        $foto = '';
    } else {
        $foto = uploadedpict(0); //exit;
        //$foto = $picturefield;
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
        }

        $insert    = 'INSERT INTO '
                     . $GLOBALS['xoopsDB']->prefix('stamboom')
                     . "(NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,user1,user2,user3,user4,user5)
		VALUES('"
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
                     . $moeder
                     . "','"
                     . $vader
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
                     . "')";
        $quer      = $GLOBALS['xoopsDB']->queryF($insert);
        $joeyid    = $GLOBALS['xoopsDB']->getInsertId();
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
				VALUES('" . $joeyid . "','" . $_POST[NAAM] . "',NOW(),'" . $user . "','all','0','all','Insert','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);

        $updated  = $GLOBALS['xoopsDB']->queryF('update ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " set addeddate =NOW() where ID='$joeyid'");
        $selectid = $GLOBALS['xoopsDB']->queryF('SELECT ID FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' ORDER BY ID DESC LIMIT 0,1');
        $fetchid  = $GLOBALS['xoopsDB']->fetchBoth($selectid);
        //$iddd=$fetchid['ID'];
        $iddd = $joeyid;
        redirect_header('dog.php?id=' . $iddd . '', 1, strtr(_PED_ADD_OK, array('[animalType]' => $moduleConfig['animalType'])));
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
    $pages .= '<a href="add_dog.php?f=sire&r=1&random=' . $random . '&l=Ã–">Ã–</a>&nbsp;';
    //create linebreak
    $pages .= '<br>';
    //create previous button
    if ($numpages > 1) {
        if ($cpage > 1) {
            echo _PED_PREVIOUS;
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
        'Addedby'     => '',
        'dateadded'   => '',
        'owner'       => '',
        'breeder'     => '',
        'colour'      => '',
        'date'        => '',
        'number'      => '',
        'usercolumns' => $empty
    );
    makelist($result, $prefix, 'add_dog.php?f=dam&random=' . $random . '&selsire=', 'ID');

    //assign links
    $xoopsTpl->assign('nummatch', strtr(_PED_ADD_SELSIRE, array('[father]' => $moduleConfig['father'])));
    $xoopsTpl->assign('pages', $pages);

    //echo "before sire function".date();
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
        //echo 'kanna code';
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
    //echo 'test kanna';
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
    //echo "INSERT INTO mSVsD_stamboom (NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,coi,user1,user2,user3,user4,user5,addeddate) SELECT NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,coi,user1,user2,user3,user4,user5 FROM " . $GLOBALS['xoopsDB']->prefix('pius_stamboon') . " WHERE ID=$random",NOW();;
    $insert_stamboom = $GLOBALS['xoopsDB']->queryF('INSERT INTO '
                                                   . $GLOBALS['xoopsDB']->prefix('stamboom')
                                                   . '(NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,coi,user1,user2,user3,user4,user5) SELECT NAAM,id_eigenaar,id_fokker,user,roft,moeder,vader,foto,coi,user1,user2,user3,user4,user5 FROM '
                                                   . $GLOBALS['xoopsDB']->prefix('pius_stamboon')
                                                   . " WHERE ID=$random");
    $joeyid          = $GLOBALS['xoopsDB']->getInsertId();

    $updated = $GLOBALS['xoopsDB']->queryF('update ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " set addeddate =NOW() where ID='$joeyid'");
    //exit;
    redirect_header('latest.php', 1, strtr(_PED_ADD_OK, array('[animalType]' => $moduleConfig['animalType'])));
}

?>
<div id="container" style="display:none;">
    <div id="progress_bar" class="ui-progress-bar ui-container">
        <div class="ui-progress" style="width: 79%;">
            <span class="ui-label" style="display:none;">please wait while Image get uploaded <b class="value">79%</b></span>
        </div>
    </div>
    <p id="conti">please wait while we are adding the joey</p>
</div>
<!--<div id="ormimage" style="display:none;">
<p id="status"></p>
<form id="form1" enctype="multipart/formdata">
<input type="file" id="photo" name="photo" />
<input type="submit" id="save" name="save" value="Upload" />
</form>

</div>-->
<!--
<div id="popup_box" style="display:none;">	<!-- OUR PopupBox DIV-->
<!--	<h1></h1>
	<div id="ormimage" style="display:none;">
<p id="status"></p>
<form id="form1" enctype="multipart/form-data">
<input type="file" id="photo" name="photo" />
<input type="submit" id="save" name="save" value="Upload" />
</form>

</div>
	<a id="popupBoxClose">Close</a>	
</div>
<div id="container" style="display:none;"> <!-- Main Page -->
<!--
</div>-->
<?php
//footer
include XOOPS_ROOT_PATH . '/footer.php';

?>


//hello
