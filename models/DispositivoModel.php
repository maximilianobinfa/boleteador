<?php

namespace APIRest\models;

use APIRest\libs\Model;
use APIRest\libs\Utils as Util;

class DispositivoModel extends Model
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
                $sql = "SELECT * FROM dispositivo;";
                $result = $this->db->execute($sql);
                break;
            case 2:
                if (is_numeric($params[1])) {
                    $sql = "SELECT * FROM dispositivo WHERE id_dispositivo = " . $params[1];
                    $result = $this->db->execute($sql);
                } else {
                    Util::JSONResponse(Util::encodeResponse(400, [], "El identificador debe ser ser numerico"));
                    exit;
                }
                break;
        }
        return $result;
    }

    public function post()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (isset($data['rut']) ) {
            $now = date("Y-m-d");
            $sql = "INSERT INTO dispositivo VALUES (NULL, {$data['rut']}, '$now', NULL);";
            $lid = $this->db->execute($sql);
            return is_numeric($lid) && $lid > 0;
        } else {
            return false;
        }
    }
}
