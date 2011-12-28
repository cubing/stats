<?php
$title = 'WCA Growth';
include('assets/templates/header.tpl.php');
?>

<ul>
    <li>PersCountries = number of countries with persons with result data (including DNS or DNF)</li>
    <li>CompCountries = number of countries that has hosted competitions</li>
</ul>

<?php
// form
$cur = 'wca_growth';
include('assets/forms/beginform.php');
include('assets/forms/regionId.php');
include('assets/forms/eventId.php');
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$query = "SELECT   year,
         COUNT(DISTINCT competitionId) AS competitions,
         COUNT(DISTINCT personId) AS persons,
         SUM(IF(value1>0,1,0)+IF(value2>0,1,0)+IF(value3>0,1,0)+IF(value4>0,1,0)+IF(value5>0,1,0)) AS solves,
         COUNT(DISTINCT Competitions.countryId) AS compcountries,
         COUNT(DISTINCT Results.personCountryId) AS perscountries,
         MIN(IF(eventId='333' and best>0,best,999999)) AS min333,
         MIN(IF(eventId='444' and best>0,best,999999)) AS min444,
         MIN(If(eventId='555' and best>0,best,999999)) AS min555,
         SUM(IF(regionalSingleRecord='WR',1,0)+IF(regionalAverageRecord='WR',1,0)) AS wrs
FROM     Results
         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= "GROUP BY year\n";
$query .= "ORDER BY year\n";

// build and query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th>Year</th>"
    ."<th>Competitions</th>"
    ."<th>Persons</th>"
    ."<th>Solves</th>"
    ."<th>CompCountries</th>"
    ."<th>PersCountries</th>"
    ."<th>Best 3x3x3</th>"
    ."<th>Best 4x4x4</th>"
    ."<th>Best 5x5x5</th>"
    ."<th>WRs</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
while($row = mysql_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['year'] . "</td>";
  echo "<td class='r'>" . $row['competitions'] . "</td>";
  echo "<td class='r'>" . $row['persons'] . "</td>";
  echo "<td class='r'>" . $row['solves'] . "</td>";
  echo "<td class='r'>" . $row['compcountries'] . "</td>";
  echo "<td class='r'>" . $row['perscountries'] . "</td>";
  echo "<td class='r'>" . $row['min333'] . "</td>";
  echo "<td class='r'>" . $row['min444'] . "</td>";
  echo "<td class='r'>" . $row['min555'] . "</td>";
  echo "<td class='r'>" . $row['wrs'] . "</td>";
  echo "</tr>\n";
}
echo "</table>\n\n";
?>

<h2>MySQL Query</h2>
<p>Based on code by Stefan Pochmann from <a href="http://www.speedsolving.com/forum/showthread.php?26513-WCA-growth-by-year">this thread</a>.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
