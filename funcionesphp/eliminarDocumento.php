<?php
header('Content-type: application/json');

include 'conexion.php';

$idDocumento = $_POST['id_documento'];
$tipoDocumento = $_POST['tipo_documento'];
$numeroEscritura = $_POST['numero_escritura'];

if ($tipoDocumento == "Declaración jurada") {

    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM peticiones WHERE id_documento = ?");
        $stmt->execute([$idDocumento]);

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE id = ? LIMIT 1");
        $stmt->execute([$idDocumento]);
        $documento = $stmt->fetch();

        $stmt = $conn->prepare("DELETE FROM documentos WHERE id = ?");
        $stmt->execute([$idDocumento]);

        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->execute([$documento['id_persona_declarador']]);


        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento eliminado";
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

    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM peticiones WHERE id_documento = ?");
        $stmt->execute([$idDocumento]);

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE id = ? LIMIT 1");
        $stmt->execute([$idDocumento]);
        $documento = $stmt->fetch();

        $stmt = $conn->prepare("DELETE FROM documentos WHERE id = ?");
        $stmt->execute([$idDocumento]);

        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->execute([$documento['id_persona_vendedor']]);

        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->execute([$documento['id_persona_comprador']]);


        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento eliminado";
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

    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM peticiones WHERE id_documento = ?");
        $stmt->execute([$idDocumento]);

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE id = ? LIMIT 1");
        $stmt->execute([$idDocumento]);
        $documento = $stmt->fetch();

        $stmt = $conn->prepare("DELETE FROM documentos WHERE id = ?");
        $stmt->execute([$idDocumento]);

        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->execute([$documento['id_persona_donatario']]);

        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->execute([$documento['id_persona_donador']]);


        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento eliminado";
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


if ($tipoDocumento == "Cesion de Derechos Hereditarios") {

    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM peticiones WHERE id_documento = ?");
        $stmt->execute([$idDocumento]);

        $stmt = $conn->prepare("SELECT * FROM documentos WHERE numero_escritura = ?");
        $stmt->execute([$numeroEscritura]);
        $documentos = $stmt->fetchAll();

        $stmt = $conn->prepare("DELETE FROM documentos WHERE numero_escritura = ?");
        $stmt->execute([$numeroEscritura]);

        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->execute([$documentos[0]['id_persona_cedente']]);

        for ($i = 0; $i < count($documentos); $i++) {
            $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
            $stmt->execute([$documentos[$i]['id_persona_cesionario']]);
        }


        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Documento eliminado";
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
echo json_encode($myObj);
