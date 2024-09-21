<?php
class Database
{

    function connectar()
      {
      $servidorlocal = 'localhost';
      $basededatos   = 'maked';
      $usuario       = 'root';
      $password      = '';
      $caracteres    = 'utf8';
        try
          {
            $conexion = "mysql:host=".$servidorlocal.";dbname=".$basededatos.";charset=".$caracteres;
            $opciones = [
                          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                          PDO::ATTR_EMULATE_PREPARES  => false
                        ];
            $pdo = new PDO($conexion, $usuario, $password, $opciones);
            return $pdo;
          }
        catch(PDOException $error)
          {
            echo 'Error en la conexion:  '.$error->getMessage();
          }
      }
      public function obtenerUsuarioPorId($idUsuario)
    {
        $pdo = $this->connectar();
        $stmt = $pdo->prepare("SELECT nombre, apellido, foto FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
