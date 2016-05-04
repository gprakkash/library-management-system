/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  gaurav
 * Created: Apr 18, 2016
 */


USE 'library';
DROP procedure IF EXISTS overdue_books;

DELIMITER $$
USE 'library'$$
CREATE PROCEDURE overdue_books ()
BEGIN
select title from books where duedate < current_date;
END
$$

DELIMITER ;


USE 'library';
DROP function IF EXISTS count_overdue_books;

DELIMITER $$
USE 'library'$$
CREATE FUNCTION count_overdue_books (days integer)
RETURNS INTEGER
BEGIN
    return (select count(*) from books
    where duedate < date_sub(current_date(), interval days day));
END$$

DELIMITER ;