import { forms } from "../../../../data/forms"

function inputNumber() {
    const numberInputs = document.querySelectorAll(".js-input-number")
    if (!numberInputs.length) return

    numberInputs.forEach((input) => {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "")
        })
    })
}


function cardInputMask() {
    const cardInputs = document.querySelectorAll(".js-card-input")
    cardInputs.forEach((input) => {
        const form = input.closest("form")
        let numberPattern = /^\d{0,16}$/g
        let numberSeparator = "    "
        let numberInputOldValue
        let numberInputOldCursor

        const mask = (value, limit, separator) => {
            var output = []
            for (let i = 0; i < value.length; i++) {
                if (i !== 0 && i % limit === 0) {
                    output.push(separator)
                }

                output.push(value[i])
            }

            return output.join("")
        }
        const unmask = (value) => value.replace(/[^\d]/g, "")
        const checkSeparator = (position, interval) => Math.floor(position / (interval + 1))
        const numberInputKeyDownHandler = (e) => {
            let el = e.target
            numberInputOldValue = el.value
            numberInputOldCursor = el.selectionEnd
        }
        const showActiveCard = (value) => {
            let cardType = ""
            let cardTypePatterns = {
                visa: /^4/,
                mastercard: /^5/,
                amex: /^3[47]/,

                undefined: /(^1|^2|^7|^8|^9|^0)/,
            }

            for (const cardTypePattern in cardTypePatterns) {
                if (cardTypePatterns[cardTypePattern].test(value)) {
                    cardType = cardTypePattern
                    break
                }
            }

            const cardTypeInput = form.querySelector(".js-card-type-input")
            if (cardTypeInput) cardTypeInput.value = cardType || "undefined"
            let activeCardType = form.querySelector(".input-card-type__item.active")
            let newActiveCardType = form.querySelector(`.input-card-type__item--${cardType}`)

            if (activeCardType) activeCardType.classList.remove("active")
            if (newActiveCardType) newActiveCardType.classList.add("active")
        }
        const numberInputInputHandler = (e) => {
            let el = e.target
            let newValue = unmask(el.value)
            let newCursorPosition

            if (newValue.match(numberPattern)) {
                newValue = mask(newValue, 4, numberSeparator)

                newCursorPosition =
                    numberInputOldCursor -
                    checkSeparator(numberInputOldCursor, 4) +
                    checkSeparator(numberInputOldCursor + (newValue.length - numberInputOldValue.length), 4) +
                    (unmask(newValue).length - unmask(numberInputOldValue).length) +
                    (numberSeparator.length - 1)

                el.value = newValue !== "" ? newValue : ""
            } else {
                el.value = numberInputOldValue
                newCursorPosition = numberInputOldCursor
            }

            el.setSelectionRange(newCursorPosition, newCursorPosition)

            showActiveCard(el.value)
        }

        input.addEventListener("keydown", numberInputKeyDownHandler)
        input.addEventListener("input", numberInputInputHandler)
    })
}

export { cardInputMask, inputNumber }
