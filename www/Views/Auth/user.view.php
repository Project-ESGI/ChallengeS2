<a href="adduser" class="openModalBtn btn btn-primary">Ajouter un user</a>

<table class="table table-striped table-bordered">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Id</th>
        <th scope="col">firstname</th>
        <th scope="col">lastname</th>
        <th scope="col">email</th>
        <th scope="col">date_inserted</th>
        <th scope="col">date_updated</th>
        <th scope="col">country</th>
        <th scope="col">banned</th>
        <th scope="col">role</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($table as $user) : ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['firstname']; ?></td>
            <td><?php echo $user['lastname']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['date_inserted']; ?></td>
            <td><?php echo $user['date_updated']; ?></td>
            <td><?php echo $user['country']; ?></td>
            <td><?php echo $user['banned']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <a href="modifyuser?id=<?php echo $user['id']; ?>" class="btn btn-primary">Modifier</a>
                <a href="deleteuser?id=<?php echo $user['id']; ?>" class="btn btn-danger">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
