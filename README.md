# Neighborly-cosc471-
Repository for COSC471 Database Priciples Group 1 project: Neighborly: a garage sale database application.
Zinet: index.php
William: sale.php, updatesale.php
Jason: user.php
Sadman: createuser.php
Darius: items.php
Patrick: login.php, listsales.php

Setup steps:
Open mysql terminal as root user
Create the database from the script by running:
"source neighborly.sql" (if terminal is in the project folder otherwise you will need the full path to the file)

copy and paste the following commands:

    -- 1. Create the user (if it doesn’t already exist)
    CREATE USER 'neighborly'@'localhost' IDENTIFIED BY '123pwd456';

    -- 2. Grant all privileges on the specific database
    GRANT ALL PRIVILEGES ON neighborly_lol.* TO 'neighborly'@'localhost';

    -- 3. Apply the changes
    FLUSH PRIVILEGES;

exit mysql terminal.