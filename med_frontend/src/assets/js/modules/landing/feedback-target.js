export class FeedbackTarget {
  constructor(trigger) {
    this.trigger = trigger
    this.target = document.querySelector(`.${this.trigger.dataset.target}`)
    this.#init()
  }

  handleTriggerClick = () => {
    this.target.checked = true
  }

  #init() {
    this.trigger.addEventListener("click", this.handleTriggerClick)
  }
}
