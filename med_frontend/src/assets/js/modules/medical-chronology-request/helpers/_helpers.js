export function checkSelectedCheckboxes(wrap) {
  return [...wrap.querySelectorAll('input[type="checkbox"]')].some((item) => item.checked)
}

export function setBodyAreas() {
  const checkboxes = document.querySelectorAll(".js-injury-item-checkbox")
  const bodyAreas = document.querySelectorAll(".js-body-area")
  bodyAreas.forEach((area) => {
    area.classList.remove("active")
  })
  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      const { iconClass } = checkbox.dataset
      document.querySelectorAll(`.${iconClass}`).forEach((group) => group.classList.add("active"))
    }
  })
}
