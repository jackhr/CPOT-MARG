<?php

require_once __DIR__ . '/../includes/head.php';

$sconces_arr = [];

$sconces_query = "SELECT * FROM sconces WHERE status = 'active';";
$sconces_result = mysqli_query($con, $sconces_query);
while ($row = mysqli_fetch_assoc($sconces_result)) $sconces_arr[] = $row;

?>

<body>
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section id="lights-header">
        <div class="inner">
            <h1>Lighting</h1>
            <p>Elevate your interiors with refined ceramic lights and sconces, thoughtfully crafted with timeless elegance and sophisticated design.</p>
            <button>Download Light Catalogue</button>
        </div>
    </section>

    <section id="sconce-section">
        <div class="inner">
            <div>
                <div class="filter-container">
                    <span>Filter By:</span>
                    <select name="" id="">
                        <option value="Style">Style</option>
                    </select>
                </div>
                <div class="filter-container">
                    <span>Filter By:</span>
                    <select name="" id="">
                        <option value="Mounting">Mounting</option>
                    </select>
                </div>
            </div>
            <div class="gallery">
                <?php foreach ($sconces_arr as $sconce) { ?>
                    <div class="sconce-panel">
                        <img src="<?php echo $sconce['image_url']; ?>" alt="Oops">
                        <div>
                            <h4><?php echo $sconce['name']; ?></h4>
                            <span><?php echo $sconce['dimensions']; ?></span>
                            <div>
                                <span><?php echo $sconce['base_price']; ?><sub>(usd)</sub></span>
                                <span>View More...</span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="load-more-btn">Load More Lights</button>
        </div>
    </section>

</body>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>