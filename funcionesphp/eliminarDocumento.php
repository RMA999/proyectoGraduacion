<?php
header('Content-type: application/json');

include 'conexion.php';

$idDocumento = $_POST['id_documento'];
$tipoDocumento = $_POST['tipo_documento'];

if ($tipoDocumento == "Declaración jurada") {

    try {

        $conn->beginTransaction();

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


$myObj = new stdClass();
$myObj->mensaje = "Tipo documento no encontrado";
$myObj->estado = 'error';
$myObj->tipoDocumento = $tipoDocumento;
echo json_encode($myObj);
