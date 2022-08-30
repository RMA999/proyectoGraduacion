CREATE TABLE documentos (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tipo_documento VARCHAR(50) NOT NULL,
    nombre_vendedor VARCHAR(200) NOT NULL,
    nombre_comprador VARCHAR(200) NOT NULL,
    dpi_vendedor VARCHAR(15) NOT NULL,
    dpi_comprador VARCHAR(15) NOT NULL,
    fecha DATE NOT NULL,
    numero_escritura VARCHAR(20) NOT NULL,
    url_archivo VARCHAR(2083) NOT NULL
    );