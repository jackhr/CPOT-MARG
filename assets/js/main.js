$(document).ready(function () {

    $(".carousel").flickity({
        fade: true,
        wrapAround: true,
        draggable: false,
        autoPlay: 5000,
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

    $("#hamburger-btn").on('click', function () {
        openHamburgerMenu();
    });

    $(".close-nav").on('click', function () {
        closeHamburgerMenu();
    });

    $('#hamburger-nav li a[href="/portfolios"]').on('click', function (e) {
        e.preventDefault();
        openPortfolioNav();
    });

    $("#back-nav").on('click', function () {
        closePortfolioNav();
    });

    $(document).off('click').on("click", function (event) {
        if (
            $("#hamburger-nav").hasClass("showing-nav") && // Check if the nav is open
            $("#hamburger-nav").is(event.target) // Check if event target is the nav itself
        ) {
            closeHamburgerMenu();
        }
    });

});

function openPortfolioNav() {
    $("#hamburger-nav").addClass('showing-portfolio-nav');
}

function closePortfolioNav() {
    $("#hamburger-nav").removeClass('showing-portfolio-nav');
}

function openHamburgerMenu() {
    $("#hamburger-nav").addClass('showing-fade');
    setTimeout(() => {
        $("#hamburger-nav").addClass('showing-nav');
    }, 300);
}

function closeHamburgerMenu() {
    $("#hamburger-nav").removeClass('showing-nav');
    setTimeout(() => {
        $("#hamburger-nav").removeClass('showing-fade');
    }, 300);
}

function reCalculateCartCount() {
    $(".cart-count").html(getCart().length || "");
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
    const res = structuredClone(resource);

    if (res.price) res.price = formatPrice(resource.price);
    if (res.base_price) res.base_price = formatPrice(resource.base_price);

    return res;
}

function arraysAreEqual(arr1, arr2) {
    if (arr1.length !== arr2.length) {
        return false; // Arrays have different lengths, so not equal
    }
    return arr1.every((value, index) => value === arr2[index]);
}

function getLineItemDescription(quantity) {
    const addOnsInfo = getSelectedAddOnsInfo();
    const cutoutStr = STATE.activeCutout ? `With "${STATE.activeCutout.name} Cutout"` : "Without Cutout";
    let initialDesc = `${quantity} x "${STATE.activeSconce.name}" sconce, ${cutoutStr}`;

    return Object.values(addOnsInfo).reduce((lineItemDesc, addOn) => {
        const addOnStr = (addOn.checked ? `With ` : `Without `) + addOn.name;
        return `${lineItemDesc}, ${addOnStr}`;
    }, initialDesc);
};

function getSelectedAddOnsInfo() {
    return $(".sconce-add-on").toArray().reduce((lookup, input) => {
        const id = $(input).val();
        lookup[id] = {
            checked: $(input).is(":checked"),
            ...STATE.addOnsLookup[id]
        }
        return lookup;
    }, {});
}

function resetSconceModal(sconce = STATE.activeSconce) {
    const sconceHasCutouts = sconce.cutout_ids.length;
    if (sconceHasCutouts) {
        $("[data-cutout]").prop('disabled', false);
        $(".cutout-list-item.no-cutout").trigger('click');
        $("#cutout-selection-container button").trigger('click');
    } else {
        // no cutouts
        $("[data-cutout]")
            .prop('disabled', true)
            .find("span")
            .text("No Cutouts Available For This Sconce");
    }
    $("#sconce-modal [data-quantity]").val(1);
    $(".sconce-add-on").each((_, el) => $(el).is(":checked") && $(el).trigger('click'));
}

function setActiveItem(item) {
    const modal = $("#item-modal");

    modal.addClass('showing');
    modal.find(".img-container img").attr("src", item.image_url);
    modal.find("[data-name]").text(item.name);
    modal.find("[data-artist]").text(item.artist);
    modal.find("[data-base_price]>span").text(item.price);
    modal.find("[data-sku]").text("#" + item.shop_item_id);
    modal.find("[data-description]").text(item.description || "This item has no description.");
    modal.find("[data-dimensions]").text(`${item.dimensions} (D/W/H)`);
    modal.find("[data-material]").text(item.material);
    modal.find("[data-color]").text(item.color);
    modal.find("[data-total_price]>span").text(item.price);

    STATE.activeItem = item;

    $("#make-enquiry-btn").toggle(STATE.activeItem.status == "available");
}

function setActiveSconce(item, editingCart = false) {
    $("#sconce-modal").addClass('showing');
    const sconce = editingCart ? item.item : item;
    const quantity = editingCart ? item.quantity : 1;

    if (sconce.sconce_id === STATE.activeSconce?.sconce_id && !editingCart) return;

    resetSconceModal(sconce);

    $("#sconce-modal .img-container img").attr("src", sconce.image_url);
    $("#sconce-modal [data-name]").text(sconce.name);
    $("#sconce-modal [data-base_price]>span").text(sconce.base_price);
    $("#sconce-modal [data-sku]").text("#" + sconce.sconce_id);
    $("#sconce-modal [data-description]").text(sconce.description || "This item has no description.");
    $("#sconce-modal [data-dimensions]").text(`${sconce.dimensions} (D/W/H)`);
    $("#sconce-modal [data-material]").text(sconce.material);
    $("#sconce-modal [data-color]").text(sconce.color);
    $("#sconce-modal [data-quantity]").val(quantity);
    $("#sconce-modal [data-total_price]>span").text(sconce.base_price);
    $("#sconce-modal [data-mounting_type]").text(sconce.mounting_type || "-");
    $("#sconce-modal [data-fitting_type]").text(sconce.fitting_type || "-");

    if (editingCart) {
        if (sconce.cutout_ids.length) {
            const cutoutId = sconce.cutout?.cutout_id;
            const cutoutEl = cutoutId ? $(`.cutout-list-item[data-id="${cutoutId}"]`) : $(".cutout-list-item.no-cutout");
            cutoutEl.trigger('click');
            $("[data-cutout]").prop('disabled', false);
            const displayStr = STATE.cutoutsLookup[cutoutId]?.name ? "Cutout Selected: " + STATE.cutoutsLookup[cutoutId]?.name : "No Cutout Selected";
            $("[data-cutout] span").text(displayStr);
        } else {
            $("[data-cutout]")
                .prop('disabled', true)
                .find("span")
                .text("No Cutouts Available For This Sconce");
        }
        $(".sconce-add-on").each((_idx, elem) => {
            if ($(elem).is(":checked")) $(elem).click()
        });
        item.item.addOnIds.forEach(id => $(`.sconce-add-on[value="${id}"]`).click());
    }

    STATE.activeSconce = sconce;
}

function generateOrderItemPrice(item) {
    const itemPrice = Number(item?.item?.base_price || 0);
    const cutoutPrice = Number(item?.item?.cutout?.base_price) || 0;
    const quantity = Number(item.quantity);
    const basePrice = Object.values(item.item.addOnIds || []).reduce((price, id) => {
        const addOn = STATE.addOnsLookup[id];
        if (addOn.is_percentage) {
            price += ((addOn.price / 100) * itemPrice);
        } else {
            price += Number(addOn.price);
        }
        return price;
    }, itemPrice + cutoutPrice);

    return basePrice * quantity;
}

async function loadAddOns() {
    await $.ajax({
        type: "POST",
        url: "/api/add-ons/api.php",
        data: JSON.stringify({
            action: "get_all_add_ons",
        }),
        contentType: "application/json",
        dataType: "json",
        success: res => {
            if (res.status === 200) {
                $(".info-section.sconce-add-ons").html("<h5>Add Ons</h5>");
                STATE.addOnsLookup = {};
                res.data.forEach(addOn => {
                    addOn = formatResource(addOn);
                    STATE.addOnsLookup[addOn.add_on_id] = addOn;

                    if ($(".info-section.sconce-add-ons").length) {
                        const addOnIdHTML = `${addOn.name.replaceAll(" ", "_").toLowerCase()}_add_on`;
                        console.log("addOn", addOn);
                        const bracketsDisplay = addOn.is_percentage ? `+${addOn.price}% of original sconce price` : `$${addOn.price}`;
                        $(".info-section.sconce-add-ons").append(`
                            <div class="input-container">
                                <input id="${addOnIdHTML}" class="sconce-add-on" type="checkbox" value="${addOn.add_on_id}">
                                <label for="${addOnIdHTML}"><span>${addOn.name}: </span>${addOn.description} (${bracketsDisplay})</label>
                            </div>
                        `);
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
                            <img src="${sconce.image_url}" alt="Sconce">
                            <div>
                                <h4>${sconce.name}</h4>
                                <span>${sconce.dimensions} (D/W/H)</span>
                                <div>
                                    <span>$${sconce.base_price}<sub>(usd)</sub></span>
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

function loadShopItems(getAllItems = false) {
    const data = getAllItems ? {
        action: "get_all",
    } : {
        action: "get_more",
        page: STATE?.pagination?.current_page
    };

    $.ajax({
        type: "POST",
        url: "/api/shop-items/api.php",
        data: JSON.stringify(data),
        contentType: "application/json",
        dataType: "json",
        success: res => {
            if (res.status === 200) {
                res.data.forEach(item => {
                    item = formatResource(item);
                    STATE.shopItemsLookup[item.shop_item_id] = item;
                    const itemEl = $(`
                        <div data-id="${item.shop_item_id}" class="item-panel">
                            <img src="${item.image_url}" alt="Shop Item">
                            <div>
                                <h4>${item.name}</h4>
                                <span data-name="artist">${item.artist}</span>
                                <span>${item.dimensions} (D/W/H)</span>
                                <div>
                                    ${item.status === "available" ? "" : `<span class="shop-item-status ${item.status}">${item.status}</span>`}
                                    <span>$${item.price}<span>(usd)</span></span>
                                    <span>View More...</span>
                                </div>
                            </div>
                        </div>
                    `);

                    itemEl.on('click', () => setActiveItem(item));

                    $(".gallery").append(itemEl);
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

                    $(".cutout-list").append(cutoutEl);
                });
                $(".cutout-list-item").on('click', function () {
                    const selectedCutoutImg = $(this).find(".cutout-list-item-img-container img").attr('src');
                    const viewingCutout = !$(this).hasClass('no-cutout');
                    $(".cutout-list-item").removeClass('selected');
                    $(this).addClass('selected');
                    $(".cutout-preview-container").toggleClass("viewing-cutout", viewingCutout);
                    if (viewingCutout) $(".cutout-preview-container img").attr('src', selectedCutoutImg);
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

function setActivePortfolioItem(portfolioItem) {
    $("#portfolio-item-modal").addClass('showing');

    if (portfolioItem.portfolio_item_id === STATE.activePortfolioItem?.portfolio_item_id) return;

    $("#portfolio-item-modal .img-container img").attr("src", portfolioItem.image_url);
    $("#portfolio-item-modal [data-name]").text(portfolioItem.name);
    $("#portfolio-item-modal [data-artist]").text(portfolioItem.artist);
    $("#portfolio-item-modal [data-dimensions]").text(portfolioItem.dimensions);
    $("#portfolio-item-modal [data-material]").text(portfolioItem.material);
    $("#portfolio-item-modal [data-created_at]").text(portfolioItem.year_created || "-");
    $("#portfolio-item-modal [data-description]").text(portfolioItem.description || "This item has no description.");
    $("#portfolio-item-modal [data-price] span").text(formatPrice(portfolioItem.price));
    $("#portfolio-item-modal [data-quantity]").val(portfolioItem.quantity);

    STATE.activePortfolioItem = portfolioItem;
}

async function loadPortfolioItems(options = {
    getAll: true
}) {
    const { getAll, artist } = options;

    const data = {
        action: !!getAll ? "get_all" : "get_more",
        page: !!getAll ? undefined : STATE?.pagination?.current_page,
        artist: !!artist ? artist : undefined
    };

    await $.ajax({
        type: "POST",
        url: "/api/portfolios/api.php",
        data: JSON.stringify(data),
        contentType: "application/json",
        dataType: "json",
        success: res => {
            if (res.status === 200) {
                if (!STATE.portfolioItems) STATE.portfolioItems = [];
                if (res.data.length) {
                    console.log("structuredClone:", structuredClone);
                    STATE.portfolioItems = [...structuredClone(STATE.portfolioItems), ...structuredClone(res.data)];

                    res.data.forEach((portfolioItem, idx) => {
                        portfolioItem = formatResource(portfolioItem);
                        STATE.portfolioItemsLookup[portfolioItem.portfolio_item_id] = portfolioItem;
                        const portfolioItemEl = $(`
                            <div data-idx="${idx}" data-id="${portfolioItem.portfolio_item_id}" class="portfolio-item-panel">
                                <img src="${portfolioItem.image_url}" alt="Portfolio Item">
                                <div class="portfolio-item-title">
                                    <h4>${portfolioItem.name}</h4>
                                    <h4>${portfolioItem.artist}</h4>
                                </div>
                            </div>
                        `);

                        $(".gallery").append(portfolioItemEl);
                    });
                }

                $(".portfolio-item-panel").each((idx, portfolioItemEl) => {
                    portfolioItemEl = $(portfolioItemEl);
                    const portfolioItemId = portfolioItemEl.data('id');
                    const portfolioItem = STATE.portfolioItemsLookup[portfolioItemId];

                    portfolioItemEl
                        .off('click')
                        .on('click', function () {
                            STATE.activePortfolioItemIdx = idx;
                            setActivePortfolioItem(portfolioItem);
                        });
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