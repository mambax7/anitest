<?php /*<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#id_fokker").click(function(){
                    //alert('sdfv');
                    var valuetext=$("#id_fokker option:selected").text();
                    var valueId=$("#id_fokker option:selected").val();
                    //alert(valueId);

                       $("#livefilter").val(valuetext);
                      $("#id_fokker").hide('fast');
                      $('#bnames').val(valuetext);
                      $('#bid').val(valueId);
                      //$('#script').submit();
                      document.location='http://pedigree.thepetglider.com/modules/animal/o_b_update/script.php?a='+valueId+'&bred='+valuetext;
                     // $("#div1").css("display","block");
                      //$("#div1").on("load", "script.php?a="+valueId);
                      });
                      $("#id_eigenaar").click(function(){
                        alert('sdfv');
                        var value=$("#id_eigenaar option:selected").text();
                        var valuesid=$("#id_eigenaar option:selected").val();

                           $("#ownerfilter").val(value);
                          $("#id_eigenaar").hide('fast');
                        document.location='http://pedigree.thepetglider.com/modules/animal/o_b_update/scripts.php?a='+valuesid+'&on='+value;

                         // $("#div1").on("load", "script.php?a="+valuesid);
                          });
});
</script> */ ?>
<?php //echo "here";

use Xmf\Request;

mysql_connect('ca-mysql1.hspheredns.com', 'thepetg_pedigree', 'chloe');
mysqli_select_db($GLOBALS['xoopsDB']->conn, 'thepetg_pedigree');
//print_r($_POST);
$fid = Request::getInt('fid', 0, 'POST');
//$fid=ad;
//echo "SELECT ID, lastname, firstname from mSVsD_eigenaar where firstname like '%$fid%' or lastname like '%$fid%' ORDER BY  lastname,firstname  asc";

//  $queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT ID, lastname, firstname from mSVsD_eigenaar  where firstname like '%a%' or lastname like '%a%' ORDER BY  lastname,firstname  asc");
$queryfoks = $GLOBALS['xoopsDB']->queryF('SELECT ID, lastname, firstname from ' . $xoopsDB->prefix('eigenaar') . " where firstname like '%$fid%' or lastname like '%$fid%' ORDER BY  lastname,firstname  asc limit 0,20");

//	while($resfoks = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)){ print_r($resfoks);

//echo "sdaf";
//}exit;
?>

<select name="state_select" id="id_fokker" style="width:250px;">

    <?php
    while ($row = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)) {
        $queryfokid = $GLOBALS['xoopsDB']->queryF('SELECT count(*) as cnts from ' . $xoopsDB->prefix('stamboom') . " where id_fokker='$row[ID]' ");
        $queyyy     = $GLOBALS['xoopsDB']->fetchBoth($queryfokid);
        if ($queyyy[cnts] != 0) {
            $id   = $row['ID'];
            $name = $row['lastname'] . ',' . $row['firstname'];
            echo '<option value="' . $id . '">' . $name . '</option>';
        }
    } ?>
</select>
   
