<?php
include 'top.php';

if (!$managerLoggedIn) {
    print '<h1>Not Found</h1>';
    print 'Page deleted by webmaster';
    die();
}
?>
<main>

    <h1 class="rounded">Newsletter Form Responses</h1>
    <?php
    $sql = 'SELECT pmkNewsletterId, fldFirstName, fldLastName, fldEmail, fldPurchase, fldTops, fldPants, fldAccessories
            FROM tblNewsletter
            ORDER BY fldEmail';

    $records = $thisDataBaseReader->select($sql);

    if (is_array($records)) {
        foreach ($records as $record) {
            print '<a href="form.php?fid=' . $record['pmkNewsletterId'] . '"><p>(Update Record)</p></a>' . ' ';
            print '<a href="displayResults.php?fid=' . $record['pmkNewsletterId'] . '">';
            print '<p>';
            print $record['fldEmail'] . ', ';
            print $record['fldFirstName'] . ', ';
            print $record['fldLastName'] . ', ';
            print $record['fldPurchase'] . ', ';

            print $record['fldTops'] ? 'Ordered Tops | ' : '';
            print $record['fldPants'] ? 'Ordered Pants | ' : '';
            print $record['fldAccessories'] ? 'Ordered Accessories' : '';
            print '</p>';
            print '</a>' . PHP_EOL;
        }
    }
    ?>
</main>

<?php
include 'footer.php';
?>