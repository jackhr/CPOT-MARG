<?php require_once __DIR__ . '/../includes/head.php'; ?>

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
            <div class="gallery"></div>
            <button class="load-more-btn">Load More Lights</button>
        </div>
    </section>

    <div id="sconce-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <div class="modal-body">
                    <div id="sconce-img-container">
                        <img src="/assets/images/sconces/single/IMG_9516.jpg" alt="">
                    </div>
                    <div id="sconce-info-container">
                        <div class="sconce-info-section">
                            <h3 data-name></h3>
                            <span data-base_price>
                                $
                                <span></span>
                                <sub>(usd)</sub>
                            </span>
                            <span data-dimensions></span>
                            <p>Made to order<br>Ships in 4 - 6 weeks<br>SKU - <span data-sku></span></p>
                        </div>
                        <div class="sconce-info-section">
                            <h5>Cutouts</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus asperiores perspiciatis perferendis blanditiis!</p>
                            <select data-cutout name="" id="">
                                <option value="">No Cutout Selected</option>
                            </select>
                        </div>
                        <div class="sconce-info-section">
                            <h5>Quantity</h5>
                            <input data-quantity type="text" name="" id="">
                        </div>
                        <div class="sconce-info-section final-price">
                            <h5>Total Price</h5>
                            <div>
                                <div data-total_price>
                                    $
                                    <span></span>
                                    <sub>(usd)</sub>
                                </div>
                                <button>Add to Cart</button>
                            </div>
                        </div>
                        <div class="sconce-info-section collapsible">
                            <h5>Overview</h5>
                            <p data-description>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eum ab, consequuntur deserunt nam quasi consequatur corporis?</p>
                        </div>
                        <div class="sconce-info-section collapsible">
                            <h5>Specification</h5>
                            <div class="sconce-spec-pair">
                                <span>Size:</span>
                                <span data-dimensions></span>
                            </div>
                            <div class="sconce-spec-pair">
                                <span>Material:</span>
                                <span data-material></span>
                            </div>
                            <div class="sconce-spec-pair">
                                <span>Colour:</span>
                                <span data-color></span>
                            </div>
                            <div class="sconce-spec-pair">
                                <span>Finish:</span>
                                <span data-finish></span>
                            </div>
                            <div class="sconce-spec-pair">
                                <span>Mounting Type:</span>
                                <span data-mounting_type></span>
                            </div>
                            <div class="sconce-spec-pair">
                                <span>Fitting Type:</span>
                                <span data-fitting_type></span>
                            </div>
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
        sconcesLookup: {},
        activeSconce: null
    }
    $(document).ready(function() {
        function setActiveSconce(sconce) {
            $("#sconce-modal").addClass('showing');
            
            if (sconce.sconce_id === STATE.activeSconce?.sconce_id) return;
            
            $("#sconce-img-container img").attr("src", sconce.image_url);
            $("#sconce-modal [data-name]").text(sconce.name);
            $("#sconce-modal [data-base_price]>span").text(sconce.base_price);
            $("#sconce-modal [data-sku]").text("#" + sconce.sconce_id);
            $("#sconce-modal [data-description]").text(sconce.description);
            $("#sconce-modal [data-dimensions]").text(sconce.dimensions);
            $("#sconce-modal [data-material]").text(sconce.material);
            $("#sconce-modal [data-color]").text(sconce.color);
            $("#sconce-modal [data-quantity]").val(1);
            $("#sconce-modal [data-total_price]>span").text(sconce.base_price);
            $("#sconce-modal [data-finish]").text(sconce.finish || "-");
            $("#sconce-modal [data-mounting_type]").text(sconce.mounting_type || "-");
            $("#sconce-modal [data-fitting_type]").text(sconce.fitting_type || "-");

            STATE.activeSconce = sconce;
        }

        function loadMoreSconces() {
            $.ajax({
                type: "POST",
                url: "/api/sconces/api.php",
                data: JSON.stringify({
                    action: "get_more_sconces",
                    page: STATE.pagination.current_page
                }),
                contentType: "application/json",
                dataType: "json",
                success: res => {
                    if (res.status === 200) {
                        res.data.forEach(sconce => {
                            STATE.sconcesLookup[sconce.sconce_id] = sconce;
                            const sconceEl = $(`
                                <div data-id="${sconce.sconce_id}" class="sconce-panel">
                                    <img src="${sconce.image_url}" alt="Oops">
                                    <div>
                                        <h4>${sconce.name}</h4>
                                        <span>${sconce.dimensions}</span>
                                        <div>
                                            <span>${sconce.base_price}<sub>(usd)</sub></span>
                                            <span>View More...</span>
                                        </div>
                                    </div>
                                </div>
                            `);

                            sconceEl.on('click', () => setActiveSconce(sconce));

                            $(".gallery").append(sconceEl);
                        });

                        STATE.pagination = {
                            ...res.pagination
                        };

                        if (STATE.pagination.current_page === STATE.pagination.total_pages) {
                            $(".load-more-btn").remove();
                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                },
                error: function() {
                    console.log(arguments);
                }
            });
        }

        function calculateNewTotal() {
            const quantity = $("[data-quantity]").val();
            const newPrice = Number(STATE.activeSconce.base_price) * quantity;
            $("#sconce-modal [data-total_price]>span").text(newPrice);
        }

        loadMoreSconces();

        $(".load-more-btn").on('click', function() {
            loadMoreSconces();
        });

        $(".modal-close").on("click", function() {
            $(this).closest(".modal").removeClass('showing');
        });

        $("#sconce-info-container .sconce-info-section.collapsible h5").on("click", function() {
            $(this).closest('.sconce-info-section').toggleClass("collapsed");
        });

        $("[data-quantity]").on('input', function(evt) {
            const currentQuantity = $(this).val();
            const match = currentQuantity.match(/\d+/g);
            let newQuantity = match === null ? "" : match.join("");
            if (newQuantity > 100) newQuantity = 100;
            $(this).val(newQuantity);
            calculateNewTotal();
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>