<?php
namespace App\Forms;
use App\Core\Sql;
use App\Models\Page;

class AddPage extends Sql {
    protected $method = "POST";

    public function addPage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données de la nouvelle page depuis la requête POST
            $page = new Page();
            $page->setTitle($_POST['title']);
            $page->setContent($_POST['content']);

            // Insérer la page dans la base de données
            $queryPrepared = $this->pdo->prepare("INSERT INTO " . $this->table . " (title, content) VALUES (?, ?)");
            $queryPrepared->execute([$page->getTitle(), $page->getContent()]);

            // Autre logique nécessaire après l'ajout de la page, si nécessaire
        }
    }
}

// Exemple d'utilisation
$addPage = new addPage();
$addPage->addPage();
?>
