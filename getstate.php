<?php //echo "here";

use Xmf\Request;

//require_once __DIR__ . '/../../mainfile.php';
//print_r($_POST);
$fid = Request::getInt('fid', 0, 'POST');
//$fid=ad;
//echo "SELECT ID, lastname, firstname from mSVsD_eigenaar where firstname like '%$fid%' or lastname like '%$fid%' ORDER BY  lastname,firstname  asc";

//  $queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT ID, lastname, firstname from mSVsD_eigenaar  where firstname like '%a%' or lastname like '%a%' ORDER BY  lastname,firstname  asc");
$queryfoks = $GLOBALS['xoopsDB']->queryF('SELECT ID, lastname, firstname from ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " where firstname like '$fid%' or lastname like '$fid%' ORDER BY  lastname,firstname  asc");

//	while($resfoks = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)){ print_r($resfoks);

//echo "sdaf";
//}exit;
?>
State:
<select name="state_select" id="state" style="width:250px;">
    <option value="">Please Select</option>
    <?php
    while ($row = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)) {
        $id   = $row['ID'];
        $name = $row['lastname'] . ',' . $row['firstname'];
        echo '<option value="' . $id . '">' . $name . '</option>';
    } ?>
</select>
   
