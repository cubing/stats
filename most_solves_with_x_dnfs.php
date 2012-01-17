<?php
$title = 'Most solves with x DNFs';
include('assets/templates/header.tpl.php');
?>

<p>Not necessarily solves in a row with x DNFs.</p>
<p>Not handling 'at most' option yet.</p>

<?php
// form
$cur = 'most_solves_with_x_dnfs';
include('assets/forms/beginform.php');
include('assets/forms/eventId.php');
include('assets/forms/regionId.php');
include('assets/forms/years.php');
?>

<td valign='bottom'><div class='space'><label for='comp'>Comp:<br /><select class='drop' id='comp' name='comp'>
<?php
$curId = $_GET['comp'];
writeOption('equal', 'exactly', $curId);
?>
</select></label></div></td>

<td valign='bottom'><div class='space'><label for='dnfs'>#DNFs:<br /><select class='drop' id='dnfs' name='dnfs'>
<?php
$curId = $_GET['dnfs'];
writeOption('0', '0', $curId);
writeOption('1', '1', $curId);
writeOption('2', '2', $curId);
writeOption('3', '3', $curId);
writeOption('4', '4', $curId);
writeOption('5', '5', $curId);
?>
</select></label></div></td>

<?php
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// validate
$valid = 1;

$comp = $_GET['comp'];
if ($comp != 'equal' && $comp != 'max') {
  $valid = 0;
  $query = "";
  echo "<p>Choose 'exactly' or 'at most'.</p>\n";
}
$dnfs = $_GET['dnfs'];
if ($dnfs != 0 && $dnfs != 1 && $dnfs != 2 && $dnfs != 3 && $dnfs != 4) {
  $valid = 0;
  $query = "";
  echo "<p>Choose number of DNFs.</p>\n";
}

if ($valid) {

// build query
$query = "select
  sum((value1>0) + (value2>0) + (value3>0) + (value4>0) + (value5>0)) solves,
  sum((value1=-1) + (value2=-1) + (value3=-1) + (value4=-1) + (value5=-1)) dnfs,
  personId, personName, personCountryId
from Results\n";
if ($_GET['years'] != '')
  $query .= "         JOIN Competitions ON Results.competitionId = Competitions.id\n";
if ($_GET['regionId'] != '')
  $query .="         JOIN Countries    ON Results.personCountryId = Countries.id\n";
$query .= "where    true\n";
$query .= regionId_str();
$query .= eventId_str();
$query .= years_str();
$query .= "group by personId
order by 2, 1 desc";

// submit query
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Country</th>"
    ."<th>Solves</th>"
    ."<th class='f'>&nbsp;</th>"
    ."</thead>\n";

// write data
$rank = 0;
$comp = $_GET['comp'];
$dnfs = $_GET['dnfs'];
while(($row = mysql_fetch_array($result)) && ($rank < 100)) {
  if ($comp == 'equal') {
    if ($row['dnfs'] < $dnfs)
      continue;
    if ($row['dnfs'] > $dnfs)
      break;
  }
  if ($comp == 'max') {
    if ($row['dnfs'] > $dnfs)
      break;
  }
  $rank++;
  // handle tie
  if ($row['solves'] == $row_prev['solves'])
    $rank_to_show = "&nbsp;";
  else
    $rank_to_show = $rank;
  $row_prev = $row;
  // write row
  echo "<tr>";
  echo "<td class='r'>" . $rank_to_show . "</td>";
  echo "<td><a class='p' href='p.php?i=". $row['personId'] ."'>" . $row['personName'] . "</a></td>";
  echo "<td>" . $row['personCountryId'] . "</td>";
  echo "<td class='r'>" . $row['solves'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>\n\n";

// end if valid
}
?>

<h2>MySQL Query</h2>
<p>Based on query written by Stefan Pochmann in <a href="http://www.speedsolving.com/forum/showthread.php?26121-Odd-WCA-stats&p=568957&viewfull=1#post568957">this post</a>.</p>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
