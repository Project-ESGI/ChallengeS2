<section>
    <h1 class="text-center">Bienvenue <span class="small"><?php echo $user_name ?></span></h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-md-6 col-12 pb-4">
                <h1>Commentaires</h1>
                <?php foreach ($table as $commentaire) : ?>
                    <div class="comment mt-4">
                        <div class="d-flex align-items-center">
                            <img src="https://i.imgur.com/CFpa3nK.jpg" width="20" height="20"
                                 class="d-inline-block align-top rounded-circle mr-2" alt="">
                            <h4><?php echo $commentaire['author']; ?></h4>
                        </div>
                        <span>- <?php echo $commentaire['date_inserted']; ?></span>
                        <?php if ($commentaire['date_updated']) : ?>
                            <br>
                            <span>- Mis à jour le <?php echo $commentaire['date_updated']; ?></span>
                        <?php endif; ?>
                        <br>
                        <p><?php echo $commentaire['content']; ?></p>
                        <div class="comment-details d-flex align-items-center">
                            <?php if ($user_id === $commentaire['authorId']): ?>
                                <a href="modifycomment?id=<?php echo $commentaire['id']; ?>" class="btn btn-link p-0">Modifier mon commentaire</a>
                            <?php elseif ($commentaire['is_reported']): ?>
                                <p class="text-danger font-weight-bold mb-0">Signalé</p>
                            <?php else : ?>
                                <div class="mr-3">
                                    <a href="report?id=<?php echo $commentaire['id']; ?>" class="btn btn-link p-0">Signaler le commentaire</a>
                                </div>
                            <?php endif; ?>
                            <a href="answer?id=<?php echo $commentaire['id']; ?>" class="btn btn-link">Répondre</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                <form>
                    <div class="form-group">
                        <h4>Laisser un commentaire</h4>
                        <label for="message">Message</label>
                        <textarea name="msg" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <a href="addcomment" class="btn btn-primary">Publier le
                            commentaire</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
