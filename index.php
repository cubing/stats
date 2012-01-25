<?php
$title = 'Home';
include('assets/templates/header.tpl.php');
?>

<h2>Bests</h2>
<ul>
  <li><a href="best_worst_result.php">Best worst result (single or average)</a></li>
  <li><a href="best_medal_collection.php">Best Medal Collection</a></li>
</ul>

<h2>Events</h2>
<ul>
  <li><a href="total_solve_days.php">Total solve days for each event</a></li>
  <li><a href="combined_finals.php">Combined finals / finals by event</a></li>
  <li><a href="most_persons_per_event.php">Most persons per event</a></li>
</ul>

<h2>Mosts</h2>
<ul>
  <li><a href="most_competitions.php">Most competitions</a></li>
  <li><a href="most_solves.php">Most solves</a></li>
  <li><a href="most_solve_hours.php">Most solve hours</a></li>
  <li><a href="most_solves_with_x_dnfs.php">Most solves with x DNFs</a></li>
  <li><a href="most_solves_per_competition.php">Most solves per competition (on average)</a></li>
  <li><a href="most_results.php">Most DNF / DNS / sub-x / sup-x / exactly x</a></li>
  <li><a href="most_3_out_of_3_3bld.php">Most 3/3 3BLD</a></li>
  <li><a href="most_records.php?eventId=333">Most records</a></li>
</ul>

<h2>Other achievements</h2>
<ul>
  <li><a href="wc_medal_table.php">All-Time World Championship Medal Table (by country or by person)</a></li>
</ul>

<h2>Names</h2>
<ul>
  <li><a href="shortest_longest_names.php">Shortest/longest names</a></li>
  <li><a href="most_common_first_names.php">Most common first names</a></li>
  <li><a href="most_common_wca_id_middles.php">Most common WCA ID middles</a></li>
  <li><a href="consonant_vowel_ratio.php">Names with highest/lowest consonant/vowel ratio</a></li>
</ul>

<h2>Miscellaneous</h2>
<ul>
  <li><a href="men_women.php">Men/Women per country</a></li>
  <li><a href="wca_growth.php">WCA growth</a></li>
  <li><a href="single_average_record_same_time.php">Regional record single and average with the same time in same event</a></li>
  <li><a href="best_magicers_without_mmagic.php">Best Magicers without Master Magic result</a></li>
</ul>

<p>In progress:</p>
<ul>
  <li><a href="result_frequency.php">Result Frequency (for region or for person)</a></li>
  <li><a href="time_range_frequency.php">Time Range Frequency (one competitor)</a></li>
  <li><a href="faster_at_x_than_at_y.php">Faster than event x than at event y</a></li>
  <li><a href="faster_at_x_than_at_y.php">Faster than event x than at event y</a></li>
  <li><a href="average_over_single.php">Best average / best single</a></li>
</ul>

<h2>Statistics on other websites</h2>
<ul>
  <li><a href="http://worldcubeassociation.org/results/statistics.php">WCA Database - Fun Statistics</a></li>
  <li><a href="http://worldcubeassociation.org/results/misc/age_vs_speed.html">WCA Database - Age vs Speed</a></li>
  <li><a href="http://www.speedsolving.com/forum/showthread.php?25742-Competitors-Distance-Travelled">Competition Distance Travelled</a></li>
  <li><a href="http://www.stefan-pochmann.info/cubieverse/">Cubieverse: Blonk numbers and Center of the WCA universe</a></li>
  <li><a href="http://www.speedsolving.com/forum/showthread.php?26121-Odd-WCA-stats">Speedsolving.com: Odd WCA stats</a></li>
</ul>
 
<?php
include('assets/templates/footer.tpl.php');
?>