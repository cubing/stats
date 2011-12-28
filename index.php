<?php
$title = 'Home';
include('assets/templates/header.tpl.php');
?>

<p>Note: Fewest Moves and Multi-BLD don't work yet.</p>

<p>Working:</p>
<ul>
  <li><a href="wc_medal_table.php">All-Time World Championship Medal Table (by country or by person)</a></li>
  <li><a href="best_medal_collection.php">Best Medal Collection</a></li>
  <li><a href="men_women.php">Men/Women per Country</a></li>
  <li><a href="combined_finals.php">Combined finals / finals by event</a></li>
  <li><a href="best_worst_result.php">All-time Best worst result (single or average)</a></li>
  <li><a href="most_records.php?eventId=333">Most records</a></li>
  <li><a href="most_results.php">Most DNF / DNS / sub-x / sup-x / exactly x</a></li>
  <li><a href="wca_growth.php">WCA growth</a></li>
</ul>

<p>Working with small caveats:</p>
<ul>
  <li><a href="result_frequency.php">Result Frequency (for region or for person)</a></li>
  <li><a href="time_range_frequency.php">Time Range Frequency (one competitor)</a></li>
</ul>

<p>Buggy or under construction:</p>
<ul>
  <li><a href="faster_at_x_than_at_y.php">Faster than event x than at event y</a></li>
  <li><a href="faster_at_x_than_at_y.php">Faster than event x than at event y</a></li>
  <li><a href="average_over_single.php">Best average / best single</a></li>
</ul>

<h2>How can I try out my own queries?</h2>
<p>Download the <a href="http://worldcubeassociation.org/results/misc/export.html">WCA Database</a>. You'll need to search how to set up MySQL on your platform: <a href="https://www.google.com/search?q=mysql+windows">Windows</a>, <a href="https://www.google.com/search?q=mysql+mac">Mac</a>, <a href="https://www.google.com/search?q=mysql+ubuntu">Linux (Ubuntu)</a>.

<h2>How do I contribute?</h2>
<p>We welcome user submissions of statistics generated using php and MySQL code. Please send them to <a href="http://makisumi.com/">the webmaster</a>.</p>

<h2>Statistics on other websites</h2>
<ul>
  <li><a href="http://worldcubeassociation.org/results/statistics.php">WCA Database - Fun Statistics</a></li>
  <li><a href="http://worldcubeassociation.org/results/misc/age_vs_speed.html">WCA Database - Age vs Speed</a></li>
  <li><a href="http://www.speedsolving.com/forum/showthread.php?25742-Competitors-Distance-Travelled">Competition Distance Travelled</a></li>
  <li><a href="http://www.stefan-pochmann.info/cubieverse/">Cubieverse: Blonk numbers and Center of the WCA univer</a></li>
</ul>
 
<?php
include('assets/templates/footer.tpl.php');
?>