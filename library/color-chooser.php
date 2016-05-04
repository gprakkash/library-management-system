<!DOCTYPE html>
<?php
    // Build the array of color choices
    $colors = array("Pink" => "f0d0d0",
                    "Violet" => "cda8ef",
                    "Blue" => "a8c1ef",
                    "Green" => "a8efab",
                    "Yellow" => "efee7b");
    
    // If this is a postback, create the cookie
    if (isset($_GET['colorchosen']))
        setcookie('colorpreference', $colors[$_GET['colorchosen']]
                , time() + 24*3600, '/', 'library.example.org', false);
?>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
        <link href="styles/main.css" rel="stylesheet" type="text/css">
        <title>Choose Color Preference</title>
    </head>
    <body>
        <main>
        <?php
        if (isset($_GET['colorchosen'])){
            echo "Your color preference has been recorded";
            echo "<br> <a href='index.php'> Return to home page</a>";
            echo "\n</main>\n</body>\n</html>";
            exit;
        }
        // Not a postback, so present the color selection form
        ?>
        <form action="color-chooser.php" method="GET">
            <table>
                <tr>
                    <td>Choose your color:</td>
                    <td>
                        <select size="1" name="colorchosen">
                            <?php
                            // Populate drop-down from array of color choices
                            foreach ($colors as $name => $hex)
                                echo "<option> " .$name;
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <input type="submit" name="confirm" value="Confirm Preference">
                    </td>
                    <td></td>
                </tr>
            </table>
        </form>
        </main>
    </body>
</html>