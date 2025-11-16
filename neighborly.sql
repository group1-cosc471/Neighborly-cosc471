DROP DATABASE neighborly_lol;

CREATE DATABASE neighborly_lol;

USE neighborly_lol;

CREATE TABLE
    user (
        u_id INT UNIQUE PRIMARY KEY,
        f_name VARCHAR(50),
        l_name VARCHAR(50),
        email VARCHAR(100),
        phone_number VARCHAR(10), -- Phone numbers from US and CA
        user_password VARCHAR(50)
    );

CREATE TABLE
    sale (
        sale_id INT UNIQUE PRIMARY KEY,
        seller_id INT,
        street_address VARCHAR(250),
        municipality VARCHAR(250),
        s_date DATE,
        e_date DATE,
        open_time TIME,
        close_time TIME,
        sale_type VARCHAR(20),

        FOREIGN KEY (seller_id) REFERENCES user (u_id)
    );

CREATE TABLE
    item (
        item_id INT UNIQUE PRIMARY KEY,
        sale_id INT,
        reserved_by INT,
        item_name VARCHAR(24),
        item_dec TEXT,
        price DECIMAL(5, 2),
        FOREIGN KEY (sale_id) REFERENCES sale (sale_id),
        FOREIGN KEY (reserved_by) REFERENCES user (u_id)
    );

    -- Insert users
INSERT INTO
    user (u_id, f_name, l_name, email, phone_number, user_password)
VALUES
    (1, 'Alice', 'Johnson', 'alice.johnson@example.com', '5551234567', 'password1'),
    (2, 'Bob', 'Smith', 'bob.smith@example.com', '552345678', 'password2'),
    (3, 'Carol', 'Miller', 'carol.miller@example.com', '5553456789', 'password3'),
    (4, 'David', 'Brown', 'david.brown@example.com', '5554567890', 'password4'),
    (5, 'Eve', 'Wilson', 'eve.wilson@example.com', '5555678901', 'password5'),
    (6, 'Frank', 'Taylor', 'frank.taylor@example.com', '5556789012', 'password6'),
    (7, 'Grace', 'Davis', 'grace.davis@example.com', '5557890123', 'password7'),
    (8, 'Henry', 'Martin', 'henry.martin@example.com', '5558901234', 'password8'),
    (9, 'Ivy', 'Anderson', 'ivy.anderson@example.com', '5559012345', 'password9'),
    (10, 'Jack', 'Thomas', 'jack.thomas@example.com', '5550123456', 'password10');

-- Insert sales (each linked to a seller_id)
INSERT INTO
    sale (sale_id, seller_id, street_address, municipality, s_date, e_date, open_time, close_time, sale_type)
VALUES
    (1, 1, '123 Maple St', 'Springfield', '2025-12-01', '2025-12-05', '10:00:00', '16:00:00', 'Garage'),
    (2, 3, '45 Oak Ave', 'Shelbyville', '2025-10-30', '2025-11-09', '09:00:00', '17:00:00', 'Estate'),
    (3, 5, '789 Pine Dr', 'Ogdenville', '2025-11-14', '2025-11-16', '12:00:00', '19:00:00', 'Estate'),
    (4, 7, '56 Elm Blvd', 'North Haverbrook', '2025-11-27', '2025-12-01', '11:00:00', '16:30:00', 'Moving'),
    (5, 9, '321 Cedar Way', 'Capital City', '2026-01-01', '2026-01-17', '13:30:00', '20:00:00', 'Yard');

-- Insert items
INSERT INTO
    item (
        item_id,
        sale_id,
        reserved_by,
        item_name,
        item_dec,
        price
    )
VALUES
    (
        1,
        1,
        NULL,
        'Lamp',
        'A modern desk lamp with LED bulb',
        12.50
    ),
    (
        2,
        1,
        4,
        'Chair',
        'Wooden dining chair in good condition',
        20.00
    ),
    (
        3,
        1,
        NULL,
        'Table',
        'Round kitchen table with glass top',
        45.00
    ),
    (
        4,
        2,
        5,
        'Bicycle',
        'Adult road bike with 18 gears',
        150.00
    ),
    (
        5,
        2,
        NULL,
        'Helmet',
        'Bike helmet, size M',
        25.00
    ),
    (
        6,
        2,
        1,
        'Backpack',
        'Waterproof hiking backpack',
        30.00
    ),
    (
        7,
        3,
        NULL,
        'TV',
        '42-inch LED television',
        200.00
    ),
    (
        8,
        3,
        2,
        'DVD Player',
        'Sony DVD player with remote',
        35.00
    ),
    (
        9,
        3,
        NULL,
        'Speakers',
        'Pair of Bluetooth bookshelf speakers',
        80.00
    ),
    (
        10,
        4,
        NULL,
        'Bookshelf',
        '5-tier oak bookshelf',
        60.00
    ),
    (
        11,
        4,
        10,
        'Mirror',
        'Full-length mirror with wooden frame',
        25.00
    ),
    (
        12,
        4,
        NULL,
        'Desk',
        'Office desk with drawers',
        90.00
    ),
    (13, 5, 6, 'Sofa', '2-seater leather sofa', 300.00),
    (
        14,
        5,
        NULL,
        'Coffee Table',
        'Glass-top coffee table',
        75.00
    ),
    (
        15,
        5,
        7,
        'Rug',
        'Large living room area rug',
        120.00
    );