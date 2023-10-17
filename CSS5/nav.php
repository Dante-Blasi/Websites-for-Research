<nav>
    <a class="<?php
                if (PATH_PARTS['filename'] == "index") {
                    print 'activePage';
                }
                ?>" href="<?php print 'index.php?time=' . $timeCurrent . '&page=' . PATH_PARTS['filename'] ?>">Home</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "men") {
                    print 'activePage';
                }
                ?>" href="<?php print 'men.php?time=' . $timeCurrent . '&page=' . PATH_PARTS['filename'] ?>">Men</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "women") {
                    print 'activePage';
                }
                ?>" href="<?php print 'women.php?time=' . $timeCurrent . '&page=' . PATH_PARTS['filename'] ?>">Women</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "form") {
                    print 'activePage';
                }
                ?>" href="<?php print 'form.php?time=' . $timeCurrent . '&page=' . PATH_PARTS['filename'] ?>">Newsletter</a>
</nav>