import { handleAreaClick } from "./_handlers"

export function initSvgAreas(areas, context) {
  areas.forEach((area) => {
    area.addEventListener("click", (event) => handleAreaClick(event, context))
  })
}
