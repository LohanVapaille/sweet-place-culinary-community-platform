<div class="card">

    <!-- Titre -->
    <h3><?= htmlspecialchars($donut['donut_name']) ?></h3>

    <div class="content">
        <!-- Image -->
        <?php if (!empty($donut['image'])): ?>
            <img src="<?= htmlspecialchars($donut['image']) ?>" alt="<?= htmlspecialchars($donut['donut_name']) ?>">
        <?php endif; ?>


        <!-- Description -->
        <p class="compo"><?= htmlspecialchars($donut['description']) ?></p>
    </div>

    <div class="interaction">
        <!-- Bouton panier -->
        <a href="addpanier.php?id=<?= $donut['id_composition'] ?>" class="btn">
            Ajouter au panier
        </a>

        <!-- Zone "like" statique -->
        <div class="like">
            <i class="btnlike bx <?= $donut['already_liked'] ? 'bxs-heart' : 'bx-heart' ?>"
                data-id="<?= $donut['id_composition'] ?>" data-liked="<?= $donut['already_liked'] ? '1' : '0' ?>"></i>


            <p class="nb_like"><?= $donut['likes'] ?></p>



        </div>
    </div>

    <a class='creator' href="profil.php?id=<?= $donut['creator_id'] ?>">par
        <?= htmlspecialchars($donut['creator_name']) ?>
    </a>
</div>