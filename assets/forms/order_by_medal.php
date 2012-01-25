<td valign='bottom'><div class='space'><label for='order'>Order by:<br /><select class='drop' id='order' name='order'>
<?php
$curId = $_GET['order'];
writeOption('gold', 'Gold', $curId);
writeOption('total', 'Total', $curId);
echo "<option value=''></option>";
writeOption('silver', 'Silver', $curId);
writeOption('bronze', 'Bronze', $curId);
?>
</select></label></div></td>
