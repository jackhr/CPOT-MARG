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
                    <span>$680</span>
                </div>
                <div class="summary-pair">
                    <span>Delivery Fee:</span>
                    <span>FREE</span>
                </div>
                <div class="summary-pair promo">
                    <span>Promo:</span>
                    <span>-</span>
                </div>
                <hr>
                <div class="summary-pair total">
                    <span>Total:</span>
                    <span>$680</span>
                </div>
            </div>
        </div>
    </section>

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
        activeCutout: null
    }
    $(document).ready(async function() {
        loadCart();
        loadCutouts();
        loadSconces(true);

        function loadCart() {
            const cart = getCart();

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
                                        <div data-dimensions>${item.item.dimensions}</div>
                                    </div>
                                    <div class="right">
                                        <div>
                                            <span>Color</span>
                                            <span>${item.item.color}</span>
                                        </div>
                                        <div>
                                            <span>Material</span>
                                            <span>${item.item.material}</span>
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
                                    <div>
                                        <svg class="edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                            <path d="m15 5 4 4"></path>
                                        </svg>
                                    </div>
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

        $("svg.edit").off('click').on('click', async function() {
            const cart = getCart();
            const lineItemEl = $(this).closest('.line-item');
            const type = lineItemEl.data('type');
            const cartIdx = lineItemEl.closest('.line-item-container').data('cart-idx');
            const lineItem = cart[cartIdx];

            STATE.activeIdx = cartIdx;
            STATE.activeSconce = lineItem.item

            if (type === "cutout") {
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
        });

        $("#cutout-selection-container>button").on('click', function() {
            const selectedCutout = $(".cutout-list-item.selected");
            const cutoutId = selectedCutout.hasClass('no-cutout') ? null : selectedCutout.data('id');
            const cart = getCart();
            STATE.activeCutout = STATE.cutoutsLookup[cutoutId] || null;
            cart[STATE.activeIdx] = {
                ...cart[STATE.activeIdx],
                lineItemDesc: getLineItemDescription(cart[STATE.activeIdx].quantity)
            }
            cart[STATE.activeIdx].item.cutout = STATE.cutoutsLookup[cutoutId];
            localStorage.setItem('cart', JSON.stringify(cart));
            location.reload();
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>