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
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>