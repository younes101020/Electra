    <body class="forced_no_overflow">
    <?php require_once '../inc/header_account.php'; ?>
        <main>
            <div class="title">
                <h1><?= calllistName(); ?></h1>
            </div>
            <div class="container">
                <?php foreach(callShowlist() as $val): ?>
                    <div class="card" style="background-image: url('<?= $val->image; ?>')">
                        <div class="card-banner">
                        <a class="call-to-action" href="#"><i class="fa-solid fa-xmark"></i></a>
                        <a class="call-to-action" target="_BLANK" href="<?= $val->buy; ?>"><i class="fa-solid fa-cart-shopping"></i></a>
                        <a class="call-to-action" href="#"><i class="fa-solid fa-check"></i></a>
                        </div>
                        <div class="card-title"><h1><i><?= $val->name; ?></i></h1></div>
                    </div>
                <?php endforeach; ?>
            </div>

        </main>
        <footer>
            <p>Electra 2022 - Tout droit réservé</p>
        </footer>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
        <script src="../js/main.js"></script>
    </body>
</html>