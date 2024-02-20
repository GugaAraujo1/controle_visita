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

function validarForm() {
    let cpfInput = document.getElementById('cpf');
    let resultadoDiv = document.getElementById('resultado');
    let form = document.getElementById('myForm'); // Set the form ID

    if (validarCPF(cpfInput.value)) {
        resultadoDiv.innerText = 'CPF válido!';
        form.action = "../DB_Querys/solicitacaoController.php"; // Set the action for valid CPF
        return true; // Allow form submission
    } else {
        resultadoDiv.innerText = 'CPF inválido!';
        form.action = ""; // Clear the action for invalid CPF
        return false; // Prevent form submission
    }

}

function validarForm_Update() {
    let cpf_Input_Update = document.getElementById('cpf_Input_Update');
    let resultado_Div_Update = document.getElementById('resultado_Div_Update');
    let form_Update = document.getElementById('form_Update');

    if (validarCPF(cpf_Input_Update.value)) {
        resultado_Div_Update.innerText = 'CPF válido!';
        form_Update.action = "../DB_Querys/solicitacaoUpdate.php";
        return true;

    } else {
        resultado_Div_Update.innerText = 'CPF inválido!';
        form_Update.action = "";
        return false;
    }
}

function adicionarInputIntegracao() {
    const select = document.getElementById('motivo_visita');
    const integracao = document.getElementById('integracao');
    const confirmar_label = document.getElementById('confirmar');
    const confirmar_integracao = document.getElementById('confirmar_integracao');
    console.log(confirmar_integracao);
    console.log(confirmar_label);

    let option = "";
    option = select.value;


    integracao.innerHTML = "";

    if (option == "Prestador de serviço") {
        const labelName = document.createElement("label");
        labelName.className = "pe-2  label-acesso-css";
        labelName.innerHTML = "Fará integração? ";

        const inputIntegracao = document.createElement("input");
        inputIntegracao.type = "checkbox";
        inputIntegracao.name = "confirmar_integracao";
        inputIntegracao.className = "inputBox-css";

        integracao.appendChild(labelName);
        integracao.appendChild(inputIntegracao);
    } 
    if(option == "Prestador de serviço" && confirmar_label && confirmar_integracao){
        integracao.innerHTML = "";
    }
     if (option == "Visita") {
        confirmar_label.classList.add('hidden');
        confirmar_integracao.classList.add('hidden');;
        confirmar_integracao.checked = false;
    }   else{
        confirmar_label.classList.remove('hidden');
        confirmar_integracao.classList.remove('hidden');
        confirmar_integracao.checked = true;
    }
}
// Adiciona um ouvinte de evento ao elemento select
document.getElementById('motivo_visita').addEventListener('change', adicionarInputIntegracao);