<?php
$title = 'Most common WCA ID middles';
include('assets/templates/header.tpl.php');
?>

<?php
// form
$cur = 'most_common_wca_id_middles';
include('assets/forms/beginform.php');
include('assets/forms/regionId.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   idMiddle, COUNT(idMiddle) AS count
FROM     (
          SELECT   SUBSTRING(p.id, 5, 4) AS idMiddle
          FROM     Persons p\n";
if ($_GET['regionId'] != '')
  $query .="                   JOIN Countries c  ON p.countryId = c.id\n";
$regionId = $_GET['regionId'];
if ($regionId != "") {
  if ($regionId[0] == '_')
    $query .= "          WHERE    continentId = '" . $regionId . "'\n";
  else
    $query .= "          WHERE    countryId = '" . $regionId . "'\n";
}
$query .= "          ) t\n";
$query .= "GROUP BY idMiddle
ORDER BY count DESC
LIMIT    100";

// query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>ID middle</th>"
    ."<th class='r'>Occurrence</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
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
  echo "<td>" . $row['idMiddle'] . "</td>";
  echo "<td class='r'>" . $row['count'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";
?>

<h2>MySQL Query</h2>
<p>By Shotaro Makisumi</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>

