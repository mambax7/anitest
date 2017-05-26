<?php

require_once __DIR__ . '/../../../include/cp_header.php';

if (file_exists(__DIR__ . '/../language/' . $xoopsConfig['language'] . '/modinfo.php')) {
    require_once __DIR__ . '/../language/' . $xoopsConfig['language'] . '/modinfo.php';
} else {
    require_once __DIR__ . '/../language/english/modinfo.php';
}
require_once XOOPS_ROOT_PATH . '/modules/animal/admin/menu.php';

xoops_cp_header();

global $xoopsDB;

$colourString = substr($_POST['mainbgcolor'], 1)
                . ';'
                . substr($_POST['sbgcolor'], 1)
                . ';'
                . substr($_POST['stxtcolor'], 1)
                . ';'
                . $_POST['sfont']
                . ';'
                . $_POST['sfontsize']
                . ';'
                . $_POST['sfontstyle']
                . ';'
                . substr($_POST['mbgcolor'], 1)
                . ';'
                . substr($_POST['mtxtcolor'], 1)
                . ';'
                . $_POST['mfont']
                . ';'
                . $_POST['mfontsize']
                . ';'
                . $_POST['mfontstyle']
                . ';'
                . substr($_POST['fbgcolor'], 1)
                . ';'
                . substr($_POST['ftxtcolor'], 1)
                . ';'
                . $_POST['ffont']
                . ';'
                . $_POST['ffontsize']
                . ';'
                . $_POST['ffontstyle']
                . ';'
                . $_POST['bstyle']
                . ';'
                . substr($_POST['bwidth'], 0, 1)
                . ';'
                . substr($_POST['bcolor'], 1);

$sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('config') . " SET conf_value='" . $colourString . "' WHERE conf_name = 'pedigreeColours'";
$GLOBALS['xoopsDB']->queryf($sql);
redirect_header('colors.php', 3, 'Your settings have been saved...');

xoops_cp_footer();
