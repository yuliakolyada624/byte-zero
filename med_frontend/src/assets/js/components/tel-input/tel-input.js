import { formInputData } from "./helpers"

export default class TelInput {
  constructor(inputs, shouldInit = true) {
    this.data = Array.from(inputs).map(formInputData)
    this.baseFlagSrc = "./svg/flags/"
    this.defaultPhoneIconSrc = "./svg/phone.svg"
    if (shouldInit) {
      this.#init()
    }
    this.isInputsValid = false
  }

  updatePhoneNumber = (data) => {
    data.fullPhone = data.codeValue + data.value
  }

  handleTriggerClick = (event, dropdown, dropdownTrigger) => {
    this.data.forEach(({ dropdown: dropdownList, dropdownTrigger: dropdownTriggerList }) => {
      if (dropdownList !== dropdown) {
        dropdownList.classList.remove("active")
      }
      if (dropdownTrigger !== dropdownTriggerList) {
        dropdownTriggerList.classList.remove("active")
      }
    })
    dropdown.classList.toggle("active")
    dropdownTrigger.classList.toggle("active")

    if (dropdown.classList.contains("active")) {
      window.addEventListener("click", (event) =>
        this.handleBackdropClick(event, dropdown, dropdownTrigger),
      )
    } else {
      window.removeEventListener("click", this.handleBackdropClick)
    }
  }

  handleBackdropClick = (event, dropdown, dropdownTrigger) => {
    if (
      event.target.closest(".tel-input-dropdown") ||
      event.target === dropdown ||
      event.target.closest(".code-section") ||
      event.target === dropdownTrigger
    ) {
      return
    } else {
      dropdown.classList.remove("active")
      dropdownTrigger.classList.remove("active")
    }
  }

  handleDropdownItemClick = (event, dropdown, dropdownTrigger, flag, code, data) => {
    const { nodeName } = event.target
    const isLiClicked = nodeName === "LI"
    const { country_code, dial_code } = isLiClicked
      ? event.target.dataset
      : event.target.closest("li").dataset
    dropdown.classList.remove("active")
    dropdownTrigger.classList.remove("active")
    dropdownTrigger.classList.add("filled")
    flag.src = `${this.baseFlagSrc}${country_code}.svg`
    code.innerText = dial_code
    data.codeValue = dial_code
    this.updatePhoneNumber(data)
    this.checkIsInputsValid()
  }

  handleInput = (event, data) => {
    const { value } = event.target
    if (!value.length || value === data.value) return
    const cursorPosition = event.target.selectionStart
    const digitValue = value.replace(/\D+/g, "")
    let maskedValue = ""

    if (digitValue.length <= 3) {
      maskedValue = digitValue
    } else if (digitValue <= 6) {
      maskedValue = `${digitValue.substring(0, 3)}-${digitValue.substring(3)}`
    } else {
      maskedValue = `${digitValue.substring(0, 3)}-${digitValue.substring(
        3,
        6,
      )}-${digitValue.substring(6)}`.slice(0, 12)
    }
    event.target.value = maskedValue
    data.value = event.target.value

    let nextCursorPos = cursorPosition
    if (maskedValue.length === 6) {
      console.log(maskedValue.length)
      nextCursorPos = cursorPosition + 1
      event.currentTarget.setSelectionRange(nextCursorPos, nextCursorPos)
    }

    this.updatePhoneNumber(data)
    this.checkIsInputsValid()
  }

  handleBackspace = (event) => {
    if (event.key === 'Backspace') {
      console.log(event.target);
      event.target.value = event.target.value.replace(/-/g, '')
    }
  }

  checkIsInputsValid = () => {
    this.isInputsValid = this.data.every(({ value, codeValue }) => {
      const isNotEmpty = value.length && codeValue.length
      return isNotEmpty
    })
  }

  #init() {
    this.data.forEach(
      ({ input, dropdownTrigger, dropdown, countriesList, dialCode, flag }, idx, data) => {
        dropdownTrigger.addEventListener("click", (event) =>
          this.handleTriggerClick(event, dropdown, dropdownTrigger),
        )
        countriesList.addEventListener("click", (event) =>
          this.handleDropdownItemClick(event, dropdown, dropdownTrigger, flag, dialCode, data[idx]),
        )
        input.addEventListener("input", (event) => this.handleInput(event, data[idx], dialCode))
        input.addEventListener("keydown", this.handleBackspace)
      },
    )
  }
}
