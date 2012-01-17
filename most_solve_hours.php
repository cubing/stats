<?php
$title = 'Most solve hours';
include('assets/templates/header.tpl.php');
?>

<p>Excluding Fewest Moves and Multi-BLD.</p>

<?php
// form
$cur = 'most_solve_hours';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/regionId.php');
include('assets/forms/years.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   (sum( if(value1>0,value1,0) ) +
          sum( if(value2>0,value2,0) ) +
          sum( if(value3>0,value3,0) ) +
          sum( if(value4>0,value4,0) ) +
          sum( if(value5>0,value5,0) ))/100/60/60 hours,
         personId, personName, personCountryId
FROM     Results
         JOIN Events      ON Events.id = eventId\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= "WHERE    format = 'time'\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= years_str();
$query .= "GROUP BY personId
ORDER BY hours DESC
LIMIT    100";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Country</th>"
    ."<th>Total solve hours</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['hours'] == $row_prev['hours'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['hours'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>\n\n";
?>

<h2>MySQL Query</h2>
<p>Based on query written by Stefan Pochmann in <a href="http://www.speedsolving.com/forum/showthread.php?26121-Odd-WCA-stats&p=584327&viewfull=1#post584327">this post</a>.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
