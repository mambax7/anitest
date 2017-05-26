pedigree database - 0.8
-----------------------
required :
PHP5 or above
GD lib. 2 (for advanced info (piecharts))


changelog 0.8
-------------
user defineable fields in result.php 
user defineable fields in stamboom_config
OO corefile - include class_field.php
add_dog.php changed to use OO userfields
update.php changed to use OO userfields
advanced.php changed to use OO userfields
index.php changed to use OO userfields
test.php included to test OO functions
mysql.sql included with test data
removed lots of dobermann specific procedural code


using version 0.8
-----------------
manualy change the values in stamboom_config. if you create a new field (number 8 for instance) also create a user8 field in stamboom and stamboom_temp.
If you set a field to have a lookup table you must create a table named stamboom_lookup8.
A lookup table has no limit to its length.
A field with a lookup table can be included in the advanced info section.
A field with a lookup table cannot be included in the search section.
A field with a lookup table cannot be included in the list (result of search)
Any field can be set to be shown in the pedigree.
Only a field shown in the advanced info section can have a Piechart.
If a field has the wrong settings an error will appear in RED telling you whats wrong !!
Userfields must be numbered in order: user1,user2,user3,user4 is OK. user1,user3,user4 is not OK. This still needs testing.

edit 17/3/2006 : !!** userfields can now also be set for the results of searches as columns **!!
