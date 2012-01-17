<?php
$title = 'Total solve days for each event';
include('assets/templates/header.tpl.php');
?>

<p>Except Fewest Moves and Mutli-BLD.</p>

<?php
// build query
$query = "select round(sum(value1*(value1>0) + value2*(value2>0) + value3*(value3>0) + value4*(value4>0) + value5*(value5>0))/60/60/24)/100 day, Events.name
from Results, Events
where Events.id = eventId
group by eventId
order by day desc";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Event</th>"
    ."<th class='r'>Days</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// ignore Fewest Moves and multi-BLD
$row = mysql_fetch_array($result);
$row = mysql_fetch_array($result);

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['1'] == $row_prev['1'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td class='r'>" . $row['name'] . "</td>";
  echo "<td class='r'>" . $row['day'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";
?>

<h2>MySQL Query</h2>
<p>Based on query written by Stefan Pochmann in <a href="http://www.speedsolving.com/forum/showthread.php?26121-Odd-WCA-stats&p=568812&viewfull=1#post568812">this post</a>.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
