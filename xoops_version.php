<?php
// -------------------------------------------------------------------------
//	pedigree
//		Copyright 2004, James Cotton
// 		http://www.dobermannvereniging.nl
//	Template
//		Copyright 2004 Thomas Hill
//		<a href="http://www.worldware.com">worldware.com</a>
// -------------------------------------------------------------------------
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$moduleDirName = basename(__DIR__);

$modversion['version']       = 1.29;
$modversion['module_status'] = 'Beta 1';
$modversion['release_date']  = '2017/03/06';
$modversion['name']          = _MI_PEDIGREE_NAME;
$modversion['description']   = _MI_PEDIGREE_DESC;
$modversion['credits']       = 'James Cotton http://www.dobermannvereniging.nl';
$modversion['author']        = 'James Cotton/Ton van der Hagen';
//$modversion['help']          = 'docs/pedigree_admin.html';
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0 or later';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']    = 0;
$modversion['image']       = 'images/pedigree.png';
$modversion['dirname']     = $moduleDirName;
$modversion['min_php']     = '5.5';
$modversion['min_xoops']   = '2.5.9';
$modversion['min_admin']   = '1.2';
$modversion['min_db']      = array('mysql' => '5.5');

// SQL file - All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql (without prefix!)
$modversion['tables'][] = 'stamboom';
$modversion['tables'][] = 'stamboom_lookup3';
$modversion['tables'][] = 'stamboom_config';
$modversion['tables'][] = 'stamboom_temp';
$modversion['tables'][] = 'stamboom_trash';
$modversion['tables'][] = 'eigenaar';

$modversion['tables'][] = 'pius_stamboon';
$modversion['tables'][] = 'ob_loginfo';
$modversion['tables'][] = 'loginfo';
$modversion['tables'][] = 'tempdata';
$modversion['tables'][] = 'tempdatas';
$modversion['tables'][] = 'tempdatass';

// Admin things
$modversion['system_menu'] = 1;
$modversion['hasAdmin']    = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// ------------------- Help files ------------------- //
$modversion['helpsection'] = array(
    array('name' => _MI_PEDIGREE_OVERVIEW, 'link' => 'page=help'),
    array('name' => _MI_PEDIGREE_DISCLAIMER, 'link' => 'page=disclaimer'),
    array('name' => _MI_PEDIGREE_LICENSE, 'link' => 'page=license'),
    array('name' => _MI_PEDIGREE_SUPPORT, 'link' => 'page=support'),
);

//admin settings
$modversion['config'][0]['name']        = 'proversion';
$modversion['config'][0]['title']       = '_MI_PROVERSION';
$modversion['config'][0]['description'] = 'is this the pro version ?';
$modversion['config'][0]['formtype']    = 'yesno';
$modversion['config'][0]['valuetype']   = 'int';
$modversion['config'][0]['default']     = 0;

$modversion['config'][1]['name']        = 'ownerbreeder';
$modversion['config'][1]['title']       = '_MI_OWNERBREEDER';
$modversion['config'][1]['description'] = 'should the owner/breeder fields be used ?';
$modversion['config'][1]['formtype']    = 'yesno';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = 1;

$modversion['config'][2]['name']        = 'brothers';
$modversion['config'][2]['title']       = '_MI_BROTHERS';
$modversion['config'][2]['description'] = 'should the brothers & sisters field be shown ?';
$modversion['config'][2]['formtype']    = 'yesno';
$modversion['config'][2]['valuetype']   = 'int';
$modversion['config'][2]['default']     = 1;

$modversion['config'][3]['name']        = 'pups';
$modversion['config'][3]['title']       = '_MI_PUPS';
$modversion['config'][3]['description'] = 'should the pups/children field be shown ?';
$modversion['config'][3]['formtype']    = 'yesno';
$modversion['config'][3]['valuetype']   = 'int';
$modversion['config'][3]['default']     = 1;

$modversion['config'][4]['name']        = 'perpage';
$modversion['config'][4]['title']       = '_MI_PEDIGREE_MENU_PERP';
$modversion['config'][4]['description'] = '_MI_PEDIGREE_MENU_PERP_DESC';
$modversion['config'][4]['formtype']    = 'select';
$modversion['config'][4]['valuetype']   = 'int';
$modversion['config'][4]['default']     = 100;
$modversion['config'][4]['options']     = array('50' => 50, '100' => 100, '250' => 250, '500' => 500, '1000' => 1000);

$modversion['config'][6]['name']        = 'animalType';
$modversion['config'][6]['title']       = '_MI_ANIMALTYPE';
$modversion['config'][6]['description'] = '_MI_ANIMALTYPE_DESC';
$modversion['config'][6]['formtype']    = 'textbox';
$modversion['config'][6]['valuetype']   = 'textarea';
$modversion['config'][6]['default']     = 'dog';

$modversion['config'][7]['name']        = 'animalTypes';
$modversion['config'][7]['title']       = '_MI_ANIMALTYPES';
$modversion['config'][7]['description'] = '_MI_ANIMALTYPES_DESC';
$modversion['config'][7]['formtype']    = 'textbox';
$modversion['config'][7]['valuetype']   = 'textarea';
$modversion['config'][7]['default']     = 'dogs';

$modversion['config'][8]['name']        = 'lastimage';
$modversion['config'][8]['title']       = '_MI_LASTIMAGE';
$modversion['config'][8]['description'] = '_MI_LASTIMAGE_DESC';
$modversion['config'][8]['formtype']    = 'yesno';
$modversion['config'][8]['valuetype']   = 'int';
$modversion['config'][8]['default']     = 0;

$modversion['config'][9]['name']        = 'children';
$modversion['config'][9]['title']       = '_MI_PEDIGREE_CHILDREN';
$modversion['config'][9]['description'] = '_MI_PEDIGREE_CHILDREN_DESC';
$modversion['config'][9]['formtype']    = 'textbox';
$modversion['config'][9]['valuetype']   = 'textarea';
$modversion['config'][9]['default']     = 'children';

$modversion['config'][10]['name']        = 'welcome';
$modversion['config'][10]['title']       = '_MI_WELCOME';
$modversion['config'][10]['description'] = 'language option children';
$modversion['config'][10]['formtype']    = 'textarea';
$modversion['config'][10]['valuetype']   = 'text';
$modversion['config'][10]['default']     = ' Welcome to the online pedigree database.

This project that now has [numanimals] [animalType] pedigrees has been made to give a better picture of the [animalType] race.
By connecting these [numanimals] pedigrees together one giant pedigree is created with [animalTypes] from around the world.

Because all the information is only added once to the database it becomes very easy to find what you are looking for.

When the correct [animalType] has been found you are able to view its pedigree. This shows you the selected [animalType], the parents, the grandparents and the great-grandparents. You can click on any of these [animalTypes] to view their pedigree. This way you can "walk" through a [animalType] pedigree and go back many generations.

Becasue so many pedigrees have been merged into one big one lots of interesting data can be shown. It is possible to calculate the coefficients of Kinship, Relationship and Inbreeding of any [animalType] very accuratly. Using such tools has shown this pedigree database to be an extremly valuable resource of information used by breeders and enthousiasts.

To keep a little controle over the [animalTypes] entered into the database only registered members of the website are allowed to enter information into the database. Registration is free and will give you full access to all the elements of this website.';

$modversion['config'][11]['name']        = 'mother';
$modversion['config'][11]['title']       = '_MI_MOTHER';
$modversion['config'][11]['description'] = 'language option mother';
$modversion['config'][11]['formtype']    = 'textbox';
$modversion['config'][11]['valuetype']   = 'textarea';
$modversion['config'][11]['default']     = 'mother';

$modversion['config'][12]['name']        = 'father';
$modversion['config'][12]['title']       = '_MI_FATHER';
$modversion['config'][12]['description'] = 'language option father';
$modversion['config'][12]['formtype']    = 'textbox';
$modversion['config'][12]['valuetype']   = 'textarea';
$modversion['config'][12]['default']     = 'father';

$modversion['config'][13]['name']        = 'female';
$modversion['config'][13]['title']       = '_MI_FEMALE';
$modversion['config'][13]['description'] = 'language option female';
$modversion['config'][13]['formtype']    = 'textbox';
$modversion['config'][13]['valuetype']   = 'textarea';
$modversion['config'][13]['default']     = 'female';

$modversion['config'][14]['name']        = 'male';
$modversion['config'][14]['title']       = '_MI_MALE';
$modversion['config'][14]['description'] = 'language option male';
$modversion['config'][14]['formtype']    = 'textbox';
$modversion['config'][14]['valuetype']   = 'textarea';
$modversion['config'][14]['default']     = 'male';

$modversion['config'][15]['name']        = 'litter';
$modversion['config'][15]['title']       = '_MI_LITTER';
$modversion['config'][15]['description'] = 'language option litter';
$modversion['config'][15]['formtype']    = 'textbox';
$modversion['config'][15]['valuetype']   = 'textbox';
$modversion['config'][15]['default']     = 'litter';

$modversion['config'][16]['name']        = 'uselitter';
$modversion['config'][16]['title']       = '_MI_USELITTER';
$modversion['config'][16]['description'] = 'should the litter feature be used ?';
$modversion['config'][16]['formtype']    = 'yesno';
$modversion['config'][16]['valuetype']   = 'int';
$modversion['config'][16]['default']     = 1;

$modversion['config'][17]['name']        = 'colourscheme';
$modversion['config'][17]['title']       = '_MI_PEDIGREE_COLOR';
$modversion['config'][17]['description'] = '_MI_PEDIGREE_COLOR_DESC';
$modversion['config'][17]['formtype']    = 'textbox';
$modversion['config'][17]['valuetype']   = 'textbox';
$modversion['config'][17]['default']     = '#663300;#999966;#B2B27F;#333333;#020000;#80804D;#999999;#663300';

$modversion['config'][18]['name']        = 'showwelcome';
$modversion['config'][18]['title']       = '_MI_SHOWELCOME';
$modversion['config'][18]['description'] = 'Show the welcome screen';
$modversion['config'][18]['formtype']    = 'yesno';
$modversion['config'][18]['valuetype']   = 'int';
$modversion['config'][18]['default']     = 1;

// Menu contents
$modversion['hasMain'] = 1;

// Menu contents
$modversion['hasMain'] = 1;
$i                     = 0;
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_VIEW_SEARCH,
    'url'  => 'index.php'
);
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_ADD_ANIMAL,
    'url'  => 'add_dog.php'
);
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_ADD_LITTER,
    'url'  => 'add_litter.php'
);
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_VIEW_OWNERS,
    'url'  => 'breeder.php'
);
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_ADD_OWNER,
    'url'  => 'add_breeder.php'
);
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_ADVANCED_INFO,
    'url'  => 'advanced.php'
);
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_VIRTUAL_MATING,
    'url'  => 'virtual.php'
);
$modversion['sub'][]   = array(
    'name' => _MI_PEDIGREE_LATEST_ADDITIONS,
    'url'  => 'latest.php'
);

if (!empty($GLOBALS['xoopsUser']) && ($GLOBALS['xoopsUser'] instanceof XoopsUser) && $GLOBALS['xoopsUser']->isAdmin()) {
    $modversion['sub'][] = array(
        'name' => _MI_PEDIGREE_WEBMASTER_TOOLS,
        'url'  => 'tools.php?op=index'
    );
}

// Templates
$modversion['templates'] = array(
    array(
        'file'        => 'pedigree_index.tpl',
        'description' => _MI_PEDIGREE_TEMPL_INDEX
    ),

    array(
        'file'        => 'pedigree_header.tpl',
        'description' => _MI_PEDIGREE_TEMPL_HEADER
    ),

    array(
        'file'        => 'pedigree_pedigree.tpl',
        'description' => _MI_PEDIGREE_TEMPL_TREE
    ),

    array(
        'file'        => 'pedigree_result.tpl',
        'description' => _MI_PEDIGREE_TEMPL_RESULTS
    ),

    array(
        'file'        => 'pedigree_latest.tpl',
        'description' => _MI_PEDIGREE_TEMPL_LATEST
    ),

    array(
        'file'        => 'pedigree_breeder.tpl',
        'description' => _MI_PEDIGREE_TEMPL_OWNER
    ),

    array(
        'file'        => 'pedigree_dog.tpl',
        'description' => _MI_PEDIGREE_TEMPL_ANIMAL
    ),

    array(
        'file'        => 'pedigree_owner.tpl',
        'description' => _MI_PEDIGREE_TEMPL_OWNER_DETAILS
    ),

    array(
        'file'        => 'pedigree_update.tpl',
        'description' => _MI_PEDIGREE_TEMPL_UPDATE
    ),

    array(
        'file'        => 'pedigree_sel.tpl',
        'description' => _MI_PEDIGREE_TEMPL_SELECT
    ),

    array(
        'file'        => 'pedigree_coi.tpl',
        'description' => _MI_PEDIGREE_TEMPL_COI
    ),

    array(
        'file'        => 'pedigree_members.tpl',
        'description' => _MI_PEDIGREE_TEMPL_TOP50
    ),

    array(
        'file'        => 'pedigree_advanced.tpl',
        'description' => _MI_PEDIGREE_TEMPL_ADVANCED_INFO
    ),

    array(
        'file'        => 'pedigree_adddog.tpl',
        'description' => _MI_PEDIGREE_TEMPL_ANIMAL_ADD
    ),

    array(
        'file'        => 'pedigree_addlitter.tpl',
        'description' => _MI_PEDIGREE_TEMPL_LITTER_ADD
    ),

    array(
        'file'        => 'pedigree_delete.tpl',
        'description' => _MI_PEDIGREE_TEMPL_DELETE_CONFIRM
    ),

    array(
        'file'        => 'pedigree_welcome.tpl',
        'description' => _MI_PEDIGREE_TEMPL_WELCOME
    ),

    array(
        'file'        => 'pedigree_virtual.tpl',
        'description' => _MI_PEDIGREE_TEMPL_VIRTUAL_MATING
    ),

    array(
        'file'        => 'pedigree_mpedigree.tpl',
        'description' => _MI_PEDIGREE_TEMPL_MEGAPEDIGREE
    ),

    array(
        'file'        => 'pedigree_book.tpl',
        'description' => _MI_PEDIGREE_TEMPL_BOOK
    ),

    array(
        'file'        => 'pedigree_tools.tpl',
        'description' => _MI_PEDIGREE_TEMPL_TOOLS
    ),

    array(
        'file'        => 'pedigree_edit.tpl',
        'description' => _MI_PEDIGREE_TEMPL_PAGE_EDIT
    ),

    array(
        'file'        => 'table_sort.tpl',
        'description' => _MI_PEDIGREE_TEMPL_TABLE_SORT
    ),

    array(
        'file'        => 'pedigree_common_breadcrumb.tpl',
        'description' => _MI_PEDIGREE_TEMPL_BREADCRUMB
    ),
    array(
        'file'        => 'pedigree_common_letterschoice.tpl',
        'description' => _MI_PEDIGREE_TEMPL_LETTERCHOICE
    )
);

// Blocks (Start indexes with 1, not 0!)

//this block shows the random pedigrees
$modversion['blocks'][1]['file']        = 'menu_block.php';
$modversion['blocks'][1]['name']        = _MI_PEDIGREE_BLOCK_MENU_TITLE;
$modversion['blocks'][1]['description'] = _MI_PEDIGREE_BLOCK_MENU_DESC;
$modversion['blocks'][1]['show_func']   = 'menu_block';
$modversion['blocks'][1]['template']    = 'pedigree_menu.tpl';

// Search function
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'pedigree_search';

//comments function
$modversion['hasComments']          = 1;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'dog.php';

//notifications function
$modversion['hasNotification']             = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'lookup';

//notify of changes in the dog's data

$modversion['notification']['category'][1]['name']           = 'dog';
$modversion['notification']['category'][1]['title']          = _MI_PED_DOG_NOTIFY;
$modversion['notification']['category'][1]['description']    = _MI_PED_DOG_NOTIFY_DSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('dog.php', 'pedigree.php');
$modversion['notification']['category'][1]['item_name']      = 'id';
$modversion['notification']['category'][1]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name']          = 'change_data';
$modversion['notification']['event'][1]['category']      = 'dog';
$modversion['notification']['event'][1]['title']         = _DOG_DATA_NOTIFY;
$modversion['notification']['event'][1]['caption']       = _DOG_DATA_NOTIFYCAP;
$modversion['notification']['event'][1]['description']   = _DOG_DATA_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'dog_data_notify';
$modversion['notification']['event'][1]['mail_subject']  = _DOG_DATA_NOTIFYSBJ;
