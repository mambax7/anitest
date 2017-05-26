<?php

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    {@link http://xoops.org/ XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package      pedigree
 * @author       XOOPS Module Dev Team
 */

if (!isset($moduleDirName)) {
    $moduleDirName = basename(dirname(__DIR__));
}

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}
$adminObject = \Xmf\Module\Admin::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
//$pathModIcon32 = $moduleHelper->getModule()->getInfo('modicons32');

// Load language files
$moduleHelper->loadLanguage('admin');
$moduleHelper->loadLanguage('modinfo');
$moduleHelper->loadLanguage('main');

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
);

//$adminmenu[] = [
//    'title' => _MI_PEDIGREE_MENU_01,
//    'link'  => 'admin/database_table.php?op=sql',
//    'icon'  => $pathIcon32 . '/manage.png'
//];
//
//
//$adminmenu[] = [
//    'title' => _MI_PEDIGREE_MENU_02,
//    'link'  => 'admin/colors.php',
//    'icon'  => $pathIcon32 . '/manage.png'
//];

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
);

//$adminmenu[0]['link']  = 'admin/database_table.php?op=sql';
//$adminmenu[0]['title'] = 'SQL Actions';
//$adminmenu[1]['link']  = 'admin/colors.php';
//$adminmenu[1]['title'] = 'Create colours';
