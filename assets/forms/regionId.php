<td valign='bottom'><div class='space'><label for='regionId'>Region:<br /><select class='drop' id='regionId' name='regionId'>
<option value=''>World</option>
<option value=''></option>
<?php
// current eventId
$curId = $_GET['regionId'];

// get official continent list
$query = "SELECT id, name FROM Continents";
$result = dbQuery($query);

// write options
while($row = mysql_fetch_array($result))
  writeOption($row['id'], $row['name'], $curId);

echo "<option value=''></option>";

// get official country list
$query = "SELECT id, name FROM Countries";
$result = dbQuery($query);

// write options
while($row = mysql_fetch_array($result))
  writeOption($row['id'], $row['name'], $curId);

?>
</select></label></div></td>
