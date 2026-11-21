-- Insert Admin User (Password: password123)
-- Hash ya password123 ni iyi ikurikira (password_hash('password123', PASSWORD_DEFAULT))
INSERT INTO users (username, email, password_hash, role) VALUES 
('admin', 'admin@school.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCS4bZJ18JuywdE0fV0OqG5OqG5Oq', 'admin');

-- Insert Sample E-Books
INSERT INTO ebooks (title, author, category, file_url) VALUES 
('Web Programming Basics', 'Dr. Emmanuel', 'Programming', 'book1.jpg'),
('Database Systems', 'John Doe', 'Database', 'book2.jpg'),
('Networking Essentials', 'Jane Smith', 'Networking', 'book3.jpg'),
('PHP Advanced', 'Shukurumungu', 'Web Programming', 'book4.jpg');