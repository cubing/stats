<td valign='bottom'><div class='space'><label for='eventId'>Event:<br /><select class='drop' id='eventId' name='eventId'>
<option value=''>All</option>
<option value=''></option>
<?php
// current eventId
$curId = $_GET['eventId'];

// get official event list
$query = "SELECT id, name, rank FROM Events WHERE rank < 999";
$result = dbQuery($query);

// write options
while($row = mysql_fetch_array($result))
  writeOption($row['id'], $row['name'], $curId);
?>
</select></label></div></td>
