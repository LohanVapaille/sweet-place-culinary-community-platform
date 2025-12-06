<div class="card">
    <h3><?= htmlspecialchars($donut['title']) ?></h3>
    <div class="content">
        <img src="<?= htmlspecialchars($donut['img']) ?>" alt="<?= htmlspecialchars($donut['imgAlt']) ?>">
        <p class="compo"><?= htmlspecialchars($donut['description']) ?></p>
    </div>
    <div class="interaction">
        <a href="addpanier.php?id=<?= $donut['id_donuts_de_base'] ?>" class="btn">Ajouter au panier</a>
        <div class="like">
            <i class="bx btnlike <?= $donut['already_liked'] ? 'bxs-heart' : 'bx-heart' ?>"
                data-id="<?= $donut['id_donuts_de_base'] ?>" data-source="base"
                data-liked="<?= $donut['already_liked'] ? '1' : '0' ?>"></i>
            <p class="nb_like"><?= $donut['likes'] ?></p>
        </div>
    </div>
</div>