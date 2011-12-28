<?php
$title = 'Most DNF / DNS / sub-x / sup-x / exactly x';
include('assets/templates/header.tpl.php');

// form
$cur = 'most_results';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/regionId.php');
include('assets/forms/years.php');
include('assets/forms/comp.php');
include('assets/forms/result.php');
include('assets/forms/single_average_submit.php');

// validate
$valid = 1;
$comp = $_GET['comp'];
if ($comp != 'sub' && $comp != 'sup' && $comp != 'equal') {
  $valid = 0;
  $query = "";
  echo "<p>Select comparator.</p>";
}
$result = $_GET['result'];
if ($result == '') {
  $valid = 0;
  $query = "";
  echo "<p>Enter result.</p>";
}
if (!result_is_valid((string)$result)) {
  $valid = 0;
  $query = "";
  echo "<p>'". $result . "' is not a valid result.</p>";
}

if ($_GET['single'] != 'Single' && $_GET['average'] != 'Average') {
  $valid = 0;
  $query = "";
  echo "<p>Select single or average</p>";
}

if ($valid) {

// build query
$query = "SELECT   personId, personName, personCountryId,\n";
$comp = to_comp($_GET['comp']);
$result = $_GET['result'];
$result_num = $result*100;

$query .= "         SUM(\n";
if ($_GET['single'] == 'Single')
  $query .= "              IF(value1 " . $comp . " " . $result_num . " AND value1 > 0, 1, 0)\n"
           ."            + IF(value2 " . $comp . " " . $result_num . " AND value2 > 0, 1, 0)\n"
           ."            + IF(value3 " . $comp . " " . $result_num . " AND value3 > 0, 1, 0)\n"
           ."            + IF(value4 " . $comp . " " . $result_num . " AND value4 > 0, 1, 0)\n"
           ."            + IF(value5 " . $comp . " " . $result_num . " AND value5 > 0, 1, 0)\n";
if ($_GET['average'] == 'Average')
  $query .= "            IF(average" . $comp . " " . $result_num . " AND average > 0, 1, 0)\n";
$query   .= "            ) AS count\n";
$query .= "FROM     Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .="WHERE    TRUE\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= years_str();
$query .= "GROUP BY personId
ORDER BY count DESC, personName
LIMIT    100";

// query
$result2 = $_GET['result'];
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Citizen of</th>"
    ."<th class='r'>" . $comp . $result2 . "</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while(($row = mysql_fetch_array($result)) && ($row['count'] > 0)) {
  $rank++;
  // handle tie
  if ($row['count'] == $row_prev['count'])
    $rank_to_show = NULL;
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a href='p.php?i=" . $row['personId'] . "'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['count'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";

// close valid
}
?>

<h2>MySQL Query</h2>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>

