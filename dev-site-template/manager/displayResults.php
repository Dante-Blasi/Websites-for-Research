<?php
include 'top.php';

if (!$managerLoggedIn) {
    print '<h1>Not Found</h1>';
    print 'Page deleted by webmaster';
    die();
}

$newsletterId = (isset($_GET['fid'])) ? (int) htmlspecialchars($_GET['fid']) : 0;

$sql = 'SELECT pmkNewsletterId, fldFirstName, fldLastName, fldEmail, fldPurchase, fldTops, fldPants, fldAccessories
            FROM tblNewsletter
            WHERE pmkNewsletterId = ?';

$data = array($newsletterId);

$records = $thisDataBaseReader->select($sql, $data);

?>

<main>
    <h1 class="rounded">Data for: <?php print $records[0]['fldEmail']; ?></h1>

    <?php
    if (is_array($records)) {
        foreach ($records as $record) {
            print '<p>First Name: ' . $record['fldFirstName'] . '</p>';
            print '<p>Last Name: ' . $record['fldLastName'] . '</p>';
            print '<p>Number of Purchases: ' . $record['fldPurchase'] . '</p>';

            print '<p>Bought Tops Before?: ';
            print $record['fldTops'] ? 'Yes' : 'No';
            print '</p>';

            print '<p>Bought Pants Before?: ';
            print $record['fldPants'] ? 'Yes' : 'No';
            print '</p>';

            print '<p>Bought Tops Before?: ';
            print $record['fldAccessories'] ? 'Yes' : 'No';
            print '</p>';
        }
    }
    ?>
</main>

<?php
include 'footer.php';
?>