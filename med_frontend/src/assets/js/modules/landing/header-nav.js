export class HeaderNavigation {
  constructor(trigger) {
    this.trigger = trigger
    this.header = trigger.closest('.landing-header')
    this.menu = this.header.querySelector('.js-header-overlap-menu')
    this.closeTrigger = this.header.querySelector('.js-header-overlap-menu-close-trigger')

    this.#init()
  }

  handleTriggerClick = () => {
    this.menu.classList.add('active')
    document.body.classList.add('_lock')
  }
  handleCloseClick = () => {
    this.menu.classList.remove('active')
    document.body.classList.remove('_lock')
  }

  #init() {
    this.trigger.addEventListener('click', this.handleTriggerClick)
    this.closeTrigger.addEventListener('click', this.handleCloseClick)
  }
}
