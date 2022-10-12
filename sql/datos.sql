TRUNCATE `documentos`;
TRUNCATE `personas`;
TRUNCATE `roles`;
TRUNCATE `tipos_documentos`;
TRUNCATE `usuarios`;


INSERT INTO `personas` (`id`, `dpi`, `nombre`, `direccion`) VALUES
(1, '2343', 'vendedor1', ''),
(2, '343453', 'comprador1', ''),
(3, '345345', 'declarador1', ''),
(4, '584684', 'cedente1', ''),
(5, '2335', 'cesionario1', ''),
(6, '234523', 'cesionario2', ''),
(7, '73764', 'cesionario3', ''),
(8, '34454', 'donante1', ''),
(9, '2344534', 'donatario1', ''),
(10, '324534', 'comprador2', ''),
(11, '754564', 'vendedor2', ''),
(12, '784664', 'declarador2', ''),
(13, '7346764', 'cedente2', ''),
(14, '74674', 'cesinario1', ''),
(15, '84764', 'cesinario2', '');

INSERT INTO `tipos_documentos` (`id`, `nombre`) VALUES
(1, 'Compraventa'),
(2, 'Declaración jurada'),
(3, 'Cesion de Derechos Hereditarios'),
(4, 'Donacion Entre Vivos');


INSERT INTO `documentos` (`id`, `id_tipo_documento`, `id_persona_vendedor`, `id_persona_comprador`, `id_persona_declarador`, `id_persona_donatario`, `id_persona_donador`, `id_persona_cedente`, `id_persona_cesionario`, `fecha`, `fecha_escaneado`, `numero_escritura`, `url_archivo`) VALUES
(1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-09-27', '2022-10-09', '111', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FcompraVentas%2Fdocumento-1665359746.pdf?alt=media&token=2770b07c-26cd-4d57-a21d-8171109a4044'),
(2, 2, NULL, NULL, 3, NULL, NULL, NULL, NULL, '2022-09-20', '2022-10-09', '222', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FdeclaracionesJuradas%2Fdocumento-1665359780.pdf?alt=media&token=77237462-2459-4cd5-946d-6944dfe8d54f'),
(3, 3, NULL, NULL, NULL, NULL, NULL, 4, 5, '2022-09-27', '2022-10-09', '333', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665359844.pdf?alt=media&token=694f9ecf-30fd-485d-b358-694c7665805c'),
(4, 3, NULL, NULL, NULL, NULL, NULL, 4, 6, '2022-09-27', '2022-10-09', '333', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665359844.pdf?alt=media&token=694f9ecf-30fd-485d-b358-694c7665805c'),
(5, 3, NULL, NULL, NULL, NULL, NULL, 4, 7, '2022-09-27', '2022-10-09', '333', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665359844.pdf?alt=media&token=694f9ecf-30fd-485d-b358-694c7665805c'),
(6, 4, NULL, NULL, NULL, 9, 8, NULL, NULL, '2022-09-27', '2022-10-09', '444', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fdonaciones%2Fdocumento-1665359901.pdf?alt=media&token=514789d8-462b-4750-ab6b-671ef6b76a63'),
(7, 1, 10, 11, NULL, NULL, NULL, NULL, NULL, '2022-09-12', '2022-10-09', '555', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FcompraVentas%2Fdocumento-1665360102.pdf?alt=media&token=7457d393-9caf-486e-a5e2-435c78dfdfb2'),
(8, 2, NULL, NULL, 12, NULL, NULL, NULL, NULL, '2022-09-14', '2022-10-09', '666', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FdeclaracionesJuradas%2Fdocumento-1665360123.pdf?alt=media&token=52ecfc91-646a-4543-816b-df93ca721c93'),
(9, 3, NULL, NULL, NULL, NULL, NULL, 13, 14, '2022-09-18', '2022-10-09', '777', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665360162.pdf?alt=media&token=5b833bb3-cff2-456d-b509-950f7225e35a'),
(10, 3, NULL, NULL, NULL, NULL, NULL, 13, 15, '2022-09-18', '2022-10-09', '777', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665360162.pdf?alt=media&token=5b833bb3-cff2-456d-b509-950f7225e35a');
