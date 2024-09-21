const home = document.getElementById("home");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");

home.addEventListener("click", () => {
    barraLateral.classList.toggle("mini-barra-lateral");

    spans.forEach((span) => {
        span.classList.toggle("oculto");
    });
});
