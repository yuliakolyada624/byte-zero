import { SelectUserHandler } from "./select-user/select-user-handler"
// container: js-search-filter
// input: js-search-filter-input
// list: js-search-filter-list
// item: js-search-filter-item
// clear button: js-search-filter-clear

export class SearchFilter {
  constructor(container) {
    this.container = container
    this.isSelect = container.classList.contains("js-select-dropdown")
    this.isSelectUser = container.classList.contains("js-select-user")
    this.input = container.querySelector(".js-search-filter-input")
    this.resultsList = container.querySelector(".js-search-filter-list")
    this.clearBtn = container.querySelector(".js-search-filter-clear")
    this.resultsItems = this.resultsList.querySelectorAll(".js-search-filter-item")
    this.hiddenClass = "_hidden"

    this.init()
  }

  init = () => {
    this.input.addEventListener("input", this.filterResults)

    if (this.isSelect) {
      this.resultsList.addEventListener("click", this.clearInput)
    } else if (this.isSelectUser) {
      new SelectUserHandler(this)
    } else {
      this.resultsList.addEventListener("click", this.handleItemClick)
    }

    this.clearBtn && this.clearBtn.addEventListener("click", this.clearInput)
  }

  filterResults = () => {
    const inputValue = this.input.value.toLowerCase()
    let hasMatchingItems = false

    this.resultsItems.forEach((item) => {
      const filterValue = item.querySelector(".js-search-filter-value")
      const itemValue = (filterValue ? filterValue.textContent : item.textContent)
        .trim()
        .toLowerCase()
      const isMatch = itemValue.includes(inputValue)

      if (isMatch) {
        hasMatchingItems = true
      }

      item.classList.toggle("_hidden", !isMatch)
    })

    if (!this.isSelect) {
      this.resultsList.classList.toggle(this.hiddenClass, !inputValue || !hasMatchingItems)
    }
  }

  handleItemClick = (event) => {
    const clickedItem = event.target.closest(".js-search-filter-item")
    if (!clickedItem) return

    const itemValue = clickedItem.querySelector(".js-search-filter-value").textContent.trim()
    this.input.value = itemValue

    if (!this.isSelect) {
      this.resultsList.classList.add(this.hiddenClass)
    }
  }

  clearInput = () => {
    this.input.value = ""
    this.filterResults()
  }
}
