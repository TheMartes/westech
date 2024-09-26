-- Drop the table if it already exists (for migrations that run multiple times)
DROP TABLE IF EXISTS products;

-- Create the products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    brand VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL
);

-- Insert 18 products into the products table
INSERT INTO products (name, description, brand, category, price) VALUES
('Product 1', 'A description for product 1', 'Brand A', 'Category A', 19.99),
('Product 2', 'A description for product 2', 'Brand B', 'Category B', 29.99),
('Product 3', NULL, 'Brand A', 'Category A', 39.99), -- Product with no description
('Product 4', 'A description for product 4', 'Brand C', 'Category C', 49.99),
('Product 5', 'A description for product 5', 'Brand B', 'Category D', 59.99),
('Product 6', 'A description for product 6', 'Brand A', 'Category B', 69.99),
('Product 7', NULL, 'Brand C', 'Category C', 79.99), -- Product with no description
('Product 8', 'A description for product 8', 'Brand B', 'Category A', 89.99),
('Product 9', 'A description for product 9', 'Brand A', 'Category D', 99.99),
('Product 10', 'A description for product 10', 'Brand C', 'Category B', 109.99),
('Product 11', 'A description for product 11', 'Brand D', 'Category A', 119.99),
('Product 12', 'A description for product 12', 'Brand D', 'Category D', 129.99),
('Product 13', NULL, 'Brand A', 'Category B', 139.99), -- Product with no description
('Product 14', 'A description for product 14', 'Brand B', 'Category C', 149.99),
('Product 15', 'A description for product 15', 'Brand C', 'Category A', 159.99),
('Product 16', 'A description for product 16', 'Brand D', 'Category B', 169.99),
('Product 17', 'A description for product 17', 'Brand B', 'Category C', 179.99),
('Product 18', NULL, 'Brand A', 'Category D', 189.99); -- Product with no description