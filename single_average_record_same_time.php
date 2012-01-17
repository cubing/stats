<?php
$title = 'Regional record single and average with the same time in same event';
include('assets/templates/header.tpl.php');

// build query
$query = "
SELECT s.personId, s.personName, s.personCountryId, s.eventId, a.average, s.regionalSingleRecord, s.competitionId singleCompetitionId, a.regionalAverageRecord, a.competitionId averageCompetitionId
FROM   (
        SELECT *
        FROM Results
        WHERE regionalSingleRecord LIKE '%R'
       ) AS s,
       (
        SELECT *
        FROM Results
        WHERE regionalAverageRecord LIKE '%R'
       ) AS a
WHERE  s.personId = a.personId
AND    s.eventId = a.eventId
AND    s.best = a.average
LIMIT  0 , 30";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th>Person</th>"
    ."<th>Country</th>"
    ."<th>Event</th>"
    ."<th class='r'>Time</th>"
    ."<th class='l' colspan='2'>Single</th>"
    ."<th class='l' colspan='2'>Average</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
while($row = mysql_fetch_array($result)) {
  echo "<tr>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td>" . $row['eventId'] . "</td>";
  echo "<td class='r'>" . $row['average'] . "</td>";
  echo "<td class='r'>" . $row['regionalSingleRecord'] . "</td>";
  echo "<td class='r'>" . $row['singleCompetitionId'] . "</td>";
  echo "<td class='r'>" . $row['regionalAverageRecord'] . "</td>";
  echo "<td class='r'>" . $row['averageCompetitionId'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";
?>

<h2>MySQL Query</h2>
<p>Based on query by Tim Reynolds in <a href="http://www.speedsolving.com/forum/showthread.php?26121-Odd-WCA-stats&p=508675&viewfull=1#post508675">this post</a>.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
