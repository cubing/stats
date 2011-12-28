<td valign='bottom'><div class='space'><label for='result'>Result:<br />
<input type='text' size='5' maxlength='5' id='result' name='result'
<?php
$result = $_GET['result'];
if ($result != '')
  echo " value=" . $result;
?>
>
</label></div></td>
