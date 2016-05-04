<!DOCTYPE html>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
        <link href="styles/main.css" rel="stylesheet" type="text/css">
        <title>
            Book Reservation Confirmation
        </title>
    </head>
    <body>
        <main>
            <?php
            // Get the title of the book we're reserving (from the URL)
            $bookstoreserve = urldecode($_GET['reservation']);
            session_start();
            if (!isset($_SESSION['reservedbooklist']))
                $reservebooklist = "";
            else
                $reservebooklist = $_SESSION['reservedbooklist'];
            // The list is maintained as a single string
            // with the titles separated by slashes
            $reservedbooklist = $reservebooklist . "/" . $bookstoreserve;
            $_SESSION['reservedbooklist'] = $reservedbooklist;
            echo "Thank you.<br> $bookstoreserve has been added to your reservation list.";
            echo "<br> <a href='index.php'> Return to home page</a>";
            ?>
        </main>
    </body>
</html>
