<section>
    <h1 class="text-center">Bienvenue <span class="small"><?php echo $user_pseudo ?></span></h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-md-6 col-12 pb-4">
                <h1>Commentaires</h1>
                <?php foreach ($table as $commentaire) : ?>
                    <div class="comment mt-4">
                        <div class="d-flex align-items-center">
                            <img src="https://i.imgur.com/CFpa3nK.jpg" width="20" height="20" class="d-inline-block align-top rounded-circle mr-2" alt="">
                            <h4><?php echo $commentaire['author']; ?></h4>
                        </div>
                        <span>- <?php echo $commentaire['date_inserted']; ?></span>
                        <?php if ($commentaire['date_updated']) : ?>
                            <br>
                            <span>- Mis à jour le <?php echo $commentaire['date_updated']; ?></span>
                        <?php endif; ?>
                        <br>
                        <p><?php echo $commentaire['content']; ?></p>
                        <div class="comment-details">
                            <a href="signalercommentaire?id=<?php echo $commentaire['id']; ?>" class="btn btn-link">Signaler le commentaire</a>
                            <a href="repondrecommentaire?id=<?php echo $commentaire['id']; ?>" class="btn btn-link">Répondre</a>
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
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <p class="text-secondary">Si vous avez un compte <a href="#" class="alert-link">gravatar</a>, votre adresse sera utilisée pour afficher votre photo de profil.</p>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="check" id="subscribe">
                        <label class="form-check-label" for="subscribe">M'abonner à la newsletter</label>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary">Publier le commentaire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
