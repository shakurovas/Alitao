
const hamburger = document.querySelector('.hamburger');
const mobileMenu = document.querySelector('.mobile-menu');
const closeMobileMenu = document.querySelector('.mobile-menu__close');
const mobileLinks = document.querySelectorAll('.mobile-menu__body a');


mobileLinks.forEach( ml => {
    ml.addEventListener('click', function(){
        mobileMenu.classList.remove('active');
    })
} )

hamburger.addEventListener('click', function(){
    mobileMenu.classList.add('active');
})

closeMobileMenu.addEventListener('click', function(){
    mobileMenu.classList.remove('active');
})




let marketsSlider = new Swiper(".markets-slider", {
    speed: 1000,
    autoplay: {
        delay: 6000,
    },
    slidesPerView: 1,
    spaceBetween: 48,
    loop: true,
    
    breakpoints: {
        360: {
            slidesPerView: 2,
            
        },
        600: {
            slidesPerView: 3,
            
        },
        800: {
            slidesPerView: 4,
            
        },
        1000: {
            slidesPerView: 5,
            
        },

        1200: {
            slidesPerView: 6,
            spaceBetween: 54
        }
    }
})

let servicesSlider = new Swiper(".services-slider", {
    speed: 1000,
    autoplay: {
        delay: 8000,
    },
    slidesPerView: 1,
    spaceBetween: 48,
    
    pagination: {
        el: '.pagination',
        clickable: true,
    },
    
    breakpoints: {
        

        576: {
            slidesPerView: 2,
            spaceBetween: 48
        },

        800: {
            slidesPerView: 3,
            spaceBetween: 48
        }
    }
})


const helpSection = document.querySelector('#help');
if ( helpSection ){
    let screenWidth = document.documentElement.clientWidth;

    if ( screenWidth < 1000){
        let swiperInnerWrapper = helpSection.querySelector('.help-swiper-wrapper');
        swiperInnerWrapper.classList.add('swiper-wrapper');

        let slider = new Swiper(".help-slider", {
            speed: 1000,
            autoplay: {
                delay: 8000,
            },
            slidesPerView: 1,
            spaceBetween: 24,
            
            pagination: {
                el: '.pagination',
                clickable: true,
            },
            
            breakpoints: {
                
        
                576: {
                    slidesPerView: 2,
                    
                },
        
                1000: {
                    slidesPerView: 3,
                    
                }
            }
        })
        
    }
}



