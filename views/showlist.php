    <body class="forced_no_overflow">
    <?php require_once '../inc/header_account.php'; ?>
        <main>
            <div class="notif" id="notif"></div>
            <div class="title">
                <h1><?= calllistName(); ?> <i class="fa-solid fa-pen"></i></h1>
                <div class="changelistname toggleedit">
                    <form action="../controllers/showlistController.php" method="POST">
                        <div id="bsinput">
                            <input type="text" id="listname" name="listname" placeholder="Ma liste...">
                        </div>
                        <input id="confirmlistname" type="submit" value="Valider">
                    </form>
                </div>
                
                <div class="publication">
                    <p>Privé</p><label class="switch"><input id="check" type="checkbox" />
                        <div></div>
                    </label><p>Public</p>
                </div>
                
            </div>

            <div class="container">
                <?php foreach(callShowlist() as $val): ?>
                    <div class="card" style="background-image: url('<?= $val->image; ?>')">
                        <div class="card-banner">
                        <a class="call-to-action removed" href="#"><i class="fa-solid fa-xmark"></i></a>
                        <a class="call-to-action" target="_BLANK" href="<?= $val->buy; ?>"><i class="fa-solid fa-cart-shopping"></i></a>
                        <a class="call-to-action finishedToggle finished" href="#"><i class="fa-solid fa-check"></i></a>
                        </div>
                        <div class="card-title"><h1><i class="moviename"><?= $val->name; ?></i><i class="ratingmsg">Quelle note lui mettriez-vous ?</i></h1>
                        <div class="stars">
                            <input type="radio" name="star" id="star-1" value="1"/>
                            <label for="star-1">
                            <span><i class="fa-solid fa-star star"></i></span>
                            </label>

                            <input type="radio" name="star" id="star-2" value="2"/>
                            <label for="star-2">
                            <span><i class="fa-solid fa-star star"></i></span>
                            </label>

                            <input type="radio" name="star" id="star-3" value="3"/> 
                            <label for="star-3">
                            <span><i class="fa-solid fa-star star"></i></span>
                            </label>

                            <input type="radio" name="star" id="star-4" value="4"/>
                            <label for="star-4">
                            <span><i class="fa-solid fa-star star"></i></span>
                            </label>

                            <input type="radio" name="star" id="star-5" value="5"/>
                            <label for="star-5">
                            <span><i class="fa-solid fa-star star"></i></span>
                            </label>
                        </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </main>
        <?php require_once '../inc/footer.php'; ?>
    </body>
</html>