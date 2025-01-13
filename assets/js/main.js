$(document).ready(function () {

    $(".carousel").flickity({
        fade: true,
        wrapAround: true,
        draggable: false,
        autoPlay: 3000,
        lazyLoad: 1,
        imagesLoaded: true, // re-positions cells once their images have loaded.
        cellSelector: '.carousel-cell',
        cellAlign: "right",
        cover: true,
        prevNextButtons: false,
        pageDots: false,
        fullscreen: false,
        pauseAutoPlayOnHover: false
    });

    setInterval(() => {
        const allWords = $("#landing-title-container>div>span")
        const activeWord = allWords.filter((_i, elem) => $(elem).hasClass('showing'));
        const nextWord = activeWord.next().length ? activeWord.next() : allWords.first();
        activeWord.removeClass("showing");
        nextWord.addClass("showing");
    }, 3000);

    $(".modal-close").on("click", function () {
        $(this).closest(".modal").removeClass('showing');
    });

    reCalculateCartCount();
});

function reCalculateCartCount() {
    $("#cart-count").html(getCart().length || "");
}

function getCart() {
    return JSON.parse(localStorage.getItem('cart')) ?? [];
};

function formatPrice(price) {
    // Convert to number and then to a string and use toLocaleString for formatting
    return Number(price).toLocaleString('en-US', {
        minimumFractionDigits: 2, // Ensures two decimal places
        maximumFractionDigits: 2 // Prevents more than two decimal places
    });
}

function formatResource(resource) {
    return {
        ...resource,
        base_price: formatPrice(resource.base_price)
    }
}

function getLineItemDescription(quantity, is_covered = false, is_glazed = true) {
    const cutoutStr = STATE.activeCutout ? `With "${STATE.activeCutout.name} Cutout"` : "Without Cutout";
    const coveredStr = is_covered ? "With Cover" : "Without Cover";
    const glazedStr = is_glazed ? "Glazed Finish" : "Unglazed Finish";

    return `${quantity} x "${STATE.activeSconce.name}" sconce, ${cutoutStr}, ${coveredStr}, ${glazedStr}`;
};

function resetSconceModal() {
    $("#sconce-modal [data-quantity]").val(1);
    $(".cutout-list-item.no-cutout").trigger('click');
    $("#cutout-selection-container button").trigger('click');
    if ($("#is_covered_input").is(":checked")) $("#is_covered_input").trigger('click');
    if ($("#is_glazed_input").is(":checked")) $("#is_glazed_input").trigger('click');
}

function setActiveSconce(item, editingCart = false) {
    $("#sconce-modal").addClass('showing');
    const sconce = editingCart ? item.item : item;
    const quantity = editingCart ? item.quantity : 1;

    if (sconce.sconce_id === STATE.activeSconce?.sconce_id && !editingCart) return;

    resetSconceModal();

    $("#sconce-img-container img").attr("src", sconce.image_url);
    $("#sconce-modal [data-name]").text(sconce.name);
    $("#sconce-modal [data-base_price]>span").text(sconce.base_price);
    $("#sconce-modal [data-sku]").text("#" + sconce.sconce_id);
    $("#sconce-modal [data-description]").text(sconce.description);
    $("#sconce-modal [data-dimensions]").text(sconce.dimensions);
    $("#sconce-modal [data-material]").text(sconce.material);
    $("#sconce-modal [data-color]").text(sconce.color);
    $("#sconce-modal [data-quantity]").val(quantity);
    $("#sconce-modal [data-total_price]>span").text(sconce.base_price);
    $("#sconce-modal [data-mounting_type]").text(sconce.mounting_type || "-");
    $("#sconce-modal [data-fitting_type]").text(sconce.fitting_type || "-");

    if (editingCart) {
        $("[data-cutout] span").text(sconce.cutout?.name || "No Cutout Selected");
        const cutoutId = sconce.cutout?.cutout_id;
        const cutoutEl = cutoutId ? $(`.cutout-list-item[data-id="${cutoutId}"]`) : $(".cutout-list-item.no-cutout");
        cutoutEl.trigger('click');
        $("[data-cutout] span").text(STATE.cutoutsLookup[cutoutId]?.name || "No Cutout Selected");
    }

    STATE.activeSconce = sconce;
}

function loadSconces(getAllSconces = false) {
    const data = getAllSconces ? {
        action: "get_all_sconces",
    } : {
        action: "get_more_sconces",
        page: STATE?.pagination?.current_page
    };

    $.ajax({
        type: "POST",
        url: "/api/sconces/api.php",
        data: JSON.stringify(data),
        contentType: "application/json",
        dataType: "json",
        success: res => {
            if (res.status === 200) {
                res.data.forEach(sconce => {
                    sconce = formatResource(sconce);
                    STATE.sconcesLookup[sconce.sconce_id] = sconce;
                    const sconceEl = $(`
                        <div data-id="${sconce.sconce_id}" class="sconce-panel">
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

                    sconceEl.on('click', () => setActiveSconce(sconce));

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
        error: function () {
            console.log(arguments);
        }
    });
}

async function loadCutouts() {
    if (!STATE.cutoutsLookup) {
        STATE.cutoutsLookup = {};
    }
    await $.ajax({
        type: "POST",
        url: "/api/cutouts/api.php",
        data: JSON.stringify({
            action: "get_all_cutouts",
        }),
        contentType: "application/json",
        dataType: "json",
        success: res => {
            if (res.status === 200) {
                res.data.forEach(cutout => {
                    cutout = formatResource(cutout);
                    STATE.cutoutsLookup[cutout.cutout_id] = cutout;
                    const cutoutEl = $(`
                        <div data-id="${cutout.cutout_id}" class="cutout-list-item">
                            <div class="cutout-list-item-img-container">
                                <img src="${cutout.image_url}" alt="">
                            </div>
                            <div class="cutout-list-item-info">
                                <span>${cutout.name}</span>
                                <div>
                                    <span>$${cutout.base_price}</span>
                                    <sub>(usd)</sub>
                                </div>
                            </div>
                        </div>
                    `);

                    $("#cutout-list").append(cutoutEl);
                });
                $(".cutout-list-item").on('click', function () {
                    const selectedCutoutImg = $(this).find(".cutout-list-item-img-container img").attr('src');
                    $(".cutout-list-item").removeClass('selected');
                    $(this).addClass('selected');
                    if ($(this).hasClass('no-cutout')) {
                        $("#cutout-preview-container img").hide();
                    } else {
                        $("#cutout-preview-container img").attr('src', selectedCutoutImg).show();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: res.message
                });
            }
        },
        error: function () {
            console.log(arguments);
        }
    });
}

function setActiveOAK(oAK) {
    $("#oak-modal").addClass('showing');

    if (oAK.one_of_a_kind_id === STATE.activeOAK?.one_of_a_kind_id) return;

    $("#oak-modal .img-container img").attr("src", oAK.image_url);
    $("#oak-modal [data-name]").text(oAK.name);
    $("#oak-modal [data-artist]").text(oAK.artist);
    $("#oak-modal [data-dimensions]").text(oAK.dimensions);
    $("#oak-modal [data-material]").text(oAK.material);
    $("#oak-modal [data-created_at]").text(new Date(oAK.created_at).getFullYear());
    $("#oak-modal [data-description]").text(oAK.description || "-");
    $("#oak-modal [data-price] span").text(formatPrice(oAK.price));
    $("#oak-modal [data-quantity]").val(oAK.quantity);

    STATE.activeOAK = oAK;
}

function loadOAKs(getAll = false) {
    const data = getAll ? {
        action: "get_all",
    } : {
        action: "get_more",
        page: STATE?.pagination?.current_page
    };

    $.ajax({
        type: "POST",
        url: "/api/one-of-a-kind/api.php",
        data: JSON.stringify(data),
        contentType: "application/json",
        dataType: "json",
        success: res => {
            if (res.status === 200) {
                STATE.oAKs = res.data.length ? res.data : [];
                res.data.forEach((oAK, idx) => {
                    oAK = formatResource(oAK);
                    STATE.oAKsLookup[oAK.one_of_a_kind_id] = oAK;
                    const oAKEl = $(`
                        <div data-idx="${idx}" data-id="${oAK.one_of_a_kind_id}" class="one-of-a-kind-panel">
                            <img src="${oAK.image_url}" alt="Oops">
                            <div class="oak-title">
                                <h4>${oAK.name}</h4>
                            </div>
                        </div>
                    `);

                    oAKEl.on('click', function () {
                        STATE.activeOAKIdx = idx;
                        setActiveOAK(oAK);
                    });

                    $(".gallery").append(oAKEl);
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
        error: function () {
            console.log(arguments);
        }
    });
}