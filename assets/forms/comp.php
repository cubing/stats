<td valign='bottom'><div class='space'><label for='comp'>Comp:<br /><select class='drop' id='comp' name='comp'>
<?php
$curId = $_GET['comp'];
writeOption('sub', 'sub-', $curId);
writeOption('sup', 'sup-', $curId);
writeOption('equal', 'exactly', $curId);
?>
</select></label></div></td>