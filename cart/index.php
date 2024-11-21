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


</body>

<script>
    const STATE = {
        cart: {
            lights: [],
            oneOfAKind: []
        }
    }
    $(document).ready(function() {
        loadCart();

        function loadCart() {
            const cart = getCart();

            let subTotal = cart.reduce((acc, item) => {
                item.item = formatResource(item.item);
                item.item.cutout && (item.item.cutout = formatResource(item.item.cutout));
                console.log("item.item:", item.item);
                const itemPrice = Number(item.item.base_price);
                const cutoutPrice = Number(item?.item?.cutout?.base_price) || 0;
                const quantity = Number(item.quantity);
                const itemSubTotal = (itemPrice + cutoutPrice) * quantity;
                const formattedItemSubTotal = formatPrice(itemSubTotal)

                const lineItemContainer = `
                    <div class="line-item-container">
                        <div class="line-item ${item.type}">
                            <h3>${item.type}</h3>
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
                            <div class="line-item cutout">
                                <h3>Cutout</h3>
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

                console.log(itemSubTotal);

                return acc + itemSubTotal;
            }, 0);

            subTotal = formatPrice(subTotal);

            $("#order-summary .summary-pair.sub span:last-child").text(`$${subTotal}`);
            $("#order-summary .summary-pair.total span:last-child").text(`$${subTotal}`);
        }
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>