<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body id="sconces">
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section class="header">
        <div class="inner">
            <div class="left">
                <img src="/assets/images/sconces/Jumby-Bay-sconces-in-progress-3-of-20.jpeg" alt="">
                <img class="animation-start" src="/assets/images/sconces/Jumby-Bay-sconces-in-progress-20-of-20-768x1024.jpeg" alt="">
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
            <div class="left">
                <p class="animation-start">Margrie Hunt lights aim to significantly enhance the decorative and architectural character of a space.</p>
                <p class="animation-start">All Margie Hunt lights are individually hand made at our studio in Antigua. The white earthenware clay we use produces a classic off-white bisque finish. However, this bisque surface readily accepts all types of treatments.</p>
            </div>
            <div class="right">
                <img src="/assets/images/sconces/suite44.jpeg" alt="">
            </div>
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
    const STATE = {
        completedSections: {}
    };

    $(document).ready(function() {
        $('body#sconces section.header').waypoint({
            offset: "10%",
            handler: function() {
                const selector = "body#sconces section.header div.inner";
                if (STATE.completedSections[selector]) return;

                STATE.completedSections[selector] = true;
                $(`${selector} > div.left img:last-child`).removeClass('animation-start');
                setTimeout(() => {
                    $(`${selector} > div.right h1`).removeClass('animation-start');
                    setTimeout(() => {
                        $(`${selector} > div.right p`).removeClass('animation-start');
                    }, 100);
                }, 100);
            }
        });

        $('#significantly-enhance-section').waypoint({
            offset: '50%',
            handler: function() {
                const id = "significantly-enhance-section";
                if (STATE.completedSections[id]) return;

                STATE.completedSections[id] = true;
                $(`section#${id} div.inner p:first-child`).removeClass('animation-start');
                setTimeout(() => {
                    $(`section#${id} div.inner p:last-child`).removeClass('animation-start');
                }, 100);
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>