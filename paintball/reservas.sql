CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sede VARCHAR(100) NOT NULL,
    horario VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);