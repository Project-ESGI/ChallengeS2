<body>
<main>
    <div class="container mt-4">
        <div class="row">
            <div class="d-flex justify-content-center col-md-3 mb-3">
                <select id="category-filter" class="form-control">
                    <option value="toutes">Toutes les catégories</option>
                    <option value="Match d'entraînement">Match d'entraînement</option>
                    <option value="Compétition">Compétition</option>
                    <option value="Exercice">Exercice</option>
                    <option value="Tournoi">Tournoi</option>
                </select>
            </div>
            <div class="d-flex justify-content-center-add col-md-9 mb-3">
                <a href="addarticle" class="openModalBtn btn btn-primary">Ajouter un article</a>
            </div>
        </div>
    </div>

    <div> <!-- Ajoutez de la marge en haut par rapport au tableau -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Date d'insertion</th>
                    <th scope="col">Date de mise à jour</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach (array_reverse($table) as $page) : ?>
                    <tr>
                        <td><?php echo $page['id']; ?></td>
                        <td><?php echo $page['slug']; ?></td>
                        <td><?php echo $page['title']; ?></td>
                        <td><?php echo $page['author']; ?></td>
                        <td><?php echo $page['category']; ?></td>
                        <td><?php echo $page['date_inserted']; ?></td>
                        <td><?php echo $page['date_updated']; ?></td>
                        <td>
                            <a href="modifyarticle?id=<?php echo $page['id']; ?>" class="btn btn-primary">Modifier</a>
                            <a href="deletearticle?id=<?php echo $page['id']; ?>" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
