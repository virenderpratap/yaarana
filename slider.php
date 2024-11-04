<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image sliderr</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
}

.sliderr {
    position: relative;
    max-width: 600px;
    margin: auto;
    overflow: hidden;
    height: 212px;
}

.slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.slide {
    min-width: 100%;
    transition: opacity 1s ease;
}

button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
}

.prev {
    left: -1px;
    top: -104px;
}

.next {
    top: -104px;
    right: -407px;
}

    </style>
</head>
<body>
    <div class="sliderr">
        <div class="slides">
            <img src="./images/ban.webp" class="slide active" alt="Image 1">
            <img src="./images/ban2.jpg" class="slide" alt="Image 2">
            <img src="./images/banner1.jpg" class="slide" alt="Image 3">
        </div>
        <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next" onclick="changeSlide(1)">&#10095;</button>
    </div>
    <script >
        let currentIndex = 0;
const slides = document.querySelectorAll('.slide');

function showSlide(index) {
    if (index >= slides.length) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = slides.length - 1;
    } else {
        currentIndex = index;
    }

    slides.forEach((slide, i) => {
        slide.style.display = (i === currentIndex) ? 'block' : 'none';
    });
}

function changeSlide(direction) {
    showSlide(currentIndex + direction);
}

function autoSlide() {
    showSlide(currentIndex + 1);
}

setInterval(autoSlide, 3000); // Change slide every 3 seconds
showSlide(currentIndex);

    </script>
</body>
</html>
