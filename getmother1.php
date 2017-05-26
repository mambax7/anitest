<!--<script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('.mother tr').mouseover(function () {
            $('.mother tr').css('cursor', 'pointer');

        });

        $('#moeder tr').click(function (event) {
            var dat = $(this).attr('class'); //trying to alert id of the clicked row
//alert(dat);					
            var iddat = $(this).attr('id'); //trying to alert id of the clicked row
            $('#motherid').val(iddat);
            $('#livefilter1').val(dat);

            $('#moeder').hide('fast');
            $.ajax({
                type: "POST",
                url: "getmotherdetails.php",
                data: "mid=" + iddat,
                success: function (response) {
                    $("#motherdetails").replaceWith(response);

                    $("#motherdetails").css("display", "block");
                    $("#motherdetails").css("width", "700px");

                }
            });


        });
    });
</script>
<style type="text/css">
    tr:hover {
        background-color: lightblue;
    }

</style>
<?php //echo "here";

use Xmf\Request;

require_once __DIR__ . '/../../mainfile.php';
//print_r($_POST);
$mid = Request::getInt('mid', 0, 'POST');
//$fid=ad;
//echo "SELECT ID, lastname, firstname from mSVsD_eigenaar where firstname like '%$fid%' or lastname like '%$fid%' ORDER BY  lastname,firstname  asc";

//  $queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT ID, lastname, firstname from mSVsD_eigenaar  where firstname like '%a%' or lastname like '%a%' ORDER BY  lastname,firstname  asc");
// /// $queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT ID,NAAM from mSVsD_stamboom where NAAM like '$fid%' and roft='0'");

//	while($resfoks = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)){ print_r($resfoks);
$queryfoks = $GLOBALS['xoopsDB']->queryF('SELECT stamboom.ID,NAAM,user2,user4,roft,value,id_fokker,uname,lastname,firstname 
FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' stamboom 
LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('users') . ' users ON stamboom.user=users.uid 
LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' eigenaar ON stamboom.id_eigenaar=eigenaar.ID
LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup3') . " stamboom_lookup3 ON stamboom.user3=stamboom_lookup3.order
where stamboom.NAAM 
like '%$mid%' and roft='1' limit 0,50");

//while($resfoks = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)){
//print_r($resfoks);

//echo "sdaf";
//}exit;

// $row1 = $GLOBALS['xoopsDB']->fetchBoth($queryfoks1);
// $idf=$row1['id_fokker'];
// $queryfoks2 = $GLOBALS['xoopsDB']->queryF("SELECT lastname,firstname FROM mSVsD_eigenaar where ID='$idf'");
// $row2 = $GLOBALS['xoopsDB']->fetchBoth($queryfoks2);

//echo "sdaf";
//}exit;
$cnt = $GLOBALS['xoopsDB']->getRowsNum($queryfoks);

?>
<div id="moeder">
    <table name="mother" class="mother">
        <h4>Displaying the first "<?php echo $cnt; ?>" matches for your search string "<?php echo ucfirst($mid); ?>"</h4>
        <tr>
            <th>Glider Name</th>
            <th>OOP Date</th>
            <th>Color</th>
            <th>Genetics</th>
            <th>Owner</th>
            <th>Breeder</th>
            <th>Added By</th>
        </tr>
        <?php

        while ($row = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)) {
            $idm        = $row['id_fokker'];
            $queryfoks1 = $GLOBALS['xoopsDB']->queryF('SELECT lastname,firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " where ID='$idm'");
            $row1       = $GLOBALS['xoopsDB']->fetchBoth($queryfoks1);
            $id         = $row['ID'];
            $name       = $row['NAAM']; ?>
            <tr class="<?php echo $name; ?>" id="<?php echo $id; ?>">
                <td><?php echo $name; ?></td>
                <td><?php echo $row['user2']; ?></td>
                <td><?php echo $row['value']; ?></td>
                <td><?php echo $row['user4']; ?></td>
                <td><?php echo $row['lastname'] . ',' . $row['firstname']; ?></td>
                <td><?php echo $row1['lastname'] . ',' . $row1['firstname']; ?></td>
                <td><?php echo $row['uname']; ?></td>
            </tr>
            <?php

        } ?>
    </table>
</div>
