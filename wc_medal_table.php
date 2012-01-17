<?php
$title = 'World Championship Medal Table';
include('assets/templates/header.tpl.php');
?>

<p>Only countries/persons with at least one medal are shown.</p>

<?php
// form
$cur = 'wc_medal_table';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/regionId.php');
include('assets/forms/years_wc.php');
?>

<td valign='bottom'><div class='space'><label for='group'>Group by:<br /><select class='drop' id='group' name='group'>
<?php
$curId = $_GET['group'];
writeOption('country', 'Country', $curId);
writeOption('person', 'Person', $curId);
?>
</select></label></div></td>

<?php
include('assets/forms/gold_total.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   personId, personName, personCountryId,
         SUM(IF(pos = 1, 1, 0)) AS gold,
         SUM(IF(pos = 2, 1, 0)) AS silver,
         SUM(IF(pos = 3, 1, 0)) AS bronze,
         SUM(IF(pos <= 3, 1, 0)) AS total
FROM     Results
         JOIN Competitions ON Results.competitionId = Competitions.id
         JOIN Countries    ON Results.personCountryId = Countries.id\n";

// WHERE
$query .= "WHERE    (roundId = 'f' OR roundId = 'c') AND best > 0 AND eventId != '333mbo'\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= wc_str();
$query .= years_str();

// group
$group = $_GET['group'];
if ($group == '' || $group == 'country')
  $query .= "GROUP BY personCountryId\n";
if ($group == 'person')
  $query .= "GROUP BY personId\n";

// order
$order = $_GET['order'];
if ($order == '' || $order == 'gold')
  $query .= "ORDER BY gold DESC, silver DESC, bronze DESC";
if ($order == 'total')
  $query .= "ORDER BY total DESC, gold DESC, silver DESC, bronze DESC";
if ($group == '' || $group == 'country')
  $query .= ", personCountryId";
if ($group == 'person')
  $query .= ", personName, personId";

// build and submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>";
if ($group == 'person')
  echo "<th>Person</th>"
      ."<th>Citizen of</th>";
else
  echo "<th>Country</th>";
echo "<th>Gold</th>"
    ."<th>Silver</th>"
    ."<th>Bronze</th>"
    ."<th>Total</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while(($row = mysql_fetch_array($result)) && ($row['total'] > 0)) {
  $rank++;
  // handle tie
  if (($row['gold'] == $row_prev['gold'])
       & ($row['silver'] == $row_prev['silver'])
       & ($row['bronze'] == $row_prev['bronze']))
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  if ($group == 'person')
    echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['gold'] . "</td>";
  echo "<td class='r'>" . $row['silver'] . "</td>";
  echo "<td class='r'>" . $row['bronze'] . "</td>";
  echo "<td class='r'>" . $row['total'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";
?>

<h2>MySQL Query</h2>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>