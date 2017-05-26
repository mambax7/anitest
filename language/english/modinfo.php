<?php
// English strings for displaying information about this module in the site administration web pages

// The name of this module. Prefix (_MI_) is for Module Information
define('_MI_PEDIGREE_NAME', 'pedigree');
define('_MI_PEDIGREE_TITLE', 'pedigree TITLE');

// The description of this module
define('_MI_PEDIGREE_DESC', 'Pedigree module to administrate pet pedigrees');

// Names of blocks in this module. Note that not all modules have blocks
define('_MI_PEDIGREE_BLOCK_ONE_TITLE', 'pedigree: Sample Block');
define('_MI_PEDIGREE_BLOCK_ONE_DESC', 'A simple, working block example.');
define('_MI_PEDIGREE_BLOCK_TWO_TITLE', 'pedigree: Database Block');
define('_MI_PEDIGREE_BLOCK_TWO_DESC', 'A simple, working block example that queries a database.');
define('_MI_PEDIGREE_BLOCK_MENU_TITLE', 'Pedigree database menu');
define('_MI_PEDIGREE_BLOCK_MENU_DESC', 'Pedigree menu block');
define('_MI_PEDIGREE_BLOCK_RAND_TITLE', 'Dobermann Pedigree');
define('_MI_PEDIGREE_BLOCK_RAND_DESC', 'Random Pedigree block');

// Names of the menu items displayed for this module in the site administration web pages
define('_MI_OWNERBREEDER', 'Use owner/breeder fields');
define('_MI_PROVERSION', 'Pro-version');
define('_MI_BROTHERS', 'Show brothers & sisters ?');
define('_MI_PUPS', 'Show the pups/children field ?');
define('_MI_WELCOME', 'Welcome/intro text');
define('_MI_MOTHER', 'mother language option');
define('_MI_FATHER', 'father language option');
define('_MI_MALE', 'male language option');
define('_MI_FEMALE', 'female language option');
define('_MI_LITTER', 'litter language option');
define('_MI_USELITTER', 'Should the add a litter feature be used ?');
define('_MI_SHOWELCOME', 'Show th welcome screen ?');
define('_MI_PEDIGREE_MENU_OVER', 'Display overview ?');
define('_MI_PEDIGREE_MENU_OVER_DESC', 'This option is used to display the Selected Dog, Parents, Grandparents and Great-grandparents below the pedigree.');
define('_MI_PEDIGREE_MENU_PICS', 'Display pictures in pedigree ?');
define('_MI_PEDIGREE_MENU_PICS_DESC', 'Use this option to toggle the display of pictures within the pedigree.');
define('_MI_PEDIGREE_MENU_GEND', 'Display gender information in pedigree ?');
define('_MI_PEDIGREE_MENU_GEND_DESC', 'Use this option to toggle the display of gender information within the pedigree.');
define('_MI_PEDIGREE_MENU_ADIN', 'Display additional information in pedigree ?');
define('_MI_PEDIGREE_MENU_ADIN_DESC', 'Use this option to toggle the display of additional information within the pedigree.<br><i>Pedigreenumber, date of birth, colour etc.</i><br/>Only for selected dog not for the entire pedigree.');
define('_MI_PEDIGREE_MENU_PERP', 'Select number of results per page');
define('_MI_PEDIGREE_MENU_PERP_DESC', 'Here you can select the number of results shown per page for queries.');
define('_MI_PEDIGREE_MENU_HD', 'Display HD-information in pedigree ?');
define('_MI_ANIMALTYPE', "Enter the type of animal you will be creating pedigree's for");
define('_MI_ANIMALTYPE_DESC', 'The value should fit in the sentences below.<br><i>Please add optional information for this <b>dog</b>.</i><br/><i>Select the first letter of the <b>dog</b>.</i>');
define('_MI_ANIMALTYPES', "Enter the type of animal you will be creating pedigree's for");
define('_MI_ANIMALTYPES_DESC', 'The value should fit in the sentences below.<br><i>No <b>dogs</b> meeting your query have been found.</i><br><i> Here you can search for specific <b>dogs</b> by entering a year.</i>');
define('_MI_LASTIMAGE', 'Show the image in the lastrow of the pedigree');
define('_MI_LASTIMAGE_DESC', 'Here you can set if the image will be visible in the last row of the pedigree or not');
define('_MI_PEDCOLOURS', 'Pedigree colour information');
define('_MI_PEDCOLOURS_DESC', 'The value represents how the pedigree will look.<br>Use <a href="../animal/admin/colors.php">this wizard</a> to set the colour information.');

//menu items
define('_PED_WEL', 'Welkom');
define('_PED_VSD', 'View/Search dogs');
define('_PED_VOB', 'View owners/breeders');
define('_PED_LA', 'Latest additions');
define('_PED_AOB', 'Add an owner/breeder');
define('_PED_AD', 'Add a dog');
define('_PED_M50', 'Members top-50');
define('_PED_AIO', 'Advanced info & orphans');
define('_PED_VM', 'Virtual mating');
define('_PED_AL', 'Add a litter');

//notication items
define('_DOG_DATA_NOTIFY', 'Changes');
define('_DOG_DATA_NOTIFYCAP', "Keep me informed about changes to this dog's information");
define('_DOG_DATA_NOTIFYDSC', 'Notification for changes');
define('_DOG_DATA_NOTIFYSBJ', 'A change has been made');

//notification categories
define('_MI_PED_DOG_NOTIFY', 'Individual dog');
define('_MI_PED_DOG_NOTIFY_DSC', 'description individual dog');

//1.31 Alpha 4
define('_MI_PEDIGREE_VIEW_SEARCH', 'View/Search');
define('_MI_PEDIGREE_ADD_ANIMAL', 'Add an animal');
define('_MI_PEDIGREE_ADD_LITTER', 'Add a litter');
define('_MI_PEDIGREE_VIEW_OWNERS', 'View owner/breeder');
define('_MI_PEDIGREE_ADD_OWNER', 'Add owner/breeder');
define('_MI_PEDIGREE_ADVANCED_INFO', 'Advanced info');
define('_MI_PEDIGREE_VIRTUAL_MATING', 'Virtual Mating');
define('_MI_PEDIGREE_LATEST_ADDITIONS', 'Latest additions');
define('_MI_PEDIGREE_WEBMASTER_TOOLS', 'Webmaster tools');

//Templates

define('_MI_PEDIGREE_TEMPL_INDEX', 'Pedigree Index Template');
define('_MI_PEDIGREE_TEMPL_TREE', 'Pedigree-tree Template');
define('_MI_PEDIGREE_TEMPL_RESULTS', 'Pedigree results Template');
define('_MI_PEDIGREE_TEMPL_LATEST', 'Latest Additions Template');
define('_MI_PEDIGREE_TEMPL_OWNER', 'View Owner/Breeder Template');
define('_MI_PEDIGREE_TEMPL_ANIMAL', 'View Animal details Template');
define('_MI_PEDIGREE_TEMPL_OWNER_DETAILS', 'View Owner details Template');
define('_MI_PEDIGREE_TEMPL_UPDATE', 'Update details Template');
define('_MI_PEDIGREE_TEMPL_SELECT', 'select dog Template');
define('_MI_PEDIGREE_TEMPL_COI', 'Coefficient of Inbreeding Template');
define('_MI_PEDIGREE_TEMPL_TOP50', 'Members top 50 Template');
define('_MI_PEDIGREE_TEMPL_ADVANCED_INFO', 'Advanced info Template');
define('_MI_PEDIGREE_TEMPL_ANIMAL_ADD', 'Add a dog Template');
define('_MI_PEDIGREE_TEMPL_LITTER_ADD', 'Add litter Template');
define('_MI_PEDIGREE_TEMPL_DELETE_CONFIRM', 'Deletion conformation Template');
define('_MI_PEDIGREE_TEMPL_WELCOME', 'Welcome Template');
define('_MI_PEDIGREE_TEMPL_VIRTUAL_MATING', 'Virtual Mating Template');
define('_MI_PEDIGREE_TEMPL_MEGAPEDIGREE', 'Megapedigree Template');
define('_MI_PEDIGREE_TEMPL_BOOK', 'Pedigreebook Template');
define('_MI_PEDIGREE_TEMPL_TOOLS', 'Tools Template');
define('_MI_PEDIGREE_TEMPL_PAGE_EDIT', 'Edit page Template');
define('_MI_PEDIGREE_TEMPL_TABLE_SORT', "Template for javascript table sort'");
define('_MI_PEDIGREE_TEMPL_BREADCRUMB', 'Breadcrumb');
define('_MI_PEDIGREE_TEMPL_LETTERCHOICE', 'Letter selection');
define('_MI_PEDIGREE_TEMPL_HEADER', 'Header Front Page');

define('_MI_PEDIGREE_COLOR', 'Color preferences');
define('_MI_PEDIGREE_COLOR_DESC', 'Set Color Preferences');
define('_MI_PEDIGREE_CHILDREN', 'Children language option');
define('_MI_PEDIGREE_CHILDREN_DESC', 'Children language option'); // "mother language option");

// The name of this module
//Help
define('_MI_PEDIGREE_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_PEDIGREE_HELP_HEADER', __DIR__ . '/help/helpheader.html');
define('_MI_PEDIGREE_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_PEDIGREE_OVERVIEW', 'Overview');

//define('_MI_PEDIGREE_HELP_DIR', __DIR__);

//help multi-page
define('_MI_PEDIGREE_DISCLAIMER', 'Disclaimer');
define('_MI_PEDIGREE_LICENSE', 'License');
define('_MI_PEDIGREE_SUPPORT', 'Support');
