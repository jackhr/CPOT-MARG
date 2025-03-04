<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body id="sconces">
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section class="header">
        <div class="inner">
            <h1>Sconces</h1>
            <p>Elevate your interiors with refined ceramic sconces, thoughtfully crafted with timeless elegance and sophisticated design.</p>
            <button id="view-catalogue">View Sconces Catalogue</button>
        </div>
    </section>

    <section id="pricing-section">
        <div class="inner">
            <button id="toggle-pricing">Toggle Pricing</button>
            <img src="/assets/images/pricing/sconce-pricing-table-1.png" alt="">
            <img src="/assets/images/pricing/sconce-pricing-table-2.png" alt="">
            <img src="/assets/images/pricing/sconce-pricing-table-3.png" alt="">
        </div>
    </section>

    <section class="gallery-section">
        <div class="inner">
            <div class="gallery"></div>
            <button class="load-more-btn">Load More Sconces</button>
        </div>
    </section>

    <section class="catalogue-section">
        <div class="inner">
            <div style="position:relative;padding-top:max(60%,326px);height:0;width:100%">
                <iframe allow="clipboard-write" sandbox="allow-top-navigation allow-top-navigation-by-user-activation allow-downloads allow-scripts allow-same-origin allow-popups allow-modals allow-popups-to-escape-sandbox allow-forms" allowfullscreen="true" style="position:absolute;border:none;width:100%;height:100%;left:0;right:0;top:0;bottom:0;" src="https://e.issuu.com/embed.html?d=margrie_hunt_light_catalog_-_old&u=tropicalstudios"></iframe>
            </div>
        </div>
    </section>

    <div id="sconce-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img src="/assets/images/sconces/single/IMG_9516.jpg" alt="">
                    </div>
                    <div class="info-container">
                        <div class="info-section">
                            <h3 data-name></h3>
                            <span data-base_price>
                                $
                                <span></span>
                                <sub>(usd)</sub>
                            </span>
                            <span data-dimensions></span>
                            <p>Made to order<br>Ships in 4 - 6 weeks<br>SKU - <span data-sku></span></p>
                        </div>
                        <div class="info-section img">
                            <div class="img-container">
                                <img src="/assets/images/sconces/single/IMG_9516.jpg" alt="">
                            </div>
                        </div>
                        <div class="info-section">
                            <h5>Cutouts</h5>
                            <p>In our ceramic sconces, a "cutout" refers to a design element where specific shapes or patterns are carved into the sconce's surface. These cutouts not only enhance the aesthetic appeal by introducing intricate designs but also allow light to pass through, creating captivating patterns and shadows in your space. You can choose from our existing range of cutout motifs or opt for no cutout for a sleek, minimalist look.</p>
                            <button data-cutout="">
                                <span>No Cutout Selected</span>
                                <img src="/assets/icons/right-arrow.svg" alt="">
                            </button>
                        </div>
                        <div class="info-section sconce-add-ons"></div>
                        <div class="info-section">
                            <h5>Quantity</h5>
                            <input data-quantity type="text" name="" id="">
                        </div>
                        <div class="info-section final-price">
                            <h5>Total Price</h5>
                            <div>
                                <div data-total_price>
                                    $
                                    <span></span>
                                    <sub>(usd)</sub>
                                </div>
                                <button id="add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                        <div class="info-section collapsible">
                            <h5>Overview</h5>
                            <div class="sconce-spec-pair">
                                <span>Description:</span>
                                <span data-description></span>
                            </div>
                        </div>
                        <div class="info-section collapsible">
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
                                <span>Mounting Type:</span>
                                <span>Wall mounted</span>
                                <!-- <span data-mounting_type></span> -->
                            </div>
                            <div class="sconce-spec-pair">
                                <span>Fitting Type:</span>
                                <span>X Bracket</span>
                                <!-- <span data-fitting_type></span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="cutout-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <div class="modal-body">
                    <div id="cutout-selection-container">
                        <h3>Select a Cutout</h3>
                        <div class="cutout-preview-container">
                            <div>This is text to enforce that the parent maintains a minimum size. Do not delete.</div>
                            <img src="" alt="">
                        </div>
                        <div class="cutout-list">
                            <div class="cutout-list-item selected no-cutout">
                                <div class="cutout-list-item-img-container"></div>
                                <div class="cutout-list-item-info">
                                    <span>No Cutout</span>
                                </div>
                            </div>
                        </div>
                        <button>Confirm Selection</button>
                    </div>
                    <div class="cutout-preview-container">
                        <div>This is text to enforce that the parent maintains a minimum size. Do not delete.</div>
                        <img src="" alt="">
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
        cutoutsLookup: {},
        activeSconce: null,
        activeCutout: null
    }
    $(document).ready(async function() {
        function setActiveCutout(cutout) {
            STATE.activeCutout = cutout;
            $("[data-cutout] span").text(cutout?.name || "No Cutout Selected");
        }

        function calculateNewTotal() {
            const quantity = Number($("[data-quantity]").val());
            const sconcePrice = Number(STATE?.activeSconce?.base_price);
            const cutoutPrice = Number(STATE?.activeCutout?.base_price) || 0;
            const basePrice = Object.values(getSelectedAddOnsInfo()).reduce((price, addOn) => {
                if (addOn.checked) price += Number(addOn.price);
                return price;
            }, sconcePrice + cutoutPrice);

            const newPrice = formatPrice(basePrice * quantity);
            $("#sconce-modal [data-total_price]>span").text(newPrice);
        }

        loadSconces();
        await loadAddOns();

        $("#view-catalogue").on('click', function() {
            scrollTo({
                top: $("section.catalogue-section").position().top,
                behavior: "smooth"
            });
        });

        $("#toggle-pricing").on('click', () => $("#pricing-section").toggleClass("viewing-pricing"));

        $(".load-more-btn").on('click', function() {
            loadSconces();
        });

        $(".sconce-add-on").on('change', function() {
            calculateNewTotal();
        });

        $(".info-container .info-section.collapsible h5").on("click", function() {
            $(this).closest('.info-section').toggleClass("collapsed");
        });

        $("[data-quantity]").on('input', function(evt) {
            const currentQuantity = $(this).val();
            const match = currentQuantity.match(/\d+/g);
            let newQuantity = match === null ? "" : match.join("");
            if (newQuantity > 100) newQuantity = 100;
            $(this).val(newQuantity);
            calculateNewTotal();
        });

        $("[data-cutout]").on('click', async function(evt) {
            if ($(".cutout-list-item").length <= 1) await loadCutouts();
            $(".cutout-list-item").removeClass('selected');
            const activeId = STATE.activeCutout?.cutout_id;
            if (Number(activeId)) {
                $(`.cutout-list-item[data-id="${activeId}"]`).trigger('click');
            } else {
                $(`.cutout-list-item.no-cutout`).trigger('click');
            }
            // Convert cutout_ids to a Set for faster lookups
            const cutoutSet = new Set(STATE.activeSconce.cutout_ids);

            // Select all elements that have the "data-id" attribute
            $('#cutout-modal').find('.cutout-list-item').each((_, el) => {
                const dataId = parseInt($(el).data('id'), 10); // Get the data-id as an integer
                if (cutoutSet.has(dataId) || $(el).hasClass("no-cutout")) {
                    console.log("here");
                    $(el).show();
                } else {
                    console.log("naaah");
                    $(el).hide();
                }
            });
            $("#cutout-modal").addClass('showing');
        });

        $(".cutout-list + button").on('click', function() {
            const selectedCutout = $(".cutout-list-item.selected");
            const cutoutId = selectedCutout.data('id');
            $("#cutout-modal .modal-close").trigger('click');
            setActiveCutout(STATE.cutoutsLookup[cutoutId]);
            calculateNewTotal();
        });

        $("#add-to-cart").on('click', function() {
            const quantity = Number($("#sconce-modal [data-quantity]").val());
            if (quantity < 1) {
                return Swal.fire({
                    icon: "warning",
                    title: "No Quantity",
                    text: "In order to add a sconce to your cart, you must have a quantity of 1 or more."
                });
            }

            const lineItemDesc = getLineItemDescription(quantity);
            const addOnsInfo = getSelectedAddOnsInfo();
            let title = "Success";
            let text = `${lineItemDesc} successfully added to cart!`;
            const addOnIds = Object.values(addOnsInfo).reduce((arr, addOn) => {
                if (addOn.checked) arr.push(addOn.add_on_id);
                return arr;
            }, []);
            try {
                const cart = getCart();
                const itemInCartIdx = cart.findIndex(item => {
                    return (
                        item.item.sconce_id === STATE.activeSconce.sconce_id &&
                        item?.item?.cutout?.cutout_id === STATE?.activeCutout?.cutout_id &&
                        arraysAreEqual(item?.item.addOnIds, addOnIds)
                    );
                });

                if (itemInCartIdx > -1) {
                    const currentQuantity = cart[itemInCartIdx].quantity;
                    const newQuantity = currentQuantity + quantity;
                    text = `The item (${getLineItemDescription(currentQuantity)}) is already in the cart so we updated the quantity to "${newQuantity}"!`;
                    cart[itemInCartIdx] = {
                        ...structuredClone(cart[itemInCartIdx]),
                        quantity: newQuantity,
                        lineItemDesc: getLineItemDescription(newQuantity)
                    }
                } else {
                    cart.push({
                        type: "sconce",
                        item: {
                            ...structuredClone(STATE.activeSconce),
                            cutout: !STATE.activeCutout ? null : {
                                ...structuredClone(STATE.activeCutout)
                            },
                            addOnIds
                        },
                        quantity: Number(quantity),
                        lineItemDesc
                    });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                resetSconceModal();
                reCalculateCartCount();
            } catch (err) {
                title = "Error";
                text = err;
                console.log(err);
            }

            Swal.fire({
                title: title,
                text: text,
                icon: title.toLocaleLowerCase(),
                showCancelButton: true,
                cancelButtonText: "Go To Cart",
                confirmButtonText: "OK",
                cancelButtonColor: '#ED6F35', // Optional: Custom color for the "Go To Cart" button
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    // Redirect to cart
                    window.location.href = "/cart"; // Replace "/cart" with your cart URL
                }
            });
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>