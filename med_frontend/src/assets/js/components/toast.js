const DEFAULT_OPTIONS = {
  autoClose: 4000,
  position: "body",
  type: "common",
  isCloseButton: false,
  side: null,
  class: null
}

export class Toast {
  #toastElem
  #autoCloseTimeout
  #removeBtn

  constructor(options) {
    this.checkAndRemoveExistingToast()
    this.#toastElem = document.createElement("div")
    this.#toastElem.classList.add("toast")
    requestAnimationFrame(() => {
      this.#toastElem.classList.add("show")
    })

    Object.entries({ ...DEFAULT_OPTIONS, ...options }).forEach(([key, value]) => {
      this[key] = value
    })
  }

  set autoClose(value) {
    if (value === false) return
    if (this.#autoCloseTimeout != null) clearTimeout(this.#autoCloseTimeout)

    this.#autoCloseTimeout = setTimeout(() => this.remove(), value)
  }

  set position(value) {
    const container = document.querySelector(value)
    container.append(this.#toastElem)
  }

  set type(value) {
    this.#toastElem.classList.add(value)
  }

  set class(value) {
    this.#toastElem.classList.add(value)
  }

  set side(value) {
    if (!value) return
    this.#toastElem.classList.add(value)
  }

  set text(value) {
    this.#toastElem.textContent = value

    if (this.isCloseButton) {
      this.addRemoveBtn()
    }
  }

  remove() {
    this.#toastElem.classList.remove("show")
    this.#toastElem.addEventListener("transitionend", () => {
      this.#toastElem.remove()
    })
  }

  checkAndRemoveExistingToast() {
    const existingToast = document.querySelector(".toast")

    if (existingToast) {
      existingToast.remove()
    }
  }

  addRemoveBtn() {
    this.#removeBtn = document.createElement("button")
    this.#removeBtn.classList.add("toast-remove-btn")
    this.#removeBtn.addEventListener("click", () => this.remove())
    this.#toastElem.append(this.#removeBtn)
  }
}
