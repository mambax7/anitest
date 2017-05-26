<?php

use Xmf\Request;

?>
<script type="text/javascript">
    $("#id_eigenaar").click(function () {
        //alert('sdfv');
        var value = $("#id_eigenaar option:selected").text();

        $("#ownerfilter").val(value);
        $("#id_eigenaar").hide('fast');
    });
</script>
<?php //echo "here";

require_once __DIR__ . '/../../mainfile.php';

//use Xmf\Request;

//require_once __DIR__ . '/../../mainfile.php';
//print_r($_POST);
$fid = Request::getString('fid', '', 'POST');
session_start();
//print_r($_SESSION);
$userid = $_SESSION['xoopsUserId'];
//$fid=ad;
//echo "SELECT ID, lastname, firstname from mSVsD_eigenaar where firstname like '%$fid%' or lastname like '%$fid%' ORDER BY  lastname,firstname  asc";

//  $queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT ID, lastname, firstname from mSVsD_eigenaar  where firstname like '%a%' or lastname like '%a%' ORDER BY  lastname,firstname  asc");
$queryfoks = $GLOBALS['xoopsDB']->queryF('SELECT ID, lastname, firstname from ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " where firstname like '$fid%' or lastname like '$fid%' ORDER BY  lastname,firstname  asc limit 0,20");

//	while($resfoks = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)){ print_r($resfoks);

//echo "sdaf";
//}exit;
?>

<select name="id_eigenaar" id="id_eigenaar" style="width:250px;">

    <?php

    error_reporting(0);
    $GLOBALS['xoopsLogger']->activated = false;

    while ($row = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)) {
        $id            = $row['ID'];
        $sqleigeraar   = 'SELECT user FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " where `ID`='$id'";
        $eigegaarsql   = $GLOBALS['xoopsDB']->queryF($sqleigeraar);
        $eigegaarfetch = $GLOBALS['xoopsDB']->fetchBoth($eigegaarsql);

        //while($eigegaarfetch=$GLOBALS['xoopsDB']->fetchArray($eigegaarsql)){
        // print_r($eigegaarfetch);

        //}
        if ($eigegaarfetch['user'] == $userid) {
            $eigeraarcount = 'SELECT count(*) as counts FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where id_fokker='$id'";
            $sqlcount      = $GLOBALS['xoopsDB']->queryF($eigeraarcount);
            $countfetch    = $GLOBALS['xoopsDB']->fetchBoth($sqlcount);
            if ($countfetch[counts] == 1) {
                $bredname = $row['lastname'] . ',' . $row['firstname'] . ' [' . $countfetch[counts] . ' Glider ]';
            } else {
                $bredname = $row['lastname'] . ',' . $row['firstname'] . ' [' . $countfetch[counts] . ' Gliders ]';
            }
        } else {
            $bredname = $row['lastname'] . ',' . $row['firstname'];
        }

        $name = $bredname;
        echo '<option value="' . $id . '">' . $name . '</option>';
    } ?>
</select>
   
