<?php
include 'top.php';

if (!$managerLoggedIn) {
    print '<h1>Not Found</h1>';
    print 'Page deleted by webmaster';
    die();
}
?>

<main>
    <h1 class="rounded">Manager Home Page</h1>
</main>

<?php
include 'footer.php';
?>