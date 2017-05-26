<?php //echo "here";

use Xmf\Request;

mysql_connect('ca-mysql1.hspheredns.com', 'thepetg_pedigree', 'chloe');
mysqli_select_db($GLOBALS['xoopsDB']->conn, 'thepetg_pedigree');
//print_r($_POST);
$fid = Request::getInt('fid', 0, 'POST');
//$fid=ad;
//echo "SELECT ID, lastname, firstname from mSVsD_eigenaar where firstname like '%$fid%' or lastname like '%$fid%' ORDER BY  lastname,firstname  asc";

//  $queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT ID, lastname, firstname from mSVsD_eigenaar  where firstname like '%a%' or lastname like '%a%' ORDER BY  lastname,firstname  asc");
//echo "SELECT ID, NAAM, id_eigenaar from mSVsD_stamboom where id_eigenaar= '$fid' ORDER BY NAAM  asc";
$queryfoks = $GLOBALS['xoopsDB']->queryF('SELECT ID, NAAM, id_fokker from ' . $xoopsDB->prefix('stamboom') . " where id_fokker= '$fid' ORDER BY NAAM  asc");

//	while($resfoks = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)){ print_r($resfoks);

//echo "sdaf";
//}exit;
$coont = $GLOBALS['xoopsDB']->getRowsNum($queryfoks);
if ($coont != 0) {
    ?>

    <table id="tabsdsatyle">
        <thead style="background-color:lightgrey; border:1px solid white;">
        <th>Joey ID</th>
        <th>Joey name</th>
        <th>Breeder id</th>
        <th>Breeder name</th>
        </thead>
        <tbody id="tabsssatyle" style="background-color:lightblue; border:1px solid white;">
        <?php while ($row = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)) {
            ?>
            <tr>
                <td align="center"><?php echo $row['ID']; ?></td>
                <td align="center"><?php echo $row['NAAM']; ?></td>
                <td align="center"><?php echo $row['id_fokker']; ?></td>
                <?php
                $sqlown    = $GLOBALS['xoopsDB']->queryF('select firstname,lastname from ' . $xoopsDB->prefix('eigenaar') . " where ID='$row[id_fokker]'");
                $fetchdata = $GLOBALS['xoopsDB']->fetchBoth($sqlown); ?>
                <td align="center"><?php echo $fetchdata['lastname'] . ',' . $fetchdata['firstname']; ?></td>

            </tr>
            <?php

        } ?>
        </tbody>
    </table>
    <div><a style="color: #6FA5E2; font-size: 20px; font-weight: 500; line-height: 15px;
    position: absolute; right: 311px; " onclick="update();">Update Breeder</a></div>
    <?php

} else {
    ?>
    <h3>No Breeders are associated with this <?php echo $fid; ?></h3><?php

} ?>
   
