<?php
$title = 'Medal in most events';
include('assets/templates/header.tpl.php');

// form
$cur = 'medal_in_most_event';
include('assets/forms/beginform.php');
include('assets/forms/regionId.php');
include('assets/forms/years.php');
?>

<td valign='bottom'><div class='space'><label for='medal'>Medal:<br /><select class='drop' id='medal' name='medal'>
<?php
$curId = $_GET['medal'];
writeOption('gold', 'Gold', $curId);
writeOption('all', 'All', $curId);
?>
</select></label></div></td>

<?php
include('assets/forms/endform.php');

// build query
$query = "select personId, personName, count(distinct eventId) won
  from Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= " where roundId in ('f','c')
   and best > 0\n";
if ($_GET['medal'] == 'Gold')
   $query .= "   and pos = 1\n";
if ($_GET['medal'] == 'All')
   $query .= "   and pos = (1, 2, 3)\n";
$query .= regionId_str();
$query .= yearsId_str();
$query .= " group by personId
 order by won desc, personName";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Country</th>"
    ."<th>Won</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['won'] == $row_prev['won'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['won'] . "</td>";
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

