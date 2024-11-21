<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body>
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section id="cart-section">
        <h1>Cart</h1>
        <div class="inner">
            <div id="cart-list">
                <div class="line-item-container">
                    <div class="line-item light">
                        <div class="img-container">
                            <img src="https://www.tropicalstudios.com/client/cpot/marg/admin/public/assets/images/sconces/J67.jpg" alt="">
                        </div>
                        <div class="line-item-info">
                            <div>
                                <h5>J48</h5>
                                <div class="line-item-quantity">
                                    <div>
                                        <span>$170</span>
                                        <sub>(usd)</sub>
                                    </div>
                                    <span>x</span>
                                    <input data-quantity type="text" name="" id="" value="4">
                                </div>
                                <div data-dimensions>12cm x 12cm x 12cm</div>
                            </div>
                            <div class="right">
                                <div>
                                    <span>Color</span>
                                    <span>White</span>
                                </div>
                                <div>
                                    <span>Material</span>
                                    <span>Clay</span>
                                </div>
                                <div>
                                    <span>Price</span>
                                    <span>$680</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="line-item cutout">
                        <div class="img-container">
                            <img src="https://www.tropicalstudios.com/client/cpot/marg/admin/public/assets/images/cutouts/Conch.jpg" alt="">
                        </div>
                        <div class="line-item-info">
                            <div>
                                <h5>Conch</h5>
                                <div class="line-item-quantity">
                                    <div>
                                        <span>$35</span>
                                        <sub>(usd)</sub>
                                    </div>
                                    <span>x</span>
                                    <input data-quantity type="text" name="" id="" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line-item-total">
                        <p>J48 with Conch cutout</p>
                        <span data-price>$680</span>
                    </div>
                </div>
                <div class="line-item-container">
                    <div class="line-item light">
                        <div class="img-container">
                            <img src="https://www.tropicalstudios.com/client/cpot/marg/admin/public/assets/images/sconces/J67.jpg" alt="">
                        </div>
                        <div class="line-item-info">
                            <div>
                                <h5>J48</h5>
                                <div class="line-item-quantity">
                                    <div>
                                        <span>$170</span>
                                        <sub>(usd)</sub>
                                    </div>
                                    <span>x</span>
                                    <input data-quantity type="text" name="" id="" value="4">
                                </div>
                                <div data-dimensions>12cm x 12cm x 12cm</div>
                            </div>
                            <div class="right">
                                <div>
                                    <span>Color</span>
                                    <span>White</span>
                                </div>
                                <div>
                                    <span>Material</span>
                                    <span>Clay</span>
                                </div>
                                <div>
                                    <span>Price</span>
                                    <span>$680</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="line-item cutout">
                        <div class="img-container">
                            <img src="https://www.tropicalstudios.com/client/cpot/marg/admin/public/assets/images/cutouts/Conch.jpg" alt="">
                        </div>
                        <div class="line-item-info">
                            <div>
                                <h5>Conch</h5>
                                <div class="line-item-quantity">
                                    <div>
                                        <span>$35</span>
                                        <sub>(usd)</sub>
                                    </div>
                                    <span>x</span>
                                    <input data-quantity type="text" name="" id="" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line-item-total">
                        <p>J48 with Conch cutout</p>
                        <span data-price>$680</span>
                    </div>
                </div>
            </div>
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

    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>