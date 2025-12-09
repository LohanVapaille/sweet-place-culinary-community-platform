<div data-id="<?= htmlspecialchars($donut['id_composition']) ?>" class="onecard-container">
    <div class="card userdonuts">
        <div class="laterale-barre composition">
            <?php if (!empty($donut['img_beignets'])): ?>
                <img class="layer" src="<?= htmlspecialchars($donut['img_beignets'], ENT_QUOTES); ?>">
            <?php endif; ?>

            <?php if (!empty($donut['img_fourrage'])): ?>
                <img class="layer" src="<?= htmlspecialchars($donut['img_fourrage'], ENT_QUOTES); ?>">
            <?php endif; ?>

            <?php if (!empty($donut['img_glacage'])): ?>
                <img class="layer imgbig" src="<?= htmlspecialchars($donut['img_glacage'], ENT_QUOTES); ?>">
            <?php endif; ?>

            <?php if (!empty($donut['img_topping'])): ?>
                <img class="layer" src="<?= htmlspecialchars($donut['img_topping'], ENT_QUOTES); ?>">
            <?php endif; ?>
        </div>
        <!-- Titre -->
        <h3><?= htmlspecialchars($donut['donut_name']) ?></h3>

        <div class="content">
            <p class="desc-donuts"><?= htmlspecialchars($donut['description']) ?>
                <br><br>Compo : <?php if (!empty($donut['name_fourrage'])): ?>
                    <?= htmlspecialchars($donut['name_fourrage']) ?>
                <?php endif; ?>,<?php if (!empty($donut['name_glacage'])): ?>
                    <?= htmlspecialchars($donut['name_glacage']) ?>
                <?php endif; ?>,<?php if (!empty($donut['name_topping'])): ?>
                    <?= htmlspecialchars($donut['name_topping']) ?>
                <?php endif; ?>
            </p>

        </div>

        <div class="addcart">


            <a style='opacity:0.5;' href="addpanier.php?id=<?= $donut['id_composition'] ?>" class=" know-more  btn">
                En savoir plus
            </a>

        </div>



    </div>
    <div class="interaction">

        <div class="int-left">
            <div class="like">
                <i class="btnlike bx <?= $donut['already_liked'] ? 'bxs-heart' : 'bx-heart' ?>"
                    data-id="<?= $donut['id_composition'] ?>"
                    data-liked="<?= $donut['already_liked'] ? '1' : '0' ?>"></i>


                <p class="nb_like"><?= $donut['likes'] ?></p>
            </div>
            <!-- Bouton panier -->
            <a href="addpanier.php?id=<?= $donut['id_composition'] ?>" class="useraddcart">
                <i class='bx bx-cart-add'></i>
            </a>
        </div>

        <a class="creator" href="profil.php?id=<?= (int) $donut['id_user'] ?>">
            par <?= htmlspecialchars($donut['login'] ?? '', ENT_QUOTES) ?>
        </a>
    </div>
</div>