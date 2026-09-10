document.addEventListener("DOMContentLoaded", function () {
    const carouselOptions = {
        slidesPerView: 5,
        spaceBetween: 20,
        loop: true,
        centeredSlides: false,
        watchOverflow: true,
        navigation: {},
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 15
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            992: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            1200: {
                slidesPerView: 5,
                spaceBetween: 20
            },
        },
    };

    new Swiper(".category-swiper", {
        ...carouselOptions,
        navigation: {
            nextEl: ".category-next",
            prevEl: ".category-prev",
        },
    });

    new Swiper(".product-swiper", {
        ...carouselOptions,
        navigation: {
            nextEl: ".product-next",
            prevEl: ".product-prev",
        },
    });

    const swiper2 = new Swiper(".mySwiper2", {
        navigation: {
            nextEl: '.custom-swiper2-next',
            prevEl: '.custom-swiper2-prev',
        },
        loop: true,
        rewind: true,
        slidesPerView: 1,
        spaceBetween: 0,
        effect: 'slide',
        speed: 800,
        autoplay: {
            delay: 4500,
            disableOnInteraction: false,
        },
        on: {
            init: function () {
                console.log('Special slider initialized');
            }
        }
    });
});
