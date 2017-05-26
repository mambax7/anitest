<?php //echo "here";

use Xmf\Request;

require_once __DIR__ . '/../../mainfile.php';


error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;

//print_r($_POST);
$fid = Request::getInt('fid', 0, 'POST');
//$fid=ad;
//echo "SELECT ID, lastname, firstname from mSVsD_eigenaar where firstname like '%$fid%' or lastname like '%$fid%' ORDER BY  lastname,firstname  asc";

//  $queryfoks = $GLOBALS['xoopsDB']->queryF("SELECT ID, lastname, firstname from mSVsD_eigenaar  where firstname like '%a%' or lastname like '%a%' ORDER BY  lastname,firstname  asc");
$queryfoks = $GLOBALS['xoopsDB']->queryF('SELECT NAAM,user2,user4,value,id_fokker,uname,lastname,firstname 
FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' stamboom 
LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('users') . ' users ON stamboom.user=users.uid 
LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . ' eigenaar ON stamboom.id_eigenaar=eigenaar.ID
LEFT JOIN ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup3') . " stamboom_lookup3 ON stamboom.user3=stamboom_lookup3.order
where stamboom.ID='$fid' and roft='0'");

//	while($resfoks = $GLOBALS['xoopsDB']->fetchBoth($queryfoks)){ print_r($resfoks);

//echo "sdaf";
//}exit;

$row        = $GLOBALS['xoopsDB']->fetchBoth($queryfoks);
$idf        = $row['id_fokker'];
$queryfoks1 = $GLOBALS['xoopsDB']->queryF('SELECT lastname,firstname FROM ' . $GLOBALS['xoopsDB']->prefix('eigenaar') . " where ID='$idf'");
$row1       = $GLOBALS['xoopsDB']->fetchBoth($queryfoks1);
?>

<table id='fatherdetails' border="0px" cellspacing="1px">
    <tr>
        <th>Glider Name</th>
        <th>OOP Date</th>
        <th>Color</th>
        <th>Genetics</th>
        <th>Owner</th>
        <th>Breeder</th>
        <th>Added By</th>
    </tr>
    <tr>
        <td><?php echo $row['NAAM']; ?></td>
        <td><?php echo $row['user2']; ?></td>
        <td><?php echo $row['value']; ?></td>
        <td><?php echo $row['user4']; ?></td>
        <td><?php echo $row['lastname'] . ',' . $row['firstname']; ?></td>
        <td><?php echo $row1['lastname'] . ',' . $row1['firstname']; ?></td>
        <td><?php echo $row['uname']; ?></td>
    </tr>
</table>
