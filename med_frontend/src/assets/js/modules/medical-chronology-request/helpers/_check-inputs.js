export function checkInputs(context) {
  const requiredInputs = [
    ...context.section.querySelectorAll(
      '.js-medical-chronology-request__input',
    ),
  ]
  const isFilled = requiredInputs.every((input) => {
    return Boolean(input.value.length)
  })
  return isFilled
}

export function checkDropdownInputs(context) {
  const keysWithInput = [...Object.keys(context.dropdowns)].filter(
    (key) => context.dropdowns[key].input,
  )
  context.isDropdownsSelected = keysWithInput.every((key) => context.dropdowns[key].input.value)
}

export function checkIsBodyInjuriesSelected(context) {
  const bodyInjuriesValue = "bodily_injury"
  const claimTypeDropdownInput = document.querySelector("#medical_chronology_request_claim_type")
  if (claimTypeDropdownInput.value === bodyInjuriesValue) {
  }
}
