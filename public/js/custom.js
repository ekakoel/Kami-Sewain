document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.promotion-item');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;
    let isPaused = false;
    let interval;

    function showNextItem() {
        items[currentIndex].classList.remove('active');
        items[currentIndex].classList.add('display-none');
        currentIndex = (currentIndex + 1) % items.length; // Move to the next item, loop back to first
        items[currentIndex].classList.add('active');
        items[currentIndex].classList.remove('display-none');
    }

    function showPrevItem() {
        items[currentIndex].classList.remove('active');
        items[currentIndex].classList.add('display-none');
        currentIndex = (currentIndex - 1 + items.length) % items.length; // Move to the previous item, loop back to last
        items[currentIndex].classList.add('active');
        items[currentIndex].classList.remove('display-none');
    }

    function startAutoSlide() {
        interval = setInterval(showNextItem, 5000); // Auto slide every 5 seconds
    }

    function stopAutoSlide() {
        clearInterval(interval);
    }

    prevBtn.addEventListener('click', showPrevItem);
    nextBtn.addEventListener('click', showNextItem);

    document.querySelector('.promotion-container').addEventListener('mouseenter', function() {
        isPaused = true;
        stopAutoSlide();
    });

    document.querySelector('.promotion-container').addEventListener('mouseleave', function() {
        isPaused = false;
        startAutoSlide();
    });

    startAutoSlide();
});

let position = 0;
const cardsToShow = 3;
const cardWidth = document.querySelector('.image-title-card').offsetWidth;
const container = document.querySelector('.carousel-wrapper');
const totalCards = document.querySelectorAll('.image-title-card').length;

function moveCarousel(direction) {
    const maxPosition = -(totalCards - cardsToShow) * cardWidth;
    position += direction * cardWidth;
    position = Math.max(position, maxPosition); // Prevent moving beyond the last card
    position = Math.min(position, 0); // Prevent moving beyond the first card
    container.style.transform = `translateX(${position}px)`;
}

window.onload = function() {
    history.replaceState(null, null, window.location.href);
    window.onpopstate = function(event) {
        history.replaceState(null, null, window.location.href);
        location.reload();
    };
};

// date picker
$('.date-picker').datepicker({
    language: 'en',
    autoClose: true,
    dateFormat: 'mm/dd/yyyy',
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});


