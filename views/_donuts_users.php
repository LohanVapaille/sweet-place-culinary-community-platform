<div class="onecard-container">
    <div class="card userdonuts" data-id="<?= $donut['id_composition'] ?>" data-type="<?= $donut['type'] ?>"
        data-nblike="<?= $donut['likes'] ?>" data-note="<?= $donut['note_moyenne'] ?? 0 ?>"
        data-prix="<?= $donut['prix'] ?>" data-name="<?= htmlspecialchars($donut['donut_name']) ?>">

        <div class="top">
            <div>
                <h3><?= htmlspecialchars($donut['donut_name']) ?></h3>
                <a class="creator" href="profil.php?id=<?= (int) $donut['id_user'] ?>">
                    Par <span class='green'><?= htmlspecialchars($donut['login'] ?? '', ENT_QUOTES) ?></span>
                </a>
            </div>
            <div class="top-right">
                <p class="note"><i class='bx bx-star'></i>
                    <?php if (!empty($donut['note_moyenne'])): ?>
                        <?= $donut['note_moyenne'] ?> / 5
                    <?php else: ?>
                        0 avis
                    <?php endif; ?>
                </p>

                <?php if ($_SESSION['id'] == (int) $donut['id_user']): ?>
                    <a href="modif-compo.php?id=<?= $donut['id_composition'] ?>" class=" modifcompo">
                        Modifier
                    </a>
                <?php endif; ?>
            </div>
        </div>



        <div class="content">
            <div class="img-container">
                <img src="./<?= $donut['img_beignets'] ?>" alt="">

                <?php if (!empty($donut['img_fourrage'])): ?>
                    <img src="./<?= $donut['img_fourrage'] ?>" alt="">
                <?php endif; ?>

                <?php if (!empty($donut['img_glacage'])): ?>
                    <img src="./<?= $donut['img_glacage'] ?>" alt="">
                <?php endif; ?>

                <?php if (!empty($donut['img_topping'])): ?>
                    <img src="./<?= $donut['img_topping'] ?>" alt="">
                <?php endif; ?>
            </div>

            <div class="info">
                <?php if (!empty($donut['name_fourrage'])): ?>
                    <p><?= $donut['name_fourrage'] ?></p>
                <?php endif; ?>


                <?php if (!empty($donut['name_glacage'])): ?>
                    <p> <?= $donut['name_glacage'] ?></p>
                <?php endif; ?>


                <?php if (!empty($donut['name_topping'])): ?>
                    <p><?= $donut['name_topping'] ?></p>
                <?php endif; ?>

            </div>


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
                + <span class="onlydesk">Ajouter au p</span><span class="onlyphone">P</span>anier
            </a>




        </div>

        <p class="prix"><?= $donut['prix'] ?>€</p>


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.userdonuts').forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                if (id) {
                    window.location.href = `details_donuts.php?id=${id}`;
                }
            });
        });
    });
</script>