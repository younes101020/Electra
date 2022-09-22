<body class="forced_no_overflow">
    <!-- Header de la page d'accueil -->
    <?php require_once '../inc/header_account.php'; ?>

    <main id="vertical_display">
        <div class="notif togglenotif" id="notif"></div>
        <div id="input_container">
            <input type="text" id="search_bar" name="search">
        </div>
        <!-- Affichage des films -->
        <div id="show">

        <?php for($i = 0; $i < 12; $i++): ?>
            <?php if($i == 0): ?>
                <div id="top_show" class="like_scope" style="background-image: url(<?= $shows[$i]->image; ?>); background-size: cover; background-position: center;">
                    <div class="top_showcard-content">
                        <p class="showcard-title"><?= $shows[$i]->name; ?></p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <button class="top_resume_btn resume_btn">résumé | <i class="fa-solid fa-plus"></i></button>
                        <p class="synopsis"><?= $shows[$i]->synopsis; ?></p>
                        <a target="_BLANK" href="<?= $shows[$i]->buy; ?>" class="buy_btn">Achetez <i class="fa-solid fa-cart-shopping"></i></a>
                    </div>
                </div>
            <?php else: ?>
            <div id="show_<?= $showid; ?>" class="like_scope" style="background-image: url(<?= $shows[$i]->image; ?>); background-size: cover; background-position: center;">
                <div class="showcard-content">
                    <p class="showcard-title"><?= $shows[$i]->name; ?></p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <button class="resume_btn">résumé | <i class="fa-solid fa-plus"></i></button>
                    <p class="synopsis"><?= $shows[$i]->synopsis; ?></p>
                    <a target="_BLANK" href="<?= $shows[$i]->buy; ?>" class="buy_btn">Achetez <i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
            <?php $showid++; ?>
            <?php endif; ?>
        <?php endfor; ?>
        </div>
    </main>

    <?php include_once '../inc/footer.php'; ?>
                
</body>
</html>