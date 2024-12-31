<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body>
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section class="header">
        <div class="inner">
            <h1>One Of A Kind</h1>
            <p>Elevate your interiors with refined unique ceramics, thoughtfully crafted with timeless elegance and sophisticated design.</p>
        </div>
    </section>

    <section class="gallery-section">
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
            <div class="one-of-a-kind gallery"></div>
            <button class="load-more-btn">Load More Artwork</button>
        </div>
    </section>

    <div id="oak-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <div class="modal-body">
                    <div class="info-container">
                        <h3 data-name></h3>
                        <div class="info-section">
                            <span>Artist:</span>
                            <span data-artist></span>
                        </div>
                        <div class="info-section">
                            <span>Size:</span>
                            <span data-dimensions></span>
                        </div>
                        <div class="info-section">
                            <span>Material:</span>
                            <span data-material></span>
                        </div>
                        <div class="info-section">
                            <span>Year Created:</span>
                            <span data-created_at></span>
                        </div>
                        <div class="info-section">
                            <span>Description:</span>
                            <span data-description></span>
                        </div>
                        <!-- <div class="info-section">
                            <h5>Price</h5>
                            <span data-base_price>
                                $
                                <span></span>
                                <sub>(usd)</sub>
                            </span>
                            <input data-quantity type="text" name="" id="">
                        </div> -->
                        <button id="enquiry-btn">Make Enquiry</button>
                    </div>
                    <div class="img-container">
                        <div class="prev">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </div>
                        <img src="" alt="">
                        <div class="next">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    const STATE = {
        pagination: {
            current_page: 0,
            total_items: null,
            total_pages: null
        },
        oAKsLookup: {},
        activeOAK: null,
        activeOAKIdx: 0
    }
    $(document).ready(function() {
        function calculateNewTotal() {
            const quantity = Number($("[data-quantity]").val());
            const basePrice = Number(STATE?.activeOAK?.base_price);
            const newPrice = formatPrice(basePrice * quantity);
            $("#sconce-modal [data-total_price]>span").text(newPrice);
        }

        loadOAKs();

        $(".load-more-btn").on('click', function() {
            loadOAKs();
        });

        $("#oak-modal .img-container .prev").on('click', function() {
            if (--STATE.activeOAKIdx < 0) {
                STATE.activeOAKIdx = STATE.oAKs.length - 1;
            }

            const newOAK = STATE.oAKs[STATE.activeOAKIdx];
            setActiveOAK(newOAK);
        });

        $("#oak-modal .img-container .next").on('click', function() {
            if (!STATE.oAKs[++STATE.activeOAKIdx]) {
                STATE.activeOAKIdx = 0;
            }

            const newOAK = STATE.oAKs[STATE.activeOAKIdx];
            setActiveOAK(newOAK);
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>