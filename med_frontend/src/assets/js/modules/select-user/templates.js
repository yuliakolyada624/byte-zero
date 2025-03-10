function selectedUserTemplate(user) {
  const { id, initials, name, email, position } = user

  return `
    <li class="selected-user-item js-user-selected" data-id="${id}">
      <p>
        ${name}
      </p>
      <div class="user-search-item selected-user-item__info js-user-selected-info"
        data-name="${name}"
        data-id="${id}"
        data-email="${email}"
        data-position="${position}">
        <div class="user-search-item__first-col">
          <div class="user-search-item__initials">
            ${initials}
          </div>
          <div>
            <p>
              <b>${name}</b>
            </p>
            <p>
              ${email}
            </p>
          </div>
        </div>
        <div class="user-search-item__second-col">
          <p>
            <b>${position}</b>
          </p>
          <p>
            <img src="./svg/flags/us.svg" alt="USA flag" with="21" height="13" />
            The Salameh Law Group, P.A.
          </p>
        </div>
      </div>
      <button class="js-user-selected-remove" type="button">
        <svg class="icon icon-close ">
          <use href="./icon/icons/icons.svg#close"></use>
        </svg>
      </button>
    </li>`
}

function assignedUserTemplate(user) {
  const { id, initials, name, email, position } = user

  return `
    <div class="user-search-item user-search-item--flex js-select-user-assigned"
      data-name="${name}"
      data-id="${id}"
      data-email="${email}"
      data-position="${position}">
      <div class="user-search-item__first-col">
        <div class="user-search-item__initials">
         ${initials}
        </div>
        <div>
          <p>
            <b>${name}</b>
          </p>
          <p>
            ${email}
          </p>
        </div>
      </div>
      <div class="user-search-item__second-col">
        <p>
          <b>${position}</b>
        </p>
        <p>
          <img src="./svg/flags/us.svg" alt="USA flag" with="21" height="13" />
          The Salameh Law Group, P.A.
        </p>
      </div>
    </div>`
}

export { assignedUserTemplate, selectedUserTemplate }
