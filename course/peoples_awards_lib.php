<?php

/*
CREATE TABLE mdl_peoples_accept_module (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  enrolid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  whosubmitted BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoples_accept_module_eid_ix ON mdl_peoples_accept_module (enrolid);
CREATE INDEX mdl_peoples_accept_module_uid_ix ON mdl_peoples_accept_module (userid);
*/


function get_student_award($userid, $enrols, &$passed_or_cpd_enrol_ids, &$modules, &$percentages, $nopercentage, &$lastestdate, &$cumulative_enrolled_ids_to_discount, &$pass_type, &$foundation_problems) {
  global $DB;

  // First work out what modules should be discounted because of academic rules (maximum of 10 semesters to date, maximum of 1 fail to date)
  $all_enrols = $DB->get_records_sql("
    SELECT
      CONCAT(e.userid, '#', s.id),
      e.userid,
      s.id,
      COUNT(*) AS num_enrolments,
      SUM(e.notified=1 AND ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0) >1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0)<=44.99999))) AS num_fails,
      SUM(e.notified=1 AND ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >44.99999))) AS num_passes,
      GROUP_CONCAT(IF(e.id=a.enrolid, 9999999, e.id) SEPARATOR ',') AS enrolled_ids_to_discount
    FROM mdl_enrolment    e
    JOIN mdl_grade_items  i ON e.courseid=i.courseid AND i.itemtype='course'
    JOIN mdl_semesters    s ON e.semester=s.semester
    LEFT JOIN mdl_grade_grades g ON e.userid=g.userid AND i.id=g.itemid
    LEFT JOIN mdl_peoples_accept_module a ON e.id=a.enrolid /* If there is a match, then this module should not be discounted, no matter what */
    WHERE e.userid=$userid /* We include even if they were enrolled and then unenrolled, could change this. */
    GROUP BY e.userid, s.id
    ORDER BY e.userid ASC, s.id ASC");

  $semester_list = $DB->get_records('semesters', NULL, 'id ASC');
  $first_semester_enrolled = 9999999;
  $total_fails = 0;
  $i = 0;
  $cumulative_enrolled_ids_to_discount_string = '9999999';
  foreach ($semester_list as $semester) {
    if (!empty($all_enrols["$userid#$semester->id"])) {
      if ($first_semester_enrolled == 9999999) $first_semester_enrolled = $i;

      $semester_enrolls = $all_enrols["$userid#$semester->id"];
      $total_fails += $semester_enrolls->num_fails;
      $elapsed_semesters = $i + 1 - $first_semester_enrolled;
      if (($total_fails > 1) || ($elapsed_semesters > 10)) { // If TRUE, then discount this Semester's Modules by academic rules
        $cumulative_enrolled_ids_to_discount_string .= ",$semester_enrolls->enrolled_ids_to_discount";
      }
    }
    $i++;
  }

  $cumulative_enrolled_ids_to_discount = explode(',', $cumulative_enrolled_ids_to_discount_string);


  // This has now (20110728) changed Diploma: 6, Certificate: 3 (also foundation/problems are no longer hard coded)
  // A Diploma when 8 modules have been passed,
  // Provided at least two are from each of the Foundation Sciences and Public Health problems groupings.
  //// THESE LISTS MUST BE KEEPT UP TO DATE HERE AND ALSO IN peoplescertificate.php WHERE THIS IS RECHECKED
  //
  //// Intro to Epi, Biostatistics, Evidence Based Practice etc. are 'foundation'
  //$foundation['PUBIOS'] = 1;  // Biostatistics
  //$foundation['PUEBP']  = 1;  // Evidence Based Practice
  //$foundation['PUEPI']  = 1;  // Introduction to Epidemiology
  //$foundation['PUETH']  = 1;  // Public Health Ethics
  //$foundation['PUEVAL'] = 1;  // Evaluation of Interventions
  //$foundation['PUHECO'] = 1;  // Health Economics
  //$foundation['PUISDH'] = 1;  // Inequalities and the social determinants of health
  //$foundation['PUPHC']  = 1;  // Public Health Concepts for Policy Makers
  //
  //// Maternal Mortality, Preventing Child Mortality and Disasters etc. are 'problems'.
  //$problems['PUCOMDIS']  = 1; // Communicable Disease
  //$problems['PUDMEP']    = 1; // Disaster Management and Emergency Planning
  //$problems['PUEH']      = 1; // Environmental Health: Investigating a problem
  //$problems['PUHIVAIDS'] = 1; // HIV/AIDS
  //$problems['PUMM']      = 1; // Maternal Mortality
  //$problems['PUNCD']     = 1; // Non-Communicable Diseases 1: Diabetes and Cardiovascular Diseases
  //$problems['PUPCM']     = 1; // Preventing Child Mortality
  //$problems['PUPHNUT']   = 1; // Public Health Nutrition
  //$problems['PUPSAFE']   = 1; // Patient Safety
  $foundation_records = $DB->get_records('peoples_course_codes', array('type' => 'foundation'), 'course_code ASC');
  foreach ($foundation_records as $record) {
    $foundation[$record->course_code] = 1;
  }
  $problems_records = $DB->get_records('peoples_course_codes', array('type' => 'problems'), 'course_code ASC');
  foreach ($problems_records as $record) {
    $problems[$record->course_code] = 1;
  }

  $diploma_passes = 0;
  $masters_passes = 0;
  $grandfathered_passes = 0;
  $countf = 0;
  $countf_grandfathered = 0;
  $countp = 0;
  $countp_grandfathered = 0;
  foreach ($enrols as $enrol) {
    $pass_type[$enrol->id] = '';
    //Test: $enrol->finalgrade = 1.0; (old grading system)
    //Test: $enrol->notified = 1;
    if (!empty($enrol->finalgrade) && (($enrol->percentgrades == 0 && $enrol->finalgrade <= 1.99999) || ($enrol->percentgrades == 1 && $enrol->finalgrade > 44.99999)) && ($enrol->notified == 1)) {
      $passed_or_cpd_enrol_ids[] = $enrol->id;

      if (!in_array($enrol->id, $cumulative_enrolled_ids_to_discount)) { // Make sure this module is not to be discounted

        $diploma_passes++;

        if ($enrol->finalgrade > 49.99999) {
          $pass_type[$enrol->id] = 'Masters Pass (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
          $masters = TRUE;
          $masters_passes++;
        }
        elseif ($enrol->percentgrades == 1) {
          $pass_type[$enrol->id] = 'Diploma Pass (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
          $masters = FALSE;
        }
        else {
          $pass_type[$enrol->id] = 'Pass';
          $masters = FALSE;
        }

        // $grandfathered = $masters || ($enrol->datefirstenrolled < 1422662400); // 31 Jan 2015
        $grandfathered = $masters || ($enrol->percentgrades == 0); // Masters level Pass OR Pre Percentage Pass
        if ($grandfathered) {
          $grandfathered_passes++;
        }

        $matched = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enrol->idnumber, $matches); // Take out course code without Year/Semester part
        if ($matched && !empty($foundation[$matches[1]])) {
          $countf++;
          if ($grandfathered) $countf_grandfathered++;
          $foundation_problems[$enrol->id] = 'Foundation';
        }
        if ($matched && !empty($problems  [$matches[1]])) {
          $countp++;
          if ($grandfathered) $countp_grandfathered++;
          $foundation_problems[$enrol->id] = 'Problems';
        }

        $semesters[] = $enrol->semester; // Not used
        $modules[] = $enrol->fullname; // Modules which count towards Certificate/Diploma

        $percent = '';
        if (!$nopercentage && $enrol->percentgrades == 1) {
          $percent = ' (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
        }
        $percentages[] = $percent;

        if ($enrol->datenotified > $lastestdate) $lastestdate = $enrol->datenotified;
      }
      else { // Discounted but note marks in any case
        if ($enrol->finalgrade > 49.99999) {
          $pass_type[$enrol->id] = 'Discounted: Masters Pass (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
        }
        elseif ($enrol->percentgrades == 1) {
          $pass_type[$enrol->id] = 'Discounted: Diploma Pass (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
        }
        else {
          $pass_type[$enrol->id] = 'Discounted: Pass';
        }

        $matched = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enrol->idnumber, $matches); // Take out course code without Year/Semester part
        if ($matched && !empty($foundation[$matches[1]])) {
          $foundation_problems[$enrol->id] = 'Foundation';
        }
        if ($matched && !empty($problems  [$matches[1]])) {
          $foundation_problems[$enrol->id] = 'Problems';
        }
      }
    }
    elseif (($enrol->notified == 1) && ($enrol->percentgrades == 0)) {
      $pass_type[$enrol->id] = 'Fail';
    }
    elseif (($enrol->notified == 1) && empty($enrol->finalgrade)) {
      $pass_type[$enrol->id] = 'Fail (0%)';
    }
    elseif ($enrol->notified == 1) {
      $pass_type[$enrol->id] = 'Fail (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
    }
    elseif ($enrol->notified == 3) {
      $pass_type[$enrol->id] = 'Participation/CPD';
      $passed_or_cpd_enrol_ids[] = $enrol->id;
    }
    elseif ($enrol->notified == 2) {
      $pass_type[$enrol->id] = 'Not Graded, Not Complete"';
    }
    elseif ($enrol->notified == 5) {
      $pass_type[$enrol->id] = 'Not Graded, Exceptional Factors';
    }
    elseif ($enrol->notified == 4) {
      $pass_type[$enrol->id] = 'Not Graded, Did Not Pay';
    }
  }

  $meets_foundation_criterion        =  $countf_grandfathered >= 2;
  $meets_problems_criterion          =  $countp_grandfathered >= 2;
  $almost_meets_foundation_criterion = ($countf_grandfathered == 1) && ($countf >= 2);
  $almost_meets_problems_criterion   = ($countp_grandfathered == 1) && ($countp >= 2);

  $meets_overall_criteria =
    ($meets_foundation_criterion && $meets_problems_criterion)
      ||
    ($meets_foundation_criterion && $almost_meets_problems_criterion)
      ||
    ($meets_problems_criterion && $almost_meets_foundation_criterion);

  $qualification = 0;
  if (($grandfathered_passes >= 3) || (($grandfathered_passes == 2) && ($diploma_passes >= 3))) {
    $qualification = $qualification | 1;
  }
  if ((($grandfathered_passes >= 6) || (($grandfathered_passes == 5) && ($diploma_passes >= 6))) && $meets_overall_criteria) {
    $qualification = $qualification | 2;
  }

  return $qualification;
}