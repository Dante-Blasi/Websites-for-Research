<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dante Blasi">
    <meta name="description" content="">

    <title>Thesis Site</title>

    <link rel="stylesheet" href="css/custom.css?version=<?php print time(); ?>" type="text/css">
    <link rel="stylesheet" media="(max-width:600px)" href="css/custom-phone.css?version=<?php print time(); ?>" type="text/css">

    <?php print '<!-- ***** INCLUDE constants.php **** -->';
    include 'lib/constants.php'; ?>
</head>

<?php

print '<!-- ***** Manager/Administrator Section **** -->';

$managerLoggedIn = false;

print PHP_EOL;

print '<body id="' . PATH_PARTS['filename'] . '">';
print '<!-- ***** START OF BODY **** -->';
print PHP_EOL;

print '<!-- ***** INCLUDE header.php **** -->';
include 'header.php';
print PHP_EOL;

print '<!-- ***** INCLUDE nav.php **** -->';
include 'nav.php';
print PHP_EOL;

require_once(LIB_PATH . 'DataBase.php');

$thisDataBaseReader = new DataBase('dblasi_reader', DATABASE_NAME);
$thisDataBaseWriter = new DataBase('dblasi_writer', DATABASE_NAME);



#   STATISTICS TRACKING

print '<!-- ***** Initialize variables **** -->';
$NetId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
print '<!-- ***** NetId = ' . $NetId . ' **** -->';
$IndexVisits = 0;
$MenVisits = 0;
$WomenVisits = 0;

if ($NetId != 'netid') {
    $sql = 'SELECT pmkNetId, fldIndexVisits, fldMenVisits, fldWomenVisits
            FROM tblTest
            WHERE pmkNetId = ?';

    $data = array($NetId);

    $records = $thisDataBaseWriter->select($sql, $data);

    if ($records == []) {
        print '<!-- ***** Creating new user profile **** -->';
        $sqlnew = 'INSERT INTO tblTest SET
                pmkNetId = ?,
                fldIndexVisits = ?,
                fldMenVisits = ?,
                fldWomenVisits = ?';
        $paramsnew = array(
            $NetId, $IndexVisits, $MenVisits, $WomenVisits
        );
        if ($success = $thisDataBaseWriter->insert($sqlnew, $paramsnew)) {
            print '<!-- ***** Successfully created new user profile **** -->';
        };
    };

    $records = $thisDataBaseWriter->select($sql, $data);

    print '<!-- ***** Load user statistics **** -->';
    $IndexVisits = $records[0]['fldIndexVisits'];
    $MenVisits = $records[0]['fldMenVisits'];
    $WomenVisits = $records[0]['fldWomenVisits'];
}

print '<!-- ***** Update user statistics **** -->';
if (PATH_PARTS['filename'] == "index") {
    $IndexVisits += 1;
    $sql = 'INSERT INTO tblTest SET
    pmkNetId = ?,
    fldIndexVisits = ?
    ON DUPLICATE KEY UPDATE
    fldIndexVisits = ?';
    $params = array(
        $NetId, $IndexVisits,
        $IndexVisits
    );
    if ($success = $thisDataBaseWriter->insert($sql, $params)) {
        print '<!-- ***** User data successfully updated **** -->';
    }
}
if (PATH_PARTS['filename'] == "men") {
    $MenVisits += 1;
    $sql = 'INSERT INTO tblTest SET
    pmkNetId = ?,
    fldMenVisits = ?
    ON DUPLICATE KEY UPDATE
    fldMenVisits = ?';
    $params = array(
        $NetId, $MenVisits,
        $MenVisits
    );
    if ($success = $thisDataBaseWriter->insert($sql, $params)) {
        print '<!-- ***** User data successfully updated **** -->';
    }
}
if (PATH_PARTS['filename'] == "women") {
    $WomenVisits += 1;
    $sql = 'INSERT INTO tblTest SET
    pmkNetId = ?,
    fldWomenVisits = ?
    ON DUPLICATE KEY UPDATE
    fldWomenVisits = ?';
    $params = array(
        $NetId, $WomenVisits,
        $WomenVisits
    );
    if ($success = $thisDataBaseWriter->insert($sql, $params)) {
        print '<!-- ***** User data successfully updated **** -->';
    }
}
?>