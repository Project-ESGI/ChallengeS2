<?php
namespace App\Controllers;
use App\Core\View;
use App\Forms\AddUser;
use App\Forms\AddPage;
use App\Models\User;
use App\Core\Verificator;

class Security{

    public function login(): void
    {
        echo "Login";
    }

    public function register(): void
    {
        $form = new AddUser();
        $view = new View("Auth/register", "connection");
        $view->assign('form', $form->getConfig());


        if($form->isSubmit()){
            $errors = Verificator::form($form->getConfig(), $_POST);
            if(empty($errors)){
                echo "Insertion en BDD";
            }else{
                $view->assign('errors', $errors);
            }
        }
        /*
        $user = new User();
        $user->setId(2);
        $user->setEmail("test@gmail.com");
        $user->save();
        */
    }

    public function addPage(): void
{
    $form = new Page();
    $view = new View("Page/add", "layout");
    $view->assign('form', $form->getConfig());

    if ($form->isSubmit()) {
        $errors = Verificator::form($form->getConfig(), $_POST);
        if (empty($errors)) {
            $page = new Page();
            $page->setTitle($_POST['title']);
            $page->setContent($_POST['content']);
            $page->save();
            echo "Page ajoutée avec succès";
        } else {
            $view->assign('errors', $errors);
        }
    }
}

    public function logout(): void
    {
        echo "Logout";
    }

}