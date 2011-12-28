<?php
$title = 'Combined finals / finals by event';
include('assets/templates/header.tpl.php');

// build query
$query = "select e.cellName event, if(c is not null, c, 0) combined, finals, format((if(c is not null, c, 0)/finals)*100,2) '%'
  from Events e,
		(
		select eventId, count(distinct competitionId) finals
		  from Results
		 group by eventId
		) r1 left join
		(
		 select eventId, count(distinct competitionId) c
		  from Results
		 where roundId = 'c'
		 group by eventId
		) r2
		on r1.eventId = r2.eventId
 where r1.eventId = e.id
 order by combined/finals desc, finals desc";
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Event</th>"
    ."<th>Combined Finals/Finals (%)</th>"
    ."<th>Combined Finals</th>"
    ."<th>Finals</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if (($row['combined'] == $row_prev['combined'])
       && ($row['finals'] == $row_prev['finals']))
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td>" . $row['event'] . "</td>";
  echo "<td class='r'>" . $row['%'] . "</td>";
  echo "<td class='r'>" . $row['combined'] . "</td>";
  echo "<td class='r'>" . $row['finals'] . "</td>";
  echo "</tr>\n";
}
echo "</table>";
?>

<h2>MySQL Query</h2>
<p>MySQL query written by Alberto Burgos.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>