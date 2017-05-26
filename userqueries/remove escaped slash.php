<?php

$form        = 'The following animals have been found in your database with a slah. Any escape characters have been removed.<hr>';
$queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM LIKE '%\'%'";
$result      = $GLOBALS['xoopsDB']->query($queryString);
while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    $form .= '<a href="pedigree.php?pedid=' . $row['ID'] . '">' . $row['NAAM'] . '</a><br>';
    $sql  = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' SET NAAM = "' . stripslashes($row['NAAM']) . "\" WHERE ID = '" . $row['ID'] . "'";
    $GLOBALS['xoopsDB']->queryF($sql);
}
