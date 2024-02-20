function validarCPF(cpf) {
  cpf = cpf.replace(/[^\d]+/g, '');
  if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

  let soma = 0;
  for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
  let resto = soma % 11;
  let digito1 = resto < 2 ? 0 : 11 - resto;

  soma = 0;
  for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
  resto = soma % 11;
  let digito2 = resto < 2 ? 0 : 11 - resto;

  return digito1 === parseInt(cpf.charAt(9)) && digito2 === parseInt(cpf.charAt(10));
}

function addInput_e_RemoverIput() {
  const nome = document.getElementById("nome").value;
  const celular = document.getElementById("celular").value;
  const cpf = document.getElementById("cpf").value;
  const email = document.getElementById("email").value;
  const periodo_visita_de = document.getElementById("periodo_visita_de").value;

    let resultado_Div_Entrevista = document.getElementById('resultado_Div_Entrevista');

  const enviar = document.getElementById("btn-enviar");
  enviar.disabled = true;
  if (!validarCPF(cpf)) {
    resultado_Div_Entrevista.innerText = 'CPF inválido!';
    return; 
  }


  if (!nome || !periodo_visita_de) {
    alert("Preencha o nome e a data da entrevista antes de adicionar.");

    return; // Não continue se algum campo estiver vazio

  } else {

    const labelName = document.createElement("label");
    labelName.className = "label-css";
    labelName.innerHTML = "Nome:";

    const labelCelular = document.createElement("label");
    labelCelular.className = "label-css";
    labelCelular.innerHTML = "Celular:";

    const labelCpf = document.createElement("label");
    labelCpf.className = "label-css";
    labelCpf.innerHTML = "CPF:";

    const labelEmail = document.createElement("label");
    labelEmail.className = "label-css";
    labelEmail.innerHTML = "Email:";

    const labelPeriodoVisita = document.createElement("label");
    labelPeriodoVisita.className = "label-css ";
    labelPeriodoVisita.innerHTML = "Data da entrevista:";

    const labelHidden = document.createElement("label");
    labelHidden.className = "label-css mt-3 ";
    labelHidden.innerHTML = "";

    const inputNome = document.createElement("input");
    inputNome.type = "text";
    inputNome.name = "nome[]";
    inputNome.value = nome;
    inputNome.className = "input-css ";

    const inputCelular = document.createElement("input");
    inputCelular.type = "text";
    inputCelular.name = "celular[]";
    inputCelular.value = celular;
    inputCelular.className = "input-css"; 

    
    const inputCpf = document.createElement("input");
    inputCpf.type = "text";
    inputCpf.name = "cpf[]";
    inputCpf.value = cpf;
    inputCpf.className = "input-css mb-2";

    const inputHidden = document.createElement("input");
    inputHidden.type = "text";
    inputHidden.className = "input-css mb-4 border-0 bg-transparent";

    const inputEmail = document.createElement("input");
    inputEmail.type = "text";
    inputEmail.name = "email[]";
    inputEmail.value = email;
    inputEmail.className = "input-css ";

    const inputPeriodoVisita = document.createElement("input");
    inputPeriodoVisita.type = "datetime-local";
    inputPeriodoVisita.name = "periodo_visita_de[]";
    inputPeriodoVisita.value = periodo_visita_de;
    inputPeriodoVisita.className = "input-css ";
    inputPeriodoVisita.id = "inputdata"

    enviar.disabled = false;

    myForm.appendChild(labelName);
    myForm.appendChild(inputNome);
    myForm.appendChild(labelCelular);
    myForm.appendChild(inputCelular);
    myForm.appendChild(labelCpf);
    myForm.appendChild(inputCpf);

    myForm2.appendChild(labelEmail);
    myForm2.appendChild(inputEmail);
    myForm2.appendChild(labelPeriodoVisita);
    myForm2.appendChild(inputPeriodoVisita);
    myForm2.appendChild(labelHidden);
    myForm2.appendChild(inputHidden);
  
   
    document.getElementById("nome").value = "";
    document.getElementById("celular").value = "";
    document.getElementById("cpf").value = "";
    document.getElementById("email").value = "";
    document.getElementById("periodo_visita_de").value = "";

    // btn remover
    const removeButton = document.createElement("div");
    removeButton.className = "btn btn-danger d-flex align-items-center";
    removeButton.innerHTML = '<i class="fa-solid fa-minus" style="color: #ffffff;"></i>';

    const removeBtnContainer = document.getElementById("remove-btn");
    removeBtnContainer.appendChild(removeButton);

    removeButton.addEventListener("click", function () {

      myForm.removeChild(labelName);
      myForm.removeChild(labelCelular);
      myForm.removeChild(labelCpf);
      myForm2.removeChild(labelEmail);
      myForm2.removeChild(labelPeriodoVisita);

      myForm.removeChild(inputNome);
      myForm.removeChild(inputCelular);
      myForm.removeChild(inputCpf);
      myForm2.removeChild(inputEmail);
      myForm2.removeChild(inputPeriodoVisita);
      myForm2.removeChild(inputHidden);

      removeBtnContainer.removeChild(removeButton);

      // Verificar se há elementos no formulário
      const formElements = myForm.querySelectorAll("input, label");
      const form2Elements = myForm2.querySelectorAll("input, label");

      //Desabilitar o botão de envio
      if (formElements.length === 0 && form2Elements.length === 0) {
        enviar.disabled = true;
      }

    });
  }
}
document.getElementById("btnAdd").addEventListener("click", addInput_e_RemoverIput);





