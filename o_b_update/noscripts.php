<?php
session_start(); //echo $_SESSION['username']; //exit;
//print_r($_SESSION);
//if(empty($_SESSION)){
//header("location:http://pedigree.thepetglider.com/");
//}
if ($_SESSION['username'] !== 'admin') {
    ?>
    <script type="text/javascript">
        document.location = 'http://thepetglider.com/pedigree/modules/animal/o_b_update';
    </script><?php

}
mysql_connect('ca-mysql1.hspheredns.com', 'thepetg_pedigree', 'chloe');
mysqli_select_db($GLOBALS['xoopsDB']->conn, 'thepetg_pedigree');
//echo "<pre>";print_r($_POST);

if (!empty($_REQUEST['del'])) {
    //echo "DELETE FROM mSVsD_eigenaar WHERE ID = '$_REQUEST[del]' ";
    //header("location:$baseur");
    //loginfo///
    $insinfo = '';
    $run     = '';
    $datarun = '';
    $run     = $GLOBALS['xoopsDB']->queryF('select * from ' . $xoopsDB->prefix('stamboom') . " WHERE ID = '$_REQUEST[del]'");
    $datarun = $GLOBALS['xoopsDB']->fetchBoth($run);
    $insinfo = $GLOBALS['xoopsDB']->queryF('INSERT INTO '
                                           . $xoopsDB->prefix('ob_loginfo')
                                           . "(joeyid,id_eigenaar_before,id_eigenaar_after,id_fokker_before,id_fokker_after,deleted_joey,status,date) VALUES('"
                                           . $own
                                           . "','"
                                           . $datarun[id_eigenaar]
                                           . "','0','"
                                           . $datarun[id_fokker]
                                           . "','0','"
                                           . $_REQUEST[del]
                                           . "','Deleted','NOW()')");
    //end of log info//
    $delet  = $GLOBALS['xoopsDB']->queryF('DELETE FROM ' . $xoopsDB->prefix('eigenaar') . " WHERE ID = '$_REQUEST[del]' ");
    $baseur = $_SERVER['HTTP_REFERER']; ?>

    <script>
        //document.location='<?php echo $baseur; ?>';
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
        //loginfo///
        $insinfo = '';
        $run     = '';
        $datarun = '';
        $run     = $GLOBALS['xoopsDB']->queryF('select * from ' . $xoopsDB->prefix('stamboom') . " WHERE ID = '$own'");
        $datarun = $GLOBALS['xoopsDB']->fetchBoth($run);
        $insinfo = $GLOBALS['xoopsDB']->queryF('INSERT INTO '
                                               . $xoopsDB->prefix('ob_loginfo')
                                               . "(joeyid,id_eigenaar_before,id_eigenaar_after,id_fokker_before,id_fokker_after,deleted_joey,status,date) VALUES('"
                                               . $own
                                               . "','"
                                               . $datarun[id_eigenaar]
                                               . "','"
                                               . $_POST[radio]
                                               . "','0','0','0','updated owner','NOW()')");
        //end of log info//
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

if (!empty($_REQUEST['a'])) {
    //echo "select firstname,lastname from mSVsD_eigenaar  where ID = '".$_REQUEST['a']."'";
    //echo "SELECT * FROM `mSVsD_eigenaar` where firstname like '.$_REQUEST[a].%' or lastname like '.$_REQUEST[a].%' or emailadres like '.$_REQUEST[a].%'";
    $fnlname    = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where firstname like '$_REQUEST[a]%' or lastname like '$_REQUEST[a]%' or emailadres like '$_REQUEST[a]%'");
    $fnlnameres = $GLOBALS['xoopsDB']->fetchBoth($fnlname);
    $count      = $GLOBALS['xoopsDB']->getRowsNum($fnlname);
    if ($count != 0) {
        //echo "<pre>";print_r($fnlnameres);
        $getres = $GLOBALS['xoopsDB']->queryF('select ID,firstname,lastname,emailadres,user from  ' . $xoopsDB->prefix('eigenaar') . "   where firstname like '$_REQUEST[a]%' or lastname like '$_REQUEST[a]%' or emailadres like '$_REQUEST[a]%'");
        //$getress=$GLOBALS['xoopsDB']->fetchBoth($getres); print_r($getress);
    } else {
        ?>
        <script type="text/javascript">
            document.location = 'http://thepetglider.com/pedigree/modules/animal/o_b_update/mainpage.php';
        </script>
        <?php

    }
} else {
    ?>
    <script type="text/javascript">
        document.location = 'http://thepetglider.com/pedigree/modules/animal/o_b_update/mainpage.php';
    </script>
    <?php

}
?>
<div id="containers">
    <h2>Owner Update Process</h2>
    <legend>Your search for <?php echo $_REQUEST['a']; ?></legend>
    <fieldset id="checkArray">
        <legend style="background-color:#666666; width:100%; color:white; font-family: Verdana,Arial,Helvetica,sans-serif;">Select one or more owners to display joeys</legend>
        <form id="testtable" method="post" action="noscripts.php?a=<?php echo $_REQUEST['a']; ?>">
            <table id="tabssatyle" style="width:100%; border: 1px solid black;">
                <thead style="background-color:lightgrey; border:1px solid white; font-family: Verdana,Arial,Helvetica,sans-serif; font-size: 62.5%;">
                <th><a class='sele'>Select All</a><input type="checkbox" class="checkd"/></th>
                <th>Owner ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Joey count</th>
                <th>Email</th>
                <th>Created User</th>
                <th>User Email</th>
                </thead>
                <tbody id="tabsssatyle" style="background-color:lightblue; border:1px solid white;">
                <?php
                $trunk = '';
                $trunk = $GLOBALS['xoopsDB']->queryF('TRUNCATE TABLE tempdatass');
                //echo "SELECT * FROM `mSVsD_eigenaar` where firstname like '%$_REQUEST[a]%' order by ID";
                $conts    = '';
                $fnlsname = '';
                $data     = '';
                $fnlsname = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where firstname like '%$_REQUEST[a]%' ");
                $conts    = $GLOBALS['xoopsDB']->getRowsNum($fnlsname);
                if ($conts != 0) {
                    $i = 0;
                    while ($data = $GLOBALS['xoopsDB']->fetchBoth($fnlsname)) {
                        $bcnt    = '';
                        $bredder = '';
                        //echo "select count(*) as bcnt from mSVsD_stamboom where id_eigenaar=$data[ID]";
                        $bredder = $GLOBALS['xoopsDB']->queryF('select * from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$data[ID]");
                        $bcnt    = $GLOBALS['xoopsDB']->getRowsNum($bredder);
                        if ($bcnt != 0) {
                            //if($i%2==0){ $even='even'; }else { $even='odd'; }
                            //$arr[]=$data['ID'];
                            ?>


                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                            $inss = '';
                            $inss = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$data[ID].')"); ?>


                            <?php
                            $sqlmail  = '';
                            $maildata = '';
                            //echo "here";
                            //echo "select  mSVsD_eigenaar.* from mSVsD_eigenaar where user='$data[user]'  order by ID";
                            $sqlmail = $GLOBALS['xoopsDB']->queryF('select  mSVsD_eigenaar.* from  ' . $xoopsDB->prefix('eigenaar') . "  where user='$data[user]' ");
                            while ($maildata = $GLOBALS['xoopsDB']->fetchBoth($sqlmail)) {
                                $quer   = '';
                                $qqquer = '';
                                $quer   = $GLOBALS['xoopsDB']->queryF('select count(*) as cntss from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$maildata[ID]");
                                $qqquer = $GLOBALS['xoopsDB']->fetchBoth($quer);
                                if ($qqquer[cntss] != 0) {
                                    if ($maildata[ID] != $data['ID']) {
                                        $inss = '';
                                        $inss = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('$maildata[ID]')"); ?>

                                        <?php

                                    }
                                }
                            } ?>


                            <?php
                            if ($data[lastname] != '') {
                                //echo "SELECT * FROM `mSVsD_eigenaar` where lastname ='$data[lastname]'";
                                $fnlssname = '';
                                $connts    = '';
                                $fnlssname = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where lastname like '%$data[lastname]%' ");
                                $connts    = $GLOBALS['xoopsDB']->getRowsNum($fnlssname);
                                if ($connts != 0) {
                                    $fnlssnamedataa = '';
                                    while ($fnlssnamedataa = $GLOBALS['xoopsDB']->fetchBoth($fnlssname)) {
                                        $bredders = $GLOBALS['xoopsDB']->queryF('select count(*) as bcnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$fnlssnamedataa[ID]");
                                        $bcnts    = $GLOBALS['xoopsDB']->fetchBoth($bredders); //echo "here";
                                        if ($bcnts[bcnts] != 0) {
                                            if ($fnlssnamedataa[ID] != $data['ID']) {
                                                ?>


                                                <?php $inass = '';
                                                $inass       = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$fnlssnamedataa[ID].')"); ?>


                                                <?php //echo "select * from mSVsD_eigenaar where user=$data[user]";
                                                $sqlmail  = '';
                                                $maildata = '';
                                                $sqlmail  = $GLOBALS['xoopsDB']->queryF('select  mSVsD_eigenaar.* from  ' . $xoopsDB->prefix('eigenaar') . "  where user=$fnlssnamedataa[user]");
                                                while ($maildata = $GLOBALS['xoopsDB']->fetchBoth($sqlmail)) {
                                                    $quer   = '';
                                                    $qqquer = '';
                                                    //echo "select count(*) as cntss from mSVsD_stamboom where id_eigenaar=$maildata[ID]";
                                                    $quer   = $GLOBALS['xoopsDB']->queryF('select count(*) as cntss from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$maildata[ID]");
                                                    $qqquer = $GLOBALS['xoopsDB']->fetchBoth($quer);
                                                    if ($qqquer[cntss] != 0) {
                                                        if ($maildata[ID] != $fnlssnamedataa['ID']) {
                                                            $inss = '';
                                                            $inss = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$maildata[ID].')"); ?>

                                                            <?php

                                                        }
                                                    }
                                                } ?>


                                                <?php

                                            } ?>
                                            </tr>
                                            <?php ++$i;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } //else {
                //echo "SELECT * FROM `mSVsD_eigenaar` where lastname like '$_REQUEST[a]%' order by ID";
                $lsname = '';
                $concts = '';
                $lsname = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where lastname like '%$_REQUEST[a]%' ");
                $concts = $GLOBALS['xoopsDB']->getRowsNum($lsname);
                if ($concts != 0) {
                    $lbredders = '';
                    $lbcnts    = '';
                    $daaata    = '';
                    $i         = 0;
                    while ($daaata = $GLOBALS['xoopsDB']->fetchBoth($lsname)) {
                        //echo "select count(*) as blcnts from mSVsD_stamboom where id_eigenaar=$daaata[ID]";
                        $lbredders = $GLOBALS['xoopsDB']->queryF('select count(*) as blcnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$daaata[ID]");
                        $lbcnts    = $GLOBALS['xoopsDB']->fetchBoth($lbredders);
                        if ($lbcnts[blcnts] != 0) {
                            ?>

                            <?php
                            $inss = '';
                            $inss = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$daaata[ID].')");
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";

                            ?>


                            <?php //echo "select * from mSVsD_eigenaar where user=$data[user]";
                            $sqlmail  = '';
                            $maildata = '';
                            $sqlmail  = $GLOBALS['xoopsDB']->queryF('select DISTINCT mSVsD_eigenaar.* from  ' . $xoopsDB->prefix('eigenaar') . "  where user=$daaata[user]");
                            while ($maildata = $GLOBALS['xoopsDB']->fetchBoth($sqlmail)) {
                                $quer   = '';
                                $qqquer = '';
                                $quer   = $GLOBALS['xoopsDB']->queryF('select count(*) as cntss from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$maildata[ID]");
                                $qqquer = $GLOBALS['xoopsDB']->fetchBoth($quer);
                                if ($qqquer[cntss] != 0) {
                                    if ($maildata[ID] != $daaata['ID']) {
                                        ?>


                                        <?php
                                        $inss = '';
                                        $inss = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$maildata[ID].')");
                                        //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                                        $usaname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$maildata[user]'");
                                        $udaata  = $GLOBALS['xoopsDB']->fetchBoth($usaname); ?>
                                        <?php

                                    }
                                }
                            } ?>


                            <?php

                            if ($daaata[firstname] != '') {
                                //echo "SELECT * FROM `mSVsD_eigenaar` where firstname ='$data[firstname]'";
                                $fnlssname      = '';
                                $fnlsssnamedata = '';
                                $connts         = '';
                                $fnlssname      = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where firstname like '%$daaata[firstname]%' ");
                                $connts         = $GLOBALS['xoopsDB']->getRowsNum($fnlssname);
                                if ($connts != 0) {
                                    while ($fnlsssnamedata = $GLOBALS['xoopsDB']->fetchBoth($fnlssname)) {
                                        $lnbredders = '';
                                        $lnbcnts    = '';
                                        $lnbredders = $GLOBALS['xoopsDB']->queryF('select count(*) as blncnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$daaata[ID]");
                                        $lnbcnts    = $GLOBALS['xoopsDB']->fetchBoth($lnbredders);
                                        if ($lnbcnts[blncnts] != 0) {
                                            if ($fnlsssnamedata[ID] != $daaata['ID']) {
                                                $arr[] = $fnlsssnamedata[ID]; ?>

                                                <?php
                                                $inssd = '';
                                                $inssd = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$fnlsssnamedata[ID].')");
                                                //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                                                $ussaname = '';
                                                $udsaata  = '';
                                                $ussaname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$fnlsssnamedata[user]'");
                                                $udsaata  = $GLOBALS['xoopsDB']->fetchBoth($ussaname); ?>
                                                <?php

                                            } ?>
                                            <?php //echo "select * from mSVsD_eigenaar where user=$data[user]";
                                            $sqlmail  = '';
                                            $maildata = '';
                                            $sqlmail  = $GLOBALS['xoopsDB']->queryF('select DISTINCT mSVsD_eigenaar.* from  ' . $xoopsDB->prefix('eigenaar') . "  where user=$fnlsssnamedata[user] ");
                                            while ($maildata = $GLOBALS['xoopsDB']->fetchBoth($sqlmail)) {
                                                $quer   = '';
                                                $qqquer = '';
                                                $quer   = $GLOBALS['xoopsDB']->queryF('select count(*) as cntss from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$maildata[ID]");
                                                $qqquer = $GLOBALS['xoopsDB']->fetchBoth($quer);
                                                if ($qqquer[cntss] != 0) {
                                                    if ($maildata[ID] != $data['ID']) {
                                                        $inssd = '';
                                                        $inssd = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$maildata[ID].')"); ?>


                                                        <?php
                                                        //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                                                        $usaname = '';
                                                        $udaata  = '';
                                                        $usaname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$maildata[user]'");
                                                        $udaata  = $GLOBALS['xoopsDB']->fetchBoth($usaname); ?>

                                                        <?php

                                                    }
                                                }
                                            } ?>


                                            <?php ++$i;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } //}?>
                <?php /////////start///////////////?>
                <?php
                //$trunk=$GLOBALS['xoopsDB']->queryF("TRUNCATE TABLE `tempdatass`");
                $fnlsname  = '';
                $conts     = '';
                $data      = '';
                $fnlsnames = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where firstname like '%$_REQUEST[a]%' order by ID");
                $contss    = $GLOBALS['xoopsDB']->getRowsNum($fnlsnames);
                if ($contss != 0) {
                    $i = 0;
                    while ($datas = $GLOBALS['xoopsDB']->fetchBoth($fnlsnames)) {
                        $bcnt    = '';
                        $bredder = '';
                        //echo "select count(*) as bcnt from mSVsD_stamboom where id_fokker=$data[ID]";
                        //echo "select count(*) as bcnt from mSVsD_stamboom where id_eigenaar=$data[ID] and id_fokker=$data[ID]";
                        $bredder = $GLOBALS['xoopsDB']->queryF('select count(*) as bcnt from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$datas[ID] or id_fokker=$datas[ID]");
                        $bcnt    = $GLOBALS['xoopsDB']->fetchBoth($bredder);
                        if ($bcnt[bcnt] == 0) {
                            if ($i % 2 == 0) {
                                $even = 'even';
                            } else {
                                $even = 'odd';
                            }
                            $arr[] = $datas['ID']; ?>
                            <input type="hidden" name="a" value="<?php echo $_REQUEST['a']; ?>"/>
                            <!--<tr class="<?php echo $even; ?>">
				
				<td align="center"><?php// echo $datas['ID'];?></td>
				<td align="center"><?php// echo $datas['firstname'];?></td>
				<td align="center"><?php// echo $datas['lastname'];?></td>
				<td align="center"><?php// echo $datas['emailadres'];?></td>
				<input type="hidden" name="values" value="<?php echo $datas['lastname'] . ',' . $datas['firstname']; ?>"/>
				<input type="hidden" name="idvalues" value="<?php echo $datas['ID']; ?>"/>-->
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                            $inss   = '';
                            $inss   = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$datas[ID].')");
                            $usname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$datas[user]'");
                            $udata  = $GLOBALS['xoopsDB']->fetchBoth($usname); ?>
                            <!--<td align="center"><?php //echo $udata['uname'];?></td>
				<td align="center"><?php //echo $udata['email'];?></td>-->

                            <?php
                            if ($datas[lastname] != '') {
                                //echo "SELECT * FROM `mSVsD_eigenaar` where lastname ='$data[lastname]'";
                                $fnlssname = '';
                                $connts    = '';
                                $fnlssname = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where lastname ='$datas[lastname]' order by ID");
                                $connts    = $GLOBALS['xoopsDB']->getRowsNum($fnlssname);
                                if ($connts != 0) {
                                    $fnlssnamedata = '';
                                    while ($fnlssnamedata = $GLOBALS['xoopsDB']->fetchBoth($fnlssname)) {
                                        $bredders = $GLOBALS['xoopsDB']->queryF('select count(*) as bcnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$fnlssnamedata[ID] or id_fokker=$fnlssnamedata[ID]");
                                        $bcnts    = $GLOBALS['xoopsDB']->fetchBoth($bredders);
                                        if ($bcnts[bcnts] == 0) {
                                            if ($fnlssnamedata[ID] != $datas['ID']) {
                                                $arr[] = $fnlssnamedata[ID]; ?>

                                                <?php
                                                $inass = '';
                                                $inass = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$fnlssnamedata[ID].')"); ?>
                                                <?php

                                            } ?>

                                            <?php ++$i;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } //else {
                $lsname = '';
                $concts = '';
                $lsname = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where lastname like '%$_REQUEST[a]%'");
                $concts = $GLOBALS['xoopsDB']->getRowsNum($lsname);
                if ($concts != 0) {
                    $i = 0;
                    while ($daasata = $GLOBALS['xoopsDB']->fetchBoth($lsname)) {
                        $lbredders = $GLOBALS['xoopsDB']->queryF('select count(*) as blcnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$daasata[ID] or  id_fokker=$daasata[ID]");
                        $lbcnts    = $GLOBALS['xoopsDB']->fetchBoth($lbredders);
                        if ($lbcnts[blcnts] == 0) {
                            if ($i % 2 == 0) {
                                $even = 'even';
                            } else {
                                $even = 'odd';
                            } ?>

                            <?php
                            $insds = '';
                            $insds = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$daasata[ID].')");
                            if ($daasata[firstname] != '') {
                                //echo "SELECT * FROM `mSVsD_eigenaar` where firstname ='$data[firstname]'";
                                $fnlssname       = '';
                                $fnlsssnamedatas = '';
                                $lnbredders      = '';
                                $lnbcnts         = '';
                                $connts          = '';
                                $fnlssname       = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where firstname ='$daasata[firstname]' ");
                                $connts          = $GLOBALS['xoopsDB']->getRowsNum($fnlssname);
                                if ($connts != 0) {
                                    $lnbredders = '';
                                    $lnbcnts    = '';
                                    while ($fnlsssnamedatas = $GLOBALS['xoopsDB']->fetchBoth($fnlssname)) {
                                        $lnbredders = $GLOBALS['xoopsDB']->queryF('select count(*) as blncnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$fnlsssnamedatas[ID] or  id_fokker=$fnlsssnamedatas[ID]");
                                        $lnbcnts    = $GLOBALS['xoopsDB']->fetchBoth($lnbredders);
                                        if ($lnbcnts[blncnts] == 0) {
                                            if ($fnlsssnamedatas[ID] != $daasata['ID']) {
                                                //$arr[]=$fnlsssnamedatas[ID];
                                                $inssd = '';
                                                $inssd = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$fnlsssnamedatas[ID].')");
                                            } ?>

                                            <?php ++$i;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } //}?>
                <?php //////////end//////////////?>

                <?php
                $btempdata = '';
                $fetch     = '';
                //echo "select distinct ins from tempdatass";
                $btempdata = $GLOBALS['xoopsDB']->queryF('SELECT DISTINCT ins FROM ' . $xoopsDB->prefix('tempdatass'));
                $j         = 0;
                while ($fetch = $GLOBALS['xoopsDB']->fetchBoth($btempdata)) {
                    $bdata    = '';
                    $breddata = '';
                    //echo "select * from mSVsD_eigenaar where id_eigenaar='$fetch[ins]' order by ID";
                    $bdata = $GLOBALS['xoopsDB']->queryF('select * from  ' . $xoopsDB->prefix('eigenaar') . "  where ID='$fetch[ins]' ");

                    while ($breddata = $GLOBALS['xoopsDB']->fetchBoth($bdata)) {
                        $even = '';
                        if ($j % 2 == 0) {
                            $even = 'even';
                        } else {
                            $even = 'odd';
                        }
                        $breddercount = '';
                        $bcntcount    = '';
                        $breddercount = $GLOBALS['xoopsDB']->queryF('select count(*) as bcnt from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$breddata[ID]");
                        $bcntcount    = $GLOBALS['xoopsDB']->fetchBoth($breddercount); ?>
                        <tr class="<?php echo $even; ?>">
                            <?php if (empty($_POST[checks])) {
                                ?>
                                <td align="center"><input class="checkss" id="checked<?php //echo $i;?>" type="checkbox" value="<?php echo $breddata['ID']; ?>" name="checks[]"/></td>
                                <?php

                            } else {
                                ?>
                                <td align="center"><input class='checkss' id="checked<?php //echo $i;?>" type="checkbox" value="<?php echo $breddata['ID']; ?>"<?php foreach ($_POST[checks] as $cheks) {
                                if ($breddata['ID'] == $cheks) {
                                ?> checked <?php

                                                          }
                                                          } ?>name="checks[]"/></td><?php

                            } ?>
                            <td align="center"><?php echo $breddata['ID']; ?></td>
                            <td align="center"><?php echo $breddata['firstname']; ?></td>
                            <td align="center"><?php echo $breddata['lastname']; ?></td>
                            <td align="center"><?php echo $bcntcount['bcnt'];
                                if ($bcntcount['bcnt'] == 0) {
                                    ?>
                                    <a id="<?php echo $breddata[ID]; ?>" onclick="show_confirm(<?php echo $breddata[ID]; ?>);"><img alt="Delete" src="../images/delete.gif"></a>
                                    <?php

                                } ?></td>
                            <td align="center"><?php echo $breddata['emailadres']; ?></td>
                            <input type="hidden" name="values" value="<?php echo $breddata['lastname'] . ',' . $breddata['firstname']; ?>"/>
                            <input type="hidden" name="idvalues" value="<?php echo $breddata['ID']; ?>"/>
                            <input type="hidden" name="a" value="<?php echo $_REQUEST['a']; ?>"/>
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                            $userdata = '';
                            $usedaata = '';
                            $userdata = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid=$breddata[user]");
                            $usedaata = $GLOBALS['xoopsDB']->fetchBoth($userdata); ?>
                            <td align="center"><?php echo $usedaata['uname']; ?></td>
                            <td align="center"><?php echo $usedaata['email']; ?></td>
                        </tr>


                        <?php ++$j;
                    }
                } ?>
                <tr>
                    <td style="background-color:white;"><a class='seleectd'>Select All</a><input type="checkbox" class="checkdd"/></td>
                </tr>
                <tr>
                    <td style="background-color:white;">
                        <input type="submit" name="submts" value="select gliders"/></td>
                </tr>
                </tbody>
            </table>
        </form>
    </fieldset>

    <div id="results" style="display:none;">
        <form id="testtaable" method="post" action="">
            <fieldset>
                <legend style="background-color:#666666; width:100%; color:white; font-family: Verdana,Arial,Helvetica,sans-serif;">Select joeys to update to Owner</legend>
                <table id="tabsastyle" style="width:100%;">
                    <thead style="background-color:lightgrey; border:1px solid white;">
                    <th><input type="checkbox" class="checksasa"/>Check to select</th>
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
                                    <td align="center"><input class='checksas' id="chees<?php echo $i; ?>" type="checkbox" value="<?php echo $datas['ID']; ?>" name="chees[]"/></td>
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
                            ?> <tr><td><?php echo $messages;
                        } ?></td></tr><?php

                    } ?>

                    </tbody>
                </table>

                <br>

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
                    // $i=0;
                    // foreach($_POST['checks'] as $cheaks){ echo $a=$a+1;;//print_r($chek);
                    // echo "SELECT NAAM,id_eigenaar,id_fokker,user FROM mSVsD_stamboom where id_eigenaar='$chek'"; //exit;
                    // echo "select firstname,lastname from mSVsD_eigenaar  where ID = '$cheaks'";
                    $sqlquername = $GLOBALS['xoopsDB']->queryF('SELECT DISTINCT tempdata.id_eig ,  tempdatass.ins FROM ' . $xoopsDB->prefix('tempdata') . ' 
			 RIGHT JOIN ' . $xoopsDB->prefix('tempdatass') . ' ON tempdata.id_eig = tempdatass.ins');
                    $cnt         = $GLOBALS['xoopsDB']->getRowsNum($sqlquername);
                    if ($cnt != 0) {
                        ?>
                        <?php $b = 0;
                        $even    = '';
                        while ($datasuserress = $GLOBALS['xoopsDB']->fetchBoth($sqlquername)) {
                            if ($b % 2 == 0) {
                                $even = 'even';
                            } else {
                                $even = 'odd';
                            }
                            // echo 'bc'.$datauserress[id_eig].'asd';
                            if ($datasuserress[id_eig] == '') { //echo $datauserress['ID'].','.$cheaks;
                                //$_POST['checks']=array_diff($_POST['checks'],$datauserress['ID']);
                                //print_r($_POST['checks']);
                                $sqql = $GLOBALS['xoopsDB']->queryF('select * from  ' . $xoopsDB->prefix('eigenaar') . "  where ID='$datasuserress[ins]'");
                                while ($datauserress = $GLOBALS['xoopsDB']->fetchBoth($sqql)) {
                                    ?>

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
                                    <?php ++$b;
                                }
                            }
                        }
                    } else {
                        ?>
                        <tr>
                        <td><?php echo 'no records'; ?></td></tr><?php

                    } ?>
                    <tr class="even">
                        <td style="background-color:white;"><input type="submit" name="submtresults" value="Update joeys with selected breeder"/></td>
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
            $fnlname = $GLOBALS['xoopsDB']->queryF('SELECT *  FROM ' . $xoopsDB->prefix('tempdatass'));

            $i    = 0;
            $even = '';
            while ($datad = $GLOBALS['xoopsDB']->fetchBoth($fnlname)) {
                if ($i % 2 == 0) {
                    $even = 'even';
                } else {
                    $even = 'odd';
                }
                $datae = $GLOBALS['xoopsDB']->queryF('select *  from  ' . $xoopsDB->prefix('eigenaar') . "  where ID='$datad[ins]'");
                $data  = $GLOBALS['xoopsDB']->fetchBoth($datae);
                $queer = $GLOBALS['xoopsDB']->queryF('select count(*) as counts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar='$data[ID]'");
                $cntu  = $GLOBALS['xoopsDB']->fetchBoth($queer);
                if ($cntu[counts] == 0) {
                    ?>

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
                            <!-- <a onclick="javascript:deletebred();"><img alt="Delete" src="../images/delete.gif"></a>-->
                            <a id="<?php echo $data[ID]; ?>" onclick="show_confirm(<?php echo $data[ID]; ?>);"><img alt="Delete" src="../images/delete.gif"></a>
                        </td>
                    </tr>

                    <?php ++$i;
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
                document.location = url + '?del=' + selidval;

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
            document.location = 'http://thepetglider.com/pedigree/modules/animal/o_b_update/script.php?a=' + selidval;

        }

        $(document).ready(function () {
            $(".checkd").click(function () {
                var tex = $('.sele').text();
                if (tex === 'Select All') {
                    $('.sele').text('Deselect All');
                } else {
                    $('.sele').text('Select All');
                }
                $(".checkss").prop("checked", $(".checkd").prop("checked"))
            })
        });

        $(document).ready(function () {
            $(".checkedd").click(function () {
                var tex = $('.sele').text();
                if (tex === 'Select All') {
                    $('.sele').text('Deselect All');
                } else {
                    $('.sele').text('Select All');
                }
                $(".checkess").prop("checked", $(".checkedd").prop("checked"))
            })
        });

        $(document).ready(function () {
            $(".checkdd").click(function () {
                var tex = $('.seleectd').text();
                if (tex === 'Select All') {
                    $('.seleectd').text('Deselect All');
                } else {
                    $('.seleectd').text('Select All');
                }
                $(".checkss").prop("checked", $(".checkdd").prop("checked"))
            })
        });
        $(document).ready(function () {
            $(".checksasa").click(function () {
                var texs = $('#selec').text();
                if (texs === 'Select All') {
                    $('#selec').text('Deselect All');
                } else {
                    $('#selec').text('Select All');
                }
                $(".checksas").prop("checked", $(".checksasa").prop("checked"))
            })
        });
    </script>

    <fieldset id="checkArray">
        <legend>Breeder/Owner with empty joeys</legend>
        <form id="testtablse" method="post" action="">
            <table id="tabssatyle" style="width:100%;">
                <thead style="background-color:lightgrey; border:1px solid white;">

                <th>Breeder/Owner ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Created User</th>
                <th>User Email</th>
                </thead>
                <tbody id="tabsssatyle" style="background-color:lightblue; border:1px solid white;">
                <?php
                //$trunk=$GLOBALS['xoopsDB']->queryF("TRUNCATE TABLE `tempdatass`");
                $fnlsnamed = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where firstname like '$_REQUEST[a]%' order by ID");
                $contds    = $GLOBALS['xoopsDB']->getRowsNum($fnlsnamed);
                if ($contds != 0) {
                    $i = 0;
                    while ($ddata = $GLOBALS['xoopsDB']->fetchBoth($fnlsnamed)) {
                        $bcnt    = '';
                        $bredder = '';
                        //echo "select count(*) as bcnt from mSVsD_stamboom where id_fokker=$ddata[ID]";
                        //echo "select count(*) as bcnt from mSVsD_stamboom where id_eigenaar=$ddata[ID] and id_fokker=$ddata[ID]";
                        $bredder = $GLOBALS['xoopsDB']->queryF('select count(*) as bcnt from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$ddata[ID] or id_fokker=$ddata[ID]");
                        $bcnt    = $GLOBALS['xoopsDB']->fetchBoth($bredder);
                        if ($bcnt[bcnt] == 0) {
                            if ($i % 2 == 0) {
                                $even = 'even';
                            } else {
                                $even = 'odd';
                            }
                            $arr[] = $ddata['ID']; ?>
                            <input type="hidden" name="a" value="<?php echo $_REQUEST['a']; ?>"/>
                        <tr class="<?php echo $even; ?>">

                            <td align="center"><?php echo $ddata['ID']; ?></td>
                            <td align="center"><?php echo $ddata['firstname']; ?></td>
                            <td align="center"><?php echo $ddata['lastname']; ?></td>
                            <td align="center"><?php echo $ddata['emailadres']; ?></td>
                            <input type="hidden" name="values" value="<?php echo $ddata['lastname'] . ',' . $ddata['firstname']; ?>"/>
                            <input type="hidden" name="idvalues" value="<?php echo $ddata['ID']; ?>"/>
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$ddata[user]'";
                            //echo "INSERT INTO " . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$ddata[ID].')";
                            $inss   = $GLOBALS['xoopsDB']->queryF('INSERT INTO ' . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$ddata[ID].')");
                            $usname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$ddata[user]'");
                            $udata  = $GLOBALS['xoopsDB']->fetchBoth($usname); ?>
                            <td align="center"><?php echo $udata['uname']; ?></td>
                            <td align="center"><?php echo $udata['email']; ?></td>

                            <?php
                            if ($ddata[lastname] != '') {
                                //echo "SELECT * FROM `mSVsD_eigenaar` where lastname ='$ddata[lastname]'";
                                $fnlssname = '';
                                $connts    = '';
                                $fnlssname = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where lastname ='$ddata[lastname]' order by ID");
                                $connts    = $GLOBALS['xoopsDB']->getRowsNum($fnlssname);
                                if ($connts != 0) {
                                    $fnlssnamedata = '';
                                    while ($fnlssnamedata = $GLOBALS['xoopsDB']->fetchBoth($fnlssname)) {
                                        $bredders = $GLOBALS['xoopsDB']->queryF('select count(*) as bcnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$fnlssnamedata[ID] or id_fokker=$fnlssnamedata[ID]");
                                        $bcnts    = $GLOBALS['xoopsDB']->fetchBoth($bredders);
                                        if ($bcnts[bcnts] == 0) {
                                            if ($fnlssnamedata[ID] != $ddata['ID'] && $ddata[firstname] != $fnlssnamedata[firstname]) {
                                                $arr[] = $fnlssnamedata[ID]; ?>
                                                </tr>
                                            <tr class="<?php echo $even; ?>">

                                                <td align="center"><?php echo $fnlssnamedata['ID']; ?></td>
                                                <td align="center"><?php echo $fnlssnamedata['firstname']; ?></td>
                                                <td align="center"><?php echo $fnlssnamedata['lastname']; ?></td>
                                                <td align="center"><?php echo $fnlssnamedata['emailadres']; ?></td>
                                                <input type="hidden" name="values" value="<?php echo $fnlssnamedata['lastname'] . ',' . $fnlssnamedata['firstname']; ?>"/>
                                                <input type="hidden" name="idvalues" value="<?php echo $fnlssnamedata['ID']; ?>"/>
                                                <?php
                                                //$inass=$GLOBALS['xoopsDB']->queryF("INSERT INTO " . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$fnlssnamedata[ID].')");
                                                //echo "select uname,email from mSVsD_users where uid='$ddata[user]'";
                                                $ussaname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$fnlssnamedata[user]'");
                                                $udsaata  = $GLOBALS['xoopsDB']->fetchBoth($ussaname); ?>
                                                <td align="center"><?php echo $udsaata['uname']; ?></td>
                                                <td align="center"><?php echo $udsaata['email']; ?></td>
                                                </tr><?php

                                            } ?>
                                            </tr>
                                            <?php ++$i;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } //else {
                $lsname = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where lastname like '$_REQUEST[a]%'");
                $concts = $GLOBALS['xoopsDB']->getRowsNum($lsname);
                if ($concts != 0) {
                    $i = 0;
                    while ($daaata = $GLOBALS['xoopsDB']->fetchBoth($lsname)) {
                        $lbredders = $GLOBALS['xoopsDB']->queryF('select count(*) as blcnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$daaata[ID] or  id_fokker=$daaata[ID]");
                        $lbcnts    = $GLOBALS['xoopsDB']->fetchBoth($lbredders);
                        if ($lbcnts[blcnts] == 0) {
                            if ($i % 2 == 0) {
                                $even = 'even';
                            } else {
                                $even = 'odd';
                            } ?>
                            <br><input type="hidden" name="a" value="<?php echo $_REQUEST['a']; ?>"/>
                        <tr class="<?php echo $even; ?>">

                            <td align="center"><?php echo $daaata['ID']; ?></td>
                            <td align="center"><?php echo $daaata['firstname']; ?></td>
                            <td align="center"><?php echo $daaata['lastname']; ?></td>
                            <td align="center"><?php echo $daaata['emailadres']; ?></td>
                            <input type="hidden" name="values" value="<?php echo $daaata['lastname'] . ',' . $daaata['firstname']; ?>"/>
                            <input type="hidden" name="idvalues" value="<?php echo $daaata['ID']; ?>"/>
                            <?php
                            //echo "select uname,email from mSVsD_users where uid='$ddata[user]'";
                            $usaaname = '';
                            $udaata   = '';
                            $usaaname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$ddata[user]'");
                            $udaata   = $GLOBALS['xoopsDB']->fetchBoth($usaaname); ?>
                            <td align="center"><?php echo $udaata['uname']; ?></td>
                            <td align="center"><?php echo $udaata['email']; ?></td>

                            <?php
                            //$insds=$GLOBALS['xoopsDB']->queryF("INSERT INTO " . $xoopsDB->prefix('tempdatass') . " (ins) VALUES ('.$daaata[ID].')");
                            if ($daaata[firstname] != '') {
                                //echo "SELECT * FROM `mSVsD_eigenaar` where firstname ='$ddata[firstname]'";
                                $fnlssname       = '';
                                $fnlsssnameddata = '';
                                $fnlssname       = $GLOBALS['xoopsDB']->queryF("SELECT * FROM `mSVsD_eigenaar` where firstname ='$daaata[firstname]' ");
                                $connts          = $GLOBALS['xoopsDB']->getRowsNum($fnlssname);
                                if ($connts != 0) {
                                    while ($fnlsssnameddata = $GLOBALS['xoopsDB']->fetchBoth($fnlssname)) {
                                        $lnbredders = $GLOBALS['xoopsDB']->queryF('select count(*) as blncnts from ' . $xoopsDB->prefix('stamboom') . " where id_eigenaar=$fnlsssnamedata[ID] or  id_fokker=$fnlsssnamedata[ID]");
                                        $lnbcnts    = $GLOBALS['xoopsDB']->fetchBoth($lnbredders);
                                        if ($lnbcnts[blncnts] == 0) {
                                            if ($fnlsssnameddata[ID] != $daaata['ID'] && $daaata[firstname] != $fnlsssnameddata[firstname]) {
                                                $arr[] = $fnlsssnameddata[ID]; ?>
                                                </tr>

                                                <?php

                                            } ?>

                                            <?php ++$i;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } //}?>
                <input type="hidden" name="arrs" value="<?php echo $arr; ?>"/>
                <tr class="even">
                    <td><input type="submit" name="submts" value="select gliders"/></td>
                </tr>
                </tbody>
    </fieldset>


    <fieldset>
        <form action="http://thepetglider.com/pedigree/modules/animal/o_b_update/mainpage.php" method="post">

            <table>
                <tr>
                    <td><input type="submit" name="sum" value="Go Back"/></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
<div id="popup_box">    <!-- OUR PopupBox DIV-->
    <h3>Joeys Associated with Breeders</h3>
    <div id="id_own"></div>
    <div><a style="color: #6FA5E2; font-size: 20px; font-weight: 500; line-height: 15px;
    position: static;  right: 5px;" onclick="oked();">Delete</a></div>
    <input type="hidden" name="selid" id="selid" value=""/>
    <a id="popupBoxClose">Close</a>
</div>


