<?php

// English strings for displaying information in the templates
define('_PED_SELECT', 'Select the first letter of the [animalType] ');
define('_PED_SEARCHNAME', 'Search by name');
define('_PED_SEARCHNAME_EX',
       'Here you can search for specific [animalTypes] by entering (part of) a name.<br><br>Searching for part of a name (a few letters) will find all [animalTypes] with those letters anywhere in the name.<br>Searching for <b>a</b> will not find [animalTypes] with <b>�</b> or other special characters.');
define('_PED_SEARCH_SHORT', 'At least 3 characters are needed to perform a search.');
define('_PED_SEARCH_NO', 'No [animalTypes] meeting your query have been found.');
define('_PED_SEARCHNUMBER', 'Search by pedigree number');
define('_PED_SEARCHNUMBER_EX', 'Here you can search for specific dogs by entering (part of) a pedigree number.<br><br>When searching for for a pedigree number the software will also search through the name field to find the pedigree number.');

define('_PED_SEARCHYEAR', 'Search by year');
define('_PED_SEARCHYEAR_EX', 'Here you can search for specific [animalTypes] by entering a year.<br><br>Searching for <b>1956</b> will find all [animalTypes] born in 1956.');
define('_PED_SEARCHEX', 'Search by Extra Information');
define('_PED_SEARCHEX_EX', 'Here you can search for dogs where specific information has been entered into the Extra Information field. This is often done with dogs which have been imported.');
define('_PED_MATCHES', ' [animalTypes] match your request. Showing ');
define('_PED_MATCHESB', ' records match your request. Showing ');
define('_PED_EXPLAIN', 'Explanation');
define('_PED_PREVIOUS', 'Previous');
define('_PED_NEXT', 'Next');
define('_PED_UNKNOWN', 'Unknown');

//pedigree information
define('_PED_SD', 'Selected Dog');
define('_PED_PA', 'Parents');
define('_PED_GP', 'Grandparents');
define('_PED_GGP', 'Great-grandparents');

//search options
define('_PED_SDVINS', 'Search the DVIN website for extra information about : ');
define('_PED_VPO', 'View pedigree of : ');
define('_PED_VPO2', 'View large pedigree of : ');
define('_PED_SII', 'Search the internet for information about : ');
define('_PED_SIP', 'Search the internet for pictures of : ');

//headers
define('_PED_HD_NAME', 'Name');
define('_PED_HD_COLO', 'Colour');
define('_PED_HD_PEDI', 'Pedigreenumber');
define('_PED_HD_DATE', 'Date of Birth');

define('_PED_OWN_NAME', 'Name');
define('_PED_OWN_CITY', 'Location');

//number of dogs
define('_PED_NUMDOGS', 'Number of dogs in the database : ');

//velden
define('_PED_FLD_NAME', 'Name');
define('_PED_FLD_NAME_EX', 'Use this field to fill in the name of the [animalType]');
define('_PED_FLD_OWNE', 'Owner');
define('_PED_FLD_OWNE_EX', 'Please select the owner of the [animalType] from the above list.<br>If the owner is not in the list you may add the owner using the <a href="add_breeder.php">Add owner/breeder</a> feature.');
define('_PED_FLD_BREE', 'Breeder');
define('_PED_FLD_BREE_EX', 'Please select the breeder of the [animalType] from the above list.<br>If the breeder is not in the list you may add the breeder using the <a href="add_breeder.php">Add owner/breeder</a> feature.');
define('_PED_FLD_GEND', 'Gender');
define('_PED_FLD_GEND_EX', 'Please select the gender for this dog.');
define('_PED_FLD_PEDB', 'Pedigreebook');
define('_PED_FLD_PEDB_EX', 'Please select the pedigreebook for this dog.');
define('_PED_FLD_PEDN', 'Pedigreenumber');
define('_PED_FLD_PEDN_EX', 'Please enter the pedigreenumber for this dog.<br>Dogs are often searched for by pedigreenumber so this field is very important.');
define('_PED_FLD_COLO', 'Colour');
define('_PED_FLD_COLO_EX', 'Please select the colour for this dog.');
define('_PED_FLD_FATH', 'Father');
define('_PED_FLD_MOTH', 'Mother');
define('_PED_FLD_DOB', 'Date of birth');
define('_PED_FLD_DOB_EX', 'The date of birth has to filled in in the following format <b>jjjj-mm-dd</b><br>example : <i>2002-12-31</i>');
define('_PED_FLD_DD', 'data desceased');
define('_PED_FLD_DD_EX', 'The date desceased has to filled in in the following format <b>jjjj-mm-dd</b><br>example : <i>2002-12-31</i>');
define('_PED_FLD_PICT', 'Picture');
define('_PED_FLD_PICT_EX', 'Use this field to provide a picture of the [animalType].<br>A URL for a picture must be in the following format : <i>http://www.yourdomain.com/[animalType].jpg</i>');
define('_PED_FLD_EXTR', 'Extra information');
define('_PED_FLD_EXTR_EX', 'Use this field to provide additional information about this dog.<br>This can be show or working results or medical information.');
define('_PED_FLD_HDST', 'HD Status');
define('_PED_FLD_HDST_EX', 'If known please supply a value for the HD of this dog.<br>By marking the HD value a better picture of the breed as a whole is generated.');
define('_PED_FLD_WLST', '"von Willebrand"');
define('_PED_FLD_WLST_EX', 'Select (if known) the "von Willebrand" status');
define('_PED_FLD_WBST', 'Wobbler Syndroom (C.V.I.)');
define('_PED_FLD_WBST_EX', 'Select (if known) the Wobbler status');
define('_PED_FLD_PHST', 'PHTVL/PHPV');
define('_PED_FLD_PHST_EX', 'Select (if known) the PVTHL/PHPV status');
define('_PED_FLD_CDST', 'Cardiomyopathie');
define('_PED_FLD_CDST_EX', 'Select (if known) the Cardiomyopathie status');
define('_PED_FLD_INBR', 'Inbred percentage');
define('_PED_FLD_BAS', 'Brothers and sisters');
define('_PED_FLD_PUPS', '[children]');
define('_PED_FLD_DBUS', 'Added by');
define('_PED_FLD_CHAN', 'Changed');
define('_PED_FLD_DELE', 'Removed');

//genders
define('_PED_FLD_MALE', '[male]');
define('_PED_FLD_FEMA', '[female]');

//colours
define('_PED_BLACK', 'Black');
define('_PED_BROWN', 'Brown');
define('_PED_BLUE', 'Blue');
define('_PED_ISABEL', 'Isabel');

//hd-results
define('_PED_HD_0', 'A-1');
define('_PED_HD_1', 'A-2');
define('_PED_HD_2', 'B-1');
define('_PED_HD_3', 'B-2');
define('_PED_HD_4', 'C');
define('_PED_HD_5', 'D');
define('_PED_HD_6', 'E');
define('_PED_HD_7', '?');

//von WIllebrands
define('_PED_WILLE_0', 'unknown');
define('_PED_WILLE_1', 'clear');
define('_PED_WILLE_2', 'Carrier');
define('_PED_WILLE_3', 'Affected');

//Wobbler
define('_PED_WOBBLER_0', 'onbekend');
define('_PED_WOBBLER_1', 'X-ray tested free');
define('_PED_WOBBLER_2', 'X-ray tested not free');
define('_PED_WOBBLER_3', 'Wobbler affected');

//phtvl/phpv
define('_PED_PHTVL_0', 'unknown');
define('_PED_PHTVL_1', 'free');
define('_PED_PHTVL_2', 'I');
define('_PED_PHTVL_3', 'II');
define('_PED_PHTVL_4', 'III');
define('_PED_PHTVL_5', 'IV');
define('_PED_PHTVL_6', 'V');
define('_PED_PHTVL_7', 'VI');
define('_PED_PHTVL_8', 'doubt');

//Cardiomyopathie
define('_PED_CARDIO_0', 'unknown');
define('_PED_CARDIO_1', 'tested free');
define('_PED_CARDIO_2', 'tested not free');
define('_PED_CARDIO_3', 'Cardio victim');

//submitbutton
define('_PED_BUT_SUB', 'Submit changes');

//no permission reasons
define('_PED_REGIST', 'You need to be a registered user to make changes.');
define('_PED_NOUSER', 'Only the user who has entered the dog can change its data.');

//other
define('_PED_SEL', 'Select the ');
define('_PED_FROM', ' of ');

//coi
define('_PED_COI_WAIT', 'Click here to calculate the inbred percententage for this [animalType].<br>Due to the complexity of these calculations it can take a few minutes to load the page.');
define('_PED_COI_MORE', 'At least both parents need to be known to do an inbreeding calculation.');
define('_PED_COI_CKRI', 'Coefficients of Kinship, Relationship and Inbreeding');
define('_PED_COI_CKRI_CT',
       'This page consist of inbreeding calculations for the [animalType] you selected or the "Virtual Mating" you have entered.<br>The calculations on this page are accurate to the point that they can only be made based upon the information in the database.<br>For more detailed calculations please make sure that as many as possible of the ancestors are known in the database.<br> NOTICE: Your present COI may change when and if additional ancestry is added to the linage.<br>Each information block has an explanation button which can be clicked to find information on that specific subject. ');
define('_PED_COI_SPANF1', 'Sorry, the parents of animal ');
define('_PED_COI_SPANF2', ' are not found in the database.');
define('_PED_COI_SGPU', 'Sorry: at least one grandparent is unknown...');
define('_PED_COI_AND', ' and ');
define('_PED_COI_SDEX', 'Shown here are the parents of the [animalType] you selected for the COI% calculation or the [animalTypes] you selected for "Virtual Mating".<br>The gender of these [animalTypes] is shown here as well as the number of [children] they have in the pedigree database.');
define('_PED_COI_COMTIT', 'List of common progency of [father] and [mother]');
define('_PED_COI_COMEX', 'Shown here are the [children] of the parents of the [animalType] you requested the calculation for.<br>The gender is shown here as well as the number of [children] that this animal has in the pedigree database.');
define('_PED_COI_NO', 'no');
define('_PED_COI_OFF', ' offspring');
define('_PED_COI_HUGE', 'huge!');
define('_PED_COI_VHIG', 'very high');
define('_PED_COI_HIGH', 'high');
define('_PED_COI_MEDI', 'medium');
define('_PED_COI_LOW', 'low');
define('_PED_COI_VLOW', 'very low');
define('_PED_COI_VVLO', 'very very low');
define('_PED_COI_TLTB', 'too low to be reliable');
define('_PED_COI_TVI', 'this value is');
define('_PED_COI_ACTIT', 'Ascendents count');
define('_PED_COI_ACEX',
       'Shown here are the number of ascendents found in this specific pedigree tree.<br>A complete tree will contain up to 510 ascendants. (8 generations are used for the calculations on this page).<br>Also shown is the number of unique ascendents. These figures will give you an indication as to how varied the gene pool is for this animal.<br><br>A total count of 500 animals with only 100 unique ascendents means that out of the 500 animals found in 8 generations there are only 100 unique animals present. These 100 animals make up the tree. Obviousily 510 unique ascendents would be better for a more varied (less inbred) gene pool.');
define('_PED_COI_ASTC', 'Total count of known ascendants (over ');
define('_PED_COI_ASTCGEN', ' generations : max=');
define('_PED_COI_ASDKA', 'Count of distinct known ascendants (over ');
define('_PED_COI_ASGEN', ' generations)');
define('_PED_COI_COI', 'Coefficient of Inbreeding ');
define('_PED_COI_COITIT', 'For any animal out of [father] and [mother] :');
define('_PED_COI_COIEX',
       'If you clicked on the COI% calculation for a single [animalType] in the database the inbred percentage is shown here.<br>If you clicked on the "Virutal Mating" button the value shown here is for any [children] that these two [animalTypes] might produce.<br><table width="100%"><tr bgcolor="#EFEFEF"><td>percentage</td><td>Value</td></tr><tr><td>0% - 1%</td><td>too low to be reliable</td></tr><tr><td>1% - 2%</td><td>very very low</td></tr><tr><td>2% - 5%</td><td>very low</td></tr><tr><td>5% - 10%</td><td>low</td></tr><tr><td>10% - 20%</td><td>medium</td></tr><tr><td>20% - 35%</td><td>high</td></tr><tr><td>35% - 55%</td><td>very high</td></tr><tr><td>>55%</td><td>Huge!</td></tr></table>');
define('_PED_COI_TCATIT', 'Top contributing ascendants :');
define('_PED_COI_TCApib', 'Partial inbreeding due to ');
define('_PED_COI_TCAEX',
       "Here you'll find a list of the ascendents (parents, gandparents etc.) who contribute the most to the genetic makeup of the selected [animalType].<br>If you clicked on \"Virutal Mating\" these are the [animalTypes] who will contribute the most to any potential [children] that the chosen [father] and [mother] might produce.<br><br>The fact that a [animalType] is the most contributing ascendent does not have to mean that that [animalType] also has the highest inbred precentage.<br>A [animalType] with a low inbred percentage can have a large contributing factor by being a closer relative (grandparent and great-grandparent for example) than other [animalTypes] with a higher inbred percentage.<br><br>The [animalType] you selected will have most in common with the [animalTypes] in this list.<br>If you clicked on the \"Virtual Mating\" the potential [children] will have most in common with the [animalTypes] in this list.");
define('_PED_COI_MIATIT', 'Most inbred ascendants :');
define('_PED_COI_MIAEX', 'Shown here are the ascendents in the pedigree tree with the highest inbred percentages.<br>This list gives an indication of the inbred percentages in earlier generations which (could) affect the selected [animalType] or selected mating.');
define('_PED_COI_SSDTIT', 'Statistics for [father] and [mother] :');
define('_PED_COI_SSDEX',
       'Shown here are the statistics for the [father] and [mother] for the selected [animalType] or selected mating.<br><br>Coefficient of Relationship between [father] and [mother] is the amount of relationship between the pedigrees of the parents.<br>Also shown are the inbred percentages of both the [father] and [mother].');
define('_PED_COI_SSDcor', 'Coefficient of Relationship');
define('_PED_COI_SDDbsd', ' between [father] and [mother]');
define('_PED_COI_TNXTIT', 'A word of thanks');
define('_PED_COI_TNXCON', "We would like to thank Jacques Le Renard for the algorithms behind this webpage. Jacques has spent many hours perfecting these calculations. Please visit his website <a href=\"http://www.somali.asso.fr/eros/\">E.R.o's Information System</a>");

//members top 50
define('_PED_M50_TIT', 'Top 50 members orderd by number of dogs entered into the database');
define('_PED_M50_POS', 'Position');
define('_PED_M50_NUMD', 'Dogs entered');

//advanced info
define('_PED_ADV_VTMF', 'View top [male] and [female]');
define('_PED_ADV_STUD', '[male] with the highest number of [children].');
define('_PED_ADV_BITC', '[female] with the highest number of [children].');
define('_PED_ADV_TNMFTIT', 'Total number of [male] and [female]');
define('_PED_ADV_TCMA', 'Total number of [male] in the database.');
define('_PED_ADV_TCFE', 'Total number of [female] in the database.');
define('_PED_ADV_ORPTIT', 'View orphans');
define('_PED_ADV_ORPALL', 'View all [animalTypes] without both parents');
define('_PED_ADV_ORPDAD', 'View all [animalTypes] without a [father]');
define('_PED_ADV_ORPMUM', 'View all [animalTypes] without a [mother]');

//add a dog
define('_PED_ADD_DOG', 'Add a [animalType]');
define('_PED_ADD_DATA', 'Check this [animalType] and add other information -->');
define('_PED_ADD_SIRE', 'Add the [father] ->');
define('_PED_ADD_SELSIRE', 'Select the [father]');
define('_PED_ADD_SELDAM', 'Select the [mother]');
define('_PED_ADD_OK', 'The [animalType] has been added !');
define('_PED_ADD_SIREPLZ', 'The information has been stored.<br>Please select the [father].');
define('_PED_ADD_SIREOK', 'The information has been stored.<br>Please select the [mother].');
define('_PED_ADD_SIREUNKNOWN', 'Click here if the [father] is unknown.');
define('_PED_ADD_DAMUNKNOWN', 'Click here if the [mother] is unknown.');
define('_PED_ADD_KNOWN', 'The [animalTypes] shown above are allready in the database. They do not need to be entered again.');
define('_PED_ADD_KNOWNOK', 'I mean a different [animalType] and would like to continue.');

//add a onwer/breeder
define('_PED_ADD_OWNER', 'Add an owner or breeder');
define('_PED_FLD_OWN_LNAME', 'Lastname');
define('_PED_FLD_OWN_FNAME', 'Firstname');
define('_PED_FLD_OWN_STR', 'Streetname');
define('_PED_FLD_OWN_HN', 'Housenumber');
define('_PED_FLD_OWN_PC', 'Postcode');
define('_PED_FLD_OWN_CITY', 'City');
define('_PED_FLD_OWN_PN', 'Telephonenumber');
define('_PED_FLD_OWN_EMAIL', 'Emailadres');
define('_PED_FLD_OWN_WEB', 'Website');
define('_PED_FLD_OWN_WEB_EX', 'Please fill in the website adres. (URL)<br/><i>http://www.yourdomain.com/page.html</i>');

//view owner/breeder
define('_PED_OWN_OWN', 'Owner of');
define('_PED_OWN_BRE', 'Breeder of');
define('_PED_OWN_FNAME', 'Firstname');
define('_PED_OWN_LNAME', 'Lastname');

//add a litter
define('_PED_ADD_LITTER', 'Add a [litter]');
define('_PED_ADD_LIT_OK', 'The [animalTypes] have been added !');

//buttons
define('_PED_BTN_EDIT', 'Edit');
define('_PED_BTN_DELE', 'Delete');

//delete
define('_PED_DELE_CONF_OWN', 'Are you sure you want to delete this owner/breeder : ');
define('_PED_DELE_SURE', 'Confirm deletion');
define('_PED_DELE_WARN', 'Warning');
define('_PED_DELE_WARN_LABL', 'Any pups will also be orphaned by this action.');
define('_PED_DELE_WARN_BREEDER', 'The following [animalTypes] will no longer have a breeder in the database.');
define('_PED_DELE_WARN_OWNER', 'The following [animalTypes] will no longer have an owner in the database.');

//welcome
define('_PED_WELCOME', 'Welcome');

//virtual mating
define('_PED_VIRUTALTIT', 'Virtual Mating');
define('_PED_VIRUTALSTO',
       'By calculating the coefficients of Kinship, Relationship and Inbreeding for any combination of [father] and [mother] in the database a lot of statistical information can be shown about the potential [children].<br><br>This so called "Virtual Mating" can help you make a correct combination by calculating the inbred percentage (coi% or ci%) of potential [children]. You will be able to see how the (potential) parents relate to each other and which ancestors have the greatist influence on the chosen combination.<br><br>To start off with you need to select the parents of the virtual litter.<br>To complete these complex calculations at least the four grandparents need to have been entered into the database. If one of the parents is not shown in the list below it is possible that the pedigree is not "complete" enough to do a proper inbreeding calculation. The more ancestors in the pedigree the better these calculations become. The calculations go back 8 generations so it is important to make the pedigree as complete as possible.');
define('_PED_VIRT_SIRE', 'First select the [father] for the virtual mating.');
define('_PED_VIRT_DAM', 'Select the [mother] for the virtual mating.');
define('_PED_VIRTUALSTIT', 'Chosen [father] :');
define('_PED_VIRTUALDTIT', 'Chosen [mother] :');
define('_PED_VIRTUALBUT', 'Click here to create the calculations. This can take several minutes!');

//data changed
define('_MD_DATACHANGED', 'Your change has been saved in the database.');

//mega pedigree
define('_PED_MPED_F2', 'Female [animalType] present twice in 4 generation pedigree');
define('_PED_MPED_F3', 'Female [animalType] present three times in 4 generation pedigree');
define('_PED_MPED_F4', 'Female [animalType] present four times in 4 generation pedigree');
define('_PED_MPED_M2', 'Male [animalType] present twice in 4 generation pedigree');
define('_PED_MPED_M3', 'Male [animalType] present three times in 4 generation pedigree');
define('_PED_MPED_M4', 'Male [animalType] present four times in 4 generation pedigree');

//pedigreebook results
define('_PED_BOOK_INTRO', 'The data on this page is only for the following pedigreebook :  [flag]  [country]');
