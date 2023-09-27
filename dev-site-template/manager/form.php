<?php
include 'top.php';

if (!$managerLoggedIn) {
    print '<h1>Not Found</h1>';
    print 'Page deleted by webmaster';
    die();
}

include '../form-content.php';

include 'footer.php';
