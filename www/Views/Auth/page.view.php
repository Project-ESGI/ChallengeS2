<a  class="openModalBtn btn btn-primary">Ajouter une page</a>

<div class="myModal modal">
    <div class="modal-content">
        <span class="closeModalBtn close">&times;</span>
        <?php $this->modal("form", $form); ?>
    </div>
</div>

<table class="table table-striped table-bordered">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Titre</th>
        <th scope="col">Date d'insertion</th>
        <th scope="col">Date de mise à jour</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($table as $page) : ?>
        <tr>
            <td><?php echo $page['title']; ?></td>
            <td><?php echo $page['date_inserted']; ?></td>
            <td><?php echo $page['date_updated']; ?></td>
            <td>
                <a href="modifyPage?id=<?php echo $page['title']; ?>" class="btn btn-primary">Modifier</a>
                <a href="deletePage" class="btn btn-danger">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
