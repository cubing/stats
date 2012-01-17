<?php
// common php functions
// @require_once'd into assets/templates/header.tpl.php

// wrapper function for mysql query
function dbQuery($query) {
    $database="";
    $username="";
    $password="";
    mysql_connect('mysql.stats.cubing.net', $username, $password) or die("Unable to connect to database");
    @mysql_select_db($database) or die("Unable to select database");
    mysql_query("SET NAMES 'utf8'") or die(mysql_error());
    $result = mysql_query($query) or die(mysql_error());
    mysql_close();
    return $result;
}

// wrapper function for mysql query
function dbQueryHandle($query) {
    $database="";
    $username="";
    $password="";
    mysql_connect('mysql.stats.cubing.net', $username, $password) or die("Unable to connect to database");
    @mysql_select_db($database) or die("Unable to select database");
    mysql_query("SET NAMES 'utf8'") or die(mysql_error());
    $result = mysql_query($query) or die(mysql_error());
    mysql_close();
    return $result;
}

// wrapper function for mysql query
function dbCommand($query) {
    $database="";
    $username="";
    $password="";
    mysql_connect('mysql.stats.cubing.net', $username, $password) or die("Unable to connect to database");
    @mysql_select_db($database) or die("Unable to select database");
    mysql_query("SET NAMES 'utf8'") or die(mysql_error());
    $result = mysql_query($query) or die(mysql_error());
    mysql_close();
    return $result;
}

// wrapper function for mysqli_real_query (to avoid DELIMITER bug)
function mysqliQuery($query) {
    $database="";
    $username="";
    $password="";
    $link = mysqli_connect('mysql.stats.cubing.net', $username, $password, $database);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    mysqli_real_query($link, $query);
}


function writeOption($id, $name, $curId) {
  echo "<option ";
  if ($id == $curId)
    echo "selected ";
  echo "value='" . $id . "'>" . $name . "</option>\n";
}

// common strings

// restrict to world championships
function wc_str() {
  return "         AND competitionId in ('WC1982', 'WC2003', 'WC2005', 'WC2007', 'WC2009', 'WC2011')\n";
}

// only final round
function final_str() {
  return "         AND (roundId = 'f' OR roundId = 'c')\n";
}

function regionId_str() {
  $regionId = $_GET['regionId'];
  if ($regionId == "")
    return "";
  if ($regionId[0] == '_')
    return "         AND continentId = '" . $regionId . "'\n";
  else
    return "         AND personCountryId = '" . $regionId . "'\n";
}

function eventId_str() {
  $eventId = $_GET['eventId'];
  if ($eventId == '')
    return "";
  else
    return "         AND eventId = '" . $eventId . "'\n";
}

function years_str() {
  $years = explode('+', $_GET['years']);
  if ($years[0] == 'only')
    return "         AND Competitions.year = " . $years[1] . "\n";
  if ($years[0] == 'until')
    return "         AND Competitions.year <= " . $years[1] . "\n";
}

function personId_is_valid($personId) {
  return preg_match('/(1982|20[0-9][0-9])[A-Z][A-Z][A-Z][A-Z][0-9][0-9]/', $personId);
}

function personId_str() {
  $personId = $_GET['personId'];
  if ($personId == '')
    return "";
  else
    return "         AND personId = '" . $personId . "'\n";
}

function result_is_valid($result) {
  return preg_match('/(-1)|(-2)|([0-9]?[0-9]?[0-9]?(\.)?[0-9]?[0-9])?/', $result);
}

function to_comp($comp) {
  switch ($comp) {
    case 'sub':
      return '<';
    case 'sup':
      return '>';
    case 'equal':
      return '=';
    default: // shouldn't ever get here!
      return NULL;
  }
}

function to_result($value) {
  switch($value) {
    case -2:
      return "DNS";
      break;
    case -1:
      return "DNF";
      break;
    default:
      return number_format($value/100, 2, '.', '');
  }
}

?>