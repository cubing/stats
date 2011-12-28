<td valign='bottom'><div class='space'><label for='personId'>WCA ID:<br />
<input type='text' size='10' maxlength='10' id='personId' name='personId'
<?php
$personId = $_GET['personId'];
if ($personId != '')
  echo " value=" . $personId;
?>
>
</label></div></td>
