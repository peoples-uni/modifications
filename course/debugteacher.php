<?php  // debug

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();

require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

?><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

$courseid = 10; // HE 09
$courseid = 39; // EBP 09
$context = get_context_instance(CONTEXT_COURSE, $courseid);

// Pass $view=true to filter hidden caps if the user cannot see them
$users = get_users_by_capability($context, 'moodle/course:update', 'u.*', 'u.id ASC', '', '', '', '', false, true);

//echo '>>>>>>get_users_by_capability...<br />';
foreach ($users as $user) {
//	echo $user->firstname . ' ' . $user->lastname . '<br />';
}
//echo var_dump($users);

echo '$context->id: ' . $context->id . '<br />';
//$context->id: 2048
echo '$context->path: ' . $context->path . '<br />';
//$context->path: /1/1962/2048

$users = xsort_by_roleassignment_authority($users, $context);
echo '>>>>>>sort_by_roleassignment_authority...<br />';
foreach ($users as $user) {
	echo $user->firstname . ' ' . $user->lastname . '<br />';
}
//echo var_dump($users);

$user = array_shift($users);
//echo '>>>>>>array_shift...<br />';
//echo $user->firstname . ' ' . $user->lastname . '<br />';
//echo var_dump($user);


function xsort_by_roleassignment_authority($users, $context, $roles=array(), $sortpolicy='locality') {
    global $CFG;

    $userswhere = ' ra.userid IN (' . implode(',',array_keys($users)) . ')';
    $contextwhere = ' ra.contextid IN ('.str_replace('/', ',',substr($context->path, 1)).')';
//... $contextwhere = ' ra.contextid IN (1,1962,2048)';

//$contextwhere = ' ra.contextid IN (1)'; // Shweta only
//$contextwhere = ' ra.contextid IN (1962)'; // None
//$contextwhere = ' ra.contextid IN (2048)'; // All (Shweta still wins)

//SQL: SELECT ra.userid,ctx.depth,r.sortorder,ra.id FROM mdl_role_assignments ra JOIN mdl_role r ON ra.roleid=r.id JOIN mdl_context ctx ON //ra.contextid=ctx.id WHERE ra.userid IN (33,83,152,172,320,338) AND ra.contextid IN (1,1962,2048)

//mysql> SELECT ra.userid,ctx.depth,r.sortorder,ra.id FROM mdl_role_assignments ra JOIN mdl_role r ON ra.roleid=r.id JOIN mdl_context ctx ON //ra.contextid=ctx.id WHERE ra.userid IN (33,83,152,172,320,338) AND ra.contextid IN (1,1962,2048)
//    -> ORDER BY ctx.depth DESC, /* locality wins */ r.sortorder ASC, /* rolesorting 2nd criteria */ ra.id /* role assignment order tie-breaker */;
//+--------+-------+-----------+------+
//| userid | depth | sortorder | id   |
//+--------+-------+-----------+------+
//|    320 |     3 |         2 | 3265 |
//|     33 |     3 |         3 | 3185 |
//|    152 |     3 |         4 | 3111 |
//|    172 |     3 |         4 | 3112 |
//|     83 |     3 |         4 | 3184 |
//|    338 |     3 |         4 | 3246 |
//|    320 |     1 |         0 | 2704 |
//+--------+-------+-----------+------+
//7 rows in set (0.00 sec)

//After sortorder changed to have Education Officer" to have lower sort order in Define Roles. Result...
//+--------+-------+-----------+------+
//| userid | depth | sortorder | id   |
//+--------+-------+-----------+------+
//|     33 |     3 |         2 | 3185 |
//|    152 |     3 |         3 | 3111 |
//|    172 |     3 |         3 | 3112 |
//|     83 |     3 |         3 | 3184 |
//|    338 |     3 |         3 | 3246 |
//|    320 |     3 |         4 | 3265 |
//|    320 |     1 |         0 | 2704 |
//+--------+-------+-----------+------+
//7 rows in set (0.00 sec)

//>>>>>>sort_by_roleassignment_authority...
//Jessica Sheringham
//Shafqat Inam
//John Sandars
//Rebecca Armstrong
//Mohit Sharma
//Shweta Chooramani

    if (empty($roles)) {
        $roleswhere = '';
    } else {
        $roleswhere = ' AND ra.roleid IN ('.implode(',',$roles).')';
    }

    $sql = "SELECT ra.userid,ctx.depth,r.sortorder,ra.id
            FROM {$CFG->prefix}role_assignments ra
            JOIN {$CFG->prefix}role r
              ON ra.roleid=r.id
            JOIN {$CFG->prefix}context ctx
              ON ra.contextid=ctx.id
            WHERE
                    $userswhere
                AND $contextwhere
                $roleswhere
            ";

    // Default 'locality' policy -- read PHPDoc notes
    // about sort policies...
    $orderby = 'ORDER BY
                    ctx.depth DESC, /* locality wins */
                    r.sortorder ASC, /* rolesorting 2nd criteria */
                    ra.id           /* role assignment order tie-breaker */';
    if ($sortpolicy === 'sortorder') {
        $orderby = 'ORDER BY
                        r.sortorder ASC, /* rolesorting 2nd criteria */
                        ra.id           /* role assignment order tie-breaker */';
    }

echo '<br />SQL: ' . $sql . '<br />';
echo '<br />orderby: ' . $orderby . '<br />';

    $sortedids = get_fieldset_sql($sql . $orderby);

    $sortedusers = array();
    $seen = array();

    foreach ($sortedids as $id) {

        // Avoid duplicates
        if (isset($seen[$id])) {
            continue;
        }
        $seen[$id] = true;

        // assign
        $sortedusers[$id] = $users[$id];
    }
    return $sortedusers;
}
?>
</body>
</html>
