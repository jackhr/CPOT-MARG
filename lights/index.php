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
                <div class="modal-header">
                    <div class="modal-options">
                        <span class="modal-close">×</span>
                    </div>
                    <h1>Sconce Details</h1>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

</body>

<script>
    $(document).ready(function() {
        const STATE = {
            pagination: {
                current_page: 0,
                total_items: null,
                total_pages: null
            }
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
                            const sconceEl = $(`
                                <div class="sconce-panel">
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

                            sconceEl.on('click', function() {
                                $("#sconce-modal").addClass('showing');
                            });

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

        loadMoreSconces();

        $(".load-more-btn").on('click', function() {
            loadMoreSconces();
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>