<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dante Blasi">
    <meta name="description" content="">

    <title>Dante Blasi CS148 Lab</title>

    <link rel="stylesheet" href="../css/custom.css?version=<?php print time(); ?>" type="text/css">
    <link rel="stylesheet" media="(max-width:600px)" href="../css/custom-phone.css?version=<?php print time(); ?>" type="text/css">

    <?php print '<!-- ***** INCLUDE constants.php **** -->';
    include '../lib/constants.php'; ?>
</head>

<?php

print '<!-- ***** Manager/Administrator Section **** -->';

$netId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
$managers = array('dblasi', 'rerickso', 'jcmcgowa', 'tallembe', 'idavis1');
$managerLoggedIn = in_array($netId, $managers) ? true : false;

print PHP_EOL;

print '<body id="' . PATH_PARTS['filename'] . '">';
print PHP_EOL;

print '<!-- ***** START OF BODY **** -->';
print PHP_EOL;

print '<!-- ***** INCLUDE header.php **** -->';
include 'header.php';
print PHP_EOL;

print '<!-- ***** INCLUDE nav.php **** -->';
include 'nav.php';
print PHP_EOL;

print '<!-- ***** Initialize Class File **** -->';
require_once('../' . LIB_PATH . 'DataBase.php');

$thisDataBaseReader = new DataBase('dblasi_reader', DATABASE_NAME);
$thisDataBaseWriter = new DataBase('dblasi_writer', DATABASE_NAME);
print PHP_EOL;

print '<!-- ***** End of Top **** -->';
print PHP_EOL;
?>