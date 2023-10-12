
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

Fancybox.bind('[data-fancybox]', {
    compact: false,
    contentClick: "iterateZoom",
    Images: {
      Panzoom: {
        maxScale: 2,
      },
    },
    Toolbar: {
      display: {
        left: [
          "infobar",
        ],
        middle : [],
        right: [
          "iterateZoom",
          "close",
        ],
      }
    }
  });  


  const swiper = new Swiper('.swiper.swiper-reviews', {
    loop: true,
    speed: 8000,
      
    autoplay: {
        delay: 0,
        pauseOnMouseEnter: true,        // stop autoplay when hovering
        disableOnInteraction: false,    // restart autoplay when hover is removed
        
    },
    breakpoints: {
        300: {
            slidesPerView: 1.5,
            spaceBetween: 8
            
        },
        480: {
            slidesPerView: 2.5,
            spaceBetween: 8
        },
        800: {
            slidesPerView: 3.5,
            spaceBetween: 8
        },
        1100: {
            slidesPerView: 5,
            spaceBetween: 16
        },

        
    }
})


const thanksModal = document.querySelector('#thanksModal');
const myModal = new bootstrap.Modal(thanksModal);



const feedbackForm = document.querySelector('form[data-form="feedback-form"]');

if ( feedbackForm ) {
    feedbackForm.onsubmit = function(event){
        event.preventDefault();
        let name = this.name;
        let phone = this.phone;
        let email = this.email;


        let data_body = "name=" + name.value + '&phone=' +  phone.value + '&email=' +  email.value; 
        console.log(data_body)
        fetch("script-name.php", {
            method: "POST",
            body: data_body,
            headers:{"content-type": "application/x-www-form-urlencoded"} 
        })
        .then( (response) => {
            if (response.status !== 200) {
                return Promise.reject();
            }
            if (thanksModal){
                myModal.show();
            }
            name.value = "";
            phone.value = "";
            email.value = "";
            return response.text()
        })
        .then(i => console.log(i))
        .catch(() => {
            //для тестирования
            if (thanksModal){
                myModal.show();
            }
            name.value = "";
            phone.value = "";
            email.value = "";
            console.log('ошибка')
        });
    }
    
}



