<nav>
    <a class="<?php
                if (PATH_PARTS['filename'] == "index") {
                    print 'activePage';
                }
                ?>" href="index.php">Home</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "men") {
                    print 'activePage';
                }
                ?>" href="men.php">Men</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "women") {
                    print 'activePage';
                }
                ?>" href="women.php">Women</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "form") {
                    print 'activePage';
                }
                ?>" href="form.php">Newsletter</a>
</nav>