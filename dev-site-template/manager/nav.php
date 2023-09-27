<nav>
    <a class="<?php
                if (PATH_PARTS['filename'] == "managerIndex") {
                    print 'activePage';
                }
                ?>" href="managerIndex.php">Home</a>

    <a class="<?php
                if (
                    PATH_PARTS['filename'] == "display" or
                    PATH_PARTS['filename'] == "displayResults"
                ) {
                    print 'activePage';
                }
                ?>" href="display.php">Registry</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "form") {
                    print 'activePage';
                }
                ?>" href="form.php">Form</a>
</nav>