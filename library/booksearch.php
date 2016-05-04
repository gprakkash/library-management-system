<!DOCTYPE html>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
        <link href="styles/main.css" rel="stylesheet" type="text/css">
        <title>Book Search Results</title>
    </head>
    <body>
        <main>
            <h1>Book Search Results</h1>
            <hr>
            <?php
            # This is the PDO version
            # Get data from form

            $searchtitle = trim($_POST['searchtitle']);
            $searchauthor = trim($_POST['searchauthor']);

            if (!$searchtitle && !$searchauthor) {
                printf("You must specify either a title or an author");
                echo "<br> <a href='index.php'> Return to home page</a>";
                echo "\n</main>\n</body>\n</html>";
                exit();
            }

            # handling cases when the search string have special characters
            $searchtitle = addslashes($searchtitle);
            $searchauthor = addslashes($searchauthor);
            # Open the database
            try {
                $db = new PDO("mysql:host=localhost;dbname=library", "borrower", "borrowerpw");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $ex) {
                printf("Unable to open database: %s\n", $ex->getMessage());
                echo "<br> <a href='index.php'> Return to home page</a>";
                echo "\n</main>\n</body>\n</html>";
                exit;
            }

            # Build the query
            # Users are allowed to search on title, author or both
            $query = "select * from books";
            if ($searchtitle && !$searchauthor) { // Title search only
                $query = $query . " where title like '%" . $searchtitle . "%'";
            }
            if (!$searchtitle && $searchauthor) { // Author search only
                $query = $query . " where author like '%" . $searchauthor . "%'";
            }
            if ($searchtitle && $searchauthor) { // Title and Author search
                $query = $query . " where title like '%" . $searchtitle
                        . "%' and author like '%" . $searchauthor . "%'";
            }

            // printf("Debug: running the query %s <br>", $query);

            try {
                $sth = $db->query($query);
                $bookcount = $sth->rowCount(); # Only works for mySQL
                if ($bookcount == 0) {
                    printf("Sorry, we did not find any matching books");
                    echo "<br> <a href='index.php'> Return to home page</a>";
                    echo "\n</main>\n</body>\n</html>";
                    exit;
                }

                // If the user has specified a color preference,
                // use it for table background
                if (isset($_COOKIE['colorpreference']))
                    $colorpreference = $_COOKIE['colorpreference'];
                else
                    $colorpreference = "#dddddd";

                printf('<table bgcolor="%s" cellpadding = "6">', $colorpreference);
                printf('<tr><b><td>Title</td> <td>Author</td> </b> </tr>');
                while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                    // We have a link on each row to allow the user to
                    // reserve the book
                    $reserveanchor = '<a href="reservebook.php?reservation=' .
                            urlencode($row['title']) . '">Reserve</a>';
                    printf("<tr> <td> %s </td> <td> %s </td> <td> %s </td>", htmlentities($row["title"]), htmlentities($row["author"]), $reserveanchor);
                }
            } catch (Exception $ex) {
                printf("We had a problem: %s\n", $ex->getMessage());
                echo "<br> <a href='index.php'> Return to home page</a>";
                echo "\n</main>\n</body>\n</html>";
                exit;
            }
            printf("</table>");
            printf("<br> We found %s matching books", $bookcount);
            echo "<br> <a href='index.php'> Return to home page</a>";
            ?>
        </main>
    </body>
</html>

