<body class="forced_no_overflow">
    <?php include_once '../inc/header_account.php'; ?>

        <main>
          <div id="notif" class="notif"></div>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach($publicshowlists as $val): ?>
                    <div class="swiper-slide" style="background-image: url('<?= $val->image; ?>')">
                      <div class="movielistname"><i><?= $val->lname; ?></i> - <i>@<?= $val->username; ?></i></div>
                        <div class="tl_card_body togglecomment">
                            <div class="form-comment">
                                <input type="text" name="message" class="commentaire">
                                <button type="submit" class="submit_btn"><i class="fa-sharp fa-solid fa-paper-plane"></i></button>
                            </div>
                            <div class="commentsection">
                                <?php foreach($commentsarr as $comment): ?>
                                    <?php if($comment->mlid == $val->mlid): ?>
                                        <div class="commentary"><?php if($currentUsername->username == $comment->pseudonyme): ?><div class="comaction"><i class="fa-solid fa-xmark"></i></div><?php endif; ?><div class="comcontent"><?= $comment->pseudonyme ?> : <span class="siblingcontent"><i><?= $comment->content ?></i></span></div></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="tl_card_title"><i><?= $val->mname; ?></i></div>
                            <div class="tl_card_action">
                                <a class="card_action buy" href="<?= $val->buy; ?>">
                                    Acheter <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                <a class="card_action comments" href="">
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
        <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
        <script>
            const swiper = new Swiper(".mySwiper", {
            effect: "cards",
            });
        </script>
          
</script>
    </body>
</html>