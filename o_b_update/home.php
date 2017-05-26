<?php
require_once __DIR__ . '/mainfile.php';
echo $numdog = 'SELECT ID FROM ' . $xoopsDB->prefix('stamboom') . " WHERE NAAM LIKE '" . $letter . "%' AND roft = '" . $gend . "'";
$numres = $xoopsDB->query($numdog);
//total number of dogs the query will find
echo $numresults = $xoopsDB->getRowsNum($numres);
