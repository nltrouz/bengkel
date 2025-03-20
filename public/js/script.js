tailwind.config = {
    theme: {
        extend: {
            keyframes: {
                slideDown: {
                    '0%': {
                        transform: 'translateY(-20px)',
                        opacity: '0'
                    },
                    '100%': {
                        transform: 'translateY(0)',
                        opacity: '1'
                    }
                },
                fadeIn: {
                    '0%': {
                        opacity: '0'
                    },
                    '100%': {
                        opacity: '1'
                    }
                }
            },
            animation: {
                'slide-down': 'slideDown 0.5s ease-out',
                'fade-in': 'fadeIn 1s ease-in'
            }
        }   
    }
}

document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.swiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});