export class FAQAccordion {
  constructor(wrap) {

    this.accordionBtns = wrap.querySelectorAll('.js-faq-section-accordion-item')

    this.#init()
  }

  handleBtnClick = (event) => {
    event.currentTarget.classList.toggle('active')
  }

  #init() {
    this.accordionBtns.forEach(btn => btn.addEventListener('click', this.handleBtnClick))
  }
}