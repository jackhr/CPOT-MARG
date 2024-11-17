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
