import { assigneesArr } from "../../../../data/assignees"
import { createUserData } from "./helpers"
import { assignedUserTemplate, selectedUserTemplate } from "./templates"
import { Toast } from "../../components/toast"

export class SelectUserHandler {
  constructor(context) {
    this.context = context
    this.container = context.container
    this.sidebar = this.container.closest(".offcanvas.assignees")
    this.resultsList = context.resultsList
    this.input = context.input
    this.isSelectUser = this.container.classList.contains("js-select-user")
    this.selectUsersContainer = this.container.querySelector(".js-select-user-container")
    this.selectUsersList = this.container.querySelector(".js-select-user-list")
    this.removeAllBtn = this.container.querySelector(".js-user-selected-remove-all")
    this.selectedUsersQty = this.container.querySelector(".js-user-selected-quantity")
    this.submitButton = this.container.querySelector(".js-select-user-submit")
    this.hiddenClass = context.hiddenClass

    this.init()
  }

  init = () => {
    this.resultsList.addEventListener("click", this.handleUserItemClick)
    this.selectUsersList.addEventListener("click", this.handleSelectedUserClick)
    this.removeAllBtn.addEventListener("click", this.removeAllSelectedUsers)
    this.submitButton.addEventListener("click", this.handleSubmit)
    document.addEventListener("click", this.handleDocumentClick)
  }

  handleUserItemClick = (event) => {
    const user = event.target.closest(".user-search-item")
    const userData = createUserData(user)
    const selectedUser = selectedUserTemplate(userData)
    this.selectUsersList.insertAdjacentHTML("beforeend", selectedUser)

    user.classList.add("_selected")
    this.resultsList.classList.add(this.hiddenClass)
    this.input.value = ""
    this.updateSelectedUsersCount()
    this.setUserInfoPopupTop()
  }

  handleSelectedUserClick = (event) => {
    const selectedUser = event.target.closest(".js-user-selected")
    const removeButton = event.target.closest(".js-user-selected-remove")

    if (removeButton && selectedUser) {
      const userId = selectedUser.dataset.id
      this.deselectUserItem(userId)
      selectedUser.remove()
    }
    this.updateSelectedUsersCount()
    this.setUserInfoPopupTop()
  }

  removeAllSelectedUsers = () => {
    const selectedUsers = this.selectUsersList.querySelectorAll(".js-user-selected")

    selectedUsers.forEach((selectedUser) => {
      const userId = selectedUser.dataset.id
      this.deselectUserItem(userId)
      selectedUser.remove()
    })
    this.updateSelectedUsersCount()
    this.setUserInfoPopupTop()
  }

  deselectUserItem = (userId) => {
    const correspondingItem = this.resultsList.querySelector(
      `.user-search-item[data-id="${userId}"]`,
    )
    if (correspondingItem) {
      correspondingItem.classList.remove("_selected")
    }
  }

  updateSelectedUsersCount = () => {
    const selectedCount = this.selectUsersList.querySelectorAll(".js-user-selected").length

    this.selectedUsersQty.innerHTML =
      selectedCount === 1 ? "1 User Selected" : `${selectedCount} Users Selected`

    this.selectUsersContainer.classList.toggle("_hidden", !selectedCount > 0)

    this.removeAllBtn.querySelector("span").innerHTML = `Remove(${selectedCount})`
  }

  setUserInfoPopupTop = () => {
    const items = this.selectUsersList.querySelectorAll(".selected-user-item__info")

    items.forEach((item) => {
      const itemParent = item.parentNode
      const itemOffset = Number(getComputedStyle(item).getPropertyValue("--_item-offset"))
      const offsetTop = itemParent.offsetTop
      const parentHeight = itemParent.offsetHeight

      item.style.top = offsetTop + parentHeight + itemOffset + "px"
    })
  }

  handleSubmit = () => {
    const { state } = this.sidebar.dataset
    const selectedUsers = this.selectUsersList.querySelectorAll(".js-user-selected-info")
    /*const assignees = document.querySelector(".js-assignees")
    const assigneesList = assignees.querySelector(".js-assignees-list")*/
    /*const listToggleInner = assignees.querySelector(".js-accordion-toggler span")*/

    if (state && state === "edit") {
      assigneesArr.length = 0
      this.selectUsersList.innerHTML = ""
      this.selectUsersContainer.classList.add("_hidden")
      this.sidebar.setAttribute("data-state", "default")
      new Toast({
        position: ".reports .offcanvas-header",
        type: "successful",
        text: "Report access email sent to assignees.",
        autoClose: 5000
      })
    } else {
      /*const hiddenElements = assignees.querySelectorAll("._hidden")
      const notification = assignees.querySelector(".js-notification")*/
      const selectedSearchUsers = document.querySelectorAll("._selected")

      /*hiddenElements.forEach((el) => el.classList.remove("_hidden"))
      notification.style.display = "none"*/
      new Toast({
        position: ".reports .offcanvas-header",
        type: "successful",
        text: `Report access email sent to assignees.`,
        autoClose: 5000
      })

      selectedSearchUsers.forEach((user) => user.remove())
      this.removeAllSelectedUsers()
    }

    // common logic
    /*assigneesList.innerHTML = ""
    selectedUsers.forEach((user) => {
      const userData = createUserData(user)
      assigneesArr.push(userData)
    })
    assigneesArr.forEach((user) => {
      const assignedUser = assignedUserTemplate(user)
      assigneesList.insertAdjacentHTML("beforeend", assignedUser)
    })
    listToggleInner.textContent = `View ${assigneesArr.length} ${
      assigneesArr.length > 1 ? "Assignees" : "Assignee"
    }`*/
    this.sidebar.classList.remove("_active")
  }

  handleDocumentClick = (event) => {
    if (!this.resultsList.contains(event.target) && !this.input.contains(event.target)) {
      this.resultsList.classList.add(this.hiddenClass)
    }
  }
}
