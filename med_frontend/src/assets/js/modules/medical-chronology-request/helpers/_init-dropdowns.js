import { handleTriggerClick, handleListClick, handleAddIjnuries } from "./_handlers"
import { initSelectedCheckboxes } from "./_init-checkboxes"

export function initDropdowns(dropdowns, context) {
  const keys = Object.keys(dropdowns)
  keys.forEach((key) => initDropdown(dropdowns[key], context))
}

function initDropdown(dropdown, context) {
  const { wrap, input, trigger, listWrap, list, isValid } = dropdown
  const { type } = list.dataset
  trigger.addEventListener("click", (event) => handleTriggerClick(event, dropdown, context))
  if (type === "button") {
    list.addEventListener("click", (event) => handleListClick(event, dropdown, context))
  }
  if (type === "check") {
    initCheckboxesDropdown(list, listWrap, trigger, context)
  }

  window.addEventListener("click", (event) => {
    const isWrapClosest = event.target.closest(".js-medical-chronology-request__dropdown")
    if (!isWrapClosest || isWrapClosest !== wrap) {
      listWrap.classList.remove("active")
      trigger.classList.remove("active")
    }
  })
}

function initCheckboxesDropdown(list, listWrap, trigger, context) {
  const addBtn = list.querySelector(".js-injury-add-btn")
  addBtn.addEventListener("click", (event) => handleAddIjnuries(event, context, listWrap, trigger))
  const selectedListWrap = document.querySelector(
    ".js-medical-chronology-request-selected-injuries-list-wrap",
  )
  initSelectedCheckboxes(selectedListWrap, context)
}
