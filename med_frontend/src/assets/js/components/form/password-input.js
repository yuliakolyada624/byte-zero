export class PasswordInput {
  constructor(input) {
    this.input = input
    this.wrap = input.closest('.password-input-wrap')
    this.showBtn = this.wrap.querySelector('.auth-form-field__password-input-button')
    this.#init()
  }

  handleBtnCick = (event) => {
    event.currentTarget.classList.toggle('active')
    const isPassword = this.input.type === 'password'
    this.input.type = isPassword ? 'text' : 'password'
  }

  #init() {
    this.showBtn.addEventListener('click', this.handleBtnCick)
  }
}