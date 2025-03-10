import { handleSelectedInjuiesCheck } from "./_handlers"

export function initSelectedCheckboxes(wrap, context) {
  wrap.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
    checkbox.addEventListener("change", (event) => handleSelectedInjuiesCheck(event, wrap, context))
  })
}
