export function itemMarkup(fileName, fileSize, fileId) {
  const sizeInMB = (fileSize / (1024 * 1024)).toFixed(2)

  const wrap = document.createElement("div")
  wrap.classList.add("medical-chronology-request-form-upload-file__item")
  wrap.innerHTML = `
  <div class="medical-chronology-request-form-upload-file__item-main">
    <div class="medical-chronology-request-form-upload-file__item-icon">
      <svg class="icon icon-document">
        <use href="/assets/themes/default/icon/icons/icons.svg#document"></use>
      </svg>
    </div>
    <div class="medical-chronology-request-form-upload-file__item-info-heading">
      <div class="medical-chronology-request-form-upload-file__item-name js-upload-file-name">${fileName}</div>
      <div class="medical-chronology-request-form-upload-file__item-size js-upload-file-size">${sizeInMB} MB</div>
    </div>
    <button type="button" class="medical-chronology-request-form-upload-file__item-delete js-upload-file-delete-btn" data-item-id="${fileId}">  
      <svg class="icon icon-trash">
        <use href="/assets/themes/default/icon/icons/icons.svg#trash"></use>
      </svg>
    </button>
  </div>`
  return wrap
}
