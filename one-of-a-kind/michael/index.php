<?php require_once __DIR__ . '/../../includes/head.php'; ?>

<body id="one-of-a-kind">
    <?php require_once __DIR__ . '/../../includes/nav.php'; ?>

    <section class="header">
        <div class="inner">
            <h1>Michael</h1>
            <p>Michael's thrown and altered ceramic work continues to be admired for its sense of design, consummate craft skill and attention to detail. He continues to explore working in stone.</p>
            <button class="enquiry-btn">Make An Enquiry</button>
        </div>
    </section>

    <section class="gallery-section">
        <div class="inner">
            <!-- Might need this filtering later -->
            <!-- <div>
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
            </div> -->
            <h1>Gallery</h1>
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
                        <div class="info-section">
                            <span>Price:</span>
                            <span data-price>
                                $
                                <span></span>
                                <sub>(usd)</sub>
                            </span>
                        </div>
                        <button class="enquiry-btn">Make Enquiry</button>
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
                    <form id="one-of-a-kind-form">
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
                    <button for="one-of-a-kind-form">Send Request</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    const STATE = {
        phoneRegEx: /^\+?[1-9]\d{0,14}(?:[\s-]*\d+)*(?:\s*x\d+)?$/,
        emailRegEx: /[a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/,
        pagination: {
            current_page: 0,
            total_items: null,
            total_pages: null
        },
        oAKsLookup: {},
        activeOAK: null,
        activeOAKIdx: 0,
        goBackToDetailsModal: false
    }
    $(document).ready(async function() {

        function calculateNewTotal() {
            const quantity = Number($("[data-quantity]").val());
            const basePrice = Number(STATE?.activeOAK?.base_price);
            const newPrice = formatPrice(basePrice * quantity);
            $("#sconce-modal [data-total_price]>span").text(newPrice);
        }

        function handleInvalidFormData() {
            const data = $("#one-of-a-kind-form").serializeObject();
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

        await loadOAKs({
            getAll: true,
            artist: "Michael Hunt"
        });

        <?php if (isset($_GET['id'])) { ?>
            const params = new URLSearchParams(location.search)
            const id = params.get('id');
            const panel = $(`.one-of-a-kind-panel[data-id="${id}"]`);

            console.log("params:", params);
            console.log("id:", id);
            console.log("panel:", panel);

            if (panel.length) {
                $('html')[0].scrollBy({
                    top: $(".gallery-section h1")[0].getBoundingClientRect().y - 50,
                    behavior: 'smooth'
                });

                setTimeout(() => panel.trigger('click'), 500);
            }
        <?php } ?>

        $("#one-of-a-kind-form input").on('keyup', function(e) {
            if (e.keyCode === 13) $('button[for="one-of-a-kind-form"]').trigger('click');
        });

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

        $(".enquiry-btn").on('click', function(e) {
            e.preventDefault();
            STATE.goBackToDetailsModal = !!$(this).closest('.modal').length;
            $("#oak-modal").removeClass("showing");
            $("#confirmation-modal").addClass("showing");
        });

        $("#confirmation-modal .modal-close").on('click', function() {
            if (STATE.goBackToDetailsModal) {
                $("#oak-modal").addClass("showing");
            }
            $("#confirmation-modal").removeClass("showing");
        });

        $("input").on('input', function() {
            $(this).removeClass('form-error');
        });

        $('button[for="one-of-a-kind-form"]').off('click').on('click', function(e) {
            e.preventDefault();
            if (!handleInvalidFormData()) return;

            const data = {
                ...$("#one-of-a-kind-form").serializeObject(),
                one_of_a_kind_id: STATE.activeOAK.one_of_a_kind_id,
                oak_name: STATE.activeOAK.name,
                action: "create_enquiry"
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
                        $("#one-of-a-kind-form")[0].reset();
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

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>