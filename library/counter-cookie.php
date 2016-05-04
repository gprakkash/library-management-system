<!DOCTYPE html>
<?php
    if (! isset($_COOKIE['counter']))
        $count = 0;
    else
        $count = $_COOKIE['counter'];
    $count += 1;
    setcookie('counter', $count, time() + 120, '/', 'library.example.org'
            , false);
?>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <form action="counter-cookie.php" method="GET">
            <input type="submit" name="count" value="count">
            <?php
            echo"count is $count";
            ?>
        </form>
    </body>
</html>