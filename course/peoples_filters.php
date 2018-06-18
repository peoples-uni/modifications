<?php
// peoples_filters.php 20140209
// Provide filters for for a list

class peoples_filters {

  private $filters = array();
  private $page_url;


  public function set_page_url($url) {
    $this->page_url = $url;
  }


  public function add_filter(peoples_filter $filter) {
    $this->filters[] = $filter;
  }


  public function get_url_parameters() {
    $parameters = '';

    foreach ($this->filters as $filter) {
      $parameters .= $filter->get_url_parameter();
    }
    return $parameters;
  }


  public function show_filters() {
    echo  '<form method="post" action="' . $this->page_url . '">';
    echo    'Display entries using the following filters...';
    echo    '<table border="2" cellpadding="2">';
    echo      '<tr>';
    foreach ($this->filters as $filter) {
      echo      "<td>$filter->human_name</td>";
    }
    echo      '</tr>';
    echo      '<tr>';
    foreach ($this->filters as $filter) {
      echo      '<td>' . $filter->choice_field() . '</td>';
    }
    echo      '</tr>';
    echo    '</table>';
    echo    '<input type="hidden" name="markfilter" value="1" />';
    echo    '<input type="submit" name="filter" value="Apply Filters" />';
    echo    ' <a href="' . $this->page_url . '">Reset Filters</a>';
    echo '</form>';
    echo '<br />';
  }


  public function filter_entries(array $list_to_filter) {

    foreach ($this->filters as $filter) {
      $list_to_filter = $filter->filter_entries($list_to_filter);
    }

    return $list_to_filter;
  }
}


abstract class peoples_filter {
  public $human_name;
  protected $name;
  protected $selectedvalue;

  abstract public function get_url_parameter();
  abstract public function choice_field();


  function get_filter_setting() {
    return $this->selectedvalue;
  }


  public function filter_entries(array $list_to_filter) {
    return $list_to_filter; // Do Nothing
  }


  protected function select_choice_field($name, $options, $selectedvalue) {
    $field = '<select name="' . $name . '">';
    foreach ($options as $option) {
      if ($option === $selectedvalue) $selected = 'selected="selected"';
      else $selected = '';

      $opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
      $field .= '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
    }
    $field .= '</select>';

    return $field;
  }
}


class peoples_boolean_filter extends peoples_filter {

  function __construct($human_name, $name) {
    $this->human_name = $human_name;
    $this->name = $name;
    $this->selectedvalue = !empty($_REQUEST[$this->name]);
  }


  public function get_url_parameter() {
    return "&$this->name=" . (empty($_REQUEST[$this->name]) ? '0' : '1');
  }


  public function choice_field() {

    if (!empty($_REQUEST[$this->name])) $checked = ' CHECKED';
    else $checked = '';
    return '<input type="checkbox" name="' . $this->name . '"' . "$checked />";
  }
}


class peoples_select_filter extends peoples_filter {
  protected $options;


  function __construct($human_name, $name, array $options, $defaultvalue) {
    $this->human_name = $human_name;
    $this->name = $name;
    $this->options = $options;

    if (!empty($_REQUEST[$this->name])) $this->selectedvalue = $_REQUEST[$this->name];
    else $this->selectedvalue = $defaultvalue;
  }


  public function get_url_parameter() {
    return "&$this->name=" . urlencode($_REQUEST[$this->name]);
  }


  public function choice_field() {
    return $this->select_choice_field($this->name, $this->options, $this->selectedvalue);
  }
}


class peoples_textfield_filter extends peoples_filter {

  function __construct($human_name, $name) {
    $this->human_name = $human_name;
    $this->name = $name;

    if (!empty($_REQUEST[$this->name])) $this->selectedvalue = $_REQUEST[$this->name];
    else $this->selectedvalue = '';
  }


  public function get_url_parameter() {
    return "&$this->name=" . urlencode($_REQUEST[$this->name]);
  }


  public function choice_field() {
    return '<input type="text" size="15" name="' . $this->name . '" value="' . htmlspecialchars($this->selectedvalue, ENT_COMPAT, 'UTF-8') . '" />';
  }
}


class peoples_chosensearch_filter extends peoples_textfield_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) &&
        stripos($list_entry->lastname, $this->selectedvalue) === false &&
        stripos($list_entry->firstname, $this->selectedvalue) === false &&
        stripos($list_entry->email, $this->selectedvalue) === false) {
        unset($list_to_filter[$index]);
      }
    }
    return $list_to_filter;
  }
}


class peoples_chosenmodule_filter extends peoples_textfield_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) &&
        stripos($list_entry->coursename1, $this->selectedvalue) === false &&
        stripos($list_entry->coursename2, $this->selectedvalue) === false) {
        unset($list_to_filter[$index]);
      }
    }
    return $list_to_filter;
  }
}


class peoples_chosensemester_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (($this->selectedvalue !== 'All') && ($list_entry->semester !== $this->selectedvalue)) {
        unset($list_to_filter[$index]);
      }
    }
    return $list_to_filter;
  }
}


class peoples_chosenstatus_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      $state = (int)$list_entry->state;
      if ($state === 1) $state = 011;
      if (
        (($this->selectedvalue  === 'Not fully Approved')     && ($state === 011 || $state === 033)) ||
        (($this->selectedvalue  === 'Not fully Enrolled')     && ($state === 033)) ||
        (($this->selectedvalue  === 'Part or Fully Approved') && (!($state === 011 || $state === 012 || $state === 021 || $state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033))) ||
        (($this->selectedvalue  === 'Part or Fully Enrolled') && (!($state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033)))
        ) {
        unset($list_to_filter[$index]);
      }
    }
    return $list_to_filter;
  }
}


class peoples_chosenpay_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'No Indication Given' && $list_entry->paymentmechanism != 0) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Not Confirmed (all)' && ($list_entry->paymentmechanism == 1 || $list_entry->paymentmechanism >= 100)) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Barclays not confirmed' && $list_entry->paymentmechanism != 2) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Diamond not confirmed' && $list_entry->paymentmechanism != 3) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Ecobank not confirmed' && $list_entry->paymentmechanism != 10) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Western Union not confirmed' && $list_entry->paymentmechanism != 4) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Indian Confederation not confirmed' && $list_entry->paymentmechanism != 5) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Posted Travellers Cheques not confirmed' && $list_entry->paymentmechanism != 7) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Posted Cash not confirmed' && $list_entry->paymentmechanism != 8) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'MoneyGram not confirmed' && $list_entry->paymentmechanism != 9) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Promised End Semester' && $list_entry->paymentmechanism != 6) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Waiver' && $list_entry->paymentmechanism != 100) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'RBS Confirmed' && $list_entry->paymentmechanism != 1) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Barclays Confirmed' && $list_entry->paymentmechanism != 102) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Diamond Confirmed' && $list_entry->paymentmechanism != 103) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Ecobank Confirmed' && $list_entry->paymentmechanism != 110) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Western Union Confirmed' && $list_entry->paymentmechanism != 104) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Indian Confederation Confirmed' && $list_entry->paymentmechanism != 105) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Posted Travellers Cheques Confirmed' && $list_entry->paymentmechanism != 107) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Posted Cash Confirmed' && $list_entry->paymentmechanism != 108) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'MoneyGram Confirmed' && $list_entry->paymentmechanism != 109) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


class peoples_chosenpaidornot_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        $paidup = TRUE;
        if (!empty($list_entry->userid)) {
          $amount = amount_to_pay($list_entry->userid);
          if ($amount >= .01) $paidup = FALSE;
        }
        if ($this->selectedvalue === 'Yes' && !$paidup) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'No' && $paidup) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


class peoples_chosenreenrol_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'Re-enrolment' && !$list_entry->reenrolment) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'New student' && $list_entry->reenrolment) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


class peoples_chosenmmu_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($list_entry->applymmumph == 8) $list_entry->applymmumph = -8;
        if ($list_entry->applymmumph == 9) $list_entry->applymmumph = -9;

        if ($this->selectedvalue === 'No' && $list_entry->applymmumph >= 2) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Yes' && $list_entry->applymmumph < 2) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


class peoples_acceptedmmu_filter extends peoples_select_filter {
  private $stamp_range = array();


  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'No' && $list_entry->mph) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Yes' && !$list_entry->mph) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'MMU MPH'     && (!$list_entry->mph || ($list_entry->mphstatus != 1))) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Peoples MPH' && (!$list_entry->mph || ($list_entry->mphstatus != 2))) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'EUCLID MPH'   && (!$list_entry->mph || ($list_entry->mphstatus != 3))) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue !== 'No' && $this->selectedvalue !== 'Yes' && $this->selectedvalue !== 'MMU MPH' && $this->selectedvalue !== 'Peoples MPH' && $this->selectedvalue !== 'EUCLID MPH') {
          if (!$list_entry->mph || $list_entry->mphdatestamp < $this->stamp_range[$this->selectedvalue]['start'] || $list_entry->mphdatestamp >= $this->stamp_range[$this->selectedvalue]['end']) {
            unset($list_to_filter[$index]);
            continue;
          }
        }
      }
    }
    return $list_to_filter;
  }


  public function set_stamp_range($stamp_range) {
    $this->stamp_range = $stamp_range;
  }
}


class peoples_chosenscholarship_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      $x = strtolower(trim($list_entry->scholarship));
      $scholarshipempty = empty($x) || ($x ==  'none') || ($x ==  'n/a') || ($x ==  'none.');
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'No' && !$scholarshipempty) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Yes' && $scholarshipempty) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// 20150602 New filter for education_committee_report.php
class peoples_applied_scholarship_in_semester_filter extends peoples_boolean_filter {

  protected $selected_semester;

  function __construct($human_name, $name, $selected_semester) {
    $this->human_name = $human_name;
    $this->name = $name;
    $this->selectedvalue = !empty($_REQUEST[$this->name]);
    $this->selected_semester = $selected_semester;
  }

  public function filter_entries(array $list_to_filter) {
    global $DB;

    if ($this->selectedvalue) {

      $semester_to_match = $this->selected_semester;

      $peoplesapplications = $DB->get_records_sql("SELECT * FROM mdl_peoplesapplication WHERE semester='$semester_to_match' AND hidden=0");
      if (empty($peoplesapplications)) {
        $peoplesapplications = array();
      }

      $scholarships = array();
      foreach ($peoplesapplications as $index => $peoplesapplication) {
        $x = strtolower(trim($peoplesapplication->scholarship));
        $scholarshipempty = empty($x) || ($x ==  'none') || ($x ==  'n/a') || ($x ==  'none.');
        if (!$scholarshipempty) {
          $scholarships[$peoplesapplication->userid] = $peoplesapplication->userid;
        }
      }

      foreach ($list_to_filter as $index => $list_entry) {
        if (!empty($list_entry->id) && empty($scholarships[$list_entry->id])) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


class peoples_daterange_filter extends peoples_filter {
  protected $starttime;
  protected $endtime;
  protected $liststartyear = array();
  protected $liststartmonth = array();
  protected $liststartday = array();
  protected $listendyear = array();
  protected $listendmonth = array();
  protected $listendday = array();


  function __construct() {
    $this->human_name = 'Start Year</td><td>Start Month</td><td>Start Day</td><td>End Year</td><td>End Month</td><td>End Day';

    if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
      $this->chosenstartyear = (int)$_REQUEST['chosenstartyear'];
      $this->chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
      $this->chosenstartday = (int)$_REQUEST['chosenstartday'];
      $this->starttime = gmmktime(0, 0, 0, $this->chosenstartmonth, $this->chosenstartday, $this->chosenstartyear);
    }
    else {
      $this->starttime = 0;
    }
    if (!empty($_REQUEST['chosenendyear']) && !empty($_REQUEST['chosenendmonth']) && !empty($_REQUEST['chosenendday'])) {
      $this->chosenendyear = (int)$_REQUEST['chosenendyear'];
      $this->chosenendmonth = (int)$_REQUEST['chosenendmonth'];
      $this->chosenendday = (int)$_REQUEST['chosenendday'];
      $this->endtime = gmmktime(24, 0, 0, $this->chosenendmonth, $this->chosenendday, $this->chosenendyear);
    }
    else {
      $this->endtime = 1.0E+20;
    }

    for ($i = 2008; $i <= (int)gmdate('Y'); $i++) {
      if (!isset($this->chosenstartyear)) $this->chosenstartyear = $i;
      $this->liststartyear[] = $i;
    }
    for ($i = 1; $i <= 12; $i++) {
      if (!isset($this->chosenstartmonth)) $this->chosenstartmonth = $i;
      $this->liststartmonth[] = $i;
    }
    for ($i = 1; $i <= 31; $i++) {
      if (!isset($this->chosenstartday)) $this->chosenstartday = $i;
      $this->liststartday[] = $i;
    }
    for ($i = (int)gmdate('Y'); $i >= 2008; $i--) {
      if (!isset($this->chosenendyear)) $this->chosenendyear = $i;
      $this->listendyear[] = $i;
    }
    for ($i = 12; $i >= 1; $i--) {
      if (!isset($this->chosenendmonth)) $this->chosenendmonth = $i;
      $this->listendmonth[] = $i;
    }
    for ($i = 31; $i >= 1; $i--) {
      if (!isset($this->chosenendday)) $this->chosenendday = $i;
      $this->listendday[] = $i;
    }
  }


  public function get_url_parameter() {
    return '&chosenstartyear=' . $_REQUEST['chosenstartyear']
         . '&chosenstartmonth=' . $_REQUEST['chosenstartmonth']
         . '&chosenstartday=' . $_REQUEST['chosenstartday']
         . '&chosenendyear=' . $_REQUEST['chosenendyear']
         . '&chosenendmonth=' . $_REQUEST['chosenendmonth']
         . '&chosenendday=' . $_REQUEST['chosenendday'];
  }


  public function choice_field() {
    $field = '';
    $field .= $this->select_choice_field('chosenstartyear', $this->liststartyear, $this->chosenstartyear) . '</td><td>';
    $field .= $this->select_choice_field('chosenstartmonth', $this->liststartmonth, $this->chosenstartmonth) . '</td><td>';
    $field .= $this->select_choice_field('chosenstartday', $this->liststartday, $this->chosenstartday) . '</td><td>';
    $field .= $this->select_choice_field('chosenendyear', $this->listendyear, $this->chosenendyear) . '</td><td>';
    $field .= $this->select_choice_field('chosenendmonth', $this->listendmonth, $this->chosenendmonth) . '</td><td>';
    $field .= $this->select_choice_field('chosenendday', $this->listendday, $this->chosenendday);

    return $field;
  }


  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if ($list_entry->datesubmitted < $this->starttime || $list_entry->datesubmitted > $this->endtime) {
        unset($list_to_filter[$index]);
        continue;
      }
    }
    return $list_to_filter;
  }
}


// 20140921 New filter for applications.php
class peoples_suspendedmmu_filter extends peoples_select_filter {

  public function filter_entries(array $list_to_filter) {
    global $DB;

    if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
      $peoplesmph2s = $DB->get_records_sql('SELECT userid, suspended, graduated FROM mdl_peoplesmph2');
      if (empty($peoplesmph2s)) {
        $peoplesmph2s = array();
      }

      foreach ($list_to_filter as $index => $list_entry) {

        if (!empty($list_entry->userid) && !empty($peoplesmph2s[$list_entry->userid])) {
          $peoplesmph2 = $peoplesmph2s[$list_entry->userid];
          $suspended = $peoplesmph2->suspended;
          $graduated = $peoplesmph2->graduated;
        }
        else {
          $suspended = FALSE;
          $graduated = FALSE;
        }

        if ($this->selectedvalue === 'Not Suspended' && $suspended) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Suspended'     && !$suspended) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Not Graduated' && $graduated) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Graduated'     && !$graduated) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Not Graduated or Suspended' && ($suspended || $graduated)) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// 20140921 New filter for applications.php
class peoples_notcurrentsemester_filter extends peoples_boolean_filter {

  public function filter_entries(array $list_to_filter) {
    global $DB;

    if ($this->selectedvalue) {

      $semester_current = $DB->get_record('semester_current', array('id' => 1));
      $semester_to_match = $semester_current->semester;

      $peoplesapplications = $DB->get_records_sql("SELECT DISTINCT userid FROM mdl_peoplesapplication WHERE semester='$semester_to_match'");
      if (empty($peoplesapplications)) {
        $peoplesapplications = array();
      }

      foreach ($list_to_filter as $index => $list_entry) {

        if (!empty($list_entry->userid) && !empty($peoplesapplications[$list_entry->userid])) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// 20140921 New filter for applications.php
class peoples_notprevioussemester_filter extends peoples_boolean_filter {

  public function filter_entries(array $list_to_filter) {
    global $DB;

    if ($this->selectedvalue) {

      $semester_current = $DB->get_record('semester_current', array('id' => 1));
      $semester_to_match = $semester_current->semester;

      $current = $semester_current->semester;
      $semesters = $DB->get_records('semesters', NULL, 'id ASC');
      foreach ($semesters as $semester) {
        if ($semester->semester !== $current) $semester_to_match = $semester->semester; // Find next to last (previous) semester
      }

      $peoplesapplications = $DB->get_records_sql("SELECT DISTINCT userid FROM mdl_peoplesapplication WHERE semester='$semester_to_match'");
      if (empty($peoplesapplications)) {
        $peoplesapplications = array();
      }

      foreach ($list_to_filter as $index => $list_entry) {

        if (!empty($list_entry->userid) && !empty($peoplesapplications[$list_entry->userid])) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// 20140930 New filter for applications.php
class peoples_income_category_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    global $DB;

    if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
      $peoples_income_category = $DB->get_records_sql("SELECT userid, income_category FROM mdl_peoples_income_category");
      if (empty($peoples_income_category)) {
        $peoples_income_category = array();
      }
    }

    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue !== 'Existing Student' && empty($list_entry->userid)) {
          unset($list_to_filter[$index]);
          continue;
        }
        if (empty($list_entry->userid)) {
          continue;
        }
        if ($this->selectedvalue === 'Existing Student' && !empty($peoples_income_category[$list_entry->userid]) && !empty($peoples_income_category[$list_entry->userid]->income_category)) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'LMIC' && empty($peoples_income_category[$list_entry->userid])) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'LMIC' && $peoples_income_category[$list_entry->userid]->income_category != 1) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'HIC' && empty($peoples_income_category[$list_entry->userid])) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'HIC' && $peoples_income_category[$list_entry->userid]->income_category != 2) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// Initially used by track_submissions.php
class peoples_mph_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'No' && $list_entry->mph != 0) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Yes' && ($list_entry->mph == 0)) { // removed " || $list_entry->mphsuspended != 0"
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'MMU MPH' && ($list_entry->mph != 1)) { // removed " || $list_entry->mphsuspended != 0"
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Peoples MPH' && ($list_entry->mph != 2)) { // removed " || $list_entry->mphsuspended != 0"
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'EUCLID MPH' && ($list_entry->mph != 3)) { // removed " || $list_entry->mphsuspended != 0"
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Not MMU MPH' && ($list_entry->mph == 1)) { // removed " || $list_entry->mphsuspended != 0"
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Not Peoples MPH' && ($list_entry->mph == 2)) { // removed " || $list_entry->mphsuspended != 0"
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Not EUCLID MPH' && ($list_entry->mph == 3)) { // removed " || $list_entry->mphsuspended != 0"
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// Initially used by track_submissions.php
class peoples_submission_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'Not submitted'              &&  $list_entry->submissionstatus === 'submitted') {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted'                  &&  $list_entry->submissionstatus !== 'submitted') {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted, No Final Grade'  && ($list_entry->submissionstatus !== 'submitted' || (($list_entry->grade !== '') && ($list_entry->time_of_submissiontime < $list_entry->time_of_last_assignmentgrade) && ($list_entry->time_of_submissiontime < $list_entry->time_modified_grade)))) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted, Final Grade <50' && ($list_entry->submissionstatus !== 'submitted' || $list_entry->grade === '' || $list_entry->grade >= 50)) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted, Final Grade =0'  && ($list_entry->submissionstatus !== 'submitted' || $list_entry->grade === '' || ($list_entry->grade !== 0 && $list_entry->grade !== '0'))) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted, Outside Due/Extension' && ($list_entry->submissionstatus !== 'submitted' || empty($list_entry->due) || ($list_entry->due === '1970-01-01') || ($list_entry->submissiontime <= $list_entry->due) || (!empty($list_entry->extension) && ($list_entry->submissiontime <= $list_entry->extension)))) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


class peoples_resubmission_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'Yes' && stripos($list_entry->assignment, 'Resubmission') === false) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'No'  && stripos($list_entry->assignment, 'Resubmission') !== false) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// Initially used by education_committee_report.php
class peoples_date_filter extends peoples_filter {
  protected $starttime;
  protected $liststartyear = array();
  protected $liststartmonth = array();
  protected $liststartday = array();


  function __construct($human_name) {
    $this->human_name = $human_name; // Needs </td><td> between the 3 columns

    if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
      $this->chosenstartyear = (int)$_REQUEST['chosenstartyear'];
      $this->chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
      $this->chosenstartday = (int)$_REQUEST['chosenstartday'];
      $this->starttime = gmmktime(0, 0, 0, $this->chosenstartmonth, $this->chosenstartday, $this->chosenstartyear);
    }
    else {
      $this->starttime = 0;
    }
    $this->selectedvalue = $this->starttime;

    for ($i = 2008; $i <= (int)gmdate('Y'); $i++) {
      if (!isset($this->chosenstartyear)) $this->chosenstartyear = $i;
      $this->liststartyear[] = $i;
    }
    for ($i = 1; $i <= 12; $i++) {
      if (!isset($this->chosenstartmonth)) $this->chosenstartmonth = $i;
      $this->liststartmonth[] = $i;
    }
    for ($i = 1; $i <= 31; $i++) {
      if (!isset($this->chosenstartday)) $this->chosenstartday = $i;
      $this->liststartday[] = $i;
    }
  }


  public function get_url_parameter() {
    return '&chosenstartyear=' . $_REQUEST['chosenstartyear']
         . '&chosenstartmonth=' . $_REQUEST['chosenstartmonth']
         . '&chosenstartday=' . $_REQUEST['chosenstartday'];
  }


  public function choice_field() {
    $field = '';
    $field .= $this->select_choice_field('chosenstartyear', $this->liststartyear, $this->chosenstartyear) . '</td><td>';
    $field .= $this->select_choice_field('chosenstartmonth', $this->liststartmonth, $this->chosenstartmonth) . '</td><td>';
    $field .= $this->select_choice_field('chosenstartday', $this->liststartday, $this->chosenstartday);

    return $field;
  }
}


// Initially used by education_committee_report.php
class peoples_mph_dissertation_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'Yes' && empty($list_entry->dissertation_grade_available)) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'No' && !empty($list_entry->dissertation_grade_available)) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}
?>
