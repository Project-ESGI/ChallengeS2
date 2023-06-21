<?php
namespace App\Forms;

use App\Core\Sql;
use App\Models\Page;

class ListPage extends Sql {
    protected $method = "POST";

    public function getAllPages()
    {
        $queryPrepared = $this->pdo->prepare("SELECT * FROM " . $this->table);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }
}