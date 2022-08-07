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

   $searchArray = array();

   // Search
   $searchQuery = " ";
   if($searchValue != ''){
      $searchQuery = " AND (
           tipo_documento LIKE :tipo_documento  OR 
           nombre_vendedor LIKE :nombre_vendedor  OR
           nombre_comprador LIKE :nombre_comprador OR 
           numero_escritura LIKE :numero_escritura 
           ) ";
      $searchArray = array( 
           'tipo_documento'=>"%$searchValue%",
           'nombre_vendedor'=>"%$searchValue%",
           'nombre_comprador'=>"%$searchValue%",
           'numero_escritura'=>"%$searchValue%"
      );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM documentos ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM documentos WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT * FROM documentos WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

   // Bind values
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute();
   $empRecords = $stmt->fetchAll();

   $data = array();

   foreach ($empRecords as $row) {
      $data[] = array(
        "id"=>$row['id'],
        "tipo_documento"=>$row['tipo_documento'],
        "nombre_vendedor"=>$row['nombre_vendedor'],
        "nombre_comprador"=>$row['nombre_comprador'],
        "dpi_vendedor"=>$row['dpi_vendedor'],
        "dpi_comprador"=>$row['dpi_comprador'],
        "numero_escritura"=>$row['numero_escritura'],
        "url_archivo"=>$row['url_archivo'],
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