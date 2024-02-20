

  function initKeyboard2(inputId, keyboardDivClass) {
    const teclado = window.SimpleKeyboard.default;
    const input = document.getElementById(inputId);
    const keyboardDiv = document.querySelector(`.${keyboardDivClass}`);
 
    input.addEventListener('click', function() {
      keyboardDiv.classList.toggle('simple-keyboard-flex');
    });

    const myKeyboard = new teclado({
      onChange: value => onChange(input, value),
      onKeyPress: button => onKeyPress(button)
    });

    function onChange(input, value) {
      input.value = value;
      console.log("Input changed", value);
    }

    function onKeyPress(button) {
      console.log("Button pressed", button);
    }

    return myKeyboard;
  }

  const keyboardPesquisar = initKeyboard2('token', 'simple-keyboard');

  // const keyboardPesquisarToken = initKeyboard2('token', 'simple-keyboard');






