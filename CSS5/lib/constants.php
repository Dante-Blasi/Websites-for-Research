<?php
define('DEBUG', false);

$_SERVER = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
define('SERVER', $_SERVER['SERVER_NAME']);

define('DOMAIN', '//' . SERVER);

define('PHP_SELF', $_SERVER['PHP_SELF']);
define('PATH_PARTS', pathinfo(PHP_SELF));

define('BASE_PATH', DOMAIN . PATH_PARTS['dirname'] . '/');

define('LIB_PATH', 'lib/');

define('DATABASE_NAME', 'DBLASI_thesis');

define('USER_NAME', 'dblasi');

if (DEBUG == true) {
    print '<p>DOMAIN: ' . DOMAIN . '</p>';
    print '<p>PHP_SELF: ' . PHP_SELF . '</p>';
    print '<p>PATH_PARTS[dirname]: ' . PATH_PARTS['dirname'] . '</p>';
    print '<p>PATH_PARTS[basename]: ' . PATH_PARTS['basename'] . '</p>';
    print '<p>PATH_PARTS[extension]: ' . PATH_PARTS['extension'] . '</p>';
    print '<p>BASE_PATH: ' . BASE_PATH . '</p>';
    print '<p>LIB_PATH: ' . LIB_PATH . '</p>';
    print '<p>DATABASE_NAME: ' . DATABASE_NAME . '</p>';
    print '<p>USER_NAME: ' . USER_NAME . '</p>';
}
