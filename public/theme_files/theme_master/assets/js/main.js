$('.main-title').on('click' , function(){
    // $('.main-title ul').removeClass('show');
    $(this).children('ul').toggleClass('show');
    $(this).children('a').children('svg').toggleClass('rotate-icon');
})
$('#mega-menu-full-cta-dropdown-button2-2').on('click' , function(){
    $(this).children('svg').toggleClass('rotate-icon');
})

// New products
var owlNew = $('.newProduct').owlCarousel({
    loop:true,
    nav:false,
    dots:true,
    rtl:true,
    responsive:{
        0:{
            items:2
        },
        768:{
            items:4,
        },
        1000:{
            items:5
        }
    }
});

// Best products
$('.bestProduct').owlCarousel({
    loop:true,
    nav: false,
    dots: false,
    rtl:true,
    responsive:{
        0:{
            items:2
        },
        768:{
            items:4,
        },
        1000:{
            items:5
        }
    }
})

// Suggested
var suggested = $('.suggestedProduct').owlCarousel({
    items:4,
    loop:false,
    rtl:true,
    dots:true,
    nav:false,
    touchDrag: true,
    responsive:{
        0:{
            items:2
        },
        768:{
            items:4,
        },
        1000:{
            items:5
        }
    }
})

// Accessory
var accessory = $('.accessory').owlCarousel({
    items:4,
    loop:false,
    rtl:true,
    dots:true,
    nav:false,
    touchDrag: true,
    responsive:{
        0:{
            items:2
        },
        768:{
            items:4,
        },
        1000:{
            items:5
        }
    }
})

var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
// if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
//     themeToggleLightIcon.classList.remove('hidden');
// } else {
//     themeToggleDarkIcon.classList.remove('hidden');
// }

var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {


    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }

});

////////////////// MOBILE LIGHT & DARK  //////////////////

var themeToggleBtn2 = document.getElementById('theme-toggle2');

themeToggleBtn2.addEventListener('click', function() {


    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }

});


// Archive Page
$('.filter-lists > .filter').each(function(){
    $(this).on('click' , function(){
        // console.log(this);
        var brand = $('ul', $(this).parent());
        var arrow = $('svg', $(this).parent());
        // console.log( arrow)
        brand.toggle('slow');
        arrow.toggleClass('-rotate-90');
    })
})

$('#filter-btn').on('click', function(){
    $('#filters').toggle('slow');
    $(this).next('svg').toggleClass('-rotate-90');
})
