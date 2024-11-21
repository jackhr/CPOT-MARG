<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body>
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section id="cart-section">
        <h1>Cart</h1>
        <div class="inner">
            <div id="cart-list"></div>
            <div id="order-summary">
                <h2>Order Summary</h2>
                <hr>
                <div class="summary-pair sub">
                    <span>Sub-Total:</span>
                    <span>-</span>
                </div>
                <div class="summary-pair fee">
                    <span>Delivery Fee:</span>
                    <span>-</span>
                </div>
                <div class="summary-pair promo">
                    <span>Promo:</span>
                    <span>-</span>
                </div>
                <hr>
                <div class="summary-pair total">
                    <span>Total:</span>
                    <span>-</span>
                </div>
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
                            <button data-cutout="">
                                <span>No Cutout Selected</span>
                                <img src="/assets/icons/right-arrow.svg" alt="">
                            </button>
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
                                <button id="update-cart">Confirm</button>
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

    <div id="cutout-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <div class="modal-body">
                    <div id="cutout-selection-container">
                        <h3>Select a Cutout</h3>
                        <div id="cutout-list">
                            <div class="cutout-list-item selected no-cutout">
                                <div class="cutout-list-item-img-container"></div>
                                <div class="cutout-list-item-info">
                                    <span>No Cutout</span>
                                </div>
                            </div>
                        </div>
                        <button>Confirm Selection</button>
                    </div>
                    <div id="cutout-preview-container">
                        <img style="display: none;" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    const STATE = {
        activeIdx: -1,
        sconcesLookup: {},
        cutoutsLookup: {},
        activeSconce: null,
        activeCutout: null,
        openingSconceModal: false
    }
    $(document).ready(async function() {
        loadCart();
        loadCutouts();
        loadSconces(true);

        function loadCart() {
            const cart = getCart();

            if (!cart.length) {
                $("#cart-list").html(`
                    <div id="empty-cart-alert">
                        <h3>There are no items in your cart!</h3>
                        <a href="/lights/">
                            <button>View Lights</button>
                        </a>
                    </div>
                `);
                return;
            }

            $(".summary-pair.fee span:last-child").text("FREE");

            let subTotal = cart.reduce((acc, item, idx) => {
                item.item = formatResource(item.item);
                item.item.cutout && (item.item.cutout = formatResource(item.item.cutout));
                const itemPrice = Number(item.item.base_price);
                const cutoutPrice = Number(item?.item?.cutout?.base_price) || 0;
                const quantity = Number(item.quantity);
                const itemSubTotal = (itemPrice + cutoutPrice) * quantity;
                const formattedItemSubTotal = formatPrice(itemSubTotal)
                const idKey = `${item.type}_id`;

                const lineItemContainer = `
                    <div class="line-item-container" data-cart-idx="${idx}">
                        <div class="line-item ${item.type}" data-type="${item.type}">
                            <div>
                                <h3>${item.type}</h3>
                                <div>
                                    <svg class="edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                        <path d="m15 5 4 4"></path>
                                    </svg>
                                    <svg class="delete" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        <line x1="10" x2="10" y1="11" y2="17"></line>
                                        <line x1="14" x2="14" y1="11" y2="17"></line>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="img-container">
                                    <img src="${item.item.image_url}" alt="">
                                </div>
                                <div class="line-item-info">
                                    <div>
                                        <h5>${item.item.name}</h5>
                                        <div class="line-item-quantity">
                                            <div>
                                                <span>$${item.item.base_price}</span>
                                                <sub>(usd)</sub>
                                            </div>
                                            <span>x</span>
                                            <input data-quantity type="text" name="" id="" value="${quantity}">
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div>
                                            <span>Size:</span>
                                            <span>${item.item.dimensions}</span>
                                        </div>
                                        <div>
                                            <span>Material:</span>
                                            <span>${item.item.material}</span>
                                        </div>
                                        <div>
                                            <span>Color:</span>
                                            <span>${item.item.color}</span>
                                        </div>
                                        <div>
                                            <span>Finish:</span>
                                            <span>${item.item.finish || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Mounting Type:</span>
                                            <span>${item.item.mounting_type || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Fitting Type:</span>
                                            <span>${item.item.fitting_type || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Description:</span>
                                            <span>${item.item.description || "-"}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ${item.type === "light" ? (
                            `<hr>
                            <div class="line-item cutout" data-type="cutout">
                                <div>
                                    <h3>Cutout</h3>
                                </div>
                                <div>
                                    <div class="img-container">
                                        <img src="${item?.item?.cutout?.image_url || ""}" alt="">
                                    </div>
                                    <div class="line-item-info">
                                        <div>
                                            <h5>${item?.item?.cutout?.name || "No Cutout"}</h5>
                                            <div>
                                                <span>$${item?.item?.cutout?.base_price || 0}</span>
                                                <sub>(usd)</sub>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            ${item?.item?.cutout?.description ? (
                                                `<div>
                                                    <span>${item.item.cutout.description}</span>
                                                </div>`
                                            ) : ""}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="line-item-total">
                                <p>${item.lineItemDesc}</p>
                                <span data-price>$${formattedItemSubTotal}</span>
                            </div>`
                        ) : ""}
                    </div>
                `;

                $("#cart-list").append(lineItemContainer);

                return acc + itemSubTotal;
            }, 0);

            subTotal = formatPrice(subTotal);

            $("#order-summary .summary-pair.sub span:last-child").text(`$${subTotal}`);
            $("#order-summary .summary-pair.total span:last-child").text(`$${subTotal}`);
        }

        async function handleOpenCutoutModal() {
            const cart = getCart();
            const lineItem = cart[STATE.activeIdx];

            if ($(".cutout-list-item").length <= 1) await loadCutouts();
            $(".cutout-list-item").removeClass('selected');
            const activeId = lineItem.item.cutout?.cutout_id;
            if (Number(activeId)) {
                $(`.cutout-list-item[data-id="${activeId}"]`).trigger('click');
            } else {
                $(`.cutout-list-item.no-cutout`).trigger('click');
            }
            $("#cutout-modal").addClass('showing');
        }

        $("svg.edit").on('click', async function() {
            const cart = getCart();
            const lineItemEl = $(this).closest('.line-item');
            const cartIdx = lineItemEl.closest('.line-item-container').data('cart-idx');
            const lineItem = cart[cartIdx];

            STATE.activeIdx = cartIdx;
            STATE.activeSconce = lineItem.item

            setActiveSconce(lineItem, true);
        });

        $("svg.delete").on('click', async function() {
            const cart = getCart();
            const lineItemEl = $(this).closest('.line-item');
            const cartIdx = lineItemEl.closest('.line-item-container').data('cart-idx');
            const lineItem = cart[cartIdx];

            const choice = await Swal.fire({
                icon: "warning",
                title: "Removing From Cart",
                html: `Are you sure you'd like to remove the following item from the cart: <p style="font-weight:700">${lineItem.lineItemDesc}</p>`,
                showCancelButton: true,
                confirmButtonText: "Remove"
            });

            if (!choice.isConfirmed) return;

            cart.splice(cartIdx, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            location.reload();
        });

        $("[data-cutout]").on('click', async function() {
            handleOpenCutoutModal();
        });

        $("#cutout-selection-container>button").on('click', function() {
            const selectedCutout = $(".cutout-list-item.selected");
            const cutoutId = selectedCutout.hasClass('no-cutout') ? null : selectedCutout.data('id');
            $("[data-cutout] span").text(STATE.cutoutsLookup[cutoutId]?.name || "No Cutout Selected");
            $("#cutout-modal .modal-close").trigger('click');
        });

        $("#update-cart").on('click', function() {
            const selectedCutout = $(".cutout-list-item.selected");
            const cutoutId = selectedCutout.hasClass('no-cutout') ? null : selectedCutout.data('id');
            const cart = getCart();
            const newQuantity = $("#sconce-modal [data-quantity]").val();
            STATE.activeCutout = STATE.cutoutsLookup[cutoutId] || null;
            cart[STATE.activeIdx] = {
                ...cart[STATE.activeIdx],
                item: {
                    ...cart[STATE.activeIdx].item,
                    cutout: STATE.activeCutout
                },
                lineItemDesc: getLineItemDescription(newQuantity),
                quantity: newQuantity
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            location.reload();
        });

        $("#sconce-modal [data-quantity]").on('input', function(evt) {
            const currentQuantity = $(this).val();
            const match = currentQuantity.match(/\d+/g);
            let newQuantity = match === null ? "" : match.join("");
            if (newQuantity > 100) newQuantity = 100;
            $(this).val(newQuantity);
            calculateNewTotal();
        });

        function calculateNewTotal() {
            const quantity = Number($("#sconce-modal [data-quantity]").val());
            const basePrice = Number(STATE?.activeSconce?.base_price);
            const cutoutPrice = Number(STATE?.activeCutout?.base_price) || 0;
            const newPrice = formatPrice((basePrice + cutoutPrice) * quantity);
            $("#sconce-modal [data-total_price]>span").text(newPrice);
        }
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>