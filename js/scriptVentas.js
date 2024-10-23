// Definición de la función toggleCaja
function toggleCaja() {
  const cajaEstado = document.getElementById("cajaStatus");
  const btnToggle = document.getElementById("toggleCaja");

  if (cajaEstado.textContent === "CAJA: ABIERTA") {
      cajaEstado.textContent = "CAJA: CERRADA";
      btnToggle.classList.remove("btn-success");
      btnToggle.classList.add("btn-danger");
  } else {
      cajaEstado.textContent = "CAJA: ABIERTA";
      btnToggle.classList.remove("btn-danger");
      btnToggle.classList.add("btn-success");
  }
}
