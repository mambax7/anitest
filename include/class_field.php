<?php

/**
 * Class Systemmessage
 */
class Systemmessage
{
    /**
     * Systemmessage constructor.
     * @param $message
     */
    public function __construct($message)
    {
        echo '<span style="color: red;"><h3>' . $message . '</h3></span>';
    }
}

/**
 * Class Animal
 */
class Animal
{
    /**
     * Animal constructor.
     * @param int $animalnumber
     */

    public $configvalues;
    public $fieldname;
public $value ;
//public $ ;
//public $ ;
//public $ ;

    public function __construct($animalnumber = 0)
    {
        global $xoopsDB;
        if ($animalnumber == 0) {
            $SQL = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom');
        } else {
            $SQL = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID = ' . $animalnumber;
        }
        $result    = $GLOBALS['xoopsDB']->query($SQL);
        $row       = $GLOBALS['xoopsDB']->fetchRow($result);
        $numfields = mysqli_num_fields($result);
        for ($i = 0; $i < $numfields; $i++) {
            $key        = $GLOBALS['xoopsDB']->getFieldName($result, $i);
            $this->$key = $row[$i];
        }
    }

    /**
     * @return array
     */
    public function numoffields()
    {
        global $xoopsDB;
        $configvalues = $fields = array();
        $SQL          = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_config') . ' ORDER BY `order`';
        $result       = $GLOBALS['xoopsDB']->query($SQL);
        $count        = 0;
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
            $fields[] = $row['ID'];
            $count++;
            $configvalues[] = $row;
        }
        $this->configvalues = $configvalues;

        //print_r ($this->configvalues); die();
        return $fields;
    }

    /**
     * @return mixed
     */
    public function getconfig()
    {
        return $this->configvalues;
    }
}

/**
 * Class Field
 */
class Field
{

    public $fieldnumber ;
    public $defaultvalue ;
    public $lookuptable;
    public $value ;
    public $fieldname ;

    /**
     * Field constructor.
     * @param $fieldnumber
     * @param $config
     */
    public function __construct($fieldnumber, $config)
    {
        //find key where ID = $fieldnumber;
        for ($x = 0, $xMax = count($config); $x < $xMax; $x++) {
            if ($config[$x]['ID'] == $fieldnumber) {
                foreach ($config[$x] as $key => $values) {
                    $this->$key = $values;
                }
            }
        }
        $this->id = $fieldnumber;
    }

    /**
     * @return bool
     */
    public function active()
    {
        $active = $this->getSetting('isActive');
        if ($active == '1') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function inadvanced()
    {
        $active = $this->getSetting('ViewInAdvanced');
        if ($active == '1') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hassearch()
    {
        $active = $this->getSetting('HasSearch');
        if ($active == '1') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function haslookup()
    {
        $active = $this->getSetting('LookupTable');
        if ($active == '1') {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getsearchstring()
    {
        return '&amp;o=naam&amp;p';
    }

    /**
     * @return bool
     */
    public function inpie()
    {
        $active = $this->getSetting('ViewInPie');
        if ($active == '1') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function inpedigree()
    {
        $active = $this->getSetting('ViewInPedigree');
        if ($active == '1') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function inlist()
    {
        $active = $this->getSetting('ViewInList');
        if ($active == '1') {
            return true;
        }

        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $setting
     * @return mixed
     */
    public function getSetting($setting)
    {
        return $this->$setting;
    }

    /**
     * @param $fieldnumber
     * @return array
     */
    public function lookup($fieldnumber)
    {
        global $xoopsDB;
        $SQL    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom_lookup' . $fieldnumber) . " ORDER BY 'order'";
        $result = $GLOBALS['xoopsDB']->query($SQL);
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
            $ret[] = array('id' => $row['ID'], 'value' => $row['value']);
        }

        //array_multisort($ret,SORT_ASC);
        return $ret;
    }

    /**
     * @return \XoopsFormLabel
     */
    public function viewField()
    {
        $view = new XoopsFormLabel($this->fieldname, $this->value);

        return $view;
    }

    /**
     * @return string
     */
    public function showField()
    {
        return $this->fieldname . ' : ' . $this->value;
    }

    /**
     * @return mixed
     */
    public function showValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function searchfield()
    {
        return '<input type="text" name="query" size="20">';
    }
}

/**
 * Class RadioButton
 */
class RadioButton extends Field
{
    /**
     * RadioButton constructor.
     * @param $parentObject
     * @param $animalObject
     */


    public function __construct($parentObject, $animalObject)
    {
        $this->fieldnumber = $parentObject->getId();

        $this->fieldname    = $parentObject->FieldName;
        $this->value        = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->DefaultValue;
        $this->lookuptable  = $parentObject->LookupTable;
        if ($this->lookuptable == '0') {
            new Systemmessage('A lookuptable must be specified for userfield' . $this->fieldnumber);
        }
    }

    /**
     * @return \XoopsFormRadio
     */
    public function editField()
    {
        $radio          = new XoopsFormRadio('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $value = $this->value);
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            $radio->addOption($lookupcontents[$i]['id'], $name = ($lookupcontents[$i]['value'] . '<br>'), $disabled = false);
        }

        return $radio;
    }

    /**
     * @return \XoopsFormRadio
     */
    public function newField()
    {
        $radio          = new XoopsFormRadio('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $value = $this->defaultvalue);
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            $radio->addOption($lookupcontents[$i]['id'], $name = ($lookupcontents[$i]['value'] . '<br>'), $disabled = false);
        }

        return $radio;
    }

    /**
     * @return \XoopsFormLabel
     */
    public function viewField()
    {
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            if ($lookupcontents[$i]['id'] == $this->value) {
                $choosenvalue = $lookupcontents[$i]['value'];
            }
        }
        $view = new XoopsFormLabel($this->fieldname, $choosenvalue);

        return $view;
    }

    /**
     * @return string
     */
    public function showField()
    {
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            if ($lookupcontents[$i]['id'] == $this->value) {
                $choosenvalue = $lookupcontents[$i]['value'];
            }
        }

        return $this->fieldname . ' : ' . $choosenvalue;
    }

    /**
     * @return mixed
     */
    public function showValue()
    {
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            if ($lookupcontents[$i]['id'] == $this->value) {
                $choosenvalue = $lookupcontents[$i]['value'];
            }
        }

        return $choosenvalue;
    }

    /**
     * @return string
     */
    public function searchfield()
    {
        $select         = '<select size="1" name="query" style="width: 140px;">';
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            $select .= '<option value="' . $lookupcontents[$i]['id'] . '">' . $lookupcontents[$i]['value'] . '</option>';
        }
        $select .= '</select>';

        return $select;
    }
}

/**
 * Class selectbox
 */
class SelectBox extends Field
{
    /**
     * selectbox constructor.
     * @param $parentObject
     * @param $animalObject
     */
    public function __construct($parentObject, $animalObject)
    {
        $this->fieldnumber  = $parentObject->getId();
        $this->fieldname    = $parentObject->FieldName;
        $this->value        = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->DefaultValue;
        $this->lookuptable  = $parentObject->LookupTable;
        if ($this->lookuptable == '0') {
            new Systemmessage('A lookuptable must be specified for userfield' . $this->fieldnumber);
        }
    }

    /**
     * @return \XoopsFormSelect
     */
    public function editField()
    {
        $select         = new XoopsFormSelect('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $value = $this->value, $size = 1, $multiple = false);
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            $select->addOption($lookupcontents[$i]['id'], $name = ($lookupcontents[$i]['value'] . '<br>'), $disabled = false);
        }

        return $select;
    }

    /**
     * @return \XoopsFormSelect
     */
    public function newField()
    {
        $select         = new XoopsFormSelect('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $value = $this->defaultvalue, $size = 1, $multiple = false);
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            $select->addOption($lookupcontents[$i]['id'], $name = ($lookupcontents[$i]['value'] . '<br>'), $disabled = false);
        }

        return $select;
    }

    /**
     * @return \XoopsFormLabel
     */
    public function viewField()
    {
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            if ($lookupcontents[$i]['id'] == $this->value) {
                $choosenvalue = $lookupcontents[$i]['value'];
            }
        }
        $view = new XoopsFormLabel($this->fieldname, $choosenvalue);

        return $view;
    }

    /**
     * @return string
     */
    public function showField()
    {
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            if ($lookupcontents[$i]['id'] == $this->value) {
                $choosenvalue = $lookupcontents[$i]['value'];
            }
        }

        return $this->fieldname . ' : ' . $choosenvalue;
    }

    /**
     * @return mixed
     */
    public function showValue()
    {
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            if ($lookupcontents[$i]['id'] == $this->value) {
                $choosenvalue = $lookupcontents[$i]['value'];
            }
        }

        return $choosenvalue;
    }

    /**
     * @return string
     */
    public function searchfield()
    {
        $select         = '<select size="1" name="query" style="width: 140px;">';
        $lookupcontents = Field::lookup($this->fieldnumber);
        for ($i = 0, $iMax = count($lookupcontents); $i < $iMax; $i++) {
            $select .= '<option value="' . $lookupcontents[$i]['id'] . '">' . $lookupcontents[$i]['value'] . '</option>';
        }
        $select .= '</select>';

        return $select;
    }
}

/**
 * Class textbox
 */
class TextBox extends Field
{
    /**
     * textbox constructor.
     * @param $parentObject
     * @param $animalObject
     */
    public function __construct($parentObject, $animalObject)
    {
        $this->fieldnumber  = $parentObject->getId();
        $this->fieldname    = $parentObject->FieldName;
        $this->value        = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->DefaultValue;
        $this->lookuptable  = $parentObject->LookupTable;
        if ($this->lookuptable == '1') {
            new Systemmessage('No lookuptable may be specified for userfield' . $this->fieldnumber);
        }
        if ($parentObject->ViewInAdvanced == '1') {
            new Systemmessage('userfield' . $this->fieldnumber . ' cannot be shown in advanced info');
        }
        if ($parentObject->ViewInPie == '1') {
            new Systemmessage('A Pie-chart cannot be specified for userfield' . $this->fieldnumber);
        }
    }

    /**
     * @return \XoopsFormText
     */
    public function editField()
    {
        $textbox = new XoopsFormText('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $size = 50, $maxsize = 50, $value = $this->value);

        return $textbox;
    }

    /**
     * @return \XoopsFormText
     */
    public function newField()
    {
        $textbox = new XoopsFormText('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $size = 50, $maxsize = 50, $value = $this->defaultvalue);

        return $textbox;
    }

    /**
     * @return string
     */
    public function getsearchstring()
    {
        return '&amp;o=naam&amp;l=1';
    }
}

/**
 * Class textarea
 */
class TextArea extends Field
{
    /**
     * textarea constructor.
     * @param $parentObject
     * @param $animalObject
     */
    public function __construct($parentObject, $animalObject)
    {
        $this->fieldnumber  = $parentObject->getId();
        $this->fieldname    = $parentObject->FieldName;
        $this->value        = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->DefaultValue;
        if ($parentObject->LookupTable == '1') {
            new Systemmessage('No lookuptable may be specified for userfield' . $this->fieldnumber);
        }
        if ($parentObject->ViewInAdvanced == '1') {
            new Systemmessage('userfield' . $this->fieldnumber . ' cannot be shown in advanced info');
        }
        if ($parentObject->ViewInPie == '1') {
            new Systemmessage('A Pie-chart cannot be specified for userfield' . $this->fieldnumber);
        }
    }

    /**
     * @return \XoopsFormTextArea
     */
    public function editField()
    {
        $textarea = new XoopsFormTextArea('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $value = $this->value, $rows = 5, $cols = 50);

        return $textarea;
    }

    /**
     * @return \XoopsFormTextArea
     */
    public function newField()
    {
        $textarea = new XoopsFormTextArea('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $value = $this->defaultvalue, $rows = 5, $cols = 50);

        return $textarea;
    }

    /**
     * @return string
     */
    public function getsearchstring()
    {
        return '&amp;o=naam&amp;l=1';
    }
}

/**
 * Class dateselect
 */
class DateSelect extends Field
{
    /**
     * dateselect constructor.
     * @param $parentObject
     * @param $animalObject
     */
    public function __construct($parentObject, $animalObject)
    {
        $this->fieldnumber  = $parentObject->getId();
        $this->fieldname    = $parentObject->FieldName;
        $this->value        = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->DefaultValue;
        if ($parentObject->LookupTable == '1') {
            new Systemmessage('No lookuptable may be specified for userfield' . $this->fieldnumber);
        }
        if ($parentObject->ViewInAdvanced == '1') {
            new Systemmessage('userfield' . $this->fieldnumber . ' cannot be shown in advanced info');
        }
        if ($parentObject->ViewInPie == '1') {
            new Systemmessage('A Pie-chart cannot be specified for userfield' . $this->fieldnumber);
        }
    }

    /**
     * @return \XoopsFormTextDateSelect
     */
    public function editField()
    {
        //$textarea = new XoopsFormFile("<b>".$this->fieldname."</b>", $this->fieldname, $maxfilesize = 2000);
        $textarea = new XoopsFormTextDateSelect('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $size = 15, $this->value);

        return $textarea;
    }

    /**
     * @return \XoopsFormTextDateSelect
     */
    public function newField()
    {
        $textarea = new XoopsFormTextDateSelect('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $size = 15, $this->defaultvalue);

        return $textarea;
    }

    /**
     * @return string
     */
    public function getsearchstring()
    {
        return '&amp;o=naam&amp;l=1';
    }
}

/**
 * Class urlfield
 */
class UrlField extends Field
{
    /**
     * urlfield constructor.
     * @param $parentObject
     * @param $animalObject
     */
    public function __construct($parentObject, $animalObject)
    {
        $this->fieldnumber  = $parentObject->getId();
        $this->fieldname    = $parentObject->FieldName;
        $this->value        = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->DefaultValue;
        $this->lookuptable  = $parentObject->LookupTable;
        if ($this->lookuptable == '1') {
            new Systemmessage('No lookuptable may be specified for userfield' . $this->fieldnumber);
        }
        if ($parentObject->ViewInAdvanced == '1') {
            new Systemmessage('userfield' . $this->fieldnumber . ' cannot be shown in advanced info');
        }
        if ($parentObject->ViewInPie == '1') {
            new Systemmessage('A Pie-chart cannot be specified for userfield' . $this->fieldnumber);
        }
    }

    /**
     * @return \XoopsFormText
     */
    public function editField()
    {
        $textbox = new XoopsFormText('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $size = 50, $maxsize = 255, $value = $this->value);

        return $textbox;
    }

    /**
     * @return \XoopsFormText
     */
    public function newField()
    {
        $textbox = new XoopsFormText('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $size = 50, $maxsize = 255, $value = $this->defaultvalue);

        return $textbox;
    }

    /**
     * @return \XoopsFormLabel
     */
    public function viewField()
    {
        $view = new XoopsFormLabel($this->fieldname, '<a href="' . $this->value . '" target=\"_new\">' . $this->value . '</a>');

        return $view;
    }

    /**
     * @return string
     */
    public function showField()
    {
        return $this->fieldname . ' : <a href="' . $this->value . '" target="_new">' . $this->value . '</a>';
    }

    /**
     * @return string
     */
    public function showValue()
    {
        return '<a href="' . $this->value . '" target="_new">' . $this->value . '</a>';
    }

    /**
     * @return string
     */
    public function getsearchstring()
    {
        return '&amp;o=naam&amp;l=1';
    }
}

/**
 * Class Picture
 */
class Picture extends Field
{
    /**
     * Picture constructor.
     * @param $parentObject
     * @param $animalObject
     */
    public function __construct($parentObject, $animalObject)
    {
        $this->fieldnumber  = $parentObject->getId();
        $this->fieldname    = $parentObject->FieldName;
        $this->value        = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->DefaultValue;
        $this->lookuptable  = $parentObject->LookupTable;
        if ($this->lookuptable == '1') {
            new Systemmessage('No lookuptable may be specified for userfield' . $this->fieldnumber);
        }
        if ($parentObject->ViewInAdvanced == '1') {
            new Systemmessage('userfield' . $this->fieldnumber . ' cannot be shown in advanced info');
        }
        if ($parentObject->ViewInPie == '1') {
            new Systemmessage('A Pie-chart cannot be specified for userfield' . $this->fieldnumber);
        }
        if ($parentObject->ViewInList == '1') {
            new Systemmessage('userfield' . $this->fieldnumber . ' cannot be included in listview');
        }
        if ($parentObject->HasSearch == '1') {
            new Systemmessage('Search cannot be defined for userfield' . $this->fieldnumber);
        }
    }

    /**
     * @return \XoopsFormFile
     */
    public function editField()
    {
        $picturefield = new XoopsFormFile($this->fieldname, 'user' . $this->fieldnumber, 1024000);
        $picturefield->setExtra("size ='50'");

        return $picturefield;
    }

    /**
     * @return \XoopsFormFile
     */
    public function newField()
    {
        $picturefield = new XoopsFormFile($this->fieldname, 'user' . $this->fieldnumber, 1024000);
        $picturefield->setExtra("size ='50'");

        return $picturefield;
    }

    /**
     * @return \XoopsFormLabel
     */
    public function viewField()
    {
        $view = new XoopsFormLabel($this->fieldname, '<img src="images/thumbnails/' . $this->value . '_400.jpeg">');

        return $view;
    }

    /**
     * @return string
     */
    public function showField()
    {
        return '<img src="images/thumbnails/' . $this->value . '_150.jpeg">';
    }

    /**
     * @return string
     */
    public function showValue()
    {
        return '<img src="images/thumbnails/' . $this->value . '_400.jpeg">';
    }
}

/**
 * Class SISContext
 */
class SISContext
{
    public $_contexts;
    public $_depth;

    /**
     * SISContext constructor.
     */
    public function __construct()
    {
        $this->_contexts = array();
        $this->_depth    = 0;
    }

    /**
     * @param $url
     * @param $name
     */
    public function myGoto($url, $name)
    {
        $keys = array_keys($this->_contexts);
        for ($i = 0; $i < $this->_depth; $i++) {
            if ($keys[$i] == $name) {
                $this->_contexts[$name] = $url; // the url might be slightly different
                $this->_depth           = $i + 1;
                for ($x = count($this->_contexts); $x > $i + 1; $x--) {
                    array_pop($this->_contexts);
                }

                return;
            }
        }

        $this->_contexts[$name] = $url;
        $this->_depth++;
    }

    /**
     * @return array
     */
    public function getAllContexts()
    {
        return $this->_contexts;
    }

    /**
     * @return array
     */
    public function getAllContextNames()
    {
        return array_keys($this->_contexts);
    }
}
