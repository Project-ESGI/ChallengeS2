<table class="table table-striped table-bordered">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Contenu</th>
        <th scope="col">Auteur</th>
        <th scope="col">Réponse</th>
        <th scope="col">Date d'insertion</th>
        <th scope="col">Date de mise à jour</th>
        <th scope="col">Signalement(s)</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($table as $commentaire) : ?>
        <tr>
            <td><?php echo $commentaire['id']; ?></td>
            <td><?php echo $commentaire['content']; ?></td>
            <td><?php echo $commentaire['author']; ?></td>
            <td><?php echo $commentaire['answer']; ?></td>
            <td><?php echo $commentaire['date_inserted']; ?></td>
            <td><?php echo $commentaire['date_updated']; ?></td>
            <td><?php echo $commentaire['is_reported'] ?></td>
            <td>
<!--                <a href="modifycomment?id=--><?php //echo $commentaire['id']; ?><!--" class="btn btn-primary">Modifier</a>-->
                <a href="deletecomment?id=<?php echo $commentaire['id']; ?>" class="btn btn-danger">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
