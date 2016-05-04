<!DOCTYPE html>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
        <link href="styles/main.css" rel="stylesheet" type="text/css">
        <title>Contact Us</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <main>
            <?php
            // Validation
            if ($_POST["customeremail"] == "") {
                echo "You did not enter an email address";
                echo "<br> <a href='index.php'> Return to home page</a>";
                echo "</main></body></html>";
                exit;
            }

            if (!ereg("[a-z]+@[a-z]+\.[a-z]+", $_POST["customeremail"])) {
                echo "Email address is not valid";
                echo "<br> <a href='index.php'> Return to home page</a>";
                echo "</main></body></html>";
                exit;
            }

            // Get the data form the form
            // This version has no error checking
            $customeremail = $_POST["customeremail"];
            $message = $_POST["message"];
            $replywanted = false;
            if (isset($_POST["replywanted"]))
                $replywanted = true;

            // Build the text of the email
            $t = "You have received a message from " . $customeremail . ":\n";
            $t = $t . $message . "\n";
            if ($replywanted)
                $t = $t . "A reply was requested";
            else
                $t = $t . "No reply was requested";

            // Send an email to the librarian
            mail("gaurav@example.org", "Customer Message", $t);

            // Give the user a nice warm fuzzy feeling
            echo "Thank you. Your message has been sent";
            echo "<br> <a href='index.php'> Return to home page</a>";
            ?>
        </main>
    </body>
</html>