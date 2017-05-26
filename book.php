<?php
// -------------------------------------------------------------------------

require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_book.tpl';

include XOOPS_ROOT_PATH . '/header.php';

global $xoopsTpl;
global $xoopsDB;

$book = $_GET['book'];
//find flag and create intro text
$queryString = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " WHERE NAAM LIKE '%\'%'";
$result      = $GLOBALS['xoopsDB']->query($queryString);
while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    echo $row['ID'] . '-' . $row['NAAM'] . '<br>';
    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' SET NAAM = "' . stripslashes($row['NAAM']) . "\" WHERE ID = '" . $row['ID'] . "'";
    echo $sql . '<br>';
    $GLOBALS['xoopsDB']->queryF($sql);
}

//comments and footer
include XOOPS_ROOT_PATH . '/footer.php';
