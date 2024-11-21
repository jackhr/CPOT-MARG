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
});

const getCart = () => JSON.parse(localStorage.getItem('cart')) ?? [];

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

function getLineItemDescription(quantity) {
    let desc = `"${STATE.activeSconce.name}" light`;

    if (STATE.activeCutout) {
        desc += ` with "${STATE.activeCutout.name}"`;
    } else {
        desc += ` without a`;
    }
    desc += ` cutout x ${quantity}`;

    return desc;
};

function resetSconceModal() {
    $("#sconce-modal [data-quantity]").val(1);
    $(".cutout-list-item.no-cutout").trigger('click');
    $("#cutout-selection-container button").trigger('click');
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
    $("#sconce-modal [data-finish]").text(sconce.finish || "-");
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
        page: STATE?.pagination?.page
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