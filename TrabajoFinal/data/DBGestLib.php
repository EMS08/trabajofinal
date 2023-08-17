<?php
class DBGestLib {

     private function getConexion(){
       $servidor = 'db4free.net';
       $dataBase = 'dblibreriafinal';
       $dns = "mysql:host=$servidor;dbname=$dataBase";
       $user = 'ems20220376';
       $password = 'esteban20220376';

        $obPDO = new PDO ($dns, $user, $password);
        return $obPDO;
     }

     public function getUsuarios($id){
      $id = intval($id);

      $objBD = $this->getConexion();
      $sql = "SELECT * FROM usuarios WHERE id = :id";
      $stmt = $objBD->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT); 

      try {
          $stmt->execute();
          $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
          if ($resultados && count($resultados) > 0) {
              return $resultados;
          } else {
              return array();
          }
      } catch (PDOException $e) {
          return false; // Si hay algún error, devuelve falso
      }
     }

     public function getLastInsertedID() {
      $conexion = $this->getConexion();
    $sql = "SELECT LAST_INSERT_ID() AS id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['id'];
     }

     public function insertContacto($nombre, $correo, $telefono, $foto) {
        $objBD = $this->getConexion();
        $sql = "INSERT INTO usuarios (nombre, correo, telefono, foto) VALUES (:nombre, :correo, :telefono, :foto)";
        $stmt = $objBD->prepare($sql);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':foto', $foto);

        try {
            $stmt->execute();
            $nuevoUsuarioID = $objBD->lastInsertId();
            return $nuevoUsuarioID;
        } catch (PDOException $e) {
            return false; // Si hay algún error, devuelve falso
        }
        $conexion = $this->getConexion();

        return $conexion->lastInsertId();
     }

}
?>