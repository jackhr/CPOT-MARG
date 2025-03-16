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
            <div class="left">
                <img class="animation-start" src="/assets/images/sconces/P8-lizard-cutout.png" alt="">
            </div>
            <div class="right">
                <div>
                    <p>The wide range of sconces also comes with an expanding choice of customised cut out motifs. The team continue to welcome customized briefs, working along with clients to specifically answer their needs with designs that are manufactured on an individual basis.</p>
                    <a href="/sconces/shop.php" class="continue-btn">Shop Sconces</a>
                </div>
            </div>
        </div>
    </section>

    <section id="cutout-selection-section">
        <div class="inner">
            <div class="left">
                <h1 class="animation-start">Cutout Selection</h1>
                <p>Margrie Hunt’s growing range of classic bisqued finish sconces can also be complemented and personalized by the addition of their expanding choice of cut-out motifs. All patterns are individually cut into the leather hard-cast clay and incur additional charges based on their complexity.</p>
                <p>It has to be noted that not all patterns may be adapted to all sconce styles. Indications will be given as to the appropriateness or otherwise of certain styles to various patterns.</p>
                <p>Combinations of patterns may be requested on any sconce style where compatible and the cutout price is adjusted accordingly.</p>
                <p>The team at Margerie Hunt also offers the option of originating custom designs based on client briefs. Enquire for pricing.</p>
                <p>Unless specified (below/with) all cutout designs should be adaptable across most sconce designs.</p>
            </div>
            <div class="right">
                <div class="mini-gallery"></div>
            </div>
        </div>
    </section>

    <section class="catalogue-section">
        <div class="inner">
            <h1>Product Catalogue</h1>
            <div style="position:relative;padding-top:max(60%,326px);height:0;width:100%">
                <iframe allow="clipboard-write" sandbox="allow-top-navigation allow-top-navigation-by-user-activation allow-downloads allow-scripts allow-same-origin allow-popups allow-modals allow-popups-to-escape-sandbox allow-forms" allowfullscreen="true" style="position:absolute;border:none;width:100%;height:100%;left:0;right:0;top:0;bottom:0;" src="https://e.issuu.com/embed.html?d=margrie_hunt_light_catalog_-_old&u=tropicalstudios"></iframe>
            </div>
        </div>
    </section>

</body>

<script>
    const STATE = {
        completedSections: {},
        cutouts: [],
        randomCutoutIndexes: []
    };

    function renderCutouts() {
        $.ajax({
            type: "POST",
            url: "/api/cutouts/api.php",
            data: JSON.stringify({
                action: "get_all_cutouts"
            }),
            contentType: "application/json",
            dataType: "json",
            success: res => {
                console.log(res);
                if (res.status === 200) {
                    STATE.cutouts = res.data.slice(0, Math.min(res.data.length, 49));

                    STATE.cutouts.forEach(cutout => {
                        $(".mini-gallery").append(`
                        <div class="item animation-start">
                            <img src="${cutout.image_url}" />
                        </div>
                    `);
                    });

                    // Shuffle indexes
                    const indexes = [...STATE.cutouts.keys()];
                    for (let i = indexes.length - 1; i > 0; i--) {
                        let j = Math.floor(Math.random() * (i + 1));
                        [indexes[i], indexes[j]] = [indexes[j], indexes[i]];
                    }

                    STATE.randomCutoutIndexes = indexes;
                }
            },
            error: function() {
                console.log(arguments);
                STATE.cutouts = [];
                STATE.randomCutoutIndexes = [];
            }
        });
    }

    $(document).ready(function() {
        renderCutouts();

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

                this.destroy(); // Ensure waypoint only runs once
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

                this.destroy(); // Ensure waypoint only runs once
            }
        });

        $('#close-up-section').waypoint({
            offset: '50%',
            handler: function() {
                const id = "close-up-section";
                if (STATE.completedSections[id]) return;

                STATE.completedSections[id] = true;
                $(`section#${id} div.inner div.left img`).removeClass('animation-start');

                this.destroy(); // Ensure waypoint only runs once
            }
        });

        $('#cutout-selection-section').waypoint({
            offset: '80%',
            handler: function() {
                const id = "cutout-selection-section";
                if (STATE.completedSections[id]) return;

                STATE.completedSections[id] = true;
                $(`section#${id} div.inner div.left h1`).removeClass('animation-start');

                // Start checking every 500ms for populated random indexes
                const cutoutAnimationInterval = setInterval(() => {
                    const selector = ".mini-gallery .item";
                    if (STATE.completedSections[selector]) return;
                    if (STATE.randomCutoutIndexes.length === 0) return; // Keep waiting

                    clearInterval(cutoutAnimationInterval); // Stop checking
                    STATE.completedSections[selector] = true;

                    let intervalCount = 0;
                    const intervalFreq = 75;
                    STATE.randomCutoutIndexes.forEach(idx => {
                        intervalCount += intervalFreq;
                        setTimeout(() => {
                            $(selector).eq(idx).removeClass('animation-start');
                        }, intervalCount);
                    });

                }, 500);

                this.destroy(); // Ensure waypoint only runs once
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>