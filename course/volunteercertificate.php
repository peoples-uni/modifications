<?php  // $Id: volunteercertificate.php,v 1.1 2009/04/16 15:16:00 alanbarrett Exp $

require_once('../config.php');
include 'fpdf/fpdf.php';
include 'fpdf/fpdfprotection.php';
include_once('html2pdf.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/volunteercertificate.php');
$PAGE->set_pagelayout('embedded');


$id = required_param('id', PARAM_INT);

$volunteercertificate = $DB->get_record('volunteercertificate', array('id' => $id));
if (empty($volunteercertificate)) {
  print_error('invalidarguments');
}

$certificate = new object();
$certificate->name = 'Certificate';
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

$url_to_display = 'http://peoples-uni.org';
$name_to_display = 'Coordinator, Professor Richard Heller';

if ($volunteercertificate->wikitox_certificate) {
  $url_to_display = 'http://wikitox.peoples-uni.org';
  $name_to_display = 'Professor Andrew H Dawson';
  $certificate->printsignature1 = 'dawsonsignature.jpg';
  $certificate->printsignature2 = '';
  $certificate->printwmark = 'Toxicology certificate wash.jpg';
}


$certificatedate = '';
$certdate = $volunteercertificate->datecreated;
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
cert_printtext(130, 435, 'L', 'Helvetica', '', 10, utf8_decode($name_to_display));
print_signature($certificate->printsignature1, $orientation, 130, 440, '64', '31');
if (!empty($certificate->printsignature2)) {
  cert_printtext(130, 475, 'L', 'Helvetica', '', 10, utf8_decode('Chair of the Trustees, Professor Rajan Madhok'));
  print_signature($certificate->printsignature2, $orientation, 130, 480, '59', '31');
}

// Add text
$pdf->SetTextColor(0, 0, 120);
cert_printtext(170, 120, 'C', 'Helvetica','B', 30, utf8_decode($volunteercertificate->title));
$pdf->SetTextColor(0, 0, 0);
//cert_printtext(170, 160, 'C', 'Times',    'B', 20, utf8_decode('This is to certify that'));

if (!empty($volunteercertificate->second_title)) {
  cert_printtext(170, 160, 'C', 'Helvetica', '', 20, utf8_decode($volunteercertificate->second_title));
  $delta = 45;
  $delta2 = -15;
}
else {
  $delta = 0;
  $delta2 = 0;
}
cert_printtext(170, 160 + $delta, 'C', 'Helvetica',    '', 20, utf8_decode('This is to certify that'));

cert_printtext(170, 205 + $delta, 'C', 'Helvetica', '', 30, utf8_decode($volunteercertificate->name));
//cert_printtext(170, 250, 'C', 'Helvetica', '', 20, utf8_decode($volunteercertificate->body1));
//cert_printtext(170, 285, 'C', 'Helvetica', '', 20, utf8_decode($volunteercertificate->body2));
//cert_printtext(170, 320, 'C', 'Helvetica', '', 14, utf8_decode($volunteercertificate->body3));
//cert_printtext(170, 350, 'C', 'Helvetica', '', 14, utf8_decode($volunteercertificate->body4));
//cert_printtext(170, 380, 'C', 'Helvetica', '', 14, utf8_decode($volunteercertificate->body5));

$pdf->SetXY( 120, 250 + $delta + $delta2);
$pdf->setFont('Helvetica', '', 20);
$pdf->MultiCell(600, 35, $volunteercertificate->body1, 0, 'C', 0);

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

//cert_printtext(170, 475, 'C', 'Helvetica', '', 15, utf8_decode('Semester: ' . $volunteercertificate->semester));
cert_printtext(170, 500, 'C', 'Helvetica', '', 10, utf8_decode(isset($course->idnumber) ? $course->idnumber : ''));
cert_printtext(170, 500, 'R', 'Helvetica', '', 10, utf8_decode($url_to_display));

//cert_printtext(150, 430, '', '', '', '', '');
//$pdf->SetLeftMargin(130);
//$pdf->WriteHTML('Custom Text');

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
?>