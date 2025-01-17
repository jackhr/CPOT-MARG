<?php

require_once __DIR__ . '/includes/head.php';

$stmt = $pdo->prepare(
    "SELECT one_of_a_kind.*, one_of_a_kind_images.image_url
        FROM one_of_a_kind
        LEFT JOIN one_of_a_kind_images ON one_of_a_kind.primary_image_id = one_of_a_kind_images.image_id
    WHERE status = :status"
);
$stmt->bindValue(':status', 'active', PDO::PARAM_STR);
$stmt->execute();
$one_of_a_kind_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <section id="index-header">
        <div class="inner">
            <div class="left">
                <div id="landing-title-container">
                    <span>Signature</span>
                    <div>
                        <span class="showing">Ceramics</span>
                        <span>Stone</span>
                        <span>Wood</span>
                    </div>
                </div>
                <p>Caribbean maker of finely crafted production and bespoke ceramic wall sconces, signature pieces in ceramic, stone, and wood.</p>
            </div>
            <div class="right">
                <div class="carousel">
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-1.png" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-2.png" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-3.png" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-4.png" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-5.png" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-6.png" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-7.png" alt="">
                    </div>
                    <div class="carousel-cell">
                        <img src="/assets/images/heros/index/hero-8.png" alt="">
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
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita ad reiciendis aspernatur dignissimos soluta perspiciatis tempore cumque, exercitationem quisquam provident delectus mollitia sed excepturi suscipit odio officia vel voluptatum rerum?</p>
                        <a href="/one-of-a-kind/">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/imogen.png" alt="">
                    </div>
                </div>
                <div class="name-panel michael">
                    <div class="left">
                        <h2>Michael</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita ad reiciendis aspernatur dignissimos soluta perspiciatis tempore cumque, exercitationem quisquam provident delectus mollitia sed excepturi suscipit odio officia vel voluptatum rerum?</p>
                        <a href="/one-of-a-kind/">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/michael.jpeg" alt="">
                    </div>
                </div>
                <div class="name-panel sconces">
                    <div class="left">
                        <h2>Sconces</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita ad reiciendis aspernatur dignissimos soluta perspiciatis tempore cumque, exercitationem quisquam provident delectus mollitia sed excepturi suscipit odio officia vel voluptatum rerum?</p>
                        <a href="/sconces/">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/sconces.png" alt="">
                    </div>
                </div>
                <div class="name-panel commissions">
                    <div class="left">
                        <h2>Commissions</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita ad reiciendis aspernatur dignissimos soluta perspiciatis tempore cumque, exercitationem quisquam provident delectus mollitia sed excepturi suscipit odio officia vel voluptatum rerum?</p>
                        <a href="/one-of-a-kind/">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/commissions.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="one-of-a-kind-section">
        <div class="inner">
            <h1>One Of A Kind</h1>
            <div class="gallery">
                <?php foreach ($one_of_a_kind_arr as $one_of_a_kind) { ?>
                    <div class="gallery-panel">
                        <img src="<?php echo $one_of_a_kind['image_url']; ?>" alt="Oops">
                        <span><?php echo $one_of_a_kind['name']; ?></span>
                    </div>
                <?php } ?>
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