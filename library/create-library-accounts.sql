# Start from scratch
# drop user 'librarian';
# drop user 'assistant';
# drop user 'borrower';

# librarian can add and delete books and borrowers
create user 'librarian' identified by 'librarianpw';
grant select, update, insert, delete on library.* to 'librarian';

# assistant can check books in and out
create user 'assistant' identified by 'assistantpw';
grant select on library.* to 'assistant';
grant update (onloan, duedate, borrowerid) on library.books to 'assistant';

# borrower can browse the books
create user 'borrower' identified by 'borrowerpw';
grant select on library.books to 'borrower';
