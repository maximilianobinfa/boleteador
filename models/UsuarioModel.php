<?php

namespace APIRest\models;

use APIRest\libs\Model;
use APIRest\libs\Utils as Util;

class UsuarioModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get(array $params = [], array $options = [])
    {
        $result = array();
        switch (count($params)) {
            case 0:
                $sql = "SELECT * FROM usuario;";
                $result = $this->db->execute($sql);
                break;
            case 2:
                if (is_numeric($params[1])) {
                    $sql = "SELECT * FROM usuario WHERE id_usuario = " . $params[1];
                    $result = $this->db->execute($sql);
                } else {
                    Util::JSONResponse(Util::encodeResponse(400, [], "El identificador debe ser ser numerico"));
                    exit;
                }
                break;
        }
        return $result;
    }


   public function post(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if(isset($data['rut']) && isset($data['id_clave'])){
            $now = date("Y-m-d");
            $sql = "INSERT INTO usuario VALUES (NULL, {$data['rut']}, {$data['id_clave']}, '$now', NULL);";
            $lid = $this->db->execute($sql);
            return is_numeric($lid) && $lid > 0;
        } else {
            return false;

        }
    }
    public function put()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (isset($data['id_usuario']) && isset($data['rut']) && isset($data['rut']) && isset($data['id_clave'])) {
            $now = date("Y-m-d");
            $sql = "UPDATE usuario SET id_usuario = {$data['id_usuario']}, rut = {$data['rut']}, fecha_alta = '{$data['fecha_alta']}', fecha_baja = {$data['fecha_baja']}, fecha_alta = '$now' WHERE id_boleta = {$data['id_boleta']};";
            $lid = $this->db->execute($sql);
            return is_numeric($lid) && $lid > 0;
        } else {
            return false;
        }
    }

    //creacion del endpoint PATCH
    public function patch()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (isset($data['id_boleta'])) {
            $now = date("Y-m-d");
            $sql = "UPDATE usuario SET id_usuario = '$now' WHERE id_clave = {$data['id_boleta']};";
            $lid = $this->db->execute($sql);
            return is_numeric($lid) && $lid > 0;
        } else {
            return false;
        }
}
}