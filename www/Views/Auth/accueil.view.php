<nav class="navbar navbar-expand-sm navbar-dark">
    <a class="navbar-brand ml-2" href="#" data-abc="true">Rib Simpson</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="end">
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav">
                <li class="nav-item"> <a class="nav-link" href="#" data-abc="true">Work</a> </li>
                <li class="nav-item"> <a class="nav-link" href="#" data-abc="true">Capabilities</a> </li>
                <li class="nav-item "> <a class="nav-link" href="#" data-abc="true">Articles</a> </li>
                <li class="nav-item active"> <a class="nav-link mt-2" href="#" data-abc="true" id="clicked">Contact<span class="sr-only">(current)</span></a> </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Body -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-md-6 col-12 pb-4">
                <h1>Comments</h1>
                <?php foreach ($table as $commentaire) : ?>
                    <div class="comment mt-4 text-justify float-left">
                        <div class="d-flex align-items-center">
                            <img src="https://i.imgur.com/CFpa3nK.jpg" width="20" height="20" class="d-inline-block align-top rounded-circle mr-2" alt=""> <!-- Ajout de la classe "mr-2" pour ajouter un espace à droite de l'image -->
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
                            <a href="signalercommentaire?id=<?php echo $commentaire['id']; ?>" class="btn btn-link">Signaler commentaire</a>
                            <a href="repondrecommentaire?id=<?php echo $commentaire['id']; ?>" class="btn btn-link">Répondre</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                <form id="algin-form">
                    <div class="form-group">
                        <h4>Leave a comment</h4>
                        <label for="message">Message</label>
                        <textarea name="msg" id="" msg cols="30" rows="5" class="form-control" style="background-color: black;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="fullname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <p class="text-secondary">If you have a <a href="#" class="alert-link">gravatar account</a> your address will be used to display your profile picture.</p>
                    </div>
                    <div class="form-inline">
                        <input type="checkbox" name="check" id="checkbx" class="mr-1">
                        <label for="subscribe">Subscribe me to the newlettter</label>
                    </div>
                    <div class="form-group">
                        <button type="button" id="post" class="btn">Post Comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
