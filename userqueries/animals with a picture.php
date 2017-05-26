<?php

$form   = 'This is an example of a userquery.<br><br>Shown below are the animals in your database that have a picture.<br>This does not include any picture userfields you may have set up.<hr>';
$sql    = 'SELECT ID, NAAM FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE foto != ''";
$result = $GLOBALS['xoopsDB']->query($sql);
while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    $form .= '<a href="pedigree.php?pedid=' . $row['ID'] . '">' . $row['NAAM'] . '</a><br>';
}
