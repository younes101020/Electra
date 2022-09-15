<body class="forced_no_overflow">
    <?php include_once '../inc/header_account.php'; ?>

        <main>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach($publicshowlists as $val): ?>
                    <div class="swiper-slide" style="background-image: url('<?= $val->image; ?>')">
                      <div class="movielistname"><i><?= $val->lname; ?> - @<?= $val->username; ?></i></div>
                        <div class="tl_card_body togglecomment">
                            <form action="" method="get" class="form-comment">
                                <input type="text" name="message" id="commentaire">
                                <button type="submit" class="submit_btn"><i class="fa-sharp fa-solid fa-paper-plane"></i></button>
                            </form>
                            <div class="tl_card_title"><i><?= $val->mname; ?></i></div>
                            <div class="tl_card_action">
                                <a class="card_action buy" href="<?= $val->buy; ?>">
                                    Acheter <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                <a class="card_action comments" href="#">
                                    Commentaires <i class="fa-sharp fa-solid fa-message"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="interaction">
                    <i class="fa-solid fa-face-frown fa-2xl"></i>
                    <i class="fa-solid fa-face-meh fa-2xl"></i>
                    <i class="fa-solid fa-face-smile fa-2xl"></i>
                </div>     
            </div>
        </main>

    <?php include_once '../inc/footer.php'; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
        <script src="../js/main.js"></script>
        

        <script>
        var swiper = new Swiper(".mySwiper", {
        effect: "cards",
        grabCursor: true,
        });
        </script>
    </body>
</html>