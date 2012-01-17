<?php
$title = 'Most competitions';
include('assets/templates/header.tpl.php');

// form
$cur = 'most_competitions';
include('assets/forms/beginform.php');
include('assets/forms/years.php');
include('assets/forms/regionId.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   personName, personId, personCountryId, COUNT(DISTINCT competitionId) comp
FROM     Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= "WHERE    TRUE\n";
$query .= regionId_str();
$query .= years_str();
$query .= "GROUP BY personId
ORDER BY comp DESC
LIMIT    100";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Country</th>"
    ."<th>Competitions</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['comp'] == $row_prev['comp'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['comp'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>\n\n";
?>


<h2>MySQL Query</h2>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
