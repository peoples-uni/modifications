<?php  // $Id: peoplestranscript.php,v 1.1 2017/09/05 17:00:00 alanbarrett Exp $

require_once('../config.php');
include 'fpdf/fpdf.php';
include 'fpdf/fpdfprotection.php';
include_once('html2pdf.php');
require_once($CFG->dirroot .'/course/peoples_awards_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/peoplestranscript.php'); // Defined here to avoid notices on errors etc
$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {
  print_error('invaliduser');
}
$userid = required_param('userid', PARAM_INT);
if (!$userrecord = $DB->get_record('user', array('id' => $userid))) {
  print_error('invaliduser');
}
if (!similar_name($userrecord)) {
  print_error('invaliduser');
}
$isteacher = is_peoples_teacher();
if (!$isteacher && ($userid != $USER->id)) {
  print_error('cannotuseadminadminorteacher');
}


$enrols = $DB->get_records_sql("SELECT * FROM
(SELECT e.*, c.fullname, c.idnumber, c.id AS cid FROM mdl_enrolment e, mdl_course c WHERE e.courseid=c.id AND e.userid=$userid) AS x
LEFT JOIN
(SELECT g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' AND g.userid=$userid) AS y
ON cid=icourseid
ORDER BY datefirstenrolled ASC, fullname ASC");
if (empty($enrols)) $enrols = array();

$enrol_list = array();
foreach ($enrols as $enrol) {
  $found = preg_match('/^([A-Z]{4,})([012][0-9][AB]?)/', str_replace('010A', '10A', strtoupper($enrol->idnumber)), $matches);
  if ($found) {
    $code = $matches[1];
    $semester_text = '20' . strtolower($matches[2]);
  }
  else {
    $code = '';
    $semester_text = '';
  }

  if ($code == 'PUDISS') {
    $credits = 60;
  }
  else {
    $credits = 20;
  }

  $enrol_list[$enrol->fullname] = array('code' => $code, 'semester' => $semester_text, 'credits' => $credits, 'id' => $enrol->id);
}


$passed_or_cpd_enrol_ids = array();
$modules = array();
$percentages = array();
$percentages = array();
$nopercentage = false;
$lastestdate = 0;
$cumulative_enrolled_ids_to_discount = array();
$pass_type = array();
$foundation_problems = array();
$passes_notified_or_not = 0;
$qualification = get_student_award($userid, $enrols, $passed_or_cpd_enrol_ids, $modules, $percentages, $nopercentage, $lastestdate, $cumulative_enrolled_ids_to_discount, $pass_type, $foundation_problems, $passes_notified_or_not);


$certificate = new stdClass();
$certificate->borderstyle = 'Fancy2-black.jpg';
$certificate->bordercolor = '3';
$certificate->printwmark = '';
$certificate->printwmark = 'temp-logo-updatwashout-BandW.jpg';
$certificate->printdate = '2';
$certificate->datefmt = '2';
$certificate->printsignature1 = 'dicksignature.jpg';
$certificate->printsignature2 = 'rajansignature.jpg';
$certificate->printseal = '';

$certificatedate = '';
$certdate = $lastestdate;

$award = '';
$peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $userid));
$award_postfix = '';
// 20180616 changed from Peoples MPH only: (!empty($peoplesmph2->graduated) && $peoplesmph2->mphstatus == 2)
if (!empty($peoplesmph2->graduated)) {
  $certdate = time();
  $found = preg_match('/^Starting (January|February|March|April|May|June|July|August|September|October|November|December) ([0-9]{4,4})$/', $peoplesmph2->semester_graduated, $matches);
  if ($found) {
    $year = $matches[2];
    $month = $matches[1];
    if ($month == 'January' || $month == 'February' || $month == 'March' || $month == 'April' || $month == 'May' || $month == 'June') {
      $month = 9;
      $day = 30;
    }
    else {
      $year++;
      $month = 2;
      $day = 28;
    }
    $certdate = gmmktime(0, 0, 0, $month, $day, $year);
  }

  if     ($peoplesmph2->graduated == 2) $award_postfix = ' (Merit)';
  elseif ($peoplesmph2->graduated == 3) $award_postfix = ' (Distinction)';

  $award = 'Masters-Level in Public Health' . $award_postfix;
}
elseif ($qualification & 2) {
  $award = 'Postgraduate Diploma-Level in Public Health';
}
elseif ($qualification & 1) {
  $award = 'Postgraduate Certificate-Level in Public Health';
}

$certificate->name = $award;

$certificatedate = date('F jS, Y', $certdate);


// Add PDF page
$orientation = 'P';
$pdf= new PDF($orientation, 'pt', 'A4');
$pdf->SetProtection(array('print'));
$pdf->AddPage();

// Add images and lines
print_border($certificate->borderstyle, $orientation);
draw_frame($certificate->bordercolor, $orientation);
print_watermark($certificate->printwmark, $orientation);
print_seal($certificate->printseal, $orientation, 590, 425, '', '');

$pdf->SetTextColor(0, 0, 0);

$signatureleft = 80 - 15;
$h = 60;
$size_header = 12;
$size_words = 10;
$size_modules = 11;
$size_title = 10;

print_signature('PeopleUniOrg_Logo.jpg', $orientation, $signatureleft, $h, '111', '74');
$h += 5;

cert_printtext($signatureleft +  55, $h, 'C', 'Helvetica', 'B', $size_header, utf8_decode("PEOPLE'S OPEN ACCESS EDUCATION INITIATIVE"));
$h += 20;
cert_printtext($signatureleft +  55, $h, 'C', 'Helvetica', 'I', $size_header, utf8_decode('UK Charity Registration number: 1126265'));
$h += 15;
cert_printtext($signatureleft +  55, $h, 'C', 'Helvetica', 'I', $size_header, utf8_decode('education@helpdesk.peoples-uni.org'));
$h += 20;
cert_printtext($signatureleft +  55, $h, 'C', 'Helvetica', 'B', $size_header, utf8_decode('STUDENT TRANSCRIPT'));
$h += 50;

cert_printtext($signatureleft,       $h, 'L', 'Helvetica', '', $size_header, utf8_decode('NAME:'));
$in = 210+30;
cert_printtext($signatureleft + $in, $h, 'L', 'Helvetica', '', $size_header, utf8_decode(proper_case_if_necessary($userrecord)));
$h += 20;

$dobid = false;
$dob = '';
$prof = $DB->get_record('user_info_field', array('shortname' => 'dateofbirth'));
if (!empty($prof->id)) $dobid = $prof->id;
if ($dobid) {
  $data = $DB->get_record('user_info_data', array('userid' => $userid, 'fieldid' => $dobid));
  if (!empty($data->data)) {
    $dob = $data->data;
  }
}

//cert_printtext($signatureleft,       $h, 'L', 'Helvetica', '', $size_header, utf8_decode('DATE OF BIRTH:'));
//cert_printtext($signatureleft + $in, $h, 'L', 'Helvetica', '', $size_header, utf8_decode($dob));
//$h += 20;

cert_printtext($signatureleft,       $h, 'L', 'Helvetica', '', $size_header, utf8_decode('STUDENT IDENTIFICATION NO:'));
cert_printtext($signatureleft + $in, $h, 'L', 'Helvetica', '', $size_header, utf8_decode("$userid"));
$h += 20;

$semester = '';
foreach ($enrols as $enrol) {
  $semester = str_replace('Starting ', '', $enrol->semester);
  break;  
}
cert_printtext($signatureleft,       $h, 'L', 'Helvetica', '', $size_header, utf8_decode('FIRST ENROLLED WITH PEOPLES-UNI:'));
cert_printtext($signatureleft + $in, $h, 'L', 'Helvetica', '', $size_header, utf8_decode($semester));
$h += 20;

if (!empty($peoplesmph2->mphstatus)) {
  cert_printtext($signatureleft,     $h, 'L', 'Helvetica', '', $size_header, utf8_decode('PROGRAMME OF STUDY:    MASTERS-LEVEL PROGRAMME IN PUBLIC HEALTH'));
  //cert_printtext($signatureleft + $in, $h, 'L', 'Helvetica', '', $size_header, utf8_decode('MASTERS-LEVEL PROGRAMME IN PUBLIC HEALTH'));
  $h += 20;
}
$h += 10;
 
cert_printtext($signatureleft,       $h, 'L', 'Helvetica', '',  $size_words, utf8_decode('This transcript provides details of Courses undertaken by the above named student at Peoples-Uni.'));
$h += 12;
cert_printtext($signatureleft,       $h, 'L', 'Helvetica', '',  $size_words, utf8_decode('Courses studied, results obtained, credit value of module and an overall summary are presented below.'));
$h += 40;

$d1 = 0;
$d2 = 45 + 10;
$d3 = 95 + 7;
$d4 = 160;
$d5 = 385;
$d6 = 420;
cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica', 'B', $size_title, utf8_decode('COURSE'));
$h += 12;
cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica', 'B', $size_title, utf8_decode('CODE'));
cert_printtext($signatureleft + $d2, $h, 'L', 'Helvetica', 'B', $size_title, utf8_decode('CREDITS'));
cert_printtext($signatureleft + $d3, $h, 'L', 'Helvetica', 'B', $size_title, utf8_decode('SEMESTER'));
cert_printtext($signatureleft + $d4, $h, 'L', 'Helvetica', 'B', $size_title, utf8_decode('TITLE'));
//cert_printtext($signatureleft + $d5, $h, 'L', 'Helvetica', 'B', $size_title, utf8_decode('GRADE (%)'));
cert_printtext($signatureleft + $d5, $h, 'L', 'Helvetica', 'B', $size_title, utf8_decode('RESULT'));
$h += 15;

$credit_total = 0;
foreach ($modules as $index => $module) {
  cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica', '', $size_title, utf8_decode($enrol_list[$module]['code']));

  cert_printtext($signatureleft + $d2, $h, 'L', 'Helvetica', '', $size_title, utf8_decode($enrol_list[$module]['credits']));

  $credit_total += $enrol_list[$module]['credits'];
  cert_printtext($signatureleft + $d3, $h, 'L', 'Helvetica', '', $size_title, utf8_decode($enrol_list[$module]['semester']));

  $module_cut = $module;
  $pos = strpos($module_cut, ':'); // Shorten
  if ($pos !== false) $module_cut = substr($module_cut, 0, $pos);
  $found = preg_match('/^(.{10,})( [012][0-9][abAB])/', $module_cut, $matches); // Remove e.g. 17b
  if ($found) $module_cut = $matches[1];
  $module_cut = str_replace('Inequalities and The Social Determinants of Health', 'Inequalities and Social Determinants of Health', $module_cut); // Save space
  $module_cut = str_replace('Conceptos de Salud Pública para la Elaboración de Políticas', 'Elaboración de Políticas', $module_cut); // Save space
  cert_printtext($signatureleft + $d4, $h, 'L', 'Helvetica', '', $size_title, utf8_decode($module_cut));

  //cert_printtext($signatureleft + $d5, $h, 'L', 'Helvetica', '', $size_title, utf8_decode($percentages[$index]));

  cert_printtext($signatureleft + $d5, $h, 'L', 'Helvetica', '', $size_title, utf8_decode($pass_type[$enrol_list[$module]['id']]));
  $h += 15;
}
$h += 10;

cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica', 'B', $size_modules, utf8_decode("Credits Obtained:    $credit_total"));
$h += 15;
$h += 20;

cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica', 'B', $size_modules, utf8_decode("OVERALL SUMMARY"));
$h += 20;
cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica',  '', $size_modules, utf8_decode("Peoples-uni Academic Achievement Award:"));

$d7 = 220;
cert_printtext($signatureleft + $d7, $h, 'L', 'Helvetica', 'B', $size_modules, utf8_decode($award));
$h += 20;

cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica',  '', $size_modules, utf8_decode("Date awarded:"));
if (empty($award)) $certificatedate = '';
cert_printtext($signatureleft + $d7, $h, 'L', 'Helvetica', 'B', $size_modules, utf8_decode($certificatedate));
$h += 20;

cert_printtext($signatureleft + $d1, $h, 'L', 'Helvetica',  '', $size_modules, utf8_decode("Total credits:"));
cert_printtext($signatureleft + $d7, $h, 'L', 'Helvetica', 'B', $size_modules, utf8_decode("$credit_total"));
$h += 20;
$h += 20;
$h += 20;


cert_printtext($signatureleft, $h, 'L', 'Helvetica', '', 10, utf8_decode('Coordinator, Professor Richard Heller'));
$h += 5;
print_signature($certificate->printsignature1, $orientation, $signatureleft, $h, '64', '31');
$h += 45;
cert_printtext($signatureleft, $h, 'L', 'Helvetica', '', 10, utf8_decode('Chair of the Trustees, Professor Rajan Madhok'));
$h += 5;
print_signature($certificate->printsignature2, $orientation, $signatureleft, $h, '59', '31');
$h += 45;

if (!empty($peoplesmph2->entitled) && $peoplesmph2->entitled == 1) {
  cert_printtext($signatureleft + 200, $h + 15, 'L', 'Helvetica', '', 10, utf8_decode('In partnership with'.$h));
  print_signature('euclidlogo-120.png', $orientation, $signatureleft + 400, $h, '180', '60');
}


$filesafe = clean_filename($certificate->name.'.pdf');
$pdf->Output($filesafe, 'I'); // open in browser


/************************************************************************
* Sends text to output given the following params.                      *
* @param int $x horizontal position in pixels                           *
* @param int $y vertical position in pixels                             *
* @param char $align L=left, C=center, R=right                          *
* @param string $font any available font in font directory              *
* @param char $style ''=normal, B=bold, I=italic, U=underline           *
* @param int $size font size in points                                  *
* @param string $text the text to print                                 *
* @return null                                                          *
 ************************************************************************/
function cert_printtext( $x, $y, $align, $font, $style, $size, $text) {
    global $pdf;
    $pdf->setFont("$font", "$style", $size);
    $pdf->SetXY( $x, $y);
    $pdf->Cell( 500, 0, "$text", 0, 1, "$align");
}

/************************************************************************
 * Creates rectangles for line border.                                  *
 ************************************************************************/
function draw_frame($certificate, $orientation) {
    global $pdf, $certificate;

    if($certificate->bordercolor == 0)    {
    } else if($certificate->bordercolor > 0)    { //do nothing

        switch ($orientation) {
            case 'L':

    // create outer line border in selected color
        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0); //black
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51); //brown
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204); //blue
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0); //green
        }
            $pdf->Rect( 26, 30, 790, 530, 'F');
             //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 32, 36, 778, 518, 'F');

    // create middle line border in selected color
            if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0);
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51);
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204);
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0);
        }
            $pdf->Rect( 41, 45, 760, 500, 'F');
             //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 42, 46, 758, 498, 'F');

    // create inner line border in selected color
        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0);
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51);
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204);
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0);
        }
            $pdf->Rect( 52, 56, 738, 478, 'F');
             //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 56, 60, 730, 470, 'F');
            break;

            case 'P':
    // create outer line border in selected color
        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0); //black
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51); //brown
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204); //blue
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0); //green
        }
            $pdf->Rect( 20, 20, 560, 800, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 26, 26, 548, 788, 'F');

    // create middle line border in selected color
            if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0);
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51);
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204);
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0);
        }
            $pdf->Rect( 35, 35, 530, 770, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 36, 36, 528, 768, 'F');

    // create inner line border in selected color
        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0);
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51);
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204);
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0);
        }
            $pdf->Rect( 46, 46, 508, 748, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 50, 50, 500, 740, 'F');
            break;
        }
    }
}

/************************************************************************
 * Creates rectangles for line border for letter size paper.            *
 ************************************************************************/
function draw_frame_letter($certificate, $orientation) {
    global $pdf, $certificate;

    if($certificate->bordercolor == 0)    {
    } elseif($certificate->bordercolor > 0) { //do nothing

        switch ($orientation) {
            case 'L':
    // create outer line border in selected color
        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0); //black
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51); //brown
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204); //blue
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0); //green
        }
            $pdf->Rect( 26, 25, 741, 555, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 32, 31, 729, 542, 'F');

    // create middle line border in selected color
            if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0);
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51);
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204);
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0);
        }
            $pdf->Rect( 41, 40, 711, 525, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 42, 41, 709, 523, 'F');

    // create inner line border in selected color
        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0);
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51);
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204);
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0);
        }
            $pdf->Rect( 52, 51, 689, 503, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 56, 55, 681, 495, 'F');
            break;

            case 'P':
        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0); //black
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51); //brown
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204); //blue
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0); //green
        }
            $pdf->Rect( 25, 20, 561, 751, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 31, 26, 549, 739, 'F');

        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0); //black
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51); //brown
        }
            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204); //blue
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0); //green
        }
            $pdf->Rect( 40, 35, 531, 721, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 41, 36, 529, 719, 'F');

        if ($certificate->bordercolor == 1)    {
            $pdf->SetFillColor( 0, 0, 0); //black
        }
            if ($certificate->bordercolor == 2)    {
            $pdf->SetFillColor(153, 102, 51); //brown
        }

            if ($certificate->bordercolor == 3)    {
            $pdf->SetFillColor( 0, 51, 204); //blue
        }
            if ($certificate->bordercolor == 4)    {
            $pdf->SetFillColor( 0, 180, 0); //green
        }
            $pdf->Rect( 51, 46, 509, 699, 'F');
            //white rectangle
            $pdf->SetFillColor( 255, 255, 255);
            $pdf->Rect( 55, 50, 501, 691, 'F');
            break;
        }
    }
}

/************************************************************************
 * Prints border images from the borders folder in PNG or JPG formats.  *
 ************************************************************************/
function print_border($border, $orientation) {
    global $CFG, $pdf;

    switch($border) {
        case '0':
        case '':
        break;
        default:
        switch ($orientation) {
            case 'L':
        if(file_exists("$border")) {
            $pdf->Image( "$border", 10, 10, 820, 580);
        }
        break;
            case 'P':
        if(file_exists("$border")) {
            $pdf->Image( "$border", 10, 10, 580, 820);
            }
            break;
        }
        break;
    }
}

/************************************************************************
 * Prints border images for letter size paper.                          *
 ************************************************************************/
function print_border_letter($border, $orientation) {
    global $CFG, $pdf;

    switch($border) {
        case '0':
        case '':
        break;
        default:
        switch ($orientation) {
            case 'L':
        if(file_exists("$border")) {
            $pdf->Image( "$border", 12, 10, 771, 594);
        }
        break;
            case 'P':
        if(file_exists("$border")) {
            $pdf->Image("$border", 10, 10, 594, 771);
            }
            break;
        }
        break;
    }
}

/************************************************************************
 * Prints watermark images.                                             *
 ************************************************************************/
function print_watermark($wmark, $orientation) {
    global $CFG, $pdf;

    switch($wmark) {
        case '0':
        case '':
        break;
        default:
        switch ($orientation) {
            case 'L':
            if(file_exists("$wmark")) {
                $pdf->Image("$wmark", 122, 90, 600, 420);
            }
            break;
            case 'P':
            if(file_exists("$wmark")) {
                $pdf->Image("$wmark", 78, 130, 450, 480);
            }
            break;
        }
        break;
    }
}

/************************************************************************
 * Prints watermark images for letter size paper.                       *
 ************************************************************************/
function print_watermark_letter($wmark, $orientation) {
    global $CFG, $pdf;

    switch($wmark) {
        case '0':
        case '':
        break;
        default:
        switch ($orientation) {
            case 'L':
            if(file_exists("$wmark")) {
                $pdf->Image("$wmark", 160, 110, 500, 400);
            }
            break;
            case 'P':
            if(file_exists("$wmark")) {
                $pdf->Image("$wmark", 83, 130, 450, 480);
            }
            break;
        }
        break;
    }
}

/************************************************************************
 * Prints signature images or a line.                                   *
 ************************************************************************/
function print_signature($sig, $orientation, $x, $y, $w, $h) {
    global $CFG, $pdf;

    switch ($orientation) {
        case 'L':
        switch($sig) {
            case '0':
            case '':
            break;
            default:
            if(file_exists("$sig")) {
                $pdf->Image("$sig", $x, $y, $w, $h);
            }
            break;
        }
        break;
        case 'P':
        switch($sig) {
            case '0':
            case '':
            break;
            default:
            if(file_exists("$sig")) {
                $pdf->Image("$sig", $x, $y, $w, $h);
            }
            break;
        }
        break;
    }
}

/************************************************************************
 * Prints seal images.                                                  *
 ************************************************************************/
function print_seal($seal, $orientation, $x, $y, $w, $h) {
    global $CFG, $pdf;

    switch($seal) {
        case '0':
        case '':
        break;
        default:
        switch ($orientation) {
            case 'L':
            if(file_exists("$seal")) {
                $pdf->Image("$seal", $x, $y, $w, $h);
            }
            break;
            case 'P':
            if(file_exists("$seal")) {
                $pdf->Image("$seal", $x, $y, $w, $h);
            }
            break;
        }
        break;
    }
}

/************************************************************************
 * Prepare to be print the date -- defaults to time.                    *
 ************************************************************************/
function certificate_generate_date($certificate, $course) {
    $timecreated = time();
    if($certificate->printdate == '0')    {
    $certdate = $timecreated;
    }
        if ($certificate->printdate == '1') {
            $certdate = $timecreated;
        }
        if ($certificate->printdate == '2') {
            if ($course->enrolenddate) {
            $certdate = $course->enrolenddate;
        } else $certdate = $timecreated;
        }
return $certdate;
}


function is_peoples_teacher() {
  global $USER;
  global $DB;

  /* All Teacher, Teachers...
  SELECT u.lastname, r.name, c.fullname
  FROM mdl_user u, mdl_role_assignments ra, mdl_role r, mdl_context con, mdl_course c
  WHERE
  u.id=ra.userid AND
  ra.roleid=r.id AND
  ra.contextid=con.id AND
  r.name IN ('Teacher', 'Teachers') AND
  con.contextlevel=50 AND
  con.instanceid=c.id ORDER BY c.fullname, r.name;
  */

  $teachers = $DB->get_records_sql("
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/grade:viewall', context_system::instance())) return true; // Added for Lurker Role
  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}


function proper_case_if_necessary($userrecord) {
  $modified = false;

  $all_lower = "/^([a-z][a-z\']*)([ ,\.\-]*[a-z][a-z\']*)*[ ,\.\-]*$/";
  $all_upper = "/^([A-Z][A-Z\']*)([ ,\.\-]*[A-Z][A-Z\']*)*[ ,\.\-]*$/";

  $first = $userrecord->firstname;
  if (preg_match($all_lower, $first) || preg_match($all_upper, $first)) {
    $modified = true;
    $first = ucwords(strtolower($first), " ,.-");
  }

  $last = $userrecord->lastname;
  if (preg_match($all_lower, $last) || preg_match($all_upper, $last)) {
    $modified = true;
    $last = ucwords(strtolower($last), " ,.-");
  }

  if ($modified) return $first . ' ' . $last;
  else           return fullname($userrecord);
}


// Security check that someone is not temporarily changing their name to print certificates for others
function similar_name($userrecord) {
  global $DB;

  $peoplesregistration = $DB->get_record('peoplesregistration', array('userid' => $userrecord->id));
  if (empty($peoplesregistration)) return true;

  $percent = 0.0;
  similar_text(strtolower($userrecord->firstname . ' ' . $userrecord->lastname), strtolower($peoplesregistration->firstname . ' ' . $peoplesregistration->lastname), $percent);
  return $percent > 40.0;
}
?>