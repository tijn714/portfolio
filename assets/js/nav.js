const body = document.querySelector("body");
const navbar = document.querySelector(".navbar");
const menuBtn = document.querySelector(".menu-btn");
const cancelBtn = document.querySelector(".cancel-btn");
const menuItems = document.querySelectorAll(".menu-item");

menuBtn.onclick = () => {
  navbar.classList.add("show");
  menuBtn.classList.add("hide");
  body.classList.add("disabled");
}

cancelBtn.onclick = () => {
  body.classList.remove("disabled");
  navbar.classList.remove("show");
  menuBtn.classList.remove("hide");
}

menuItems.forEach(item => {
  item.addEventListener("click", (event) => {
    // Get the href attribute of the clicked link
    const target = event.currentTarget.getAttribute("href");

    // Close the menu
    navbar.classList.remove("show");
    menuBtn.classList.remove("hide");
    body.classList.remove("disabled");

    // Smoothly scroll to the anchor
    const targetElement = document.querySelector(target);
    if (targetElement) {
      targetElement.scrollIntoView({ behavior: "smooth" });
    }

    // Prevent the default anchor link behavior
    event.preventDefault();
  });
});

window.onscroll = () => {
  this.scrollY > 20 ? navbar.classList.add("sticky") : navbar.classList.remove("sticky");
}
