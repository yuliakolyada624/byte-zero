export class HeaderLinksScroll {
  constructor(page) {
    // console.log('constructor occurs');
    this.page = page
    this.links = page.querySelectorAll(".js-header-nav-item-link")
    this.sections = Array.from(
      new Set(
        [...this.links].map(({ dataset: { target } }) => {
          return this.page.querySelector(`#${target}`)
        }),
      ),
    )
    this.#init()
  }

  handleLinkClick = (event) => {
    event.preventDefault()
    this.links.forEach((link) => link.parentNode.classList.remove("active"))
    event.currentTarget.parentNode.classList.add("active")
    if (event.currentTarget.closest(".js-header-overlap-menu")) {
      event.currentTarget.closest(".js-header-overlap-menu").classList.remove("active")
      document.body.classList.remove("_lock")
    }

    const { target } = event.currentTarget.dataset
    let topPosition = 0
    if (target === "home") {
      topPosition = 0
    } else {
      const elementToScroll = this.page.querySelector(`#${target}`)
      const headerHeight = parseInt(
        window.getComputedStyle(document.documentElement).getPropertyValue("--header-height"),
      )
      topPosition = elementToScroll.offsetTop - headerHeight
    }
    window.scrollTo({
      top: topPosition,
      behavior: "smooth",
    })
  }

  handleScroll = () => {
    this.sections.forEach((section) => {
      const { top, bottom } = section.getBoundingClientRect()
      if (top <= 150 && bottom > 150) {
        const target = section.getAttribute("id")
        this.links.forEach((link) => {
          if (link.dataset.target === target) {
            link.parentNode.classList.add("active")
          } else {
            link.parentNode.classList.remove("active")
          }
        })
      }
    })
  }

  #init() {
    this.handleScroll()
    this.links.forEach((link) => {
      link.addEventListener("click", this.handleLinkClick)
    })
    window.addEventListener("scroll", this.handleScroll)
  }
}
