<?php
$title = 'Best Medal Collection';
include('assets/templates/header.tpl.php');

// form
$cur = 'best_medal_collection';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/regionId.php');
include('assets/forms/years.php');
include('assets/forms/order_by_medal.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "select personId, personName, personCountryId, sum(if(pos=1, 1, 0)) gold, sum(if(pos=2, 1, 0)) silver, sum(if(pos=3, 1, 0)) bronze,
       (sum(if(pos=1, 1, 0)) + sum(if(pos=2, 1, 0))  + sum(if(pos=3, 1, 0))) total
  from Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= " where roundId in ('f','c')
   and pos in (1,2,3)
   and best > 0\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= years_str();
$query .= " group by personId, personName\n";
$query .= "ORDER BY " . medal_str() . ", personName\n";
$query .= "LIMIT    100";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Citizen of</th>"
    ."<th>Gold</th>"
    ."<th>Silver</th>"
    ."<th>Bronze</th>"
    ."<th>Total</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if (($row['gold'] == $row_prev['gold'])
      && ($row['silver'] == $row_prev['silver'])
      && ($row['bronze'] == $row_prev['bronze']))
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['gold'] . "</td>";
  echo "<td class='r'>" . $row['silver'] . "</td>";
  echo "<td class='r'>" . $row['bronze'] . "</td>";
  echo "<td class='r'>" . $row['total'] . "</td>";
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
