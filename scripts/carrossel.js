window.addEventListener('load', renderCarrossel);
window.addEventListener('resize', renderCarrossel);

function renderCarrossel() {
  // Código para versão desktop - telas > 768px
  if (window.innerWidth > 768) {
    const mainWrapper = document.querySelector('.carrossel-videos');
    const slider = document.querySelector('.carrossel-videos .wrapper-itens');
    const sliderItems = document.querySelectorAll(
      '.carrossel-videos .item-carrossel',
    );
    const buttonUp = document.querySelector('.slider-button-up');
    const buttonDown = document.querySelector('.slider-button-down');

    mainWrapper.style.height = `${
      sliderItems[0].offsetHeight + sliderItems[1].offsetHeight + 24
    }px`;
    let slideIndex = 0;
    const slideLength = sliderItems.length;
    const slideHeight = sliderItems[0].offsetHeight;

    buttonUp.addEventListener('click', () => {
      console.log(slideIndex);
      if (slideIndex > 0) {
        buttonDown.disabled = false;
        buttonUp.disabled = false;
        slideIndex--;
        slider.style.transform = `translateY(${slideIndex * -slideHeight}px)`;
        if (slideIndex <= 1) {
          buttonUp.disabled = true;
        }
      } else {
        buttonUp.disabled = true;
      }
    });

    buttonDown.addEventListener('click', () => {
      if (slideIndex < slideLength - 2) {
        buttonDown.disabled = false;
        buttonUp.disabled = false;
        slideIndex++;
        slider.style.transform = `translateY(${
          slideIndex * -slideHeight - 24
        }px)`;
      } else {
        buttonDown.disabled = true;
      }
    });
  }
}
