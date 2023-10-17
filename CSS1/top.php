<?php
$timeCurrent = time();
?>

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

require_once(LIB_PATH . 'DataBase.php');

$thisDataBaseReader = new DataBase('dblasi_reader', DATABASE_NAME);
$thisDataBaseWriter = new DataBase('dblasi_writer', DATABASE_NAME);



#   STATISTICS TRACKING

$tableNum = 1;
print '<!-- ***** This is combination CSS' . $tableNum . ' **** -->';
print '<!-- ***** Initialize variables **** -->';
$NetId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
$timePrevious = (isset($_GET['time'])) ? (int) htmlspecialchars($_GET['time']) : 0;
$pagePrevious = (isset($_GET['page'])) ? (string) htmlspecialchars($_GET['page']) : '';
print '<!-- ***** NetId = ' . $NetId . ' **** -->';
print '<!-- ***** Previous Time = ' . $timePrevious . ' seconds **** -->';
print '<!-- ***** Previous Page = ' . $pagePrevious . '.php **** -->';
$IndexVisits = 0;
$IndexTime = 0;
$MenVisits = 0;
$MenTime = 0;
$WomenVisits = 0;
$WomenTime = 0;
$FormVisits = 0;
$FormTime = 0;

if ($NetId != 'netid') {
    $sql = 'SELECT pmkNetId, fldIndexVisits, fldIndexTime, fldMenVisits, fldMenTime, fldWomenVisits, fldWomenTime, fldFormVisits, fldFormTime
            FROM tblCSS' . $tableNum . '
            WHERE pmkNetId = ?';

    $data = array($NetId);

    $records = $thisDataBaseWriter->select($sql, $data);

    if ($records == []) {
        print '<!-- ***** Creating new user profile **** -->';
        $sqlnew = 'INSERT INTO tblCSS' . $tableNum . ' SET
                pmkNetId = ?,
                fldIndexVisits = ?,
                fldIndexTime = ?,
                fldMenVisits = ?,
                fldMenTime = ?,
                fldWomenVisits = ?,
                fldWomenTime = ?,
                fldFormVisits = ?,
                fldFormTime = ?';
        $paramsnew = array(
            $NetId, $IndexVisits, $IndexTime, $MenVisits, $MenTime, $WomenVisits, $WomenTime, $FormVisits, $FormTime
        );
        if ($success = $thisDataBaseWriter->insert($sqlnew, $paramsnew)) {
            print '<!-- ***** Successfully created new user profile **** -->';
        };
    };

    $records = $thisDataBaseWriter->select($sql, $data);

    print '<!-- ***** Load user statistics **** -->';
    $IndexVisits = $records[0]['fldIndexVisits'];
    $IndexTime = $records[0]['fldIndexTime'];
    $MenVisits = $records[0]['fldMenVisits'];
    $MenTime = $records[0]['fldMenTime'];
    $WomenVisits = $records[0]['fldWomenVisits'];
    $WomenTime = $records[0]['fldWomenTime'];
    $FormVisits = $records[0]['fldFormVisits'];
    $FormTime = $records[0]['fldFormTime'];
}

print '<!-- ***** Update user visits **** -->';
if (PATH_PARTS['filename'] == "index") {
    $IndexVisits += 1;
    $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
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
} elseif (PATH_PARTS['filename'] == "men") {
    $MenVisits += 1;
    $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
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
} elseif (PATH_PARTS['filename'] == "women") {
    $WomenVisits += 1;
    $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
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
} elseif (PATH_PARTS['filename'] == "form") {
    $FormVisits += 1;
    $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
    pmkNetId = ?,
    fldFormVisits = ?
    ON DUPLICATE KEY UPDATE
    fldFormVisits = ?';
    $params = array(
        $NetId, $FormVisits,
        $FormVisits
    );
    if ($success = $thisDataBaseWriter->insert($sql, $params)) {
        print '<!-- ***** User data successfully updated **** -->';
    }
}

print '<!-- ***** Update user time **** -->';
if ($pagePrevious != '') {
    $timeSpent = $timeCurrent - $timePrevious;
    if ($pagePrevious == 'index') {
        $IndexTime += $timeSpent;
        $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
        pmkNetId = ?,
        fldIndexTime = ?
        ON DUPLICATE KEY UPDATE
        fldIndexTime = ?';
        $params = array(
            $NetId, $IndexTime,
            $IndexTime
        );
        if ($success = $thisDataBaseWriter->insert($sql, $params)) {
            print '<!-- ***** User data successfully updated **** -->';
        }
    } elseif ($pagePrevious == 'men') {
        $MenTime += $timeSpent;
        $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
        pmkNetId = ?,
        fldMenTime = ?
        ON DUPLICATE KEY UPDATE
        fldMenTime = ?';
        $params = array(
            $NetId, $MenTime,
            $MenTime
        );
        if ($success = $thisDataBaseWriter->insert($sql, $params)) {
            print '<!-- ***** User data successfully updated **** -->';
        }
    } elseif ($pagePrevious == 'women') {
        $WomenTime += $timeSpent;
        $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
        pmkNetId = ?,
        fldWomenTime = ?
        ON DUPLICATE KEY UPDATE
        fldWomenTime = ?';
        $params = array(
            $NetId, $WomenTime,
            $WomenTime
        );
        if ($success = $thisDataBaseWriter->insert($sql, $params)) {
            print '<!-- ***** User data successfully updated **** -->';
        }
    } elseif ($pagePrevious == 'form') {
        $FormTime += $timeSpent;
        $sql = 'INSERT INTO tblCSS' . $tableNum . ' SET
        pmkNetId = ?,
        fldFormTime = ?
        ON DUPLICATE KEY UPDATE
        fldFormTime = ?';
        $params = array(
            $NetId, $FormTime,
            $FormTime
        );
        if ($success = $thisDataBaseWriter->insert($sql, $params)) {
            print '<!-- ***** User data successfully updated **** -->';
        }
    }
}

print '<!-- ***** INCLUDE header.php **** -->';
include 'header.php';
print PHP_EOL;

print '<!-- ***** INCLUDE nav.php **** -->';
include 'nav.php';
print PHP_EOL;


?>