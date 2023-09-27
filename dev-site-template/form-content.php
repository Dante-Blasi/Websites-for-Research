<?php
$dataIsGood = false;

$newsletterId = null;
$first = '';
$last = '';
$email = '';
$purchase = '';
$tops = false;
$pants = false;
$new = false;

if ($managerLoggedIn) {
    $newsletterId = (isset($_GET['fid'])) ? (int) htmlspecialchars($_GET['fid']) : null;

    if ($newsletterId > 0) {
        $sql = 'SELECT pmkNewsletterId, fldFirstName, fldLastName, fldEmail, fldPurchase, fldTops, fldPants, fldNew
            FROM tblNewsletter
            WHERE pmkNewsletterId = ?';

        $data = array($newsletterId);

        $records = $thisDataBaseWriter->select($sql, $data);

        $first = $records[0]['fldFirstName'];
        $last = $records[0]['fldLastName'];
        $email = $records[0]['fldEmail'];
        $purchase = $records[0]['fldPurchase'];
        $tops = $records[0]['fldTops'];
        $pants = $records[0]['fldPants'];
        $new = $records[0]['fldNew'];
    }
}

function getData($field)
{
    if (!isset($_POST[$field])) {
        $data = "";
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}

function verifyAlphaNum($testString)
{
    // Check for letters, numbers and dash, period, space and single quote only.
    return (preg_match("/^([[:alnum:]]|-|\.| |\'|&|;|#)+$/", $testString));
}
?>
<main>
    <section class="form-actual">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dataIsGood = true;

            $first = getData("txtFirst");
            $last = getData("txtLast");
            $email = getData("txtEmail");
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $purchase = getData("radPurchase");
            $tops = (int) getData("chkTops");
            $pants = (int) getData("chkPants");
            $new = (int) getData("chkNew");

            if ($first == "") {
                print '<p class="alert">Enter a first name</p>';
                $dataIsGood = false;
            }
            if ($last == "") {
                print '<p class="alert">Enter a last name</p>';
                $dataIsGood = false;
            }
            if ($email == "") {
                print '<p class="alert">Enter an email address</p>';
                $dataIsGood = false;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                print '<p class="alert">Enter a valid email address</p>';
                $dataIsGood = false;
            }
            if ($purchase != "Never" and $purchase != "1-3" and $purchase != "4+") {
                print '<p class="alert">Choose an amount of purchases</p>';
                $dataIsGood = false;
            }
            if ($tops == "") {
                $tops = 0;
            }
            if ($pants == "") {
                $pants = 0;
            }
            if ($new == "") {
                $new = 0;
            }
        }

        if ($dataIsGood) {
            try {
                $sql = 'INSERT INTO tblNewsletter SET
                    pmkNewsletterId = ?,
                    fldFirstName = ?,
                    fldLastName = ?,
                    fldEmail = ?,
                    fldPurchase = ?,
                    fldTops = ?,
                    fldPants = ?,
                    fldNew = ?
                    ON DUPLICATE KEY UPDATE
                    fldFirstName = ?,
                    fldLastName = ?,
                    fldEmail = ?,
                    fldPurchase = ?,
                    fldTops = ?,
                    fldPants = ?,
                    fldNew = ?';

                $params = array(
                    $newsletterId, $first, $last, $email, $purchase, $tops, $pants, $new,
                    $first, $last, $email, $purchase, $tops, $pants, $new
                );
                if ($success = $thisDataBaseWriter->insert($sql, $params)) {
                    print '<p class="alert">We have successfully added you to the online mailing list. A record of your responses has been 
                    sent to your email address.</p>';
                    $to = $email;
                    $from = 'StreetWearHouse Co. Customer Support <Dante.Blasi@uvm.edu>';
                    $subject = 'Newsletter Responses';
                    $message = '<p style="font: 14pt sans-serif;">Thank you for signing up for the StreetWearHouse Co. monthly newsletter. 
                                We hope you appreciate our commitment to updating customers with valuable information.</p>';
                    $message .= '<p style="font: 14pt sans-serif;">Stay well dressed,</p><p style="font: 14pt sans-serif;">SWH Co.</p>';
                    $message .= '<p style="font: 14pt sans-serif;">P.S. Don\'t worry about unsubscribing, I\'m not going to write a fake monthly newsletter</p>';
                    $message .= '<p>' . $first . '</p><p>' . $last . '</p><p>' . $email . '</p>';
                    if ($purchase == "Never") {
                        $message .= '<p>I have never shopped with StreetWearHouse Co.</p>';
                    } elseif ($purchase == "1-3") {
                        $message .= '<p>I have bought 1-3 products</p>';
                    } elseif ($purchase == "4+") {
                        $message .= '<p>I have bought 4+ products</p>';
                    }
                    if ($tops) {
                        $message .= '<p>I have previously bought shirts, sweaters, or hoodies</p>';
                    }
                    if ($pants) {
                        $message .= '<p>I have previously bought pants</p>';
                    }
                    if ($new) {
                        $message .= '<p>I have previously bought newly released clothing</p>';
                    }
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=utf-8\r\n";
                    $headers .= "From: " . $from . "\r\n";
                    $send = mail($to, $subject, $message, $headers);
                } else {
                    print '<p class="alert">The attempt to add you to the mailing list was unsuccessful, please contact a customer relations 
                    representative at this email address: Dante.Blasi@uvm.edu</p>';
                }
            } catch (PDOException $e) {
                print '<p class="alert">The attempt to add you to the mailing list was unsuccessful, please contact a customer relations 
                representative at this email address: Dante.Blasi@uvm.edu</p>';
            }
        }
        ?>
        <h2>Sign Up Today</h2>
        <form action="#" method="POST">
            <fieldset>
                <legend>Personal & Contact Information</legend>
                <p>
                    <input type="text" name="txtFirst" id="txtFirst" placeholder="First" value="<?php print $first; ?>" required>
                    <label for="txtFirst">First Name</label>
                </p>
                <p>
                    <input type="text" name="txtLast" id="txtLast" placeholder="Last" value="<?php print $last; ?>" required>
                    <label for="txtLast">Last Name</label>
                </p>
                <p>
                    <input type="text" name="txtEmail" id="txtEmail" placeholder="Email" value="<?php print $email; ?>" required>
                    <label for="txtEmail">Email</label>
                </p>
            </fieldset>

            <fieldset>
                <legend>Purchase History Information</legend>
                <p>
                    <input type="radio" name="radPurchase" id="radNever" value="Never" <?php
                                                                                        if ($purchase == "Never") print 'checked'; ?> required>
                    <label for="radNever">I have never shopped with StreetWearHouse Co.</label>
                </p>
                <p>
                    <input type="radio" name="radPurchase" id="rad1-3" value="1-3" <?php
                                                                                    if ($purchase == "1-3") print 'checked'; ?> required>
                    <label for="rad1-3">I have bought 1-3 products</label>
                </p>
                <p>
                    <input type="radio" name="radPurchase" id="rad4+" value="4+" <?php
                                                                                    if ($purchase == "4+") print 'checked'; ?> required>
                    <label for="rad4+">I have bought 4+ products</label>
                </p>
            </fieldset>

            <fieldset>
                <legend>Purchase Information</legend>
                <p>
                    <input type="checkbox" value="1" name="chkTops" id="chkTops" <?php
                                                                                    if ($tops) print 'checked'; ?>>
                    <label for="chkTops">I have previously bought shirts, sweaters, or hoodies</label>
                </p>
                <p>
                    <input type="checkbox" value="1" name="chkPants" id="chkPants" <?php
                                                                                    if ($pants) print 'checked'; ?>>
                    <label for="chkPants">I have previously bought pants</label>
                </p>
                <p>
                    <input type="checkbox" value="1" name="chkNew" id="chkNew" <?php
                                                                                if ($new) print 'checked'; ?>>
                    <label for="chkNew">I have previously bought newly released clothing</label>
                </p>
            </fieldset>

            <fieldset class="submit">
                <input type="submit" value="Submit" name="btnSubmit" id="btnSubmit">
            </fieldset>

        </form>
    </section>

    <section class="form-info">
        <h2>The Value of Our Newsletter</h2>
        <p>Signing up for monthly updates via our newsletter provides many benefits</p>
        <ul>
            <li>Detailed information on new offerings</li>
            <li>Sneak peaks at upcoming products</li>
            <li>Information regarding seasonal sales and discounts</li>
            <li>Articles written by our designers outlining their process</li>
            <li>Stories shared by valued customers</li>
        </ul>
    </section>

    <section class="pic">
        <h2>Join The StreetWearHouse Co. Newsletter</h2>
        <figure>
            <img src="images/newsletter.png" alt="Newsletter mail">
        </figure>
    </section>

</main>