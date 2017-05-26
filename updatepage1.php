<?php
//echo '<pre>';print_r($_POST);

require_once __DIR__ . '/../../mainfile.php';
if ($_POST['button_id'] === 'Update mother') {
    $mid       = $_POST['motherid'];
    $uis       = $_POST['dbuser'];
    $id        = $_POST['dogid'];
    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$id'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

    if ($dataquer[moeder] != $mid) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $id . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Mother','" . $dataquer['moeder'] . "','" . $mid . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $query = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET `moeder` = '$mid' WHERE `ID` ='$id'";
    $GLOBALS['xoopsDB']->queryF($query) || exit("Error in query: $query. " . $GLOBALS['xoopsDB']->error());
    header('location:dog.php?id=' . $id);
}
if ($_POST['button_id'] === 'Update father') {
    //echo '<pre>';print_r($_POST);

    $fid = $_POST['fatherid'];
    $uis = $_POST['dbuser'];
    $id  = $_POST['dogid'];

    $loginsert = '';
    $Query     = '';
    $dataquer  = '';
    $Query     = $GLOBALS['xoopsDB']->queryF('select * from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID='$id'");
    $dataquer  = $GLOBALS['xoopsDB']->fetchBoth($Query);

    if ($dataquer[vader] != $fid) {
        $loginsert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('loginfo') . "(joey_id,joey_name,trans_date,user_id,field_name,before_value,after_value,transaction_type,ip_address)
						VALUES('" . $id . "','" . $dataquer['NAAM'] . "',NOW(),'" . $_SESSION[xoopsUserId] . "','Father','" . $dataquer['vader'] . "','" . $fid . "','Update','" . $_SERVER['REMOTE_ADDR'] . "')";
        $queri     = $GLOBALS['xoopsDB']->queryF($loginsert);
    }
    $query = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " SET `vader` = '$fid' WHERE `ID` ='$id'";
    $GLOBALS['xoopsDB']->queryF($query) || exit("Error in query: $query. " . $GLOBALS['xoopsDB']->error());
    header('location:dog.php?id=' . $id);
}
