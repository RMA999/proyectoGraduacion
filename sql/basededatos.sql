CREATE TABLE personas (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dpi VARCHAR(20) NOT NULL,
    nombres VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    direccion VARCHAR(255) NOT NULL
);

CREATE TABLE roles (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_rol VARCHAR(255) NOT NULL
);

CREATE TABLE usuarios(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(255) NOT NULL,
    contrasenia VARCHAR(255) NOT NULL,
    estado VARCHAR(255) DEFAULT "desconectado",
    id_persona INT NOT NULL,
    id_rol INT NOT NULL,
    CONSTRAINT FK_usuario_persona FOREIGN KEY (id_persona) REFERENCES `personas` (id),
    CONSTRAINT FK_usuario_rol FOREIGN KEY (id_rol) REFERENCES `roles` (id)
);

CREATE TABLE tipos_documentos(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_tipo_ducumento VARCHAR(255) NOT NULL
);

CREATE TABLE documentos (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_tipo_documento INT NOT NULL,
    id_persona_vendedor INT,
    id_persona_comprador INT,
    fecha DATE NOT NULL,
    numero_escritura VARCHAR(20) NOT NULL,
    url_archivo VARCHAR(2083) NOT NULL,
    CONSTRAINT FK_documento_persona_vendedor FOREIGN KEY (id_persona_vendedor) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_persona_comprador FOREIGN KEY (id_persona_comprador) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_tipos_documento FOREIGN KEY (id_tipo_documento) REFERENCES `tipos_documentos` (id)
);