import { resetSelectedCheckboxes } from "./_cleaners"
import { checkSelectedCheckboxes, setBodyAreas } from "./_helpers"
import { checkInputs, checkDropdownInputs, checkIsBodyInjuriesSelected } from "./_check-inputs"

export function handleTriggerClick(event, dropdown, context) {
  const { wrap, input, trigger, listWrap, list, isValid } = dropdown
  const { currentTarget } = event
  const keys = Object.keys(context.dropdowns)
  currentTarget.classList.toggle("active")
  listWrap.classList.toggle("active")
}

export function handleListClick(event, dropdown, context) {
  const { wrap, input, trigger, triggerValueContainer, listWrap, list, isValid, activeItem } =
    dropdown
  const { target, currentTarget } = event
  activeItem && activeItem.classList.remove("active")
  dropdown.activeItem = target
  target.classList.add("active")
  listWrap.classList.remove("active")
  trigger.classList.remove("active")
  triggerValueContainer.innerText = target.dataset.value
  input.value = target.dataset.itemId
  checkDropdownInputs(context)

  if (target.dataset.gender) {
    context.bodyAreas.classList.remove("male", "female")
    context.bodyAreas.classList.add(target.dataset.gender)
  }
  if (listWrap.classList.contains("claim-list-wrap") && target.dataset.target) {
    context.bodyAreas.classList.add("active")
    const { targetId } = target.dataset
    context.dropdowns[targetId].hiddenDropdown.classList.add("active")
    context.isBodyAreas = true
  }
  if (listWrap.classList.contains("claim-list-wrap") && !target.dataset.target) {
    context.bodyAreas.classList.remove("active")
    const { targetId } = target.dataset
    context.dropdowns[targetId].hiddenDropdown.classList.remove("active")
    context.dropdowns[targetId].list.querySelectorAll('input[type="checkbox"]').forEach((check) => {
      const { target: selectedCheckId, iconClass } = check.dataset
      const selectedCheck = context.selectedInjuriesList.querySelector(`#${selectedCheckId}`)
      const event = new Event("change")
      check.dispatchEvent(event)
      selectedCheck.dispatchEvent(event)
      check.checked = false
      selectedCheck.checked = false
    })

    context.isBodyAreas = false
  }

  checkIsBodyInjuriesSelected()
  context.checkisFormFilled()
}

export function handleAddIjnuries(event, context, listWrap, trigger) {
  const list = event.currentTarget.closest(".js-medical-chronology-request-dropdown-list")
  resetSelectedCheckboxes(context)
  const selectedCheckboxes = [...list.querySelectorAll('input[type="checkbox"]')].filter(
    (item) => item.checked,
  )
  if (selectedCheckboxes && selectedCheckboxes.length) {
    context.selectedInjuriesList.parentNode.classList.add("active")
    selectedCheckboxes.forEach((checkbox) => {
      const { target, iconClass } = checkbox.dataset
      const selectedInput = context.selectedInjuriesList.querySelector(`#${target}`)
      selectedInput.closest(".selected-injury-item").classList.add("active")
      document.querySelectorAll(`g.${iconClass}`).forEach((group) => group.classList.add("active"))
      selectedInput.checked = true
    })
  }
  context.checkisFormFilled()
  listWrap.classList.remove("active")
  trigger.classList.remove("active")
}

export function handleSelectedInjuiesCheck(event, wrap, context) {
  const { itemId, iconClass } = event.target.dataset
  if (!event.target.checked) {
    event.target.closest(".selected-injury-item").classList.remove("active")
    document.querySelector(`#${itemId}`).checked = false
    document.querySelectorAll(`.${iconClass}`).forEach((group) => group.classList.remove("active"))
  }
  setBodyAreas()
  context.checkisFormFilled()
  const isEmptyList = !checkSelectedCheckboxes(wrap)
  if (isEmptyList) {
    wrap.classList.remove("active")
  }
}

export function handleInput(event, context) {
  context.inputs[event.target.name].input.value = event.target.value
  context.inputs[event.target.name].value = event.target.value
  context.isInputsFilled = checkInputs(context)
  context.checkisFormFilled()
}

export function handleAreaClick(event, context) {
  const { currentTarget } = event
  const { bodyPart } = currentTarget.dataset

  context.section.querySelectorAll(`g[data-body-part="${bodyPart}"]`).forEach((part) => {
    part.classList.add("clicked")
  })
  // currentTarget.classList.add('clicked')

  const popup = context.section.querySelector(`.js-injury-popup-wrap[data-popup-id="${bodyPart}"]`)
  popup.classList.add("active")
}

export function handlePopupButtonClick(event, context) {
  const { targetId } = event.currentTarget.dataset

  const popup = context.section.querySelector(`.js-injury-popup-wrap[data-popup-id="${targetId}"]`)
  popup.classList.remove("active")
  document.querySelectorAll(".js-body-area").forEach((group) => group.classList.remove("clicked"))

  const targetCheckbox = context.section.querySelector(
    `.js-injury-item-checkbox[data-icon-class="${targetId}"]`,
  )
  const addBtn = context.section.querySelector(".js-injury-add-btn")
  targetCheckbox.checked = !targetCheckbox.checked
  addBtn.click()
  context.checkisFormFilled()
}
