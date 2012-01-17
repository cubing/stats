<?php
$title = 'Most common first names';
include('assets/templates/header.tpl.php');
?>

<?php
// form
$cur = 'most_common_first_names';
include('assets/forms/beginform.php');
include('assets/forms/regionId.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   firstName, COUNT(firstName) AS count
FROM     (
          SELECT   IF(
                      LOCATE(' ', p.name) = 0,
                      p.name,
                      SUBSTRING(p.name, 1, LOCATE(' ', p.name) - 1)
                      ) AS firstName
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
$query .= "GROUP BY firstName
ORDER BY count DESC
LIMIT    100";

// query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>First name</th>"
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
  echo "<td>" . $row['firstName'] . "</td>";
  echo "<td class='r'>" . $row['count'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";
?>

<h2>MySQL Query</h2>
<p>Query written by Shotaro Makisumi.</p>

<p>The 'name' field stores the full name. LOCATE(' ', name) returns the index of the first occurrence of space. If this is 0 (i.e. for one-word names), the whole name is used; otherwise, the substring left of the first space is used.</p>

<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>

