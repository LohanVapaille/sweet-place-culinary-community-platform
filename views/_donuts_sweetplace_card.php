<div class="onecard-container ">
    <div data-id="<?= htmlspecialchars($donut['id_donuts_de_base']) ?>" class="card sweetplacedonuts ">

        <div class="top">
            <div>
                <h3><?= htmlspecialchars($donut['title']) ?></h3>
                <a class="#">
                    Par <span class='green'>Sweeplace</span>
                </a>
            </div>


        </div>



        <div class="content ">
            <div class="img-container">


                <img src="<?php echo $donut['img'] ?>" alt="<?php echo $donut['imgAlt'] ?>">
            </div>

            <div class="info">
                <p><?php echo $donut['description'] ?>
                </p>
            </div>


        </div>




    </div>
    <div class="interaction">

        <div class="int-left">
            <div class="like">
                <i class="bx btnlike <?= $donut['already_liked'] ? 'bxs-heart' : 'bx-heart' ?>"
                    data-id="<?= $donut['id_donuts_de_base'] ?>" data-source="base"
                    data-liked="<?= $donut['already_liked'] ? '1' : '0' ?>"></i>
                <p class="nb_like"><?= $donut['likes'] ?></p>
            </div>
            <!-- Bouton panier -->
            <a href="addpanier.php?id=<?= $donut['id_donuts_de_base'] ?>" class="useraddcart">
                + Ajouter au panier
            </a>
        </div>

        <p class="prix"><?= $donut['prix'] ?>€</p>


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.sweetplacedonuts').forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                if (id) {
                    window.location.href = `details_donuts.php?id=${id}`;
                }
            });
        });
    });
</script>