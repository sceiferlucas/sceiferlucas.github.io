let currentIndex = 0;
        const images = document.querySelectorAll('.main img');
        const totalImages = images.length;

        setInterval(() => {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % totalImages;
            images[currentIndex].classList.add('active');
        }, 5000);