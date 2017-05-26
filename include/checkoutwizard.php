<?php
require_once __DIR__ . '/wizard.php';

/**
 * Class CheckoutWizard
 */
class CheckoutWizard extends ZervWizard
{

    public $fieldtype;

    /**
     * CheckoutWizard constructor.
     */
    public function __construct()
    {
        global $field;
        // start the session and initialize the wizard
        if (!isset($_SESSION)) {
            session_start();
        }
        parent::__construct($_SESSION, __CLASS__);

        $this->addStep('Fieldname', 'Enter the fieldname');
        if ($this->getValue('field') == 0) { //only for a new field
            $this->addStep('Fieldtype', 'Select the fieldtype');
            if ($this->getValue('fieldtype') === 'selectbox' || $this->getValue('fieldtype') === 'radiobutton') {
                $this->addStep('lookup', 'Add possible value(s) for your field');
            }
        }

        $this->addStep('Settings', 'Choose the settings for this field');
        if ($this->getValue('hassearch') === 'hassearch') {
            $this->addStep('search', 'Search settings for this field');
        }
        if ($this->getValue('fieldtype') !== 'Picture') {
            $this->addStep('defaultvalue', 'Enter a default value for this field');
        }
        $this->addStep('confirm', 'Confirm the settings for this field');
    }

    public function prepare_Fieldname()
    {
        global $xoopsDB, $field;
        if (!$field == 0) { // field allready exists (editing mode)
            $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . ' WHERE ID=' . $field;
            $result = $GLOBALS['xoopsDB']->query($sql);
            while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
                $name             = $row['FieldName'];
                $fieldexplenation = $row['FieldExplenation'];
                $fieldtype        = $row['FieldType'];
            }
            $this->setValue('name', $name);
            $this->setValue('explain', $fieldexplenation);
            //set the fieldtype because we wont allow it to be edited
            $this->setValue('fieldtype', $fieldtype);
        }
        $this->setValue('field', $field); //is it a new field or are we editing a field
    }

    /**
     * @param $form
     * @return bool
     */
    public function process_Fieldname($form)
    {
        $name = $this->coalesce($form['name']);
        if (strlen($name) > 0) {
            $this->setValue('name', $name);
        } else {
            $this->addError('name', 'Please enter the fieldname');
        }

        $fieldexplenation = $this->coalesce($form['explain']);
        if (strlen($fieldexplenation) > 0) {
            $this->setValue('explain', $fieldexplenation);
        } else {
            $this->addError('explain', 'Please enter the explanation for this field');
        }

        return !$this->isError();
    }

    public function prepare_Fieldtype()
    {
        $this->fieldtype[] = array('value' => 'radiobutton', 'description' => 'Radiobutton');
        $this->fieldtype[] = array('value' => 'selectbox', 'description' => 'Dropdown list');
        $this->fieldtype[] = array('value' => 'textbox', 'description' => 'Textbox');
        $this->fieldtype[] = array('value' => 'textarea', 'description' => 'Textarea (Multiple lines)');
        $this->fieldtype[] = array('value' => 'dateselect', 'description' => 'Date field (Automatically displays a date picker)');
        $this->fieldtype[] = array('value' => 'urlfield', 'description' => 'Url field (Stores an url)');
        $this->fieldtype[] = array('value' => 'Picture', 'description' => 'Picture field (Automatically displays a "Browse... button" to upload an image from your computer)');
    }

    /**
     * @param $form
     * @return bool
     */
    public function process_Fieldtype($form)
    {
        $this->prepare_Fieldtype();
        $fieldtype = $this->coalesce($form['fieldtype']);
        $this->setValue('fieldtype', $fieldtype);

        return !$this->isError();
    }

    /**
     * @param $form
     * @return bool
     */
    public function process_lookup($form)
    {
        $fc = $this->coalesce($form['fc']);
        $this->setValue('fc', $fc);
        $lookup   = $this->coalesce($form['lookup' . $fc]);
        $lookupid = $this->coalesce($form['id' . $fc]);
        if (strlen($lookup) > 0) {
            $this->setValue('lookup' . $fc, $lookup);
            $this->setValue('id' . $fc, $lookupid);
        }
        $lastlookup = $this->getValue('lookup' . $fc);
        if ($lastlookup == '') {
            $this->setValue('fc', $fc - 1);
        }

        for ($i = 1; $i < $fc; $i++) {
            $radioarray[] = array('id' => $this->getValue('id' . $i), 'value' => $this->getValue('lookup' . $i));
        }
        //print_r($radioarray); die();
        $this->setValue('radioarray', $radioarray);

        return !$this->isError();
        //
    }

    public function prepare_Settings()
    {
        global $xoopsDB;
        if (!$this->getValue('field') == 0) { // field allready exists (editing mode)
            $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . ' WHERE ID=' . $this->getValue('field');
            $result = $GLOBALS['xoopsDB']->query($sql);
            while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
                $hs = $row['HasSearch'];
                if ($hs == '1') {
                    $this->setValue('hassearch', 'hassearch');
                }
                $vip = $row['ViewInPedigree'];
                if ($vip == '1') {
                    $this->setValue('viewinpedigree', 'viewinpedigree');
                }
                $via = $row['ViewInAdvanced'];
                if ($via == '1') {
                    $this->setValue('viewinadvanced', 'viewinadvanced');
                }
                $vipie = $row['ViewInPie'];
                if ($vipie == '1') {
                    $this->setValue('viewinpie', 'viewinpie');
                }
                $vil = $row['ViewInList'];
                if ($vil == '1') {
                    $this->setValue('viewinlist', 'viewinlist');
                }
            }
        }
    }

    /**
     * @param $form
     * @return bool
     */
    public function process_Settings($form)
    {
        $hassearch = $this->coalesce($form['hassearch']);
        $this->setValue('hassearch', $hassearch);
        $viewinpedigree = $this->coalesce($form['viewinpedigree']);
        $this->setValue('viewinpedigree', $viewinpedigree);
        $viewinadvanced = $this->coalesce($form['viewinadvanced']);
        $this->setValue('viewinadvanced', $viewinadvanced);
        $viewinpie = $this->coalesce($form['viewinpie']);
        $this->setValue('viewinpie', $viewinpie);
        $viewinlist = $this->coalesce($form['viewinlist']);
        $this->setValue('viewinlist', $viewinlist);

        return !$this->isError();
    }

    public function prepare_search()
    {
        global $xoopsDB;
        if (!$this->getValue('field') == 0) { // field allready exists (editing mode)
            $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . ' WHERE ID=' . $this->getValue('field');
            $result = $GLOBALS['xoopsDB']->query($sql);
            while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
                if ($this->getValue('hassearch') === 'hassearch') {
                    $searchname = $row['SearchName'];
                    $this->setValue('searchname', $searchname);
                    $searchexplain = $row['SearchExplenation'];
                    $this->setValue('searchexplain', $searchexplain);
                }
            }
        }
    }

    /**
     * @param $form
     * @return bool
     */
    public function process_search($form)
    {
        $searchname = $this->coalesce($form['searchname']);
        if (strlen($searchname) > 0) {
            $this->setValue('searchname', $searchname);
        } else {
            $this->addError('searchname', 'Please enter the searchname');
        }

        $fieldexplenation = $this->coalesce($form['searchexplain']);
        if (strlen($fieldexplenation) > 0) {
            $this->setValue('searchexplain', $fieldexplenation);
        } else {
            $this->addError('searchexplain', 'Please enter the search explanation for this field');
        }

        return !$this->isError();
    }

    public function prepare_defaultvalue()
    {
        global $xoopsDB;
        if (!$this->getValue('field') == 0) { // field allready exists (editing mode)
            $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . ' WHERE ID=' . $this->getValue('field');
            $result = $GLOBALS['xoopsDB']->query($sql);
            while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
                $def = $row['DefaultValue'];
                $this->setValue('defaultvalue', $def);
                if ($row['LookupTable'] == '1') { //we have a lookup table; load values
                    $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $this->getValue('field')) . " ORDER BY 'order'";
                    $fc     = 0;
                    $result = $GLOBALS['xoopsDB']->query($sql);
                    while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
                        $radioarray[] = array('id' => $row['ID'], 'value' => $row['value']);
                        $fc++;
                    }
                    $this->setValue('radioarray', $radioarray);
                    $this->setValue('fc', $fc);
                }
            }
        }
    }

    /**
     * @param $form
     * @return bool
     */
    public function process_defaultvalue($form)
    {
        $defaultvalue = $this->coalesce($form['defaultvalue']);
        if (strlen($defaultvalue) >= 0) {
            $this->setValue('defaultvalue', $defaultvalue);
        } else {
            $this->addError('defaultvalue', 'Please enter a defaultvalue');
        }

        return !$this->isError();
    }

    /**
     * @param $form
     * @return bool
     */
    public function process_confirm($form)
    {
        return !$this->isError();
    }

    public function completeCallback()
    {
        global $xoopsDB;
        //can this field be searched
        $search = $this->getValue('hassearch');
        if ($search === 'hassearch') {
            $search        = '1';
            $searchname    = $this->getValue('searchname');
            $searchexplain = $this->getValue('searchexplain');
        } else {
            $search        = '0';
            $searchname    = '';
            $searchexplain = '';
        }
        //show in pedigree
        $viewinpedigree = $this->getValue('viewinpedigree');
        if ($viewinpedigree === 'viewinpedigree') {
            $viewinpedigree = '1';
        } else {
            $viewinpedigree = '0';
        }
        //show in advanced
        $viewinadvanced = $this->getValue('viewinadvanced');
        if ($viewinadvanced === 'viewinadvanced') {
            $viewinadvanced = '1';
        } else {
            $viewinadvanced = '0';
        }
        //show in pie
        $viewinpie = $this->getValue('viewinpie');
        if ($viewinpie === 'viewinpie') {
            $viewinpie = '1';
        } else {
            $viewinpie = '0';
        }
        //view in list
        $viewinlist = $this->getValue('viewinlist');
        if ($viewinlist === 'viewinlist') {
            $viewinlist = '1';
        } else {
            $viewinlist = '0';
        }

        if (!$this->getValue('field') == 0) { // field allready exists (editing mode)
            $sql = 'UPDATE '
                   . $GLOBALS['xoopsDB']->prefix('stamboom_config')
                   . " SET FieldName = '"
                   . htmlspecialchars($this->getValue('name'))
                   . "', FieldType = '"
                   . $this->getValue('fieldtype')
                   . "', DefaultValue = '"
                   . $this->getValue('defaultvalue')
                   . "', FieldExplenation = '"
                   . $this->getValue('explain')
                   . "', HasSearch = '"
                   . $search
                   . "', SearchName = '"
                   . $searchname
                   . "', SearchExplenation = '"
                   . $searchexplain
                   . "', ViewInPedigree = '"
                   . $viewinpedigree
                   . "', ViewInAdvanced = '"
                   . $viewinadvanced
                   . "', ViewInPie = '"
                   . $viewinpie
                   . "', ViewInList = '"
                   . $viewinlist
                   . "' WHERE ID ='"
                   . $this->getValue('field')
                   . "'";
            $GLOBALS['xoopsDB']->queryF($sql);
            //possible change defaultvalue for userfield
            $sql = 'ALTER TABLE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' CHANGE `user' . $this->getValue('field') . '` `user' . $this->getValue('field') . "` VARCHAR( 255 ) NOT NULL DEFAULT '" . $this->getValue('defaultvalue') . "'";
            $GLOBALS['xoopsDB']->queryF($sql);
            $sql = 'ALTER TABLE ' . $GLOBALS['xoopsDB']->prefix('stamboom_temp') . ' CHANGE `user' . $this->getValue('field') . '` `user' . $this->getValue('field') . "` VARCHAR( 255 ) NOT NULL DEFAULT '" . $this->getValue('defaultvalue') . "'";
            $GLOBALS['xoopsDB']->queryF($sql);
            $sql = 'ALTER TABLE ' . $GLOBALS['xoopsDB']->prefix('stamboom_trash') . ' CHANGE `user' . $this->getValue('field') . '` `user' . $this->getValue('field') . "` VARCHAR( 255 ) NOT NULL DEFAULT '" . $this->getValue('defaultvalue') . "'";
            $GLOBALS['xoopsDB']->queryF($sql);
        } else {
            $sql       = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom');
            $result    = $GLOBALS['xoopsDB']->query($sql);
            $numfields = $GLOBALS['xoopsDB']->getFieldsNum($result);
            //** ATTENTION **
            //10 = number of fields if there are no userfields
            //edit this if database structure changes !!!
            //** ATTENTION **
            $nextfieldnum = ($numfields - 10) + 1;
            //add userfield to various tables as a new field.
            //allways add at the end of the table
            $tables = array('stamboom', 'stamboom_temp', 'stamboom_trash');
            foreach ($tables as $table) {
                $SQL = 'ALTER TABLE ' . $GLOBALS['xoopsDB']->prefix($table) . ' ADD `user' . $nextfieldnum . "` VARCHAR( 255 ) NOT NULL DEFAULT '" . $this->getValue('defaultvalue') . "'";
                $GLOBALS['xoopsDB']->queryF($SQL);
            }
            //is a lookup table present
            $lookup = $this->getValue('lookup1');
            if ($lookup == '') {
                $lookup = '0';
            } else {
                $lookup = '1';
                //create table for lookupfield
                $createtable = 'CREATE TABLE ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $nextfieldnum) . ' (`ID` TINYINT( 3 ) NOT NULL ,`value` VARCHAR( 255 ) NOT NULL, `order` TINYINT( 3 )) ENGINE = MyISAM';
                $GLOBALS['xoopsDB']->queryF($createtable);
                //fill table
                $count = $this->getValue('fc');
                for ($x = 1; $x < $count + 1; $x++) {
                    $y   = $x - 1;
                    $sql = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $nextfieldnum) . " ( `ID` , `value`, `order`) VALUES ('" . $y . "', '" . $this->getValue('lookup' . $x) . "','" . $y . "')";
                    $GLOBALS['xoopsDB']->queryF($sql);
                }
            }

            //Insert new record into stamboom_config
            $sql = 'INSERT INTO '
                   . $GLOBALS['xoopsDB']->prefix('stamboom_config')
                   . " ( `ID` , `isActive` , `FieldName` , `FieldType` , `LookupTable` , `DefaultValue` , `FieldExplenation` , `HasSearch` , `SearchName` , `SearchExplenation` , `ViewInPedigree` , `ViewInAdvanced` , `ViewInPie` , `ViewInList`, `order` ) VALUES ('"
                   . $nextfieldnum
                   . "', '1', '"
                   . htmlspecialchars($this->getValue('name'))
                   . "', '"
                   . $this->getValue('fieldtype')
                   . "', '"
                   . $lookup
                   . "', '"
                   . $this->getValue('defaultvalue')
                   . "', '"
                   . $this->getValue('explain')
                   . "', '"
                   . $search
                   . "', '"
                   . $searchname
                   . "', '"
                   . $searchexplain
                   . "', '"
                   . $viewinpedigree
                   . "', '"
                   . $viewinadvanced
                   . "', '"
                   . $viewinpie
                   . "', '"
                   . $viewinlist
                   . "','"
                   . $nextfieldnum
                   . "')";
            $GLOBALS['xoopsDB']->queryF($sql);
        }
    }

    /**
     * Miscellaneous utility functions
     * @param $email
     * @return int
     */

    public function isValidEmail($email)
    {
        return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i', $email);
    }
}
