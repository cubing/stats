<?php
$title = 'Names with highest/lowest consonant/vowel ratio';
include('assets/templates/header.tpl.php');

// form
$cur = 'consonant_vowel_ratio';
include('assets/forms/beginform.php');
include('assets/forms/regionId.php');
?>

<td valign='bottom'><div class='space'><label for='y'>Option:<br /><select class='drop' id='y' name='y'>
<?php
// current eventId
$curId = $_GET['y'];
writeOption('vowel', 'y is a vowel', $curId);
writeOption('consonant', 'y is a consonant', $curId);
?>
</select></label></div></td>

<?php
include('assets/forms/submit.php');
include('assets/forms/endform.php');

// build query
$drop = "DROP FUNCTION IF EXISTS `remove_ai_ci`;";
dbQuery($drop);

$create = "CREATE FUNCTION  `remove_ai_ci`(original VARCHAR(1000), remove VARCHAR(1000))
RETURNS VARCHAR(1000)
DETERMINISTIC
BEGIN 
 DECLARE temp VARCHAR(1000);
 DECLARE ch VARCHAR(1);
 DECLARE rm VARCHAR(1);
 DECLARE i INT;
 DECLARE j INT;
 DECLARE matched INT;
 SET i = 1;
 SET temp = '';
 loop_label: LOOP
  IF i>CHAR_LENGTH(original) THEN
   LEAVE loop_label;
  END IF;
  SET ch = SUBSTRING(original,i,1);
  SET j = 1;
  SET matched = 0;
  loop_label2: LOOP
   IF j>CHAR_LENGTH(remove) THEN
    LEAVE loop_label2;
   END IF;
   SET rm = SUBSTRING(remove,j,1);
   IF ch LIKE rm COLLATE utf8_general_ci THEN
    SET matched = 1;
    LEAVE loop_label2;
   END IF;
   SET j=j+1;
  END LOOP;
  IF matched = 0 THEN
   SET temp = CONCAT(temp,ch);
  END IF;
  SET i=i+1;
 END LOOP;
 RETURN temp;
END";
mysqliQuery($create);

$query = "SELECT   id, name, countryId, letters, consonants, (letters - consonants) AS vowels, IF(letters = consonants, 99.9999, consonants/(letters - consonants)) AS ratio
FROM     (
          SELECT   p.id, p.name, p.countryId,
                   CHAR_LENGTH(remove_ai_ci(SUBSTRING_INDEX(p.name, '(', 1), ' -`.\'0123456789')) AS letters,
                   CHAR_LENGTH(remove_ai_ci(SUBSTRING_INDEX(p.name, '(', 1), ' -`.\'0123456789aoeui";
$y = $_GET['y'];
if ($y == '' || $y == 'vowel')
  $query .= "y";
$query .= "øæœ')) AS consonants
          FROM     Persons p\n";
$regionId = $_GET['regionId'];
if ($regionId != '' && $regionId[0] == '_')
  $query .="                   JOIN Countries c    ON p.countryId = c.id\n";
if ($regionId != '') {
  if ($regionId[0] == '_')
    $query .= "          WHERE    c.continentId = '" . $regionId . "'\n";
  else
    $query .= "          WHERE    p.countryId = '" . $regionId . "'\n";
}
$query .= "         ) helper
ORDER BY ratio DESC, consonants DESC
LIMIT    100;";
$result = dbQuery($query);

// table heading
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>\n";
echo "<thead>"
    ."<th class='r'>Rank</th>"
    ."<th>Person</th>"
    ."<th>Citizen of</th>"
    ."<th class='r'>Consonant/Vowel ratio</th>"
    ."<th class='r'>Consonants</th>"
    ."<th class='r'>Vowels</th>"
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
  echo "<td><a class='p' href='p.php?i=". $row['id'] ."'>" . $row['name'] . "</a></td>";
  echo "<td>" . $row['countryId'] . "</td>";
  echo "<td class='r'>" . $row['ratio'] . "</td>";
  echo "<td class='r'>" . $row['consonants'] . "</td>";
  echo "<td class='r'>" . $row['vowels'] . "</td>";
  echo "<td class='f'>&nbsp;</td>";
  echo "</tr>\n";
}
echo "</table>";

$drop2 = "DROP FUNCTION `remove_ai_ci`;";
$result = dbQuery($drop2);

?>

<h2>MySQL Query</h2>
<p>by Shotaro Makisumi</p>
<pre><?php echo $drop; ?> 
DELIMITER %%
<?php echo $create; ?>%%
DELIMITER ;
<?php echo $query; ?> 
<?php echo $drop2; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
