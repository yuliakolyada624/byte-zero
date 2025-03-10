import { handlePopupButtonClick } from "./_handlers"

export function initInjuriesPopups(popups, context) {
  popups.forEach(popup => {
    const popupBtn = popup.querySelector('.js-injury-popup-button')
    popupBtn.addEventListener('click', (event) => handlePopupButtonClick(event, context))
    window.addEventListener('click', (event) => {
      const isPopupActive = popup.classList.contains('active')
      const isClickOnPopup = event.target.closest('.js-injury-popup-wrap')  === popup
      const isClickedOnBodyArea = event.target.closest('.js-human-body-svg')
      if(isPopupActive && !isClickOnPopup && !isClickedOnBodyArea) {
        popup.classList.remove("active");
        document.querySelectorAll('.js-body-area').forEach(group => group.classList.remove('clicked'))
      }
      if(isClickedOnBodyArea) {
        const {bodyPart} = event.target.closest('g').dataset
        const currentClicked = document.querySelector(`.js-injury-popup-wrap[data-popup-id='${bodyPart}']`)
        popups.forEach(popup => {
          popup.classList[currentClicked === popup ? 'add' : 'remove']('active')
        })
        document.querySelectorAll('.js-body-area').forEach(group => {
          const isCurrent = group.classList.contains(bodyPart)
          group.classList[isCurrent ? 'add' : 'remove']('clicked')
        })
      }
    })
  })
}