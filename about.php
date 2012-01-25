<?php
$title = 'About';
include('assets/templates/header.tpl.php');
?>

<p>stats.cubing.net collects statistics based on the <a href="http://worldcubeassociation.org/results/">WCA results database</a>. All statistics use php and MySQL queries on the latest WCA results database export. The project is <a href="https://github.com/cubing/stats">on GitHub</a>.</p>

<p>We take questions and requests on <a href="http://www.speedsolving.com/forum/showthread.php?34250-WCA-Statistics-Website">this Speedsolving Forums thread</a>.</p>

<h2>Why an unofficial statistics website?</h2>
<p>Although popular statistics may be incorporated into the official <a href="http://worldcubeassociation.org/results/statistics.php">WCA Statistics page</a>, some statistics are inherently unofficial, e.g. different proposed global ranking systems. The hope, moreover, is to encourage cubers, especially those without server access, to learn and experiment with php and MySQL.</p>

<h2>People</h2>
<ul>
 <li><a href="http://makisumi.com/">Shotaro Makisumi</a>: creator, current <a href="https://github.com/cubing/stats">GitHub</a> project maintainer and webmaster</li>
 <li><a href="http://garron.us/">Lucas Garron</a>: cubing.net hub</li>
 <li>Contributors: <a href="http://www.stefan-pochmann.info/">Stefan Pochmann</a>, Tim Reynolds, Alberto Burgos</li>
</ul>

<h2>How can I try out my own queries?</h2>
<p>Download the <a href="http://worldcubeassociation.org/results/misc/export.html">WCA Database</a>. You'll need to search how to set up MySQL on your platform: <a href="https://www.google.com/search?q=mysql+windows">Windows</a>, <a href="https://www.google.com/search?q=mysql+mac">Mac</a>, <a href="https://www.google.com/search?q=mysql+ubuntu">Linux (Ubuntu)</a>.

<h2>How can I contribute?</h2>
<p>Please send MySQL/php statistics code to <a href="http://makisumi.com/contact.html">the webmaster</a>. For the more technologically savvy, feel free to fork the <a href="http://github.com/cubing/stats">cubing/stats</a> GitHub repo.</p>

<?php
include('assets/templates/footer.tpl.php');
?>
