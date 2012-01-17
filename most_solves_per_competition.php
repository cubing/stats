<?php
$title = 'Most solves per competition (on average)';
include('assets/templates/header.tpl.php');

// form
$cur = 'most_solves_per_competition';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/years.php');
include('assets/forms/regionId.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   personName, personId, personCountryId, SUM(IF(value1 > 0, 1, 0) + IF(value2 > 0, 1, 0) + IF(value3 > 0, 1, 0) + IF(value4 > 0, 1, 0) + IF(value5 > 0, 1, 0))/COUNT(DISTINCT competitionId) AS solvePerComp
FROM     Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= "WHERE    TRUE\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= years_str();
$query .= "GROUP BY personId
ORDER BY solvePerComp DESC
LIMIT    100";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Country</th>"
    ."<th>Solves per competition</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['solvePerComp'] == $row_prev['solvePerComp'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['solvePerComp'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>\n\n";
?>


<h2>MySQL Query</h2>
<p>Based on query by Tim Reynolds in <a href="http://www.speedsolving.com/forum/showthread.php?34480-2011-Statistics!&p=693794#post693794">this post</a>.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
