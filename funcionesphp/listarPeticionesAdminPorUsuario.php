<?php
// Database Connection
include('conexion.php');

// Reading value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$idUsuario = $_POST['id_usuario'];

$searchArray = array();

// Search
$searchQuery = " AND id_usuario LIKE :id_usuario";
$searchArray = array(
   'id_usuario' => "%$idUsuario%"
);
if ($searchValue != '') {
   $searchQuery = " AND id_usuario LIKE :id_usuario AND (
           numero_escritura LIKE :numero_escritura  OR 
           tipo_documento LIKE :tipo_documento  OR
           estado LIKE :estado
           ) ";
   $searchArray = array(
      'numero_escritura' => "%$searchValue%",
      'tipo_documento' => "%$searchValue%",
      'estado' => "%$searchValue%",
      'id_usuario' => "%$idUsuario%"
   );
}

// Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM vista_peticiones WHERE id_usuario = ?");
$stmt->execute([$idUsuario]);
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

// Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM vista_peticiones WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

// Fetch records
$stmt = $conn->prepare("SELECT * FROM vista_peticiones WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

// Bind values
foreach ($searchArray as $key => $search) {
   $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach ($empRecords as $row) {
   $data[] = array(
      "id_peticion" => $row['id_peticion'],
      "id_documento" => $row['id_documento'],
      "numero_escritura" => $row['numero_escritura'],
      "tipo_documento" => $row['tipo_documento'],
      "estado" => $row['estado'],
      "url_archivo" => $row['url_archivo'],
   );
}

// Response
$response = array(
   "draw" => intval($draw),
   "iTotalRecords" => $totalRecords,
   "iTotalDisplayRecords" => $totalRecordwithFilter,
   "aaData" => $data
);

echo json_encode($response);
