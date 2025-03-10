export function resetSelectedCheckboxes(context) {
  const checkboxes = context.selectedInjuriesList.querySelectorAll('input[type="checkbox"]')
  checkboxes.forEach((checkbox) => {
    const { iconClass } = checkbox.dataset
    document.querySelectorAll(`.${iconClass}`).forEach((group) => group.classList.remove("active"))
    checkbox.checked = false
    checkbox.closest(".selected-injury-item").classList.remove("active")
  })
}
