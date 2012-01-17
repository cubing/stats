<?php
$title = 'Most Records';
include('assets/templates/header.tpl.php');

// form
$cur = 'most_records';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/regionId.php');
include('assets/forms/years.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   personId, personName, personCountryId, 
         SUM(IF(regionalSingleRecord = 'WR', 1, 0)) singleWr,
         SUM(IF(regionalAverageRecord = 'WR', 1, 0)) averageWr,
         SUM(IF(regionalSingleRecord = 'WR', 1, 0) + IF(regionalAverageRecord = 'WR', 1, 0)) totalWr,
         SUM(IF(regionalSingleRecord = 'NAR', 1, 0) + IF(regionalSingleRecord = 'SAR', 1, 0) + IF(regionalSingleRecord = 'ER', 1, 0) + IF(regionalSingleRecord = 'AsR', 1, 0) + IF(regionalSingleRecord = 'OcR', 1, 0) + IF(regionalSingleRecord = 'AfR', 1, 0)) singleCr,
         SUM(IF(regionalAverageRecord = 'NAR', 1, 0) + IF(regionalAverageRecord = 'SAR', 1, 0) + IF(regionalAverageRecord = 'ER', 1, 0) + IF(regionalAverageRecord = 'AsR', 1, 0) + IF(regionalAverageRecord = 'OcR', 1, 0) + IF(regionalAverageRecord = 'AfR', 1, 0)) averageCr,
         SUM(IF(regionalSingleRecord = 'NAR', 1, 0) + IF(regionalSingleRecord = 'SAR', 1, 0) + IF(regionalSingleRecord = 'ER', 1, 0) + IF(regionalSingleRecord = 'AsR', 1, 0) + IF(regionalSingleRecord = 'OcR', 1, 0) + IF(regionalSingleRecord = 'AfR', 1, 0) + IF(regionalAverageRecord = 'NAR', 1, 0) + IF(regionalAverageRecord = 'SAR', 1, 0) + IF(regionalAverageRecord = 'ER', 1, 0) + IF(regionalAverageRecord = 'AsR', 1, 0) + IF(regionalAverageRecord = 'OcR', 1, 0) + IF(regionalAverageRecord = 'AfR', 1, 0)) totalCr,
         SUM(IF(regionalSingleRecord = 'NR', 1, 0)) singleNr,
         SUM(IF(regionalAverageRecord = 'NR', 1, 0)) averageNr,
         SUM(IF(regionalSingleRecord = 'NR', 1, 0) + IF(regionalAverageRecord = 'NR', 1, 0)) totalNr
FROM     Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= "WHERE    (regionalSingleRecord in ('WR', 'AfR', 'AsR', 'ER', 'OcR', 'NAR', 'SAR', 'NR') OR regionalAverageRecord in ('WR', 'AfR', 'AsR', 'ER', 'OcR', 'NAR', 'SAR', 'NR'))\n";
$query .= eventId_str();
$query .= regionId_str();
$query .= years_str();
$query .= "GROUP BY personId
ORDER BY totalWr DESC, averageWR DESC, totalCr DESC, averageCr DESC, totalNr DESC, averageNr DESC";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Citizen of</th>"
    ."<th class='r'>Total WR</th>"
    ."<th class='r'>Average WR</th>"
    ."<th class='r'>Single WR</th>"
    ."<th class='r'>Total CR</th>"
    ."<th class='r'>Average CR</th>"
    ."<th class='r'>Single CR</th>"
    ."<th class='r'>Total NR</th>"
    ."<th class='r'>Average NR</th>"
    ."<th class='r'>Single NR</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if (($row['totalWr'] == $row_prev['totalWr'])
      && ($row['averageWr'] == $row_prev['averageWr'])
      && ($row['totalCr'] == $row_prev['totalCr'])
      && ($row['averageCr'] == $row_prev['averageCr'])
      && ($row['totalNr'] == $row_prev['totalNr'])
      && ($row['averageNr'] == $row_prev['averageNr']))
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['totalWr'] . "</td>";
  echo "<td class='r'>" . $row['averageWr'] . "</td>";
  echo "<td class='r'>" . $row['singleWr'] . "</td>";
  echo "<td class='r'>" . $row['totalCr'] . "</td>";
  echo "<td class='r'>" . $row['averageCr'] . "</td>";
  echo "<td class='r'>" . $row['singleCr'] . "</td>";
  echo "<td class='r'>" . $row['totalNr'] . "</td>";
  echo "<td class='r'>" . $row['averageNr'] . "</td>";
  echo "<td class='r'>" . $row['singleNr'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table";
?>

<h2>MySQL Query</h2>
<p>By Shotaro Makisumi</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
