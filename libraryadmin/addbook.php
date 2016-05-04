<!DOCTYPE html>
<html>
    <head>
        <title>Add New Book</title>
    </head>
    <body>
        <?php
        if (isset($_POST['newbooktitle'])){
            // This is the postback so add the book to the database
            
            # Get data from form
            $newbooktitle = trim($_POST['newbooktitle']);
            $newbookauthor = trim($_POST['newbookauthor']);
            
            if (!$newbooktitle || !$newbookauthor){
                printf("You must specify both a title and an author");
                echo "<br><a href='index.php'> Return to home page</a>";
                echo "</body></html>";
                exit;
            }
            
            $newbooktitle = addslashes($newbooktitle);
            $newbookauthor = addslashes($newbookauthor);
            
            # Open the database using the "librarian" account
            
            try {
                $db = new PDO("mysql:host=localhost;dbname=library", "librarian",
                        "librarianpw");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $ex) {
                printf("Unable to open database: %s", $ex->getMessage());
                echo "<br><a href='index.php'> Return to home page</a>";
                echo "</body></html>";
                exit;
            }
            
            // Prepare an insert statement and execute it
            $stmt = $db->prepare("insert into books values"
                    . "(null, ?, ?, false, null, null)");
            $stmt->execute(array("$newbooktitle", "$newbookauthor"));
            printf("<br><p>Book Added!<p>");
            echo "<br><a href='index.php'> Return to home page</a>";
            echo "</body></html>";
            exit;
        }
        // Not a postbak, so present the book entry form
        ?>
        
        <h3>Add a new book</h3>
        <hr>
        <p>You must enter both a title and an author</p>
        <form action="addbook.php" method="POST">
            <table>
                <tbody>
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="newbooktitle"></td>
                    </tr>
                    <tr>
                        <td>Author:</td>
                        <td><input type="text" name="newbookauthor"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Add Book"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>