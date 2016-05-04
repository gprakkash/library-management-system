<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=library",
            "root", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
    $sth = $db->query("select * from books " . 
            "where author like '%Bryson'");
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
        printf("%-40s %-20s\n", $row["title"],
                $row["author"]);
    }
} catch (Exception $ex) {
    printf("We had a problem: %s\n", $ex->getMessage());
}

exit();
?>

