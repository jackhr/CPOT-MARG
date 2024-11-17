<?php

require_once __DIR__ . '/includes/head.php';

$one_of_a_kind_arr = [];

$ceramics_query = "SELECT * FROM unique_ceramics WHERE status = 'active';";
$ceramics_result = mysqli_query($con, $ceramics_query);
while ($row = mysqli_fetch_assoc($ceramics_result)) $one_of_a_kind_arr[] = $row;

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
                <p>Caribbean maker of finely crafted production and bespoke ceramic wall lights, signature pieces in ceramic, stone, and wood.</p>
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
                        <a href="#">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/imogen.png" alt="">
                    </div>
                </div>
                <div class="name-panel michael">
                    <div class="left">
                        <h2>Michael</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita ad reiciendis aspernatur dignissimos soluta perspiciatis tempore cumque, exercitationem quisquam provident delectus mollitia sed excepturi suscipit odio officia vel voluptatum rerum?</p>
                        <a href="#">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/michael.jpeg" alt="">
                    </div>
                </div>
                <div class="name-panel lights">
                    <div class="left">
                        <h2>Lights</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita ad reiciendis aspernatur dignissimos soluta perspiciatis tempore cumque, exercitationem quisquam provident delectus mollitia sed excepturi suscipit odio officia vel voluptatum rerum?</p>
                        <a href="#">view more...</a>
                    </div>
                    <div class="right">
                        <img src="/assets/images/panels/lights.png" alt="">
                    </div>
                </div>
                <div class="name-panel commissions">
                    <div class="left">
                        <h2>Commissions</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita ad reiciendis aspernatur dignissimos soluta perspiciatis tempore cumque, exercitationem quisquam provident delectus mollitia sed excepturi suscipit odio officia vel voluptatum rerum?</p>
                        <a href="#">view more...</a>
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

</body>

<?php require_once __DIR__ . '/includes/foot.php'; ?>