<td valign='bottom'><div class='space'><label for='years'>Years:<br /><select class='drop' id='years' name='years'>
<option value=''>All</option>
<option value=''></option>

<?php
$curId = $_GET['years'];
$years_until = array('until+2011' => 'until 2011',
                     'until+2010' => 'until 2010',
                     'until+2009' => 'until 2009',
                     'until+2008' => 'until 2008',
                     'until+2007' => 'until 2007',
                     'until+2006' => 'until 2006',
                     'until+2005' => 'until 2005',
                     'until+2004' => 'until 2004',
                     'until+2003' => 'until 2003',
                     'until+1982' => 'until 1982');
foreach ($years_until as $id => $name)
  writeOption($id, $name, $curId);
echo "<option value=''></option>";
$years_only = array('only+2011' => 'only 2011',
                    'only+2010' => 'only 2010',
                    'only+2009' => 'only 2009',
                    'only+2008' => 'only 2008',
                    'only+2007' => 'only 2007',
                    'only+2006' => 'only 2006',
                    'only+2005' => 'only 2005',
                    'only+2004' => 'only 2004',
                    'only+2003' => 'only 2003',
                    'only+1982' => 'only 1982');
foreach($years_only as $id => $name)
  writeOption($id, $name, $curId);
?>
<option value=''></option>
</select></label></div></td>
