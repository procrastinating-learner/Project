CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT true
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    image VARCHAR(255),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);
CREATE TABLE product_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Inserting 
INSERT INTO categories (category_name) VALUES ('Electronics');
INSERT INTO categories (category_name) VALUES ('Clothing');
INSERT INTO categories (category_name) VALUES ('Home and Garden');
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Laptop', 'High-performance laptop with SSD', 1200.00, 50, 'images/laptop_image.jpg', 1);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Smartphone', 'Latest smartphone with dual camera', 800.00, 100, 'images/smartphone_image.jpg', 1);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Smart TV', '4K UHD Smart TV with HDR', 1500.00, 30, 'images/tv_image.jpg', 1);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Gaming Console', 'Next-gen gaming console with VR support', 500.00, 50, 'images/console_image.jpg', 1);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('T-shirt', 'Comfortable cotton T-shirt', 25.00, 200, 'images/tshirt_image.jpg', 2);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Coffee Maker', 'Automatic coffee maker for your kitchen', 50.00, 30, 'images/coffeemaker_image.jpg', 3);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Wireless Headphones', 'High-quality noise-canceling headphones', 150.00, 80, 'images/headphones_image.jpg', 1);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Digital Camera', 'Professional DSLR camera with 4K recording', 900.00, 40, 'images/camera_image.jpg', 1);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Men\'s Casual Shirt', 'Comfortable and stylish shirt for everyday wear', 35.00, 100, 'images/shirt_image.jpg', 2);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Women\'s Running Shoes', 'Lightweight and breathable shoes for active women', 60.00, 75, 'images/shoes_image.jpg', 2);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Garden Furniture Set', 'Durable and elegant outdoor furniture set', 300.00, 20, 'images/furniture_image.jpg', 3);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Kitchen Blender', 'Powerful blender for smoothies and food prep', 80.00, 50, 'images/blender_image.jpg', 3);

INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Women\'s Denim Jeans', 'Classic denim jeans for a stylish look', 45.00, 60, 'images/jeans_image.jpg', 2);
INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('Indoor Plants Set', 'Assortment of low-maintenance indoor plants', 25.00, 30, 'images/plants_image.jpg', 3);

INSERT INTO product_details (product_id, details) VALUES (1, 'High-performance laptop with SSD details.');
INSERT INTO product_details (product_id, details) VALUES (2, 'Latest smartphone with dual camera details.');
INSERT INTO product_details (product_id, details) VALUES (3, '4K UHD Smart TV with HDR details.');
INSERT INTO product_details (product_id, details) VALUES (4, 'Next-gen gaming console with VR support details.');
INSERT INTO product_details (product_id, details) VALUES (5, 'Comfortable cotton T-shirt details.');
INSERT INTO product_details (product_id, details) VALUES (6, 'Automatic coffee maker for your kitchen details.');
INSERT INTO product_details (product_id, details) VALUES (7, 'High-quality noise-canceling headphones details.');
INSERT INTO product_details (product_id, details) VALUES (8, 'Professional DSLR camera with 4K recording details.');
INSERT INTO product_details (product_id, details) VALUES (9, 'Comfortable and stylish shirt for everyday wear details.');
INSERT INTO product_details (product_id, details) VALUES (10, 'Lightweight and breathable shoes for active women details.');
INSERT INTO product_details (product_id, details) VALUES (11, 'Durable and elegant outdoor furniture set details.');
INSERT INTO product_details (product_id, details) VALUES (12, 'Powerful blender for smoothies and food prep details.');
INSERT INTO product_details (product_id, details) VALUES (13, 'Classic denim jeans for a stylish look details.');
INSERT INTO product_details (product_id, details) VALUES (14, 'Assortment of low-maintenance indoor plants details.');
