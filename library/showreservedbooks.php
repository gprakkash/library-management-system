<!DOCTYPE html>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
        <link href="styles/main.css" rel="stylesheet" type="text/css">
        <title>
            Reserved books list
        </title>
    </head>
    <body>
        <main>
            <?php
            session_start();
            if (!isset($_SESSION['reservedbooklist'])) {
                echo "You have no reserved books";
                echo "<br> <a href='index.php'> Return to home page</a>";
                echo "</main></body></html>";
                exit;
            }
            echo "you have reserved these books: <br> <br>";
            // The list is maintained as a single string
            // Split the list into separate titles and pring them out
            $reservedbooklist = split("/", $_SESSION['reservedbooklist']);
            foreach ($reservedbooklist as $reservedbook)
                echo $reservedbook . "<br>";
            echo "<br> <a href='index.php'> Return to home page</a>";
            ?>
        </main>
    </body>
</html>