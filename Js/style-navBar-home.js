// DARK MODE FUNCTIONS
const mudarThema = document.querySelector("#mudar-thema");
const modoIcon = document.getElementById("modo-icon");
const modoText = document.getElementById("modo-text");

function toggleDarkMode() {
  document.body.classList.toggle("dark");

  const modoText = document.getElementById("modo-text");

  if (modoText) {
    if (document.body.classList.contains("dark")) {
      modoText.innerText = "Modo Light";
      modoIcon.classList.remove("fa-moon");
      modoIcon.classList.add("fa-sun");
    } else {
      modoText.innerText = "Modo Noturno";
      modoIcon.classList.remove("fa-sun");
      modoIcon.classList.add("fa-moon");
    }
  }
}

function loadTheme() {

  const darkMode = localStorage.getItem("dark");

  if (darkMode) {
    toggleDarkMode();
  }
}

loadTheme();

mudarThema.addEventListener("change", function () {
  toggleDarkMode();

  // salva ou remove o dark mode
  localStorage.removeItem("dark");

  if (document.body.classList.contains("dark")) {
    localStorage.setItem("dark", 1);
  }
});


// FUNCTION PARA TRATAMENTO DO INPUT RADIO DA TELA SOLICITACAO.PHP
document.addEventListener('DOMContentLoaded', () => {

  const fabrica = document.querySelector("#acesso_fabrica");
  const area_da_Visita = document.querySelector("#area_da_visita");
  const area_visita = document.querySelector("#area_visita");

  fabrica.addEventListener('change', () => {

    const isChecked = fabrica.checked;
    area_visita.classList.toggle("display-flex", isChecked);
    area_da_Visita.classList.toggle("display-flex", isChecked);
    area_da_Visita.value = '';

  });
});


