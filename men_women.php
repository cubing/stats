<?php
$title = 'Men/Women per Country';
include('assets/templates/header.tpl.php');

// build query
$query = "select c.countryId,
       if(men is null, 0, men) men, if(women is null, 0, women) women,
       if(men is null, 0, if(women is null, 99.99, round(men/women, 2))) ratio
from
    (select distinct countryId from Persons) c
    left join
        (select countryId, count(*) men
           from Persons
           where gender = 'm'
          group by countryId desc) m
    on c.countryId = m.countryId
    left join
        (select countryId,count(*) women
           from Persons
           where gender = 'f'
          group by countryId desc) w
    on c.countryId = w.countryId
order by ratio, men asc, women desc, countryId";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Country</th>"
    ."<th class='r'>Men/Women Ratio</th>"
    ."<th class='r'>Men</th>"
    ."<th class='r'>Women</th>"
    ."</thead>\n";

// write data
$rank = 0;
while($row = mysql_fetch_array($result)) {
  $rank++;
  // handle tie
  if ($row['ratio'] == $row_prev['ratio'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td>" . $row['countryId'] . "</td>";
  echo "<td class='r'>" . $row['ratio'] . "</td>";
  echo "<td class='r'>" . $row['men'] . "</td>";
  echo "<td class='r'>" . $row['women'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";
?>

<h2>MySQL Query</h2>
<p>Written by Alberto Burgos.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
