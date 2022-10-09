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

INSERT INTO
    tipos_documentos (nombre)
VALUES
    ('Compraventa');

INSERT INTO
    tipos_documentos (nombre)
VALUES
    ('Declaración jurada');

INSERT INTO
    tipos_documentos (nombre)
VALUES
    ('Cesion de Derechos Hereditarios');

INSERT INTO
    tipos_documentos (nombre)
VALUES
    ('Donacion Entre Vivos');

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

CREATE
OR REPLACE VIEW vista_documentos AS
SELECT
    ROW_NUMBER() OVER (
        ORDER BY
            documentos.id
    ) as rowNumber,
    documentos.id AS id_documento,
    documentos.numero_escritura,
    tipos_documentos.nombre AS tipo_documento,
    documentos.fecha AS fecha_documento,
    documentos.url_archivo
FROM
    (
        documentos
        INNER JOIN tipos_documentos ON documentos.id_tipo_documento = tipos_documentos.id
    )
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