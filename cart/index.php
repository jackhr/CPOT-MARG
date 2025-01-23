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
                        <div class="info-section">
                            <h5>Cutouts</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus asperiores perspiciatis perferendis blanditiis!</p>
                            <button data-cutout="">
                                <span>No Cutout Selected</span>
                                <img src="/assets/icons/right-arrow.svg" alt="">
                            </button>
                        </div>
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
                                <button id="update-cart">Confirm</button>
                            </div>
                        </div>
                        <div class="info-section collapsible">
                            <h5>Overview</h5>
                            <p data-description>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eum ab, consequuntur deserunt nam quasi consequatur corporis?</p>
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

    <div id="confirmation-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-options">
                        <span class="modal-close">×</span>
                    </div>
                    <h3>Complete Your Request</h3>
                    <p>Provide your contact details below, and we will get in touch to finalize your request.</p>
                </div>
                <div class="modal-body">
                    <form action="">
                        <h3>Contact Info</h3>
                        <div class="multiple-input-container">
                            <div class="input-container">
                                <input type="text" name="first_name" placeholder="First Name" required>
                            </div>
                            <div class="input-container">
                                <input type="text" name="last_name" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="multiple-input-container">
                            <div class="input-container">
                                <input type="text" name="email" placeholder="Email" required>
                            </div>
                            <div class="input-container">
                                <input type="text" name="phone" placeholder="Phone" required>
                            </div>
                        </div>
                        <h3>Address Info</h3>
                        <div class="input-container">
                            <input type="text" name="address_1" placeholder="Street Address" required>
                        </div>
                        <div class="input-container">
                            <input type="text" name="town_or_city" placeholder="Town / City" required>
                        </div>
                        <div class="input-container">
                            <input type="text" name="state" placeholder="State" required>
                        </div>
                        <div class="input-container">
                            <input type="text" name="country" placeholder="Country" required>
                        </div>
                        <div class="input-container">
                            <textarea name="message" placeholder="Message" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="send-request-btn">Send Request</button>
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
        openingSconceModal: false,
        emailRegEx: /[a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/
    }

    function openConfirmationModal() {
        $("#confirmation-modal").addClass('showing');
    }

    $(document).ready(async function() {
        await loadAddOns();
        loadCart();
        loadCutouts();
        loadSconces(true);

        function handleInvalidFormData() {
            const data = $("#confirmation-modal form").serializeObject();
            let text;

            if (data.first_name === '') {
                text = 'Please enter Your first name.';
                element = $('input[name="first_name"]');
            } else if (data.last_name === '') {
                text = 'Please enter your last name.';
                element = $('input[name="last_name"]');
            } else if (data.email === '') {
                text = 'Please enter your email address.';
                element = $('input[name="email"]');
            } else if (!STATE.emailRegEx.test(data.email)) {
                text = 'Please enter a valid email address.';
                element = $('input[name="email"]');
            } else if (data.phone === '') {
                text = 'Please enter your phone number.';
                element = $('input[name="phone"]');
            } else if (data.address_1 === '') {
                text = 'Please enter your address.';
                element = $('input[name="address_1"]');
            } else if (data.town_or_city === '') {
                text = 'Please enter your town or city.';
                element = $('input[name="town_or_city"]');
            } else if (data.state === '') {
                text = 'Please enter your state.';
                element = $('input[name="state"]');
            } else if (data.country === '') {
                text = 'Please enter your country.';
                element = $('input[name="country"]');
            }

            if (text) {
                Swal.fire({
                    text,
                    title: "Incomplete form",
                    icon: "warning",
                });
                element.addClass('form-error');
            }

            return !text;
        }

        function submitOrder() {
            if (!handleInvalidFormData()) return;

            const cart = getCart();
            const data = {
                action: "create",
                first_name: $('input[name="first_name"]').val().trim(),
                last_name: $('input[name="last_name"]').val().trim(),
                email: $('input[name="email"]').val().trim(),
                phone: $('input[name="phone"]').val().trim(),
                message: $('textarea[name="message"]').val().trim(),
                address_1: $('input[name="address_1"]').val().trim(),
                town_or_city: $('input[name="town_or_city"]').val().trim(),
                state: $('input[name="state"]').val().trim(),
                country: $('input[name="country"]').val().trim(),
                total_amount: cart.reduce((total, item) => (total + generateOrderItemPrice(item)), 0),
                order_items: cart.map(item => ({
                    item_type: item.type,
                    sconce_id: item.item.sconce_id || null,
                    cutout_id: item.item.cutout ? item.item.cutout.cutout_id : null,
                    quantity: item.quantity,
                    price: generateOrderItemPrice(item),
                    description: item.lineItemDesc,
                    add_on_ids: item.item.addOnIds
                }))
            };

            $.ajax({
                type: "POST",
                url: "/api/orders/api.php",
                data: JSON.stringify(data),
                contentType: "application/json",
                dataType: "json",
                success: async (res) => {
                    await Swal.fire({
                        icon: res.status === 200 ? "success" : "error",
                        title: res.status === 200 ? "Success" : "Error",
                        text: res.message,
                    });

                    if (res.status === 200) {
                        localStorage.clear('cart');
                        location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(arguments);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: errorThrown,
                    });
                }
            });
        }

        function loadCart() {
            const cart = getCart();

            if (!cart.length) {
                $("#cart-list").html(`
                    <div id="empty-cart-alert">
                        <h3>There are no items in your cart!</h3>
                        <a href="/sconces/">
                            <button>View Sconces</button>
                        </a>
                    </div>
                `);
                return;
            }

            $("#order-summary").append(`
                <hr>
                <button id="open-confirm-order-btn" onClick="openConfirmationModal()">Send Request</button>
            `);

            $(".summary-pair.fee span:last-child").text("FREE");

            let subTotal = cart.reduce((acc, item, idx) => {
                item.item = formatResource(item.item);
                item.item.cutout && (item.item.cutout = formatResource(item.item.cutout));
                const quantity = Number(item.quantity);
                const itemSubTotal = generateOrderItemPrice(item);
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
                                            <span>Mounting Type:</span>
                                            <span>Wall mounted</span>
                                            <!-- <span>${item.item.mounting_type || "-"}</span> -->
                                        </div>
                                        <div>
                                            <span>Fitting Type:</span>
                                            <span>X Bracket</span>
                                            <!-- <span>${item.item.fitting_type || "-"}</span> -->
                                        </div>
                                        ${Object.values(STATE.addOnsLookup).map(addOn => {
                                            const addOnIsApplied = item?.item?.addOnIds.includes(addOn.add_on_id);
                                            const finalAddOnStr = (addOnIsApplied ? "With" : "Without") + ` ${addOn.name}`;
                                            return `
                                                <div>
                                                    <span>${addOn.name}:</span>
                                                    <span>${finalAddOnStr}</span>
                                                </div>
                                            `;
                                        }).join('')}
                                        <div>
                                            <span>Description:</span>
                                            <span>${item.item.description || "-"}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
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
                        <hr>
                        <div class="line-item add-ons" data-type="add-ons">
                            <div>
                                <h3>Add Ons</h3>
                            </div>
                            <div>
                                <div class="line-item-info">
                                    <div class="bottom">
                                        ${Object.values(STATE.addOnsLookup).map(addOn => {
                                            const addOnIsApplied = item?.item?.addOnIds.includes(addOn.add_on_id);
                                            const finalAddOnStr = (addOnIsApplied ? "With" : "Without") + ` ${addOn.name}`
                                            return `
                                                <div>
                                                    <span>${finalAddOnStr}:</span>
                                                    <div>
                                                        <span>$${addOnIsApplied ? addOn.price : 0}</span>
                                                        <sub>(usd)</sub>
                                                    </div>
                                                </div>
                                            `;
                                        }).join('')}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line-item-total">
                            <p>${item.lineItemDesc}</p>
                            <span data-price>$${formattedItemSubTotal}</span>
                        </div>
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

        $("input").on('input', function() {
            $(this).removeClass('form-error');
        });

        $("#send-request-btn").on('click', submitOrder);

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
                ...structuredClone(cart[STATE.activeIdx]),
                item: {
                    ...structuredClone(cart[STATE.activeIdx].item),
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