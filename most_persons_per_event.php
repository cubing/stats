<?php
$title = 'Most persons per event';
include('assets/templates/header.tpl.php');
?>

<p>No region or years option yet because they're too slow!</p>

<?php
// build query
$query = "SELECT    r.eventId, e.name, COUNT(DISTINCT r.personId) people
FROM      Results r
          JOIN Events e ON r.eventId = e.id\n";
// the region and years options are too slow!
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON r.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON r.personCountryId = Countries.id\n";
$query .= "GROUP BY eventId
ORDER BY people DESC";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Event</th>"
    ."<th class='r'>Persons</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['people'] == $row_prev['people'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td class='r'>" . $row['people'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>\n\n";
?>

<h2>MySQL Query</h2>
<p>Based on query written by Alberto Burgos.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
