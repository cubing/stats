<?php
$title = 'Personal statistics';
include('assets/templates/header.tpl.php');

// validation
$valid = 1;
$personId = $_GET['i'];
if (!personId_is_valid($personId)) {
  $valid = 0;
  $query = "";
  echo "'" . $personId . "' is not a valid WCA ID.";
}

if ($valid) {

$query = "SELECT * FROM Persons WHERE id = '" . $personId . "'";
$result = dbQuery($query);
$row = mysql_fetch_array($result);

echo "<p><a href='http://worldcubeassociation.org/results/p.php?i=" . $personId . "'>official WCA profile</a> for " . $personId  . "</p>";

echo "<h1>" . $row['name'] . "</h1>

<table width='100%' border='0' cellpadding='0' cellspacing='0' class='results'>

<tr><td colspan='4'>&nbsp;</td></tr>

<tr><td class='caption' colspan='4'>Details</td></tr>

<thead>
<th>Country</th>
<th>WCA Id</th>
<th>Date of birth</th>
<th class='f'>Gender</th>
</thead>

<tr><td>" . $row['countryId'] . "</td><td>" . $row['id'] . "</td><td> </td><td class='f'>" . $row['gender'] . "</td></tr>
</table>";


// end if valid
}
?>

<h2>MySQL Query</h2>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
