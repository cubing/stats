<?php
$title = 'All-time best worst result';
include('assets/templates/header.tpl.php');

// form
$cur = 'best_worst_result';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/regionId.php');
include('assets/forms/years.php');
include('assets/forms/single_average_submit.php');
include('assets/forms/endform.php');

// valid
$valid = 1;
$single = $_GET['single'];
$average = $_GET['average'];
if (($single != 'Single') && ($average != 'Average')) {
  $valid = 0;
  $query = "";
}

if (!$valid)
  echo "<p>Choose single or average.</p>";
else {

// build query
$query = "select personId, personName, personCountryId,\n";
if ($_GET['single'] == 'Single')
  $query .= "       round(max(greatest(value1, value2, value3, value4, value5))/100,2) worst\n";
if ($_GET['average'] == 'Average')
  $query .= "       round(max(average)/100,2) worst\n";
$query .= "  from Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
if ($_GET['single'] == 'Single')
  $query .= " where (value1+value2+value3+value4+value5) > 0\n";
if ($_GET['average'] == 'Average')
  $query .= " where average > 0\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= years_str();
$query .= " group by personId\n";
$query .= " order by worst asc, personName
 limit 100";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Citizen of</th>"
    ."<th class='r'>Worst</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['worst'] == $row_prev['worst'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank . "</td>";
  echo "<td>" . $row['personName'] . "</td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['worst'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";

// close valid else
}
?>

<h2>MySQL Query</h2>
<p>Based on query written by Alberto Burgos.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
