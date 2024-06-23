INSERT INTO users (id, name, email, email_verified_at, password, usertype, status, remember_token, created_at, updated_at) 
VALUES 
('1', 'Fercho', 'Fercho@gmail.com', NULL, '12345', 'user', '1', NULL, NULL, NULL),
('2', 'Camilo', 'Camilo@gmail.com', NULL, '12345', 'user', '1', NULL, NULL, NULL),
('3', 'Alison', 'Alison@gmail.com', NULL, '12345', 'user', '1', NULL, NULL, NULL)

INSERT INTO categorias (id, user_id, Nombre, status, created_at, updated_at) VALUES 
('1', '1', 'Paquetes', '1', NULL, NULL),
('2', '1', 'Super Ricas', '1', NULL, NULL),
('3', '1', 'Chitos', '1', NULL, NULL)