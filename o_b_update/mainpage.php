<?php
//require_once "../../../mainfile.php";
session_start();
//print_r($_SESSION);
if ($_SESSION['username'] !== 'admin') {
    ?>
    <script type="text/javascript">
        document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update';
    </script><?php

}
mysql_connect('ca-mysql1.hspheredns.com', 'thepetg_pedigree', 'chloe');
mysqli_select_db($GLOBALS['xoopsDB']->conn, 'thepetg_pedigree');
//print_r($_SESSION);
if (!empty($_POST)) {

    //echo "<pre>"; print_r($_POST);
    //echo count($_POST['checks']);
    if (count($_POST['checks']) != 0) { //echo count($_POST['checks']);?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                /*var valueId = new Array();
                 var atLeastOneIsChecked = $('#checkArray :checkbox:checked').length;
                 for(var i=0;  i<=atLeastOneIsChecked;  i++){
                 valueId[i]=$('#checked'+i).val(); alert(valueId[i]);
                 }*/
                $('#livefilter').val('<?php echo $_POST[values]; ?>');
                var valueId = '<?php echo $_POST[idvalues]; ?>';
                $("#div1").on("load", "script.php?a=" + valueId);
                $("#div22").on("load", "script.php?a=" + valueId + "&msg=abc");
                $('#results').css("display", "block");
            });
        </script>
        <?php

    }
}
$numdog = $GLOBALS['xoopsDB']->queryF('SELECT COUNT(*) AS count FROM ' . $xoopsDB->prefix('stamboom'));
$numres = $GLOBALS['xoopsDB']->fetchBoth($numdog); //print_r($numres['count']);
//total number of dogs the query will find
$numresults = $GLOBALS['xoopsDB']->getRowsNum($numdog);
?>
<!DOCTYPE html>
<html>
<head>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script type="text/javascript">
        $(window).on("load", function () {
            var valrad = $("input:radio[name=radSize]").val();


            $("input:radio[name=radSize]").click(function () {
                var value = $(this).val();
                if (value === 'small') {
                    $("#breeder").css("display", "block");
                    $("#owner").css("display", "none");
                    //$('#fown').hide('fast');
                    //$('#fbre').show('fast');
                } else {
                    $("#owner").css("display", "block");
                    $("#breeder").css("display", "none");
                    //$('#fown').show('fast');
                    //$('#fbre').hide('fast');
                }
                //alert(value);
            });
        });

        $(document).ready(function () {
            $('#livefilter').prop('placeholder', "Type first few characters of breeder to narrow your search");
            $("#livefilter").keyup(function () {

                //var optionValue = $("select[name='country_select']").val();
                var id = $("#livefilter").val();
                //var dataString = 'id='+ id;
                //alert("datastring"+dataString);
                if (id.length <= 2) {
                    $("#id_fokker").hide();
                }
                if (id.length >= 3) {
                    $.ajax({
                        type: "POST",
                        url: "getstate.php",
                        data: "fid=" + id,
                        // beforeSend: function(){ $("#ajaxLoader").show(); },
                        // complete: function(){ $("#ajaxLoader").hide(); },
                        success: function (response) {
                            //alert(response);
                            //$("#livefilter").hide('fast');
                            $("#id_fokker").html(response);
                            //$("#state").attr("id","id_fokker");
                            $("#id_fokker").attr("size", "10");
                            //$("#id_fokker").focus();
                            $("#id_fokker").css("width", "325px");
                            $("#id_fokker").css("margin-left", "161px");
                            $("#id_fokker").css("display", "block");

                        }

                    });
                }
            });
            $("select#id_fokker").click(function () {
                //alert('sdfv');
                var valuetext = $("#id_fokker option:selected").text();
                var valueId = $("#id_fokker option:selected").val();
                //alert(valueId);

                $("#livefilter").val(valuetext);
                $("#id_fokker").hide('fast');
                $('#bnames').val(valuetext);
                $('#bid').val(valueId);
                //$('#script').submit();
                document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update/script.php?a=' + valueId + '&bred=' + valuetext;
                // $("#div1").css("display","block");
                //$("#div1").on("load", "script.php?a="+valueId);
            });
        });
        $(document).ready(function () {
            $('#ownerfilter').prop('placeholder', "Type characters of owner to narrow your search");
            $("#ownerfilter").keyup(function () {

                //var optionValue = $("select[name='country_select']").val();
                var id = $("#ownerfilter").val();
                //var dataString = 'id='+ id;
                //alert("datastring"+dataString);
                if (id.length <= 2) {
                    $("#id_eigenaar").hide();
                }
                if (id.length >= 3) {
                    $.ajax({
                        type: "POST",
                        url: "getstates.php",
                        data: "fid=" + id,
                        // beforeSend: function(){ $("#ajaxLoader").show(); },
                        // complete: function(){ $("#ajaxLoader").hide(); },
                        success: function (response) {
                            //alert(response);
                            //$("#livefilter").hide('fast');
                            $("#id_eigenaar").html(response);
                            //$("#state").prop("id","id_eigenaar");
                            $("#id_eigenaar").attr("size", "10");
                            //$("#id_fokker").focus();

                            $("#id_eigenaar").css("width", "325px");
                            $("#id_eigenaar").css("margin-left", "161px");
                            $("#id_eigenaar").show('fast');

                        }

                    });
                }
            });
            $("select#id_eigenaar").click(function () {
                //alert('sdfv');
                var value = $("#id_eigenaar option:selected").text();
                var valuesid = $("#id_eigenaar option:selected").val();

                $("#ownerfilter").val(value);
                $("#id_eigenaar").hide('fast');
                document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update/scripts.php?a=' + valuesid + '&on=' + value;

                // $("#div1").on("load", "script.php?a="+valuesid);
            });
        });
        function selected() {

            /*$("#checkArray").each(function(){
             var atLeastOneIsChecked = $('#checkArray :checkbox:checked').prop('id');
             alert(atLeastOneIsChecked);
             });



             var atLeastOneIsChecked = $('#checkArray :checkbox:checked').prop('id');
             //alert(atLeastOneIsChecked);
             var regSubCodeArray = new Array();
             var data = new Array();
             for(var i=0; i<=atLeastOneIsChecked; i++){
             data[i]=$('#checked'+i+' :checkbox:checked').val();

             alert(data[i]);

             }
             //var ht=$("#result").html();
             /*
             $("#result").on("load", "joey.php?a="+data[i]);
             //var htl=$("#result").html();
             //$("#result").html(ht+htl);
             /*var atLeastOneIsChecked = $('#checkArray :checkbox:checked').length;
             for(var i=1; i<=atLeastOneIsChecked; i++){
             alert($('#checked'+i).val());
             alert(data);
             if ($('#checked' +i +':checked')) {
             alert('inside');
             $("#result").append(load("joey.php?a="+valuesid));
             // var content = $( data ).find( '#content' );
             $( "#result" ).empty().append( content );
             } else {
             alert('outside');
             }
             }*/
            var someObj = {};
            someObj.fruitsGranted = [];
            someObj.fruitsDenied = [];

            $("input:checkbox").each(function () {
                var $this = $(this);
                //alert($this);
                if ($this.is(":checked")) {
                    alert($this.attr("id"));
                    someObj.fruitsGranted.push($this.attr("id"));
                } else {
                    alert($this.attr("id"));
                    someObj.fruitsDenied.push($this.attr("id"));
                }
            });		//alert(someObj.fruitsGranted.push($this.attr("id")));
            $('#testtable').submit();
        }
        function choosen() {

            var selected = $("#chose option:selected").val();
            if (selected === 'email') {
                $('#name').css("display", "none");
                $('#mail').css("display", "block");
            } else { //if(selected=='name'){
                $('#mail').css("display", "none");
                $('#name').css("display", "block");

            }
            /*else {
             $('#mail').css("display","none");
             $('#name').css("display","none");
             }*/
        }
        function chosen() {

            var selected = $("#Ochose option:selected").val();
            if (selected === 'email') {
                $('#oname').css("display", "none");
                $('#omail').css("display", "block");
            } else {//if(selected=='name'){
                $('#omail').css("display", "none");
                $('#oname').css("display", "block");

            }
            /*else {
             $('#omail').css("display","none");
             $('#oname').css("display","none");
             }*/
        }
        function searchbymail() {
            var bymail = $('#bymail').val();
            //alert(bymail);
            if (bymail === '') {
                $('#bymail').css('border', '1px solid red');
                $('#bymail').focus();
            } else {
                document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update/bredmail.php?a=' + bymail;
            }
        }
        function searchbymails() {
            var Obymail = $('#obymail').val();
            //alert(Obymail);
            if (Obymail === '') {
                $('#obymail').css('border', '1px solid red');
                $('#obymail').focus();
            }
            else {
                document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update/ownmail.php?a=' + Obymail;
            }
        }

    </script>

    <title>Breeder/Owner Update</title>
</head>
<body>
<form id="script" action="script.php" method="post">
    <input type="hidden" name="a" id="bid" value=""/>
    <input type="hidden" name="bnames" id="bnames" value=""/>
</form>
<h3>Breeder/Owner Update</h3>
<fieldset>
    <legend style="background-color:#666666; width:100%; color:white; font-family: Verdana,Arial,Helvetica,sans-serif;">Select Owner or Breeder</legend>
    <p>
        <label></label>
        <input type="radio"
               name="radSize"
               id="sizeSmall"
               value="small"
               checked="checked"/>
        <label for="sizeSmall">Breeder</label>

        <input type="radio"
               name="radSize"
               id="sizeMed"
               value="medium"/>
        <label for="sizeMed">Owner</label>

    </p>
</fieldset>
<div class="breeder" id="breeder">
    <div style="background-color:grey;padding-left:10px; text-align:left;">
        <p style="background-color:#666666; width:100%; color:white; font-family: Verdana,Arial,Helvetica,sans-serif;">Breeder</p>
    </div>
    <fieldset id="fbre">
        <label for="sizeSmall">Please select search type</label>

        <select id="chose" onchange="choosen();" style="width:300px;">
            <option value="name">Breeder Name</option>
            <option value="email">Breeder Mail</option>

        </select>
    </fieldset>
    <fieldset id="mail" style="display:none;">
        <!--<input type = "checkbox"  name = "checkpattern" id = "checkpattern" checked value = ""  />Check to have pattern search<br>
           --> <label for="sizeSmall">Breeder Email id</label>
        <input type="text" autocomplete="off" name="bymail" id="bymail" value="" style="width:300px;"/>

        <label for="sizeSmallss">Example: xyz@xyz.com</label>

        <br>
        <label for="simall"></label>
        <input type="button" name="goto" id="goto" value="Search" onclick="searchbymail();"/>

    </fieldset>
    <fieldset id="name">
        <form action="nbscript.php" method="post">
            <!--<input type = "checkbox"  name = "checkpatterns" id = "checkpatterns" checked value = ""  />Check to have pattern search
                   <br>-->
            <label for="sizeSmall">Search for breeder name</label>

            <input type="text" autocomplete="off" name="a" id="livefilter" value="" style="width:300px;"/>
            <br>
            <label for="sizedfSmall"></label>

            <select id="id_fokker" style="display:none;"> <?php
                $queryfok = "SELECT ID, lastname, firstname FROM mSVsD_  WHERE firstname!='' OR lastname!='' ORDER BY  lastname, firstname ASC";
                $resfok   = $GLOBALS['xoopsDB']->queryF($queryfok);
                while ($data = $GLOBALS['xoopsDB']->fetchBoth($resfok)) {
                    ?>
                    <option value="<?php echo $data['ID']; ?>"><?php echo $data['lastname'] . ',' . $data['firstname']; ?></option>
                    <?php

                } ?>
            </select>

            <br>
            <label for="simall"></label>
            <input type="submit" name="gotoas" id="gotoas" value="Search"/>
        </form>
    </fieldset>
</div>
<div class="owner" id="owner" style="display:none;">
    <div style="background-color:grey; padding-left:10px; text-align:left;">
        <p style="background-color:#666666; width:100%; color:white; font-family: Verdana,Arial,Helvetica,sans-serif;">Owner</p>
    </div>
    <fieldset id="fown">
        <label for="sizeSmall">Please select search type</label>

        <select id="Ochose" onchange="chosen();" style="width:300px;">
            <option value="name">Owner Name</option>
            <option value="email">Owner Mail</option>

        </select>
    </fieldset>

    <fieldset id="omail" style="display:none;">
        <!-- <input type = "checkbox"  name = "checkpatternd" id = "checkpatternd" checked value = ""  />Check to have pattern search<br>
         --> <label for="sizeSmall">Breeder Email id</label>
        <input type="text" autocomplete="off" name="obymail" id="obymail" value="" style="width:300px;"/>
        <label for="sizeSmallss">Example: xyz@xyz.com</label>

        <br>
        <label for="sismall"></label>
        <input type="button" name="gotos" id="gotos" value="Search" onclick="searchbymails();"/>

    </fieldset>
    <fieldset id="oname">
        <form action="noscripts.php" method="post">
            <!--<input type = "checkbox"  name = "checkpatterndd" id = "checkpatterndd" checked value = ""  />Check to have pattern search<br>
              --> <label for="sizeSmall">Search for owner name</label>

            <input type="text" autocomplete="off" name="a" id="ownerfilter" style="width:300px;" value=""/>
            <br>
            <select id="id_eigenaar" style="display:none;"> <?php
                $queryfok = "SELECT ID, lastname, firstname FROM mSVsD_  WHERE firstname!='' OR lastname!='' ORDER BY  lastname, firstname ASC";
                $resfok   = $GLOBALS['xoopsDB']->queryF($queryfok);
                while ($data = $GLOBALS['xoopsDB']->fetchBoth($resfok)) {
                    ?>
                    <option value="<?php echo $data['ID']; ?>"><?php echo $data['lastname'] . ',' . $data['firstname']; ?></option>
                    <?php

                } ?>
            </select>

            <br>
            <label for="simall"></label>
            <input type="submit" name="gotoss" id="gotoss" value="Search"/>
        </form>
    </fieldset>
</div>
<form id="testtable" method="post" action="">

    <div id="div1" style="display:none;"></div>
    <div id="results" style="display:none;">

        <fieldset>
            <legend>Select joeys to update to breeder</legend>
            <table id="tabstyle">
                <thead style="background-color:lightgrey; border:1px solid white;">
                <th>Check to select</th>
                <th>Glider name</th>
                <th>Breeder</th>
                <th>Breeder Name</th>
                <th>Owner</th>
                <th>Created User</th>

                </thead>
                <tbody style="background-color:lightblue; border:1px solid white;">
                <?php //echo count($_POST['checks']);
                //print_r($_POST['checks']); $a=0;
                foreach ($_POST['checks'] as $chek) { //echo $a;//print_r($chek);
                    // echo "SELECT NAAM,id_eigenaar,id_fokker,user FROM mSVsD_stamboom where id_eigenaar='$chek'"; //exit;
                    $sql = $GLOBALS['xoopsDB']->queryF('SELECT NAAM,id_eigenaar,id_fokker,user FROM ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar='$chek'"); ?>
                    <?php $i = 0;
                    while ($datas = $GLOBALS['xoopsDB']->fetchBoth($sql)) {
                        ?>

                        <tr>
                            <td align="center"><input id="checkes<?php echo $i; ?>" type="checkbox" value="<?php echo $data['id_eigenaar']; ?>" name="checks[]"/></td>
                            <td align="center"><?php echo $datas['NAAM']; ?></td>
                            <td align="center"><?php echo $datas['id_eigenaar']; ?></td>
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                            //echo "select firstname,lastname from mSVsD_eigenaar where id_eigenaar='$datas[id_eigenaar]'";
                            $brdname = $GLOBALS['xoopsDB']->queryF('select firstname,lastname from ' . $xoopsDB->prefix('eigenaar') . " where ID='$datas[id_eigenaar]'");
                            $brdata  = $GLOBALS['xoopsDB']->fetchBoth($brdname); //print_r($brdata);
                            ?>
                            <td align="center"><?php echo $brdata['lastname'] . ',' . $brdata['firstname']; ?></td>
                            <td align="center"><?php echo $datas['id_fokker']; ?></td>
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                            $usname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$datas[user]'");
                            $udata  = $GLOBALS['xoopsDB']->fetchBoth($usname); ?>
                            <td align="center"><?php echo $udata['uname']; ?></td>

                        </tr>
                        <?php ++$i;
                    } ?><?php ++$a;
                } ?>

                </tbody>
            </table>
            <div id="div22"></div>
        </fieldset>

    </div>

</form>


</body>

</html> 
