CREATE TABLE personas (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dpi VARCHAR(13) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    direccion VARCHAR(255) DEFAULT ''
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
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE documentos (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_tipo_documento INT NOT NULL,
    id_persona_vendedor INT,
    id_persona_comprador INT,
    id_persona_declarador INT,
    -- tipo de documento Declaración jurada
    id_persona_donatario INT,
    id_persona_donador INT,
    id_persona_cedente INT,
    -- tipo sesion de derecho hereditario
    id_persona_cesionario INT,
    -- tipo sesion de derecho hereditario (pueden ser mas de una persona) de ultimo
    fecha DATE NOT NULL,
    fecha_escaneado DATE DEFAULT CURRENT_TIMESTAMP,
    numero_escritura VARCHAR(20) NOT NULL,
    ubicacion_fisica VARCHAR(1000) NOT NULL,
    url_archivo VARCHAR(2083) NOT NULL,
    CONSTRAINT FK_documento_persona_vendedor FOREIGN KEY (id_persona_vendedor) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_persona_comprador FOREIGN KEY (id_persona_comprador) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_persona_donatario FOREIGN KEY (id_persona_donatario) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_persona_donador FOREIGN KEY (id_persona_donador) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_persona_declarador FOREIGN KEY (id_persona_declarador) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_persona_difunto FOREIGN KEY (id_persona_cedente) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_persona_heredera FOREIGN KEY (id_persona_cesionario) REFERENCES `personas` (id),
    CONSTRAINT FK_documento_tipos_documento FOREIGN KEY (id_tipo_documento) REFERENCES `tipos_documentos` (id)
);

CREATE TABLE peticiones (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_documento INT,
    id_usuario INT,
    estado VARCHAR(100),
    CONSTRAINT FK_peticion_documento FOREIGN KEY (id_documento) REFERENCES `documentos` (id),
    CONSTRAINT FK_peticion_usuario FOREIGN KEY (id_usuario) REFERENCES `usuarios` (id)
);

CREATE
OR REPLACE VIEW vista_peticiones AS
SELECT
    peticiones.id AS id_peticion,
    peticiones.estado,
    documentos.id AS id_documento,
    documentos.numero_escritura,
    documentos.url_archivo,
    tipos_documentos.nombre AS tipo_documento,
    usuarios.id AS id_usuario,
    usuarios.nombre_usuario
FROM
    (((
        peticiones
        INNER JOIN documentos ON peticiones.id_documento = documentos.id)
        INNER JOIN tipos_documentos ON documentos.id_tipo_documento = tipos_documentos.id)
        INNER JOIN usuarios ON peticiones.id_usuario = usuarios.id);

-- CREATE
-- OR REPLACE VIEW vista_documentos AS
-- SELECT
--     ROW_NUMBER() OVER (
--         ORDER BY
--             documentos.id
--     ) as rowNumber,
--     documentos.id AS id_documento,
--     documentos.numero_escritura,
--     documentos.id_tipo_documento,
--     tipos_documentos.nombre AS tipo_documento,
--     documentos.fecha AS fecha_documento,
--     documentos.ubicacion_fisica,
--     documentos.url_archivo
-- FROM
--     (
--         documentos
--         INNER JOIN tipos_documentos ON documentos.id_tipo_documento = tipos_documentos.id
--     )
-- GROUP BY
--     documentos.numero_escritura;

CREATE
OR REPLACE VIEW vista_documentos AS
SELECT
    ROW_NUMBER() OVER (
        ORDER BY
            documentos.id
    ) as rowNumber,
    documentos.id AS id_documento,
    documentos.numero_escritura,
    documentos.id_tipo_documento,
    tipos_documentos.nombre AS tipo_documento,
    documentos.fecha AS fecha_documento,
    documentos.ubicacion_fisica,
    documentos.url_archivo,
    COMPRADOR.nombre AS nombre_comprador,
    VENDEDOR.nombre AS nombre_vendedor,
    DECLARADOR.nombre AS nombre_declarador,
    DONATARIO.nombre AS nombre_donatario,
    DONADOR.nombre AS nombre_donador,
    CEDENTE.nombre AS nombre_cedente,
    CESIONARIO.nombre AS nombre_cesionario
FROM
    ((((((((
        documentos
        INNER JOIN tipos_documentos ON documentos.id_tipo_documento = tipos_documentos.id)
     	LEFT JOIN personas COMPRADOR ON COMPRADOR.id = documentos.id_persona_comprador)
     	LEFT JOIN personas VENDEDOR ON VENDEDOR.id = documentos.id_persona_vendedor)
     	LEFT JOIN personas DECLARADOR ON DECLARADOR.id = documentos.id_persona_declarador)
     	LEFT JOIN personas DONATARIO ON DONATARIO.id = documentos.id_persona_donatario)
     	LEFT JOIN personas DONADOR ON DONADOR.id = documentos.id_persona_donador)
     	LEFT JOIN personas CEDENTE ON CEDENTE.id = documentos.id_persona_cedente)
     	LEFT JOIN personas CESIONARIO ON CESIONARIO.id = documentos.id_persona_cesionario)
GROUP BY
    documentos.numero_escritura;

CREATE
OR REPLACE VIEW vista_cesionarios AS
SELECT
    personas.id AS id_persona,
    personas.nombre,
    personas.dpi,
    documentos.numero_escritura
FROM
    (
        personas
        INNER JOIN documentos ON personas.id = documentos.id_persona_cesionario
    );

CREATE
OR REPLACE VIEW vista_cedentes AS
SELECT
    personas.id AS id_persona,
    personas.nombre,
    personas.dpi,
    documentos.numero_escritura
FROM
    (
        personas
        INNER JOIN documentos ON personas.id = documentos.id_persona_cedente
    );

CREATE
OR REPLACE VIEW vista_compradores AS
SELECT
    personas.id AS id_persona,
    personas.nombre,
    personas.dpi,
    documentos.numero_escritura
FROM
    (
        personas
        INNER JOIN documentos ON personas.id = documentos.id_persona_comprador
    );

CREATE
OR REPLACE VIEW vista_vendedores AS
SELECT
    personas.id AS id_persona,
    personas.nombre,
    personas.dpi,
    documentos.numero_escritura
FROM
    (
        personas
        INNER JOIN documentos ON personas.id = documentos.id_persona_vendedor
    );

CREATE
OR REPLACE VIEW vista_declaradores AS
SELECT
    personas.id AS id_persona,
    personas.nombre,
    personas.dpi,
    documentos.numero_escritura
FROM
    (
        personas
        INNER JOIN documentos ON personas.id = documentos.id_persona_declarador
    );

CREATE
OR REPLACE VIEW vista_usuarios AS
SELECT
    usuarios.id AS id_usuario,
    usuarios.nombre_usuario,
    usuarios.contrasenia,
    usuarios.estado,
    usuarios.id_rol,
    personas.id AS id_persona,
    personas.dpi,
    personas.nombre,
    roles.nombre_rol
FROM
    ((
        usuarios
        INNER JOIN personas ON usuarios.id_persona = personas.id)
        INNER JOIN roles ON usuarios.id_rol = roles.id);


CREATE
OR REPLACE VIEW vista_donadores AS
SELECT
    personas.id AS id_persona,
    personas.nombre,
    personas.dpi,
    documentos.numero_escritura
FROM
    (
        personas
        INNER JOIN documentos ON personas.id = documentos.id_persona_donador
    );

CREATE
OR REPLACE VIEW vista_donatarios AS
SELECT
    personas.id AS id_persona,
    personas.nombre,
    personas.dpi,
    documentos.numero_escritura
FROM
    (
        personas
        INNER JOIN documentos ON personas.id = documentos.id_persona_donatario
    );
