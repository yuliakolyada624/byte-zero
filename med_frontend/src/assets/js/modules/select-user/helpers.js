function createUserData(user) {
  const { name, id, email, position } = user.dataset
  const initials = name
    .split(" ")
    .map((word) => word[0])
    .join("")
  const userData = {
    id,
    initials,
    name,
    email,
    position,
  }

  return userData
}

export { createUserData }
