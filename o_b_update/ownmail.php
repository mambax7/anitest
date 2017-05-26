<?php
session_start(); //echo $_SESSION['username']; //exit;
//print_r($_SESSION);
//if(empty($_SESSION)){
//header("location:http://pedigree.thepetglider.com/");
//}
if ($_SESSION['username'] !== 'admin') {
    ?>
    <script type="text/javascript">
        document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update/mainpage.php';
    </script><?php

}
mysql_connect('ca-mysql1.hspheredns.com', 'thepetg_pedigree', 'chloe');
mysqli_select_db($GLOBALS['xoopsDB']->conn, 'thepetg_pedigree');
//echo "<pre>";print_r($_POST);

if (!empty($_REQUEST['del'])) {
    //echo "DELETE FROM mSVsD_eigenaar WHERE ID = '$_REQUEST[del]' ";
    //header("location:$baseur");
    $delet  = $GLOBALS['xoopsDB']->queryF('DELETE FROM  ' . $xoopsDB->prefix('eigenaar') . "  WHERE ID = '$_REQUEST[del]' ");
    $baseur = $_SERVER['HTTP_REFERER']; ?>

    <script>
        document.location = '<?php echo $baseur; ?>';
    </script>

    <?php

}
?>
<style type="text/css">
    /* popup_box DIV-Styles*/
    #popup_box {
        display: none; /* Hide the DIV */
        position: fixed;
        _position: absolute; /* hack for internet explorer 6 */
        height: 300px;
        width: 600px;
        background: #FFFFFF;
        left: 300px;
        top: 150px;
        z-index: 100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
        margin-left: 15px;

        /* additional features, can be omitted */
        border: 2px solid skyblue;
        padding: 15px;
        font-size: 15px;
        -moz-box-shadow: 0 0 5px #ff0000;
        -webkit-box-shadow: 0 0 5px #ff0000;
        box-shadow: 0 0 5px skyblue;

    }

    #container {
        background: #d2d2d2; /*Sample*/
        width: 100%;
        height: 100%;
    }

    a {
        cursor: pointer;
        text-decoration: none;
    }

    /* This is for the positioning of the Close Link */
    #popupBoxClose {
        font-size: 20px;
        line-height: 15px;
        right: 5px;
        top: 5px;
        position: absolute;
        color: #6fa5e2;
        font-weight: 500;
    }

    .even {
        background-color: #F5F5F5;
        width: 100%;
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
        font-size: 62.5%;
    }

    .odd {
        background-color: white;
        width: 100%;
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
        font-size: 62.5%;

    }
</style>

<?php

if (!empty($_POST[radio])) {
    foreach ($_POST[chees] as $own) {
        $querysql = $GLOBALS['xoopsDB']->queryF('UPDATE ' . $xoopsDB->prefix('stamboom') . " SET  id_eigenaar='$_POST[radio]' WHERE ID = '$own'");
        //echo "UPDATE `mSVsD_stamboom` SET  id_eigenaar='$_POST[radio]' WHERE ID = '$own'";
    }
}
//mysql_connect("ca-mysql1.hspheredns.com","thepetg_pedigree","chloe");
//mysqli_select_db($GLOBALS['xoopsDB']->conn, 'thepetg_pedidev2');
if (!empty($_REQUEST['msg'])) {
    $message = 'Choose Breeder to move joeys';
} else {
    $message = 'Select one or more to display joeys';
}

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
            //$("#div22").on("load", "script.php?a="+valueId+"&msg=abc");
            $('#results').css("display", "block");

            /*	$("#checkArray :checkbox").each(function(){
             var $this = $(this);
             //alert($this);
             if($this.is(":checked")){ //alert($this.html());
             //someObj.fruitsGranted.push($this.attr("id"));
             }else{ //alert('sd');alert($this.attr("id"));
             var table=document.getElementById("tabsssatyle");
             var row=table.insertRow(0);
             var cell1=row.insertCell(0);
             var cell2=row.insertCell(1);
             cell1.innerHTML=$this.attr("id");
             //cell2.innerHTML="New";
             }
             });*/
        });

    </script>
    <?php

}

//echo $_REQUEST['a'];
//echo "select firstname,lastname from mSVsD_eigenaar  where ID = '".$_REQUEST['a']."'";
$fnlname    = $GLOBALS['xoopsDB']->queryF('SELECT ID,firstname,lastname,emailadres FROM  ' . $xoopsDB->prefix('eigenaar') . "   WHERE emailadres LIKE '" . $_REQUEST['a'] . "%'");
$fnlnameres = $GLOBALS['xoopsDB']->fetchBoth($fnlname);
$count      = $GLOBALS['xoopsDB']->getRowsNum($fnlname); //exit;
if ($count != 0) {
    //echo "<pre>";print_r($fnlnameres);
    $getres = $GLOBALS['xoopsDB']->queryF('SELECT ID,firstname,lastname,emailadres,user FROM  ' . $xoopsDB->prefix('eigenaar') . "   WHERE emailadres LIKE '" . $_REQUEST['a'] . "%' ORDER BY  lastname,firstname  ASC");
    //$getress=$GLOBALS['xoopsDB']->fetchBoth($getres); print_r($getress);
} else {
    ?>
    <script type="text/javascript">
        //alert("Deleted succesfully");
        document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update/mainpage.php';
    </script>
    <?php

}

?>
<div id="containers">
    <legend>You have selected <?php echo $_REQUEST['a']; ?></legend>
    <fieldset id="checkArray">
        <legend>Select one or more owners to display associated joeys</legend>
        <form id="testtable" method="post" action="">
            <table id="tabssatyle" style="width:100%;">
                <thead style="background-color:lightgrey; border:1px solid white;">
                <th><input type="checkbox" class="checksasa"/>Check to select</th>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Created User</th>
                <th>User Email</th>
                </thead>
                <tbody id="tabsssatyle" style="background-color:lightblue; border:1px solid white;">
                <?php $i = 0;
                while ($data = $GLOBALS['xoopsDB']->fetchBoth($getres)) {
                    $ownd = $GLOBALS['xoopsDB']->queryF('select * from ' . $xoopsDB->prefix('stamboom') . " where id_fokker!='$data[ID]'");
                    //while($bredata=$GLOBALS['xoopsDB']->fetchBoth($bredd)){
                    $owncont = $GLOBALS['xoopsDB']->getRowsNum($ownd);
                    if ($owncont != 0) {
                        if ($i % 2 == 0) {
                            $even = 'even';
                        } else {
                            $even = 'odd';
                        } ?>

                        <tr class="<?php echo $even; ?>">
                            <?php if (empty($_POST[checks])) {
                                ?>
                                <td align="center"><input class='checksas' id="checked<?php echo $i; ?>" type="checkbox" value="<?php echo $data['ID']; ?>" name="checks[]"/></td>
                                <?php

                            } else {
                                ?>
                                <td align="center"><input class='checksas' id="checked<?php echo $i; ?>" type="checkbox" value="<?php echo $data['ID']; ?>"<?php foreach ($_POST[checks] as $cheks) {
                                if ($data['ID'] == $cheks) {
                                ?> checked
                                                          <?php

                                                          }
                                                          } ?>name="checks[]"/></td><?php

                            } ?>
                            <td align="center"><?php echo $data['ID']; ?></td>
                            <td align="center"><?php echo $data['firstname']; ?></td>
                            <td align="center"><?php echo $data['lastname']; ?></td>
                            <td align="center"><?php echo $data['emailadres']; ?></td>
                            <input type="hidden" name="values" value="<?php echo $data['lastname'] . ',' . $data['firstname']; ?>"/>
                            <input type="hidden" name="idvalues" value="<?php echo $data['ID']; ?>"/>
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                            $usname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$data[user]'");
                            $udata  = $GLOBALS['xoopsDB']->fetchBoth($usname); ?>
                            <td align="center"><?php echo $udata['uname']; ?></td>
                            <td align="center"><?php echo $udata['email']; ?></td>
                        </tr>
                        <?php ++$i;
                    }
                } ?>
                <tr>
                    <td style="background-color:white;"><input type="submit" name="submts" value="select gliders"/></td>
                </tr>
                </tbody>
            </table>
        </form>
    </fieldset>
    <div id="results" style="display:none;">
        <form id="testtaable" method="post" action="">
            <fieldset>
                <legend>Select joeys to update to Owner</legend>
                <table id="tabsastyle" style="width:100%;">
                    <thead style="background-color:lightgrey; border:1px solid white;">
                    <th><input type="checkbox" class="checkd"/>Check to select</th>
                    <th>Glider name</th>
                    <th>Owner</th>
                    <th>Owner Name</th>
                    <th>Breeder</th>
                    <th>Created User</th>

                    </thead>
                    <tbody style="background-color:lightblue; border:1px solid white;">
                    <?php //echo count($_POST['checks']);
                    //print_r($_POST['checks']); $a=0;
                    $trunk = $GLOBALS['xoopsDB']->queryF('TRUNCATE TABLE `tempdata`');
                    foreach ($_POST['checks'] as $chek) { //echo $a;//print_r($chek);
                        $messages = '';
                        // echo "SELECT NAAM,id_eigenaar,id_fokker,user FROM mSVsD_stamboom where id_fokker='$chek'"; //exit;
                        //echo "SELECT NAAM,id_eigenaar,id_fokker,user FROM mSVsD_stamboom where id_eigenaar='$chek'";
                        $ins  = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdata') . " (id_eig) VALUES ('.$chek.')");
                        $sql  = $GLOBALS['xoopsDB']->queryF('SELECT ID,NAAM,id_eigenaar,id_fokker,user FROM ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar='$chek'");
                        $cont = $GLOBALS['xoopsDB']->getRowsNum($sql);
                        if ($cont != 0) {
                            ?>
                            <?php $i = 0;
                            while ($datas = $GLOBALS['xoopsDB']->fetchBoth($sql)) {
                                $messages = 'no records';
                                if ($i % 2 == 0) {
                                    $even = 'even';
                                } else {
                                    $even = 'odd';
                                } ?>
                                <tr class="<?php echo $even; ?>">
                                    <td align="center"><input class="checkss" id="chees<?php echo $i; ?>" type="checkbox" value="<?php echo $datas['ID']; ?>" name="chees[]"/></td>
                                    <td align="center"><?php echo $datas['NAAM']; ?></td>
                                    <td align="center"><?php echo $datas['id_eigenaar']; ?></td>
                                    <?php
                                    //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                                    //echo "select firstname,lastname from mSVsD_eigenaar where id_eigenaar='$datas[id_eigenaar]'";
                                    $brdname = $GLOBALS['xoopsDB']->queryF('select firstname,lastname from  ' . $xoopsDB->prefix('eigenaar') . "  where ID='$datas[id_eigenaar]'");
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
                        } else {
                            ?> <tr ><td><?php echo $messages;
                        } ?></td></tr><?php

                    } ?>

                    </tbody>
                </table>

                <legend>Select owner to update joeys</legend>

                <table id="tabsdsatyle" style="width:100%;">
                    <thead style="background-color:lightgrey; border:1px solid white;">
                    <th>Check to select</th>
                    <th>Owner ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Created User</th>
                    <th>User Email</th>
                    </thead>
                    <tbody id="tabsssatyle" style="background-color:lightblue; border:1px solid white;">
                    <?php //echo count($_POST['checks']);
                    //print_r($_POST['checks']);
                    $a = 0;
                    // foreach($_POST['checks'] as $cheaks){ echo $a=$a+1;;//print_r($chek);
                    // echo "SELECT NAAM,id_eigenaar,id_fokker,user FROM mSVsD_stamboom where id_eigenaar='$chek'"; //exit;
                    // echo "select firstname,lastname from mSVsD_eigenaar  where ID = '$cheaks'";
                    $sqlquer = '';
                    $sqlquer = $GLOBALS['xoopsDB']->queryF('SELECT ID,firstname,lastname,emailadres,user FROM  ' . $xoopsDB->prefix('eigenaar') . "   WHERE emailadres LIKE '" . $_REQUEST['a'] . "%' ORDER BY  lastname,firstname  ASC");

                    while ($sqlquernameres = $GLOBALS['xoopsDB']->fetchBoth($sqlquer)) {
                        $obredd = '';
                        $obredd = $GLOBALS['xoopsDB']->queryF('select * from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar='$sqlquernameres[ID]'");
                        //while($bredata=$GLOBALS['xoopsDB']->fetchBoth($bredd)){
                        $obrecont = 0;
                        $obrecont = $GLOBALS['xoopsDB']->getRowsNum($obredd);
                        if ($obrecont != 0) {
                            //$sqlquername=$GLOBALS['xoopsDB']->queryF("select ID,firstname,lastname,emailadres,user from mSVsD_eigenaar  where firstname= '$sqlquernameres[firstname]' and lastname ='$sqlquernameres[lastname]' ORDER BY  lastname,firstname  asc");
                            //echo "SELECT DISTINCT  mSVsD_eigenaar .*,tempdata.id_eig
                            //FROM mSVsD_eigenaar left JOIN tempdata ON mSVsD_eigenaar.ID = tempdata.id_eig
                            // WHERE mSVsD_eigenaar.firstname='$sqlquernameres[firstname]' and lastname='$sqlquernameres[lastname]'";

                            //$sqlquername='';
                            $sqlquername = $GLOBALS['xoopsDB']->queryF('SELECT DISTINCT   ' . $xoopsDB->prefix('eigenaar') . '  .*,tempdata.id_eig
			  FROM  ' . $xoopsDB->prefix('eigenaar') . "  left JOIN tempdata ON mSVsD_eigenaar.ID = tempdata.id_eig
			  WHERE mSVsD_eigenaar.emailadres='$sqlquernameres[emailadres]'");
                            $cnt         = 0;
                            $cnt         = $GLOBALS['xoopsDB']->getRowsNum($sqlquername);
                            if ($cnt != 0) {
                                ?>
                                <?php $i = 0;
                                while ($datauserress = $GLOBALS['xoopsDB']->fetchBoth($sqlquername)) {
                                    // echo 'bc'.$datauserress[id_eig].'asd';
                                    if ($datauserress[id_eig] == '') { //echo $datauserress['ID'].','.$cheaks;
                                        //$_POST['checks']=array_diff($_POST['checks'],$datauserress['ID']);
                                        //print_r($_POST['checks']);
                                        if ($i % 2 == 0) {
                                            $even = 'even';
                                        } else {
                                            $even = 'odd';
                                        } ?>

                                        <tr class="<?php echo $even; ?>">
                                            <td align="center"><input id="radio" type="radio" value="<?php echo $datauserress['ID']; ?>" name="radio"/></td>
                                            <td align="center"><?php echo $datauserress['ID']; ?></td>
                                            <td align="center"><?php echo $datauserress['firstname']; ?></td>
                                            <td align="center"><?php echo $datauserress['lastname']; ?></td>
                                            <td align="center"><?php echo $datauserress['emailadres']; ?></td>
                                            <input type="hidden" name="values" value="<?php echo $datauserress['lastname'] . ',' . $dataress['firstname']; ?>"/>
                                            <input type="hidden" name="idvalues" value="<?php echo $datauserress['ID']; ?>"/>
                                            <?php
                                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                                            $username = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$datauserress[user]'");
                                            $userdata = $GLOBALS['xoopsDB']->fetchBoth($username); ?>
                                            <td align="center"><?php echo $userdata['uname']; ?></td>
                                            <td align="center"><?php echo $userdata['email']; ?></td>
                                        </tr>
                                        <?php ++$i;
                                    }
                                    $datauserress = '';
                                }
                            }
                        }
                        $sqlquernameres = '';
                    } ?>
                    <tr>
                        <td style="background-color:white;"><input type="submit" name="submtresults" value="Update joeys with selected owner"/></td>
                    </tr>
                    </tbody>
                </table>

                <div id="div22"></div>
            </fieldset>
        </form>
    </div>
    <legend><a class="links" style="color:blue;" onclick='divdisp();'>Click here to see owners without joeys</a></legend>

    <fieldset id="checkemptyd" style="display:none;">
        <legend>Owners with empty records</legend>

        <table id="tabssatyle" style="width:100%;">
            <thead style="background-color:lightgrey; border:1px solid white;">
            <th>Owner ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Created User</th>
            <th>User Email</th>
            <th>Delete Owner</th>
            </thead>
            <tbody id="tabsssatyle" style="background-color:lightblue; border:1px solid white;">
            <?php

            //echo $_REQUEST['a'];
            //echo "select firstname,lastname from mSVsD_eigenaar  where ID = '".$_REQUEST['a']."'";
            $fnlname    = $GLOBALS['xoopsDB']->queryF('SELECT firstname,lastname FROM  ' . $xoopsDB->prefix('eigenaar') . "   WHERE ID = '" . $_REQUEST['a'] . "'");
            $fnlnameres = $GLOBALS['xoopsDB']->fetchBoth($fnlname);
            //echo "<pre>";print_r($fnlnameres);
            $getres = $GLOBALS['xoopsDB']->queryF('SELECT ID,firstname,lastname,emailadres,user FROM  ' . $xoopsDB->prefix('eigenaar') . "   WHERE emailadres LIKE '" . $_REQUEST['a'] . "%' ORDER BY  lastname,firstname  ASC");
            //$getress=$GLOBALS['xoopsDB']->fetchBoth($getres); print_r($getress);

            $i = 0;
            while ($data = $GLOBALS['xoopsDB']->fetchBoth($getres)) {
                //echo "select count(*) as counts from mSVsD_stamboom where id_fokker='$data[ID]'";
                $bredsd = $GLOBALS['xoopsDB']->queryF('select * from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar='$data[ID]'");
                //while($bredata=$GLOBALS['xoopsDB']->fetchBoth($bredd)){
                $breconts = $GLOBALS['xoopsDB']->getRowsNum($bredsd);
                if ($breconts != 0) {
                    $quer = $GLOBALS['xoopsDB']->queryF('select count(*) as counts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar='$data[ID]'");
                    $cont = $GLOBALS['xoopsDB']->fetchBoth($quer);
                    if ($cont[counts] == 0) {
                        if ($i % 2 == 0) {
                            $even = 'even';
                        } else {
                            $even = 'odd';
                        } ?>

                        <tr class="<?php echo $even; ?>">
                            <td align="center"><?php echo $data['ID']; ?></td>
                            <td align="center"><?php echo $data['firstname']; ?></td>
                            <td align="center"><?php echo $data['lastname']; ?></td>
                            <td align="center"><?php echo $data['emailadres']; ?></td>
                            <input type="hidden" name="values" value="<?php echo $data['lastname'] . ',' . $data['firstname']; ?>"/>
                            <input type="hidden" name="idvalues" value="<?php echo $data['ID']; ?>"/>
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                            $usname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$data[user]'");
                            $udata  = $GLOBALS['xoopsDB']->fetchBoth($usname); ?>
                            <td align="center"><?php echo $udata['uname']; ?></td>
                            <td align="center"><?php echo $udata['email']; ?></td>
                            <td align="center">
                                <!-- <a onclick="javascript:deletebred();"><img alt="Delete" src="../images/delete.gif"></a>
                                -->
                                <a onclick="show_confirm(<?php echo $data[ID]; ?>);"><img alt="Delete" src="../images/delete.gif"></a>
                            </td>
                        </tr>
                        <?php ++$i;
                    }
                }
            } ?>
            <!--<tr><td> <input type="submit" name="submts"  value="select gliders"/></td></tr>-->
            </tbody>
        </table>

    </fieldset>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript">
        var valss = 0;
        function divdisp() {
            if (valss == 0) {
                $('#checkemptyd').show('fast');
                $('.links').text('Click here to hide breeders without joeys');
                valss = 1;
            } else {
                $('#checkemptyd').hide('fast');
                $('.links').text('Click here to see breeders without joeys');
                valss = 0;
            }
        }
        function deletebred(iddel) {
            var pathname = window.location.pathname;
            alert(iddel);
            var url = document.URL;

            //alert(<?php echo $_REQUEST['a']; ?>);
            //var bredd='<?php echo trim($_REQUEST[bred], ','); ?>'; alert(bredd);
            //alert(pathname?a=<?php echo $_REQUEST['a']; ?>&bred=bredd);
        }
        function show_confirm(iddel) {
            var abc = 1;
            $.ajax({
                type: "POST",
                url: "getbredown.php",
                data: "fid=" + iddel,
                // beforeSend: function(){ $("#ajaxLoader").show(); },
                // complete: function(){ $("#ajaxLoader").hide(); },
                success: function (response) {
                    //alert(response);
                    //$("#livefilter").hide('fast');
                    //  alert("First need to perform owner update process");

                    $("#id_own").html(response);
                    //$("#id_fokker").attr("size","10");
                    //$("#id_fokker").focus();
                    $("#id_own").css("width", "500px");
                    //$("#id_own").show('fast');

                }

            });
            $('#selid').val(iddel);
            loadPopupBox();
            $('#popupBoxClose').click(function () {
                unloadPopupBox();
            });

            $('#container').click(function () {
                unloadPopupBox();
            });
            /*var con = confirm("Are You Sure");

             if (con ==true)
             {
             var url=document.URL;
             // alert("You pressed OK!");
             document.location=url+'&del='+iddel;

             }
             else
             {
             var url=document.URL;
             //alert("You pressed Cancel!");
             document.location=url;
             }*/

        }
        function unloadPopupBox() {    // TO Unload the Popupbox
            $('#popup_box').fadeOut("slow");
            $('input').show('fast');
            $("#containers").css({ // this is just for style
                "opacity": "1",
                "cursor": "auto"
            });
        }

        function loadPopupBox() {    // To Load the Popupbox
            $('#popup_box').fadeIn("slow");
            $('input').hide('fast');
            $("#containers").css({ // this is just for style
                "opacity": "0.3",
                "cursor": "text"
            });
        }
        function oked() {
            $('input').show('fast');
            var selidval = $('#selid').val();
            //alert(selidval);
            var con = confirm("Are You Sure");

            if (con === true) {
                var url = document.URL;
                // alert("You pressed OK!");
                document.location = url + '&del=' + selidval;

            }
            else {
                //var url=document.URL;
                alert("You pressed Cancel!");
                // document.location=url;
            }


        }
        function update() {
            var selidval = $('#selid').val();
            var url = document.URL;
            document.location = 'http://www.thepetglider.com/pedigree/modules/animal/o_b_update/script.php?a=' + selidval;

        }
        $(document).ready(function () {
            $(".checkd").click(function () {
                $(".checkss").prop("checked", $(".checkd").prop("checked"))
            })
        });
        $(document).ready(function () {
            $(".checksasa").click(function () {
                $(".checksas").prop("checked", $(".checksasa").prop("checked"))
            })
        });
    </script>


    <fieldset>
        <form action="http://www.thepetglider.com/pedigree/modules/animal/o_b_update/mainpage.php" method="post">

            <table>
                <tr>
                    <td><input type="submit" name="sum" value="Go Back"/></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
<div id="popup_box">    <!-- OUR PopupBox DIV-->
    <h3>Breeders Report</h3>
    <div id="id_own"></div>
    <div><a style="color: #6FA5E2; font-size: 20px; font-weight: 500; line-height: 15px;
    position: static;  right: 5px;" onclick="oked();">Delete</a></div>
    <input type="hidden" name="selid" id="selid" value=""/>
    <a id="popupBoxClose">Close</a>
</div>


