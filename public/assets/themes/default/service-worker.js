const STATIC_CACHE_KEY = "s-v1"
const DYNAMIC_CACHE_KEY = "d-v1"

const ASSETS_TO_CAcHE = [
  "./index.html",
  "./404.html",
  "./favicons/favicon.png",
  "./launch-screens/launch-screen.png",
  "./js/main.js",
  "./css/app.min.css",
]

const install_handle = async () => {
  const cache = await caches.open(STATIC_CACHE_KEY)
  await cache.addAll(ASSETS_TO_CAcHE)
}

self.addEventListener("install", install_handle)

const activate_handle = async () => {
  const cache_keys = await caches.keys()

  await Promise.all(
    cache_keys
      .filter((cache_name) => cache_name !== STATIC_CACHE_KEY)
      .filter((cache_name) => cache_name !== DYNAMIC_CACHE_KEY)
      .map((cache_name) => caches.delete(cache_name)),
  )
}

self.addEventListener("activate", activate_handle)

const fetch_handle = (event) => {
  if (
    event.request.url.startsWith("chrome-extension") ||
    event.request.url.includes("extension") ||
    !(event.request.url.indexOf("http") === 0)
  )
    return

  const { request } = event
  const url = new URL(request.url)

  if (url.origin === location.origin) {
    event.respondWith(static_data(request))
  } else {
    event.respondWith(dynamic_data(request))
  }
}

async function static_data(request) {
  const response = await fetch(request)

  return response ?? (await caches.match(request))
}

async function dynamic_data(request) {
  const cache = await caches.open(DYNAMIC_CACHE_KEY)

  try {
    const response = await fetch(request)
    await cache.put(request, response.clone())

    return response
  } catch (e) {
    console.warn(e)
    const cached = await cache.match(request)

    return cached ?? (await caches.match("404.html"))
  }
}

self.addEventListener("fetch", fetch_handle)
