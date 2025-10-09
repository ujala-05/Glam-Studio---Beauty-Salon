
CREATE DATABASE salon_GS;
USE salon_GS;

-- Services/Products
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255) Not Null
);

-- Users: Either Admin or customers
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('customer','admin') DEFAULT 'customer'
);

-- Bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_id INT,
    booking_date DATE,
    booking_time TIME NOT NULL,
    status ENUM('Pending','Confirmed','Completed') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Feedback table
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    comments TEXT,
    rating INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Insert some services
INSERT INTO services (name, description, price, image) VALUES
('Hair Coloring', 'Different color looks', 75.00, 'images\\hair-coloring.png'),
('Hair Styling', 'Haircuts, blow-dry, and treatments', 60.00,'images\\hair-styling.png'),
('Eyelash Extension', 'long or short eye lash', 25.00, 'images\\eyelash-extension.png' ),
('Nail Extension', 'Manicures, pedicures, nail art, and extensions', 50.00, 'images\\nail-extension.png');

-- Insert admin account
INSERT INTO users (name, email, password, role) 
VALUES ('Admin', 'admin@salonGS.com', MD5('GlamStudio123'), 'admin');