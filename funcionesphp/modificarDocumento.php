<?php
header('Content-type: application/json');

include 'conexion.php';

$idTipoDocumento = $_POST['idTipoDocumento'];

$stmt = $conn->prepare("SELECT * FROM tipos_documentos WHERE id = ? LIMIT 1");
$stmt->execute([$idTipoDocumento]);
$resultTipoDocumento = $stmt->fetch();
$tipoDocumento = $resultTipoDocumento['nombre'];


if ($tipoDocumento == "Cesion de Derechos Hereditarios") {

    $nombreCedente = $_POST['nombreCedente'];
    $dpiCedente = $_POST['dpiCedente'];
    $fecha = $_POST['fecha'];
    $numEscrituraAnt = $_POST['numEscrituraAnt'];
    $numEscritura = $_POST['numEscritura'];
    $urlArchivo = $_POST['urlArchivo'];
    $ubicacionFisica = $_POST['ubicacionFisica'];

    $cesionarios = (array) $_POST['cesionarios'];
    $cantidadCesionarios = count($cesionarios);

    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE numero_escritura = ?");
        $stmt->execute([$numEscrituraAnt]);
        $documentos = $stmt->fetchAll();

        $stmt = $conn->prepare("DELETE FROM documentos WHERE numero_escritura = ?");
        $stmt->execute([$numEscrituraAnt]);

        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->execute([$documentos[0]['id_persona_cedente']]);

        for ($i = 0; $i < count($documentos); $i++) {
            $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
            $stmt->execute([$documentos[$i]['id_persona_cesionario']]);
        }

        $idsCesionarios = [];
        $idsDocumentos = [];

        $stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) VALUES(?,?);");
        $stmt->execute([$dpiCedente, $nombreCedente]);
        $idCedente = $conn->lastInsertId();

        for ($x = 0; $x < $cantidadCesionarios; $x++) {
            $stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) VALUES(?,?);");
            $stmt->execute([$cesionarios[$x]['dpi'], $cesionarios[$x]['nombre']]);
            array_push($idsCesionarios, $conn->lastInsertId());
        }

        for ($x = 0; $x < $cantidadCesionarios; $x++) {
            $stmt = $conn->prepare("INSERT INTO documentos(id_tipo_documento, id_persona_cedente, id_persona_cesionario, fecha, ubicacion_fisica, numero_escritura, url_archivo) 
    VALUES(?,?,?,?,?,?,?);");
            $stmt->execute([$idTipoDocumento, $idCedente, $idsCesionarios[$x], $fecha, $ubicacionFisica, $numEscritura, $urlArchivo]);
            array_push($idsDocumentos, $conn->lastInsertId());
        }


        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento modificado";
        $myObj->estado = 'ok';
        echo json_encode($myObj);
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
    }
    return;
}


if ($tipoDocumento == "Compraventa") {
    $numEscrituraAnt = $_POST['numEscrituraAnt'];
    $nombreVendedor = $_POST['nombreVendedor'];
    $nombreComprador = $_POST['nombreComprador'];
    $dpiVendedor = $_POST['dpiVendedor'];
    $dpiComprador = $_POST['dpiComprador'];
    $fecha = $_POST['fecha'];
    $numEscritura = $_POST['numEscritura'];
    $urlArchivo = $_POST['urlArchivo'];
    $ubicacionFisica = $_POST['ubicacionFisica'];


    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE numero_escritura = ?");
        $stmt->execute([$numEscrituraAnt]);
        $documento = $stmt->fetch();

        //Update persona comprador
        $stmt = $conn->prepare("UPDATE personas SET dpi = ?, nombre = ? WHERE id = ?");
        $stmt->execute([$dpiComprador, $nombreComprador, $documento['id_persona_comprador']]);

        //Update persona vendedor
        $stmt = $conn->prepare("UPDATE personas SET dpi = ?, nombre = ? WHERE id = ?");
        $stmt->execute([$dpiVendedor, $nombreVendedor, $documento['id_persona_vendedor']]);

        //Update documento
        $stmt = $conn->prepare("UPDATE documentos SET fecha = ?, numero_escritura = ?, ubicacion_fisica = ?, url_archivo = ? WHERE id = ?");
        $stmt->execute([$fecha, $numEscritura, $ubicacionFisica, $urlArchivo, $documento['id']]);

        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento modificado";
        $myObj->estado = 'ok';
        echo json_encode($myObj);
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
    }


    return;
}


if ($tipoDocumento == "Declaración jurada") {
    $numEscrituraAnt = $_POST['numEscrituraAnt'];
    $nombreDeclarador = $_POST['nombreDeclarador'];
    $dpiDeclarador = $_POST['dpiDeclarador'];
    $fecha = $_POST['fecha'];
    $numEscritura = $_POST['numEscritura'];
    $urlArchivo = $_POST['urlArchivo'];
    $ubicacionFisica = $_POST['ubicacionFisica'];


    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE numero_escritura = ?");
        $stmt->execute([$numEscrituraAnt]);
        $documento = $stmt->fetch();

        //Update persona declarador
        $stmt = $conn->prepare("UPDATE personas SET dpi = ?, nombre = ? WHERE id = ?");
        $stmt->execute([$dpiDeclarador, $nombreDeclarador, $documento['id_persona_declarador']]);

        //Update documento
        $stmt = $conn->prepare("UPDATE documentos SET fecha = ?, numero_escritura = ?, ubicacion_fisica = ?, url_archivo = ? WHERE id = ?");
        $stmt->execute([$fecha, $numEscritura, $ubicacionFisica, $urlArchivo, $documento['id']]);

        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento modificado";
        $myObj->estado = 'ok';
        echo json_encode($myObj);
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
    }


    return;
}

if ($tipoDocumento == "Donacion Entre Vivos") {
    $numEscrituraAnt = $_POST['numEscrituraAnt'];
    $nombreDonante = $_POST['nombreDonante'];
    $nombreDonatario = $_POST['nombreDonatario'];
    $dpiDonante = $_POST['dpiDonante'];
    $dpiDonatario = $_POST['dpiDonatario'];
    $fecha = $_POST['fecha'];
    $numEscritura = $_POST['numEscritura'];
    $urlArchivo = $_POST['urlArchivo'];
    $ubicacionFisica = $_POST['ubicacionFisica'];


    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE numero_escritura = ?");
        $stmt->execute([$numEscrituraAnt]);
        $documento = $stmt->fetch();

        //Update persona donador
        $stmt = $conn->prepare("UPDATE personas SET dpi = ?, nombre = ? WHERE id = ?");
        $stmt->execute([$dpiDonante, $nombreDonante, $documento['id_persona_donador']]);

        //Update persona donatario
        $stmt = $conn->prepare("UPDATE personas SET dpi = ?, nombre = ? WHERE id = ?");
        $stmt->execute([$dpiDonatario, $nombreDonatario, $documento['id_persona_donatario']]);

        //Update documento
        $stmt = $conn->prepare("UPDATE documentos SET fecha = ?, numero_escritura = ?, ubicacion_fisica = ?, url_archivo = ? WHERE id = ?");
        $stmt->execute([$fecha, $numEscritura, $ubicacionFisica, $urlArchivo, $documento['id']]);

        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento modificado";
        $myObj->estado = 'ok';
        echo json_encode($myObj);
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
    }


    return;
}



$myObj = new stdClass();
$myObj->mensaje = "Tipo documento no encontrado";
$myObj->estado = 'error';
$myObj->tipoDocumento = $tipoDocumento;
$myObj->numEscrituraAnt = $numEscrituraAnt;
$myObj->cantidadCesionarios = $cantidadCesionarios;
$myObj->urlArchivo = $urlArchivo;
echo json_encode($myObj);
