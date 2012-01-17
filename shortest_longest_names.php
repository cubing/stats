<?php
$title = 'Shortest/longest names (romanized)';
include('assets/templates/header.tpl.php');
?>

<p>Not counting spaces.</p>

<?php
// form
$cur = 'shortest_longest_names';
include('assets/forms/beginform.php');
include('assets/forms/regionId.php');
?>

<td valign='bottom'><div class='space'><div class='buttborder'><input class='chosenButton' type='submit' name='longest' value='Longest' /> </div></div></td>

<td valign='bottom'><div class='space'><div class='buttborder'><input class='butt' type='submit' name='shortest' value='Shortest' /> </div></div></td>

<?php
include('assets/forms/endform.php');

// build query
$query = "SELECT   p.id, p.name, p.countryId,
         CHAR_LENGTH(
          REPLACE(
           IF(
             LOCATE('(', p.name) = 0,
             p.name,
             SUBSTRING(p.name, 1, LOCATE('(', p.name) - 1)
             ),
           ' ',
           ''
          )
         ) AS len
FROM     Persons p\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries c  ON p.countryId = c.id\n";
$query .= "WHERE   TRUE\n";
$regionId = $_GET['regionId'];
if ($regionId != "") {
  if ($regionId[0] == '_')
    $query .= "         AND continentId = '" . $regionId . "'\n";
  else
    $query .= "         AND countryId = '" . $regionId . "'\n";
}
$query .= "ORDER BY len ";
// should make this work properly at some point
if ($_GET['longest'] == 'Longest')
  $query .= "DESC";
$query .= "\nLIMIT    100";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Country</th>"
    ."<th>Name length</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['len'] == $row_prev['len'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['id'] ."'>" . $row['name'] . "</a></td>";
  echo "<td>" . $row['countryId'] . "</td>";
  echo "<td class='r'>" . $row['len'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>\n\n";
?>


<h2>MySQL Query</h2>
<p>Written by Shotaro Makisumi.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>

