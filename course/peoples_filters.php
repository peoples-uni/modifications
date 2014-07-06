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
        if ($this->selectedvalue !== 'No' && $this->selectedvalue !== 'Yes') {
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


// Initially used by track_submisisons.php
class peoples_mph_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'No' && $list_entry->mph != 0) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Yes' && ($list_entry->mph == 0 || $list_entry->mphsuspended != 0)) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}


// Initially used by track_submisisons.php
class peoples_submission_filter extends peoples_select_filter {
  public function filter_entries(array $list_to_filter) {
    foreach ($list_to_filter as $index => $list_entry) {
      if (!empty($this->selectedvalue) && $this->selectedvalue !== 'Any') {
        if ($this->selectedvalue === 'Not submitted' && $list_entry->submissionstatus === 'submitted') {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted' && $list_entry->submissionstatus !== 'submitted') {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted, No Final Grade' && ($list_entry->submissionstatus !== 'submitted' || $list_entry->grade !== '') {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted, Final Grade <50' && ($list_entry->submissionstatus !== 'submitted' || $list_entry->grade >= 50)) {
          unset($list_to_filter[$index]);
          continue;
        }
        if ($this->selectedvalue === 'Submitted, Final Grade =0' && ($list_entry->submissionstatus !== 'submitted' || $list_entry->grade === 0 || $list_entry->grade === '0')) {
          unset($list_to_filter[$index]);
          continue;
        }
      }
    }
    return $list_to_filter;
  }
}
?>
