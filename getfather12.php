<!--<script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var flagfath = 0;
    $(document).ready(function () {
        $('.father tr').mouseover(function () {
            $('.father tr').css('cursor', 'pointer');

        });
        $('#vader tr').click(function (event) {
            var dat = $(this).attr('class'); //trying to alert id of the clicked row
            var iddat = $(this).attr('id');  //trying to alert id of the clicked row


            // if(flagfath==0){
            $('#fatherid').val(iddat);
            // flagfath=1;
            // }else {
            // $('#fatherid').val(0);
            // flagfath=0;
            // }
            $('#fathertext').val(dat);
            $('#vader').hide('fast');
            $.ajax({
                type: "POST",
                url: "getfatherdetails.php",
                data: "fid=" + iddat,
                success: function (response) {
                    $("#fatherdetails").replaceWith(response);
                    $("#fatherdetails").css("display", "block");
                    $("#fatherdetails").css("width", "100%");

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
<?php

use Xmf\Request;

require_once __DIR__ . '/../../mainfile.php';
//print_r($_SESSION);

/*if($_SESSION){

}else{

}*/
$fid = Request::getString('fid', '', 'POST');

/*$queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT mSVsD_stamboom.ID,NAAM,user2,user4,value,id_fokker,uname,lastname,firstname FROM mSVsD_stamboom
LEFT JOIN mSVsD_users ON mSVsD_stamboom.user=mSVsD_users.uid
LEFT JOIN mSVsD_eigenaar ON mSVsD_stamboom.id_eigenaar=mSVsD_eigenaar.ID
LEFT JOIN mSVsD_stamboom_lookup3 ON mSVsD_stamboom.user3=mSVsD_stamboom_lookup3.order
where mSVsD_stamboom.NAAM
like '$fid%' and roft='0'");*/
$query = $GLOBALS['xoopsDB']->queryF('SELECT ID,NAAM,user2,user3,user4,id_eigenaar,id_fokker,user FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM LIKE '%$fid%' AND roft='0' ORDER BY NAAM ASC limit 0, 50");
//$query=$GLOBALS['xoopsDB']->queryF("SELECT ID,NAAM,user2 FROM mSVsD_stamboom WHERE NAAM LIKE '$fid%' AND roft='0' ORDER BY NAAM ASC ");
//$query = $GLOBALS['xoopsDB']->queryF("SELECT ID, NAAM,user2 from mSVsD_stamboom where NAAM LIKE '$d%' and roft='0' ORDER BY  NAAM asc limit 0, 50");
$count = $GLOBALS['xoopsDB']->getRowsNum($query);
if ($count < 50) {
    $cnt = $count;
} else {
    $cnt = 50;
}
?>
<div id="vader" style="width:500px;">
    <?php if ($cnt != 0) {
        ?>
        <h4>Displaying the first <?php echo $cnt; ?> matches for your search string "<?php echo ucfirst($fid); ?>"</h4>
        <?php

    } else {
        ?>
        <h4>No records found for your search string "<?php echo ucfirst($fid); ?>"</h4>
        <?php

    } ?>
    <?php if ($cnt != 0) {
        ?>
        <table name="father" class="father" style="overflow:scroll;">

            <tr>
                <th>Glider Name</th>
                <th>OOP Date</th>
                <th>Color</th>
                <th>Genetics</th>
                <th>Owner</th>
                <th>Breeder</th>
                <th>Added By</th>

            </tr>
            <?php while ($row = $GLOBALS['xoopsDB']->fetchBoth($query)) {
                $id   = $row['ID'];
                $name = $row['NAAM']; ?>


                <tr class="<?php echo $name; ?>" id="<?php echo $id; ?>">
                    <td><?php echo $name; ?></td>
                    <td><?php echo $row['user2']; ?></td>
                    <?php
                    $orderz     = $row['user3'];
                    $colorquery = $GLOBALS['xoopsDB']->queryF('SELECT `value` FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup3') . " where `order`='$orderz'");
                    $color1     = $GLOBALS['xoopsDB']->fetchBoth($colorquery); ?>
                    <td><?php echo $color1['value']; ?> </td>
                    <td><?php echo $row['user4']; ?></td>
                    <?php
                    $ide       = $row['id_eigenaar'];
                    $queryeig1 = $GLOBALS['xoopsDB']->queryF('SELECT lastname,firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " where ID='$ide'");
                    $row2      = $GLOBALS['xoopsDB']->fetchBoth($queryeig1); ?>
                    <td> <?php echo $row2['lastname'] . ',' . $row2['firstname']; ?></td>
                    <?php
                    $idf        = $row['id_fokker'];
                    $queryfoks1 = $GLOBALS['xoopsDB']->queryF('SELECT lastname,firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " where ID='$idf'");
                    $row1       = $GLOBALS['xoopsDB']->fetchBoth($queryfoks1); ?>
                    <td> <?php echo $row1['lastname'] . ',' . $row1['firstname']; ?></td>
                    <?php
                    $idu       = $row['user'];
                    $queryuser = $GLOBALS['xoopsDB']->queryF('SELECT uname FROM ' . $GLOBALS['xoopsDB']->prefix('users') . " WHERE uid='$idu'");
                    $user      = $GLOBALS['xoopsDB']->fetchBoth($queryuser); ?>
                    <td><?php echo $user['uname']; ?> </td>
                </tr>
                <?php

            } ?>
        </table>
        <?php

    } ?>
</div>
   
