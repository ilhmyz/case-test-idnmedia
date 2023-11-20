-- Insert data into 'users' table
INSERT INTO users (username, email, password, created_at) VALUES
('admin', 'admin@admin.com', '$2y$10$8w7fsdvVrf4zZgza5vUM4unm24DyN7s20Da5UDDh4bKtzCfEL8J3G', NOW());

-- Insert data into 'posts' table
INSERT INTO posts (user_id, title, content, created_at) VALUES
(1, 'Hello World', 'Content for Hello, World!', NOW()),
(1, 'El Clasico', 'Python vs PHP', NOW()),
(1, 'Welcome JKT48', 'Post wota amatir', NOW());

-- Insert data into 'site_settings' table
INSERT INTO site_settings (title) VALUES
('IDN Man');
