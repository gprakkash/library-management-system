<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <form action="counter-hidden.php" method="GET">
            <input type="submit" name="count" value="count">
            <?php
            if (! isset($_GET['counter']))
                $count = 0;
            else
                $count = $_GET['counter'];
            $count += 1;
            echo "<input type='hidden' name='counter'"
            . "value='$count'>";
            echo"count is $count";
            ?>
        </form>
    </body>
</html>