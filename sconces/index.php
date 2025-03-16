<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body id="sconces">
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section class="header">
        <div class="inner">
            <div class="left">
                <img src="/assets/images/heros/Jumby-Bay-sconces-in-progress-3-of-20.jpeg" alt="">
                <img class="animation-start" src="/assets/images/heros/Jumby-Bay-sconces-in-progress-20-of-20-768x1024.jpeg" alt="">
            </div>
            <div class="right">
                <h1 class="animation-start">Sconces Portfolio</h1>
                <p class="animation-start">Margie Hunt is the Eastern Caribbean’s leading manufacturer of custom, handmade ceramic wall sconces. We invite you to view our creative and growing collection of ceramic lighting options.</p>
                <p class="animation-start">Designed by husband and wife, Michael Hunt and Imogen Margrie, the evolving range combines characteristics of regional motifs, Arts and Crafts and contemporary styles in beautiful versatile forms.</p>
                <a href="/sconces/shop.php" class="continue-btn">Shop Sconces</a>
            </div>
        </div>
    </section>

    <section id="significantly-enhance-section">
        <div class="inner">
        </div>
    </section>

    <section id="close-up-section">
        <div class="inner">
        </div>
    </section>

    <section id="cutout-selection-section">
        <div class="inner">
        </div>
    </section>

    <section id="product-catalogue-section">
        <div class="inner">
        </div>
    </section>

</body>

<script>
    $(document).ready(function() {
        setTimeout(() => {
            $("body#sconces section.header div.inner > div.left img:last-child").removeClass('animation-start');
            setTimeout(() => {
                $("body#sconces section.header div.inner > div.right h1").removeClass('animation-start');
                setTimeout(() => {
                    $("body#sconces section.header div.inner > div.right p").removeClass('animation-start');
                }, 100);
            }, 100);
        }, 250);
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>