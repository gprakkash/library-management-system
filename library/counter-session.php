<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <form action="counter-session.php" method="GET">
            <input type="submit" name="count" value="count">
            <?php
            session_start();
            if (! isset($_SESSION['counter']))
                $count = 0;
            else
                $count = $_SESSION['counter'];
            $count += 1;
            $_SESSION['counter'] = $count;
            echo"count is $count";
            ?>
        </form>
    </body>
</html>