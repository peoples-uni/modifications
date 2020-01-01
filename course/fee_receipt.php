<?php  // fee_receipt.php 20151109

require_once('../config.php');
include 'fpdf/fpdf.php';
include 'fpdf/fpdfprotection.php';
include_once('html2pdf.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/fee_receipt.php');
$PAGE->set_pagelayout('embedded');


$id = required_param('id', PARAM_INT);

$peoples_fee_receipt = $DB->get_record('peoples_fee_receipt', array('id' => $id));
if (empty($peoples_fee_receipt)) {
  print_error('invalidarguments');
}

$certificate = new stdClass();
$certificate->name = 'Certificate';
$certificate->borderstyle = 'Fancy2-black.jpg';
$certificate->bordercolor = '3';
$certificate->printwmark = '';
$certificate->printdate = '2';
$certificate->datefmt = '2';
//$certificate->printsignature1 = 'Alec_Tice_Signature.png';
$certificate->printsignature1 = 'Alice_Chimuzu_Signature.jpg';
$certificate->logo = 'PeopleUniOrg_Logo.jpg';
$certificate->printseal = '';

$url_to_display = 'https://peoples-uni.org';
$name_to_display = 'Coordinator, Professor Richard Heller';

$certificatedate = '';
$certdate = $peoples_fee_receipt->date;
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
$orientation = 'P';
$pdf= new PDF($orientation, 'pt', 'A4');
$pdf->SetProtection(array('print'));
$pdf->AddPage();

// Add images and lines
//print_border($certificate->borderstyle, $orientation);
//draw_frame($certificate->bordercolor, $orientation);
//print_watermark($certificate->printwmark, $orientation);
//print_seal($certificate->printseal, $orientation, 590, 425, '', '');

$pdf->SetTextColor(0, 0, 0);
print_signature($certificate->logo, $orientation, 180, 20, '200', '134');

$left = 80;
$offset = 180;
$delta = 12;
//cert_printtext($left, $offset, 'L', 'Times', '', 10, utf8_decode('UK Charity Commission number: 1126265, 34 Stafford Road, Eccles, Manchester, M30 9ED'));
cert_printtext($left, $offset, 'L', 'Times', '', 10, utf8_decode('UK Charity Commission number: 1126265, 2 Troed y Fenlli, Llanbedr Dyffryn Clwyd, Ruthin, Denbighshire, LL15 1BQ'));
$offset += $delta;
cert_printtext($left, $offset, 'L', 'Times', '', 10, utf8_decode('Trustees:'));
$offset += $delta;
cert_printtext($left, $offset, 'L', 'Times', '', 10, utf8_decode('Professor Rajan Madhok, rmadhok@peoples-uni.org  Chair'));
$offset += $delta;
//cert_printtext($left, $offset, 'L', 'Times', '', 10, utf8_decode('Mr Alistair Tice, atice@peoples-uni.org  Treasurer'));
cert_printtext($left, $offset, 'L', 'Times', '', 10, utf8_decode('Ms Julie Storr'));
$offset += $delta;
cert_printtext($left, $offset, 'L', 'Times', '', 10, utf8_decode('Professor Richard Heller, rfheller@peoples-uni.org  Coordinator'));

$offset += 30;

if ($peoples_fee_receipt->receipt_flag < 100) {

cert_printtext($left-50, $offset, 'C', 'Times', '', 18, utf8_decode('RECEIPT'));
$offset += 20;

$delta = 18;
$offset += $delta;
cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode($certificatedate));
$offset += $delta;
if (!empty($peoples_fee_receipt->name_payee)) cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode('To    ' . $peoples_fee_receipt->name_payee));
$offset += $delta;
cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode('To    ' . $peoples_fee_receipt->firstname . ' ' . $peoples_fee_receipt->lastname));
$offset += $delta;
if (!empty($peoples_fee_receipt->sid)) cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode('SID: ' . $peoples_fee_receipt->sid));

$currency = ($peoples_fee_receipt->currency == 'GBP') ? 'UK Pounds' : $peoples_fee_receipt->currency;
$offset += 20;
$pdf->SetXY($left, $offset);
$pdf->setFont('Times', '', 14);
$pdf->MultiCell(400, 35, utf8_decode("The Trustees acknowledge the receipt of $peoples_fee_receipt->amount $currency in payment for $peoples_fee_receipt->modules"), 0, 'L', 0);

} else { // Invoice
  cert_printtext($left-50, $offset, 'C', 'Times', '', 18, utf8_decode('RECEIPT'));
  $offset += 20;

  $delta = 18;
  $offset += $delta;
  cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode($certificatedate));
  $offset += $delta;
  if (!empty($peoples_fee_receipt->name_payee)) cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode('To    ' . $peoples_fee_receipt->name_payee));
  $offset += $delta;
  cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode('To    ' . $peoples_fee_receipt->firstname . ' ' . $peoples_fee_receipt->lastname));
  $offset += $delta;
  if (!empty($peoples_fee_receipt->sid)) cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode('SID: ' . $peoples_fee_receipt->sid));

  $currency = ($peoples_fee_receipt->currency == 'GBP') ? 'UK Pounds' : $peoples_fee_receipt->currency;
  $offset += 20;
  $pdf->SetXY($left, $offset);
  $pdf->setFont('Times', '', 14);
  $pdf->MultiCell(400, 35, utf8_decode("The Trustees acknowledge the receipt of $peoples_fee_receipt->amount $currency in payment for $peoples_fee_receipt->modules"), 0, 'L', 0);
}

$offset += 160;
cert_printtext($left, $offset, 'L', 'Times', '', 14, utf8_decode('Signed'));
//print_signature($certificate->printsignature1, $orientation, $left + 70, $offset - 14, '100', '20');
print_signature($certificate->printsignature1, $orientation, $left + 70, $offset - 14 - 10, '99', '30');

$delta = 20;
$offset += $delta;
//cert_printtext($left + 70, $offset, 'L', 'Times', '', 14, utf8_decode('Alistair Tice,'));
cert_printtext($left + 70, $offset, 'L', 'Times', '', 14, utf8_decode('Mrs Alice Chimuzu,'));
$offset += $delta;
//cert_printtext($left + 70, $offset, 'L', 'Times', '', 14, utf8_decode('Treasurer'));
cert_printtext($left + 70, $offset, 'L', 'Times', '', 14, utf8_decode('Accountant'));


$filesafe = clean_filename($certificate->name . '.pdf');
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