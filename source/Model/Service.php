<?php

namespace Source\Model;

use \Source\DB\Sql;
use \Source\Model;

class Service extends Model
{
    const ERROR = 'ServiceError';

    public static function listAll()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM services_online ORDER BY id DESC");
    }

    /**
     * Insere o banner na base de dados.
     * @return void
     */
    public function save()
    {
        $sql = new Sql();

        $action = empty($this->getid()) ? "insert" : "update";

        $result = $sql->{$action} ("services_online", $this->getValues());

        if ($result && !$this->getid()) $this->setid($result);

        $this->setData($this->getValues());
    }


    public static function setError($msg)
    {
        $_SESSION[Service::ERROR] = $msg;
    }
    public static function getError()
    {
        $msg = (isset($_SESSION[Service::ERROR]) && $_SESSION[Service::ERROR]) ? $_SESSION[Service::ERROR] : '';
        Service::clearError();
        return $msg;
    }
    public static function clearError()
    {
        $_SESSION[Service::ERROR] = NULL;
    }

    public function get($id):void
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM services_online WHERE id = :id", [":id" => $id]);
        $this->setData($results[0]);
    }

    public function delete()
    {
        $sql = new Sql();
        $sql->query('DELETE FROM services_online WHERE id = :id', [":id" => $this->getid()]);
    }

    public static function getPage($page = 1, $itensPerPage = 8)
    {
        $start = ($page - 1) * $itensPerPage;

        $sql = new Sql();

        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM services_online 
            ORDER BY id DESC
            LIMIT $start, $itensPerPage;
        "
        );

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
            'data' => $results,
            'total' => (int) $resultTotal[0]['nrtotal'],
            'pages' => ceil($resultTotal[0]['nrtotal'] / $itensPerPage),
        ];
    }
    public static function getPageSearch($search, $page = 1, $itensPerPage = 3)
    {

        $start = ($page - 1) * $itensPerPage;

        $sql = new Sql();

        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM services_online 
            WHERE name LIKE :search 
            ORDER BY name
            LIMIT $start, $itensPerPage;
        ",
            [
                ':search' => '%' . $search . '%'
            ]
        );

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
            'data' => $results,
            'total' => (int) $resultTotal[0]['nrtotal'],
            'pages' => ceil($resultTotal[0]['nrtotal'] / $itensPerPage),
        ];
    }
}//End Classe
