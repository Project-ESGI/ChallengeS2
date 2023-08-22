<div class="container mt-4">
    <div class="row">
        <div class="mb-3 text-right-custom"> <!-- Utilisez col-md-9 pour la colonne du bouton -->
            <a href="adduser" class="openModalBtn btn btn-primary">Ajouter un utilisateur</a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Prénom</th>
            <th scope="col">Nom de famille</th>
            <th scope="col">Pseudo</th>
            <th scope="col">Email</th>
            <th scope="col">Date d'insertion</th>
            <th scope="col">Date de mise à jour</th>
            <th scope="col">Pays</th>
            <th scope="col">role</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (array_reverse($table) as $user) : ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['firstname']; ?></td>
                <td><?php echo $user['lastname']; ?></td>
                <td><?php echo $user['pseudo']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['date_inserted']; ?></td>
                <td><?php echo $user['date_updated']; ?></td>
                <td><?php echo $user['country']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <a href="modifyuser?id=<?php echo $user['id']; ?>" class="btn btn-primary">Modifier</a>
                    <a href="deleteuser?id=<?php echo $user['id']; ?>" class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
