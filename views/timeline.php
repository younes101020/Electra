<body class="forced_no_overflow">
    <?php include_once '../inc/header_account.php'; ?>

        <main>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">Slide 1</div>
                    <div class="swiper-slide">Slide 2</div>
                    <div class="swiper-slide">Slide 3</div>
                    <div class="swiper-slide">Slide 4</div>
                    <div class="swiper-slide">Slide 5</div>
                    <div class="swiper-slide">Slide 6</div>
                    <div class="swiper-slide">Slide 7</div>
                    <div class="swiper-slide">Slide 8</div>
                    <div class="swiper-slide">Slide 9</div>
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