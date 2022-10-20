-- Script que actualiza la base de datos de v0.6 a v0.6.1
CREATE TABLE IF NOT EXISTS opciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    valor VARCHAR(50)
);

INSERT INTO opciones (nombre, valor) VALUES ('tips', 0);
INSERT INTO empresa (nombre, direccion, poblacion, provincia, cp) 
    VALUES ('miempresa', 'midireccion', 'mipoblacion', 'miprovincia', '00000');

INSERT INTO opciones (nombre, valor) VALUES ('version', '0.6.1');
