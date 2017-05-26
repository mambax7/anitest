<?php
//session_start(); //echo $_SESSION['username']; //exit;

mysql_connect('ca-mysql1.hspheredns.com', 'thepetg_pedigree', 'chloe');
mysqli_select_db($GLOBALS['xoopsDB']->conn, 'thepetg_pedigree');

echo $_REQUEST['a'];
//echo "select firstname,lastname from mSVsD_eigenaar  where ID = '".$_REQUEST['a']."'";
$fnlname    = $GLOBALS['xoopsDB']->queryF('SELECT firstname,lastname FROM ' . $xoopsDB->prefix('eigenaar') . "  WHERE ID = '" . $_REQUEST['a'] . "'");
$fnlnameres = $GLOBALS['xoopsDB']->fetchBoth($fnlname);
//echo "<pre>";print_r($fnlnameres);
$getres = $GLOBALS['xoopsDB']->queryF('select ID,firstname,lastname,emailadres,user from ' . $xoopsDB->prefix('eigenaar') . "  where firstname= '$fnlnameres[firstname]' and lastname ='$fnlnameres[lastname]' ORDER BY  lastname,firstname  asc");
//$getress=$GLOBALS['xoopsDB']->fetchBoth($getres); print_r($getress);
?>
<div>
    <fieldset id="checkArray">
        <legend>Select one or more to display joeys</legend>
        <table id="tabstyle">
            <thead style="background-color:lightgrey; border:1px solid white;">
            <th>Check to select</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Created User</th>
            <th>User Email</th>
            </thead>
            <tbody style="background-color:lightblue; border:1px solid white;">
            <?php $i = 1;
            while ($data = $GLOBALS['xoopsDB']->fetchBoth($getres)) {
                ?>

                <tr>
                    <td align="center"><input id="checked.<?php echo $i; ?>" type="checkbox" value="<?php echo $data['ID']; ?>" onclick="selected('<?php echo $data['ID']; ?>');" name="checks[]"/></td>
                    <td align="center"><?php echo $data['firstname']; ?></td>
                    <td align="center"><?php echo $data['lastname']; ?></td>
                    <td align="center"><?php echo $data['emailadres']; ?></td>
                    <?php
                    //echo "select uname,email from mSVsD_users where uid='$data[user]'";
                    $usname = $GLOBALS['xoopsDB']->queryF('select uname,email FROM ' . $xoopsDB->prefix('users') . " WHERE uid='$data[user]'");
                    $udata  = $GLOBALS['xoopsDB']->fetchBoth($usname); ?>
                    <td align="center"><?php echo $udata['uname']; ?></td>
                    <td align="center"><?php echo $udata['email']; ?></td>
                </tr>
                <?php ++$i;
            } ?>
            <tr>
                <td><input type="submit" name="submts" value="select gliders"/></td>
            </tr>
            </tbody>
        </table>
    </fieldset>
</div>
