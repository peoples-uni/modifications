<?php  // $Id: peoplescertificate.php,v 1.1 2008/11/28 20:00:00 alanbarrett Exp $

require_once('../config.php');
include 'fpdf/fpdf.php';
include 'fpdf/fpdfprotection.php';
include_once('html2pdf.php');
require_once($CFG->dirroot .'/course/peoples_awards_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/peoplescertificate.php'); // Defined here to avoid notices on errors etc
$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {
  print_error('invaliduser');
}

$cert = required_param('cert', PARAM_ALPHA);
$nopercentage = optional_param('nopercentage', 0, PARAM_INT);
$nomodules = optional_param('nomodules', 0, PARAM_INT);

$signatureleft = 130;
$signatureleft = 80;


if ($cert == 'transcript') {
	//$enrol = get_record_sql("SELECT e.semester, g.finalgrade
	//FROM mdl_enrolment e, mdl_course c, mdl_grade_grades g, mdl_grade_items i
	//WHERE e.courseid=$courseid AND e.userid=$userid AND c.id=$courseid
	//AND g.userid=$userid AND g.itemid=i.id AND i.itemtype='course' AND i.courseid=$courseid");

	$enrolid = required_param('enrolid', PARAM_INT);
  $enrol = $DB->get_record_sql("SELECT e.semester, e.userid, e.courseid, e.notified, e.datenotified, e.percentgrades, g.finalgrade
	FROM mdl_enrolment e, mdl_course c, mdl_grade_grades g, mdl_grade_items i
	WHERE e.id=$enrolid AND e.courseid=c.id AND e.userid=g.userid AND g.itemid=i.id AND i.itemtype='course' AND e.courseid=i.courseid");
	if (empty($enrol)) {
    print_error('invalidarguments');
		//Test with no grade: $enrol = get_record_sql("SELECT e.semester, e.userid, e.courseid, e.notified FROM mdl_enrolment e, mdl_course c WHERE e.id=$enrolid AND e.courseid=c.id");
		//$enrol->finalgrade = 1.0;
		//$enrol->notified = 1;
	}

	$userid = $enrol->userid;
  if (!$userrecord = $DB->get_record('user', array('id' => $userid))) {
    print_error('invaliduser');
	}

	$courseid = $enrol->courseid;
  if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('cannotfindcourse');
	}

	//$cert = required_param('cert', PARAM_NOTAGS);
	//if (!$certificate = get_record('certificate', 'name', $cert)) {
	//	error('certificate was not found');
	//}
	$certificate = new object();
	$certificate->name = 'Academic Transcript';
	$certificate->borderstyle = 'Fancy2-black.jpg';
	$certificate->bordercolor = '3';
	$certificate->printwmark = '';
	$certificate->printwmark = 'Crest.png';
	$certificate->printwmark = 'tapestry_logo.jpg';
	$certificate->printwmark = 'temp-logo-updatwashout-BandW.jpg';
	$certificate->printdate = '2';
	$certificate->datefmt = '2';
	$certificate->printsignature1 = 'RVincent.png';
	$certificate->printsignature1 = 'dicksignature.jpg';
	$certificate->printsignature2 = 'rajansignature.jpg';
	$certificate->printseal = 'Logo.png';
	$certificate->printseal = 'tapestry_logo.jpg';
	$certificate->printseal = '';

  $isteacher = is_peoples_teacher();
	if (!$isteacher && ($userid != $USER->id)) {
    print_error('cannotuseadminadminorteacher');
	}

  if (empty($enrol->finalgrade) || !(($enrol->percentgrades == 0 && $enrol->finalgrade <= 1.99999) || ($enrol->percentgrades == 1 && $enrol->finalgrade > 44.99999)) || ($enrol->notified != 1)) {
    print_error('invalidarguments');
	}

	$certificatedate = '';
	//$certdate = certificate_generate_date($certificate, $course);
	$certdate = $enrol->datenotified;
	if ($certificate->printdate > 0) {
		if ($certificate->datefmt == 1) {
			$certificatedate = str_replace(' 0', ' ', strftime('%B %d, %Y', $certdate));
		}
		if ($certificate->datefmt == 2) {
			$certificatedate = date('F jS, Y', $certdate);
		}
		if ($certificate->datefmt == 3) {
			$certificatedate = str_replace(' 0', '', strftime('%d %B %Y', $certdate));
		}
		if ($certificate->datefmt == 4) {
			$certificatedate = strftime('%B %Y', $certdate);
		}
		if ($certificate->datefmt == 5) {
			$timeformat = get_string('strftimedate');
			$certificatedate = userdate($certdate, $timeformat);
	    }
	}


	// Add PDF page
	$orientation = 'L';
	$pdf= new PDF($orientation, 'pt', 'A4');
	$pdf->SetProtection(array('print'));
	$pdf->AddPage();

	// Add images and lines
	print_border($certificate->borderstyle, $orientation);
	draw_frame($certificate->bordercolor, $orientation);
	print_watermark($certificate->printwmark, $orientation);
	print_seal($certificate->printseal, $orientation, 590, 425, '', '');

	$pdf->SetTextColor(0, 0, 0);
	cert_printtext($signatureleft, 435, 'L', 'Helvetica', '', 10, utf8_decode('Coordinator, Professor Richard Heller'));
	print_signature($certificate->printsignature1, $orientation, $signatureleft, 440, '64', '31');
	cert_printtext($signatureleft, 475, 'L', 'Helvetica', '', 10, utf8_decode('Chair of the Trustees, Professor Rajan Madhok'));
	print_signature($certificate->printsignature2, $orientation, $signatureleft, 480, '59', '31');

	// Add text
	$pdf->SetTextColor(0, 0, 120);
	cert_printtext(170, 120, 'C', 'Helvetica','B', 30, utf8_decode('Academic Transcript'));
	$pdf->SetTextColor(0, 0, 0);
	cert_printtext(170, 160, 'C', 'Times',    'B', 20, utf8_decode('This is to certify that'));

	cert_printtext(170, 205, 'C', 'Helvetica', '', 30, utf8_decode(fullname($userrecord)));
	cert_printtext(170, 250, 'C', 'Helvetica', '', 20, utf8_decode('has successfully completed the course module'));
  $percent = '';
  if (!$nopercentage && $enrol->percentgrades == 1) {
    $percent = ' (Grade ' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
  }
  cert_printtext(170, 285, 'C', 'Helvetica', '', 20, utf8_decode($course->fullname . $percent . ','));
	cert_printtext(170, 320, 'C', 'Helvetica', '', 14, utf8_decode("one of the course modules in the People's Open Access Educational Initiative - Peoples-uni."));

  if ($certdate > 1291161600) { // December 1st 2010
    if (stripos($course->fullname , 'dissertation') === FALSE) { // Not Masters dissertation
      cert_printtext(170, 350, 'C', 'Helvetica', '', 14, utf8_decode('This carries 20 credits towards a Peoples-uni Certificate or Diploma,'));
      cert_printtext(170, 380, 'C', 'Helvetica', '', 14, utf8_decode(' and 10 credits towards the European Credit Transfer System.'));
    }
    else { // Masters dissertation
      cert_printtext(170, 350, 'C', 'Helvetica', '', 14, utf8_decode('This carries 60 credits towards a Peoples-uni Certificate or Diploma,'));
      cert_printtext(170, 380, 'C', 'Helvetica', '', 14, utf8_decode(' and 30 credits towards the European Credit Transfer System.'));
    }
  }
  else {
    cert_printtext(170, 350, 'C', 'Helvetica', '', 14, utf8_decode('This carries 15 credits towards a Peoples-uni Certificate or Diploma,'));
    cert_printtext(170, 380, 'C', 'Helvetica', '', 14, utf8_decode(' and 7.5 credits towards the European Credit Transfer System.'));
  }

	cert_printtext(170, 430, 'C', 'Helvetica', '', 14, utf8_decode($certificatedate));

	//$outcomes = get_records_sql("SELECT fullname
	//FROM mdl_grade_outcomes_courses goc, mdl_grade_outcomes go
	//WHERE goc.courseid=$courseid AND goc.outcomeid=go.id
	//ORDER BY fullname ASC");

	//$h = 409;
	//foreach ($outcomes as $outcome) {
	//	cert_printtext(170, $h, 'C', 'Times', '', 10, utf8_decode($outcome->fullname));
	//	$h += 11;
	//}

	cert_printtext(170, 475, 'C', 'Helvetica', '', 15, utf8_decode('Semester: ' . $enrol->semester));
	cert_printtext(170, 500, 'C', 'Helvetica', '', 10, utf8_decode(isset($course->idnumber) ? $course->idnumber : ''));
	cert_printtext(170, 500, 'R', 'Helvetica', '', 10, utf8_decode('http://peoples-uni.org'));

	//cert_printtext(150, 430, '', '', '', '', '');
	//$pdf->SetLeftMargin(130);
	//$pdf->WriteHTML('Custom Text');

	$filesafe = clean_filename($certificate->name.'.pdf');
	$pdf->Output($filesafe, 'I'); // open in browser
}
elseif ($cert == 'participation') {
	$enrolid = required_param('enrolid', PARAM_INT);
  $enrol = $DB->get_record_sql("SELECT e.semester, e.userid, e.courseid, e.notified, e.datenotified, e.percentgrades FROM mdl_enrolment e WHERE e.id=$enrolid");
	if (empty($enrol)) {
    print_error('invalidcourse');
	}

	$userid = $enrol->userid;
  if (!$userrecord = $DB->get_record('user', array('id' => $userid))) {
    print_error('invaliduser');
	}

	$courseid = $enrol->courseid;
  if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('cannotfindcourse');
	}

	$certificate = new object();
	$certificate->name = 'Certificate of Participation';
	$certificate->borderstyle = 'Fancy2-black.jpg';
	$certificate->bordercolor = '3';
	$certificate->printwmark = '';
	$certificate->printwmark = 'Crest.png';
	$certificate->printwmark = 'tapestry_logo.jpg';
	$certificate->printwmark = 'temp-logo-updatwashout-BandW.jpg';
	$certificate->printdate = '2';
	$certificate->datefmt = '2';
	$certificate->printsignature1 = 'RVincent.png';
	$certificate->printsignature1 = 'dicksignature.jpg';
	$certificate->printsignature2 = 'rajansignature.jpg';
	$certificate->printseal = 'Logo.png';
	$certificate->printseal = 'tapestry_logo.jpg';
	$certificate->printseal = '';

  $isteacher = is_peoples_teacher();
	if (!$isteacher && ($userid != $USER->id)) {
    print_error('cannotuseadminadminorteacher');
	}

	if ($enrol->notified != 3) {
    print_error('invalidarguments');
	}

	$certificatedate = '';
	$certdate = $enrol->datenotified;
	if ($certificate->printdate > 0) {
		if ($certificate->datefmt == 1) {
			$certificatedate = str_replace(' 0', ' ', strftime('%B %d, %Y', $certdate));
		}
		if ($certificate->datefmt == 2) {
			$certificatedate = date('F jS, Y', $certdate);
		}
		if ($certificate->datefmt == 3) {
			$certificatedate = str_replace(' 0', '', strftime('%d %B %Y', $certdate));
		}
		if ($certificate->datefmt == 4) {
			$certificatedate = strftime('%B %Y', $certdate);
		}
		if ($certificate->datefmt == 5) {
			$timeformat = get_string('strftimedate');
			$certificatedate = userdate($certdate, $timeformat);
	    }
	}


	// Add PDF page
	$orientation = 'L';
	$pdf= new PDF($orientation, 'pt', 'A4');
	$pdf->SetProtection(array('print'));
	$pdf->AddPage();

	// Add images and lines
	print_border($certificate->borderstyle, $orientation);
	draw_frame($certificate->bordercolor, $orientation);
	print_watermark($certificate->printwmark, $orientation);
	print_seal($certificate->printseal, $orientation, 590, 425, '', '');

	$pdf->SetTextColor(0, 0, 0);
	cert_printtext($signatureleft, 435, 'L', 'Helvetica', '', 10, utf8_decode('Coordinator, Professor Richard Heller'));
	print_signature($certificate->printsignature1, $orientation, $signatureleft, 440, '64', '31');
	cert_printtext($signatureleft, 475, 'L', 'Helvetica', '', 10, utf8_decode('Chair of the Trustees, Professor Rajan Madhok'));
	print_signature($certificate->printsignature2, $orientation, $signatureleft, 480, '59', '31');

	// Add text
	$pdf->SetTextColor(0, 0, 120);
	cert_printtext(170, 120, 'C', 'Helvetica','B', 30, utf8_decode('Certificate of Participation'));
	$pdf->SetTextColor(0, 0, 0);
	cert_printtext(170, 160, 'C', 'Times',    'B', 20, utf8_decode('This is to certify that'));

	cert_printtext(170, 205, 'C', 'Helvetica', '', 30, utf8_decode(fullname($userrecord)));
	cert_printtext(170, 250, 'C', 'Helvetica', '', 20, utf8_decode('has participated in the course module'));
	cert_printtext(170, 285, 'C', 'Helvetica', '', 20, utf8_decode($course->fullname . ','));
	cert_printtext(170, 320, 'C', 'Helvetica', '', 14, utf8_decode("one of the course modules in the People's Open Access Educational Initiative - Peoples-uni."));

	cert_printtext(170, 430, 'C', 'Helvetica', '', 14, utf8_decode($certificatedate));

	cert_printtext(170, 475, 'C', 'Helvetica', '', 15, utf8_decode('Semester: ' . $enrol->semester));
	cert_printtext(170, 500, 'C', 'Helvetica', '', 10, utf8_decode(isset($course->idnumber) ? $course->idnumber : ''));
	cert_printtext(170, 500, 'R', 'Helvetica', '', 10, utf8_decode('http://peoples-uni.org'));

	$filesafe = clean_filename($certificate->name.'.pdf');
	$pdf->Output($filesafe, 'I'); // open in browser
}
else {
	$userid = required_param('userid', PARAM_INT);

	$enrols = $DB->get_records_sql("SELECT * FROM
(SELECT e.*, c.fullname, c.idnumber, c.id AS cid FROM mdl_enrolment e, mdl_course c WHERE e.courseid=c.id AND e.userid=$userid) AS x
LEFT JOIN
(SELECT g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' AND g.userid=$userid) AS y
ON cid=icourseid
ORDER BY datefirstenrolled ASC, fullname ASC");


  $passed_or_cpd_enrol_ids = array();
  $modules = array();
  if ($nopercentage) {
    $modules[] = 'Modules completed:';
  }
  else {
    $modules[] = 'Modules completed (Grade):';
  }
  $percentages = array();
  $percentages[] = '';
  //$nopercentage is passed as parameter
  $lastestdate = 0;
  $cumulative_enrolled_ids_to_discount = array();
  $pass_type = array();
  $foundation_problems = array();
  $passes_notified_or_not = 0;
  $qualification = get_student_award($userid, $enrols, $passed_or_cpd_enrol_ids, $modules, $percentages, $nopercentage, $lastestdate, $cumulative_enrolled_ids_to_discount, $pass_type, $foundation_problems, $passes_notified_or_not);

  if (($cert == 'certificate') && ($qualification & 1)) {
    $award = 'Certificate in Public Health';
  }
  elseif (($cert == 'diploma') && ($qualification & 2)) {
    $award = 'Diploma in Public Health';
  }
  elseif ($cert == 'testcertificate') {
    $award = 'Certificate in Public Health';
    while (count($modules) < 5) $modules[] = 'Aaaaaaaaaaaaaaaaaaaaaaaaaa';
  }
  elseif ($cert == 'testdiploma') {
    $award = 'Diploma in Public Health';
    while (count($modules) < 9) $modules[] = 'Aaaaaaaaaaaaaaaaaaaaaaaaaa';
  }
  else {
    print_error('invalidarguments');
  }

  if (!$userrecord = $DB->get_record('user', array('id' => $userid))) {
    print_error('invaliduser');
	}

	$certificate = new object();
	$certificate->name = $award;
	$certificate->borderstyle = 'Fancy2-black.jpg';
	$certificate->bordercolor = '3';
	$certificate->printwmark = '';
	$certificate->printwmark = 'temp-logo-updatwashout-BandW.jpg';
	$certificate->printdate = '2';
	$certificate->datefmt = '2';
	$certificate->printsignature1 = 'dicksignature.jpg';
	$certificate->printsignature2 = 'rajansignature.jpg';
	$certificate->printseal = '';

  $isteacher = is_peoples_teacher();
	if (!$isteacher && ($userid != $USER->id)) {
    print_error('cannotuseadminadminorteacher');
	}

	$certificatedate = '';
	$certdate = $lastestdate;
	if ($certificate->printdate > 0) {
		if ($certificate->datefmt == 1) {
			$certificatedate = str_replace(' 0', ' ', strftime('%B %d, %Y', $certdate));
		}
		if ($certificate->datefmt == 2) {
			$certificatedate = date('F jS, Y', $certdate);
		}
		if ($certificate->datefmt == 3) {
			$certificatedate = str_replace(' 0', '', strftime('%d %B %Y', $certdate));
		}
		if ($certificate->datefmt == 4) {
			$certificatedate = strftime('%B %Y', $certdate);
		}
		if ($certificate->datefmt == 5) {
			$timeformat = get_string('strftimedate');
			$certificatedate = userdate($certdate, $timeformat);
	    }
	}


	// Add PDF page
	$orientation = 'L';
	$pdf= new PDF($orientation, 'pt', 'A4');
	$pdf->SetProtection(array('print'));
	$pdf->AddPage();

	// Add images and lines
	print_border($certificate->borderstyle, $orientation);
	draw_frame($certificate->bordercolor, $orientation);
	print_watermark($certificate->printwmark, $orientation);
	print_seal($certificate->printseal, $orientation, 590, 425, '', '');

	$pdf->SetTextColor(0, 0, 0);
	cert_printtext($signatureleft, 435, 'L', 'Helvetica', '', 10, utf8_decode('Coordinator, Professor Richard Heller'));
	print_signature($certificate->printsignature1, $orientation, $signatureleft, 440, '64', '31');
	cert_printtext($signatureleft, 475, 'L', 'Helvetica', '', 10, utf8_decode('Chair of the Trustees, Professor Rajan Madhok'));
	print_signature($certificate->printsignature2, $orientation, $signatureleft, 480, '59', '31');

	// Add text
	//$pdf->SetTextColor(0, 0, 120);
	//cert_printtext(170, 120, 'C', 'Helvetica','B', 30, utf8_decode($award));
	//$pdf->SetTextColor(0, 0, 0);
	cert_printtext(170, 120, 'C', 'Times',    'B', 20, utf8_decode('This is to certify that'));

	cert_printtext(170, 165, 'C', 'Helvetica', '', 30, utf8_decode(fullname($userrecord)));

  if ($nomodules) {
    cert_printtext(170, 235, 'C', 'Helvetica', '', 14, utf8_decode('has been awarded a'));
    $pdf->SetTextColor(0, 0, 120);
    cert_printtext(170, 270, 'C', 'Helvetica', '', 30, utf8_decode($award));
    $pdf->SetTextColor(0, 0, 0);
    cert_printtext(170, 305, 'C', 'Helvetica', '', 14, utf8_decode("by the People's Open Access Educational Initiative - Peoples-uni."));
  }
  else {
    cert_printtext(170, 200, 'C', 'Helvetica', '', 14, utf8_decode('has been awarded a'));
    $pdf->SetTextColor(0, 0, 120);
    cert_printtext(170, 235, 'C', 'Helvetica', '', 30, utf8_decode($award . ','));
    $pdf->SetTextColor(0, 0, 0);
    cert_printtext(170, 270, 'C', 'Helvetica', '', 14, utf8_decode("by the People's Open Access Educational Initiative - Peoples-uni."));
  }

	//cert_printtext(170, 350, 'C', 'Helvetica', '', 14, utf8_decode('This carries 15 credits towards a Peoples-uni Certificate or Diploma,'));
	//cert_printtext(170, 380, 'C', 'Helvetica', '', 14, utf8_decode(' and 7.5 credits towards the European Credit Transfer System.'));

	cert_printtext(170, 500, 'C', 'Helvetica', '', 14, utf8_decode($certificatedate));

	$h = 295;
	$firstdelta = 4;
  if ($nomodules) $modules = array();
	foreach ($modules as $index => $module) {
    cert_printtext(170, $h, 'C', 'Helvetica', '', 14, utf8_decode($module . $percentages[$index]));
		$h += 15 + $firstdelta;
		$firstdelta = 0;
	}

	//cert_printtext(170, 475, 'C', 'Helvetica', '', 15, utf8_decode('Semester: ' . $enrol->semester));
	//cert_printtext(170, 500, 'C', 'Helvetica', '', 10, utf8_decode(isset($course->idnumber) ? $course->idnumber : ''));
	cert_printtext(170, 500, 'R', 'Helvetica', '', 10, utf8_decode('http://peoples-uni.org'));

	//cert_printtext(150, 430, '', '', '', '', '');
	//$pdf->SetLeftMargin(130);
	//$pdf->WriteHTML('Custom Text');

	$filesafe = clean_filename($certificate->name.'.pdf');
	$pdf->Output($filesafe, 'I'); // open in browser
}


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
?>