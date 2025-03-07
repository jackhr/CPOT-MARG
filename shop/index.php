<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body id="shop">
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section class="header">
        <div class="inner">
            <h1>Shop</h1>
            <p>Elevate your interiors with refined ceramic items, thoughtfully crafted with timeless elegance and sophisticated design.</p>
        </div>
    </section>

    <section class="gallery-section">
        <div class="inner">
            <div class="gallery"></div>
            <button class="load-more-btn">Load More Items</button>
        </div>
    </section>

    <div id="item-modal" class="modal">
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
                        </div>
                        <div class="info-section img">
                            <div class="img-container">
                                <img src="/assets/images/sconces/single/IMG_9516.jpg" alt="">
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
                        </div>
                        <button id="make-enquiry-btn">Make Enquiry</button>
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
                    <form id="shop-item-form">
                        <h3>Item Info</h3>
                        <div>

                        </div>
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
                    <button for="shop-item-form">Send Request</button>
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
        shopItemsLookup: {},
        activeItem: null,
        phoneRegEx: /^\+?[1-9]\d{0,14}(?:[\s-]*\d+)*(?:\s*x\d+)?$/,
        emailRegEx: /[a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/,
    }
    $(document).ready(async function() {
        loadShopItems();

        function handleInvalidFormData() {
            const data = $("#shop-item-form").serializeObject();
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
            } else if (!STATE.phoneRegEx.test(data.phone) === '') {
                text = 'Please enter a valide phone number.';
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
                    willClose: () => {
                        setTimeout(() => {
                            element.focus();
                            document.activeElement = element[0];
                        }, 300);
                    }
                });
                element.addClass('form-error');
            }

            return !text;
        }

        $("input").on('input', function() {
            $(this).removeClass('form-error');
        });

        $(".load-more-btn").on('click', function() {
            loadShopItems();
        });

        $(".info-container .info-section.collapsible h5").on("click", function() {
            $(this).closest('.info-section').toggleClass("collapsed");
        });

        $("#make-enquiry-btn").on('click', function(e) {
            e.preventDefault();
            $("#item-modal").removeClass("showing");
            $("#confirmation-modal").addClass("showing");
        });

        $('button[for="shop-item-form"]').off('click').on('click', function(e) {
            e.preventDefault();
            if (!handleInvalidFormData()) return;

            const data = {
                ...$("#shop-item-form").serializeObject(),
                shop_item_id: STATE.activeItem.shop_item_id,
                shop_item_name: STATE.activeItem.name,
                action: "create_shop_item_enquiry"
            };

            Swal.fire({
                icon: "info",
                title: "Loading",
                text: "Submitting your request!",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: false,
                showDenyButton: false,
                showCloseButton: false,
                didOpen: () => Swal.showLoading(),
            });

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
                        $("#shop-item-form")[0].reset();
                        $("#confirmation-modal .modal-close").trigger('click');
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
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>