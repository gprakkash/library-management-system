<?php
$searchtitle = "Pilgrim's";
$searchauthor = "Goudge";
try {
    $db = new PDO("mysql:host=localhost;dbname=library", "root", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    switch ($argv[1]) {
        case 1: // Build an SQL query explicitly
            $query = "select * from books where title like '%$searchtitle%' " .
                    "and author like '%$searchauthor%'";
            $stmt = $db->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printf("%-40s %-20s\n", $row["title"], $row["author"]);
            }
            break;

        case 2: // Use a prepared statement with parameters bound by position - Method 1
            $stmt = $db->prepare("select * from books where title like ? "
                    . "and author like ?");
            $stmt->execute(array("%$searchtitle%", "%$searchauthor%"));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printf("%-40s %-20s\n", $row["title"], $row["author"]);
            }
            break;

        case 3: // Use a prepared statement with parameters bound by position - Method 2
            $stmt = $db->prepare("select * from books where title regexp ? "
                    . "and author regexp ?");
            // When binding parameters you must pass a variable by reference
            // you cannot bind a literal
            $stmt->bindParam(1, $searchtitle);
            $stmt->bindParam(2, $searchauthor);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printf("%-40s %-20s\n", $row["title"], $row["author"]);
            }
            // To query for a different book just assign new values to
            // searchtitle and searchauthor and re-execute the query
            $searchtitle = "Potter";
            $searchauthor = "Rowling";
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printf("%-40s %-20s\n", $row["title"], $row["author"]);
            }
            break;

        case 4: // Use a prepared statement with parameters bound by name - Method 1
            $stmt = $db->prepare("select * from books where title like :title "
                    . "and author like :author");
            $stmt->execute(array(":title" => "%$searchtitle%",
                ":author" => "%$searchauthor%"));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printf("%-40s %-20s\n", $row["title"], $row["author"]);
            }
            break;

        case 5: // Use a prepared statement with parameters bound by name - Method 2
            $stmt = $db->prepare("select * from books where title regexp :title "
                    . "and author regexp :author");
            // You must bind a variable by reference, you cannot bind a literal
            $stmt->bindParam(':title', $searchtitle);
            $stmt->bindParam(':author', $searchauthor);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printf("%-40s %-20s\n", $row["title"], $row["author"]);
            }
            // To query for a different book just assign new values to
            // searchtitle and searchauthor and re-execute the query
            $searchtitle = "Potter";
            $searchauthor = "Rowling";
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printf("%-40s %-20s\n", $row["title"], $row["author"]);
            }
            break;
            
        case 6: // Use a stored procedure
            $stmt = $db->query("call overdue_books()");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                printf("%s\n", $row["title"]);
            }
            break;
            
        case 7: // Use a stored function
            $stmt = $db->prepare("select count_overdue_books(:days)");
            $stmt->bindParam(":days" , $days);
            $days = 1;
            $stmt->execute();
            printf("No. of overdue books = %d\n", $stmt->fetchColumn());
            break;
        
        case 8: // Execute a non-query (INSERT)
            $stmt = $db->prepare("insert into borrowers (name, address)"
                    . "values (:name, :address)");
            $stmt->execute(array(":name" => "Harold Wilson",
                ":address" => "10 Downing Street"));
            $stmt->execute(array(":name" => "Bill Clinton",
                ":address" => "1600 Pennsylvania Ave"));
            break;
        
        case 9: // Execute a non-query (DELETE)
            $stmt = $db->prepare("delete from borrowers where address = ?");
            $stmt->execute(array("10 Downing Street"));
            printf("%d rows deleted\n", $stmt->rowCount());
            break;
        
        case 10: // Execute a summary function
            $stmt = $db->query("select count(*) from books where author "
                    . "like '%Dickens'");
            printf("We have %d books by Dickens\n", $stmt->fetchColumn());
            break;
    }
} catch (Exception $ex) {
    printf("%s",$ex->getMessage());
}
?>