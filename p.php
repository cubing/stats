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

echo "<p>This page will eventually display some miscellaneous personal statistics.</p>";
echo "<p><a href='http://worldcubeassociation.org/results/p.php?i=" . $personId . "'>official WCA profile</a> for " . $personId  . "</p>";



// end if valid
}
?>

<h2>MySQL Query</h2>
<pre><?php echo $query; ?></pre>

<?php
include('assets/templates/footer.tpl.php');
?>
