<?php

require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/helpers.php';

const IMOGEN_MARGRIE = 'Imogen Margrie';
const MICHAEL_HUNT = 'Michael Hunt';

$imogen_portfolio_item_arr = getPortfolioItemsForArtist($pdo, IMOGEN_MARGRIE);
$michael_portfolio_item_arr = getPortfolioItemsForArtist($pdo, MICHAEL_HUNT);
$portfolio_item_arr = array_merge($imogen_portfolio_item_arr, $michael_portfolio_item_arr);

?>

<body>
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <section id="index-header">
        <div class="inner">
            <div class="left">
                <div id="landing-title-container">
                    <span>Signature, Ceramics,<br>Stone and Wood</span>
                    <!-- <div>
                        <span class="showing">Ceramics</span>
                        <span>Stone</span>
                        <span>Wood</span>
                    </div> -->
                </div>
                <p>Caribbean maker of finely crafted production and bespoke ceramic wall sconces, signature pieces in ceramic, stone, and wood.</p>
            </div>
            <div class="right">
                <div class="carousel">
                    <div class="carousel-cell">
                        <img srcset="/assets/images/heros/index/mobile/hero-1.png 768w, /assets/images/heros/index/hero-1.png" src="" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img class="right" srcset="/assets/images/heros/index/mobile/hero-2.jpg 768w, /assets/images/heros/index/hero-2.jpg" src="" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img class="right" srcset="/assets/images/heros/index/mobile/hero-3.jpg 768w, /assets/images/heros/index/hero-3.jpg" src="" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img class="right" srcset="/assets/images/heros/index/mobile/hero-4.png 768w, /assets/images/heros/index/hero-4.png" src="" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img srcset="/assets/images/heros/index/mobile/hero-5.png 768w, /assets/images/heros/index/hero-5.png" src="" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img class="right" srcset="/assets/images/heros/index/mobile/hero-6.jpg 768w, /assets/images/heros/index/hero-6.jpg" src="" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img class="right" srcset="/assets/images/heros/index/mobile/hero-7.png 768w, /assets/images/heros/index/hero-7.png" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="panel-section">
        <div class="inner">
            <div id="name-panel-container">
                <div class="name-panel imogen">
                    <div class="left">
                        <h2>Imogen</h2>
                        <p>Imogen Margrie-Hunt, hailing from Camden, North London, was immersed in the arts from a young age. With a background enriched by her family's artistic pursuits, she naturally progressed to the Central School of Art. Post-graduation, Imogen established herself in the ceramics community, contributing to esteemed institutions like the Victoria and Albert Museum and the Contemporary Applied Arts Gallery. Her journey reflects a deep commitment to artistic excellence and education.</p>
                        <a href="/portfolios/imogen">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/imogen.png" alt="">
                    </div>
                </div>
                <div class="name-panel michael">
                    <div class="left">
                        <h2>Michael</h2>
                        <p>Born in Antigua and raised in the UK, Michael Hunt discovered his passion for ceramics at a youth center, leading him to pursue a degree at the Central School of Art in London. His career encompasses teaching roles, Japanese garden construction, and personal ceramic creations. Michael's work often delves into themes of island history and ancestry, showcasing his diverse talents in stone, wood, and ceramics.</p>
                        <a href="/portfolios/michael">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/michael.jpeg" alt="">
                    </div>
                </div>
                <div class="name-panel sconces">
                    <div class="left">
                        <h2>Sconces</h2>
                        <p>Our ceramic wall sconces are meticulously crafted to elevate any interior space. Combining timeless elegance with sophisticated design, each piece reflects our dedication to quality and aesthetic appeal. Explore our collection to find the perfect sconce that resonates with your style.</p>
                        <a href="/sconces/">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/sconces.png" alt="">
                    </div>
                </div>
                <div class="name-panel commissions">
                    <div class="left">
                        <h2>Commissions</h2>
                        <p>We offer bespoke ceramic creations tailored to your unique vision. Collaborating closely with clients and architects, we develop one-of-a-kind pieces that enhance and personalize spaces. From conceptualization to completion, our commissioned works are a testament to our commitment to individualized artistry.</p>
                        <a href="/portfolios/imogen/">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/delilah.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="portfolio-section">
        <div class="inner">
            <h1>Portfolio Items</h1>
            <div class="gallery">
                <?php
                $link_lookup = [
                    IMOGEN_MARGRIE => "imogen",
                    MICHAEL_HUNT => "michael",
                ];
                foreach ($portfolio_item_arr as $portfolio_item) {
                    $artist_first_name = $link_lookup[$portfolio_item['artist']];
                    $href = getPortfolioItemLink($artist_first_name, $portfolio_item['portfolio_item_id']);
                    echo "
                        <a class='portfolio-item-panel' href='$href'>
                            <img src='{$portfolio_item['image_url']}' alt='Sconce'>
                            <div class='portfolio-item-title'>
                                <h4>{$portfolio_item['name']}</h4>
                                <h4>{$portfolio_item['artist']}</h4>
                            </div>
                        </a>
                    ";
                } ?>
            </div>
        </div>
    </section>

    <section id="about-us-section">
        <div class="inner">
            <h1>About Us</h1>
            <div>
                <div>
                    <p>Cedars Pottery began in 1996 when Antiguan-born ceramicist Michael Hunt returned to the island with his English wife and fellow ceramicist Imogen Margie. They initially collaborated to produce a range of hand-thrown decorative tableware, before an architect commission heralded their foray into wall sconces.</p>
                    <p>Whilst continuing to offer hand-thrown pieces to order, they are now developing an eclectic mix of architectural, one-of-a-kind pieces made to commission, in collaboration with architects and clients. The pair recently decided to rebrand to Margie Hunt as Cedars Pottery no longer reflects the diverse range of work they produce. Their portfolio includes ceramic wall pieces, relief carvings, highly individual fountains, stone carvings and imaginative ceramic sculptures.</p>
                    <p>As individuals both Mike and Imogen have continued to experiment in their one-of-a-kind pieces, the creative energy feeding into all aspects of their production. Their work continues to be admired for its sense of design, consummate craft skill and attention to detail.</p>
                </div>
                <img src="/assets/images/misc/about-us.jpg" alt="">
            </div>
        </div>
    </section>

</body>

<?php require_once __DIR__ . '/includes/footer.php'; ?>