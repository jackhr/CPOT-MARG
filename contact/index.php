<?php require_once __DIR__ . '/../includes/head.php'; ?>

<body id="contact">
    <?php require_once __DIR__ . '/../includes/nav.php'; ?>

    <section class="header">
        <div class="inner">
            <h1>Contact Us</h1>
            <p>Connect with us to explore bespoke ceramic artistry—crafted with care, inspired by passion, and tailored to you.</p>
            <!-- <h2>We’re here for you</h2> -->
        </div>
    </section>

    <section id="map-section">
        <div class="inner">
            <div>
                <h2>Come Contact Us!</h2>
                <p>Nestled in the heart of Antigua & Barbuda, Margrie Hunt's studio and gallery is a haven for art enthusiasts. Located just off Buckley's Main Road, the venue showcases a diverse range of finely crafted ceramics, stone, and wood pieces.</p>
                <p>Visitors can explore the gallery and garden, and view unique sculptural commissions.</p>
                <p>For inquiries or to plan your visit, contact the studio at: <a href="tel:+1 (268) 460-5293">+1 (268) 460-5293</a>.</p>
            </div>
            <div id="map-container">
                <div id="display-google-map">
                    <iframe frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=cedar+pottery+antigua&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>
                </div>
                <a class="google-maps-html" href="https://kbj9qpmy.com/bp" id="inject-map-data">Broadband Providers</a>
            </div>
        </div>
    </section>

    <section id="contact-form-section">
        <div class="inner">
            <div>
                <img src="/assets/images/misc/three-heads.jpeg" alt="">
            </div>
            <div>
                <h2>Send us your enquiry</h2>
                <h3>We are ready to answer your questions</h3>
                <form id="contact-form">
                    <input name="name" type="text" placeholder="Name*" required>
                    <input name="phone" type="text" placeholder="Phone*" required>
                    <input name="email" type="text" placeholder="Email*" required>
                    <textarea name="message" placeholder="Message"></textarea>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>

</body>

<script>
    const STATE = {
        emailRegEx: /[a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/
    }

    function handleInvalidFormData() {
        const data = $("#contact-form").serializeObject();
        let text;

        if (data.name === '') {
            text = 'Please enter your name.';
            element = $('input[name="name"]');
        } else if (data.phone === '') {
            text = 'Please enter your phone number.';
            element = $('input[name="last_name"]');
        } else if (data.email === '') {
            text = 'Please enter your email address.';
            element = $('input[name="email"]');
        } else if (!STATE.emailRegEx.test(data.email)) {
            text = 'Please enter a valid email address.';
            element = $('input[name="email"]');
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

    $('#contact-form button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        if (!handleInvalidFormData()) return;

        const data = {
            ...$(this).closest('form').serializeObject(),
            action: "submit_enquiry"
        };

        Swal.fire({
            icon: "info",
            title: "Loading...",
            text: "Submitting your enquiry.",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: false,
            showDenyButton: false,
            showCloseButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            type: "POST",
            url: "/api/contact/api.php",
            data: JSON.stringify(data),
            contentType: "application/json",
            dataType: "json",
            success: async (res) => {
                Swal.fire({
                    icon: res.status === 200 ? "success" : "error",
                    title: res.status === 200 ? "Success" : "Error",
                    text: res.message,
                });

                console.log("hello:", res);
                if (res?.status === 200) {
                    $("#contact-form")[0].reset();
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

    $("input").on('input', function() {
        $(this).removeClass('form-error');
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>