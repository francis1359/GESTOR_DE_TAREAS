CREATE DATABASE gestor_tareas;
USE gestor_tareas;

-- Tabla de grupos
CREATE TABLE grupo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    estado TINYINT(1) DEFAULT 1 -- 1 = Activo, 0 = Inactivo
);

-- Tabla de usuarios
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL, -- Se guardará encriptada
    grupo_id INT,
    cargo ENUM('Encargado', 'Miembro') NOT NULL,
    estado TINYINT(1) DEFAULT 1, -- 1 = Activo, 0 = Inactivo
    FOREIGN KEY (grupo_id) REFERENCES grupo(id) ON DELETE SET NULL
);

-- Tabla de tareas
CREATE TABLE tarea (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_inicial DATE NOT NULL,
    fecha_final DATE NOT NULL,
    estado ENUM('Pendiente', 'En Proceso', 'Completada') DEFAULT 'Pendiente'
);

-- Tabla de asignación de tareas a usuarios (tarea puede tener varios usuarios)
CREATE TABLE tarea_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tarea_id INT,
    usuario_id INT,
    descripcion TEXT NULL, -- Para que los usuarios confirmen que la hicieron
    FOREIGN KEY (tarea_id) REFERENCES tarea(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
);
