import { handleInput } from "./_handlers"

export function initInputs(inputs, context) {
  const keys = Object.keys(inputs)
  keys.forEach((key) => {
    context.inputs[key].input.addEventListener("input", (event) => handleInput(event, context))
  })
}
