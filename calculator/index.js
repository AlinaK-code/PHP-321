let display = document.getElementById('display');
let errorDisplay = document.getElementById('error-display');
let currentInput = '0';
let lastChar = '';

const buttonNum0 = document.querySelector(".num0");
const buttonNum1 = document.querySelector(".num1");
const buttonNum2 = document.querySelector(".num2");
const buttonNum3 = document.querySelector(".num3");
const buttonNum4 = document.querySelector(".num4");
const buttonNum5 = document.querySelector(".num5");
const buttonNum6 = document.querySelector(".num6");
const buttonNum7 = document.querySelector(".num7");
const buttonNum8 = document.querySelector(".num8");
const buttonNum9 = document.querySelector(".num9");
const buttonDot = document.querySelector(".dot");

const buttonOpenScaple = document.querySelector(".openScaple");
const buttonCloseScaple = document.querySelector(".closeScaple");

const buttonReset = document.querySelector(".reset");
const buttonDelete = document.querySelector(".delete");
const buttonCalculate = document.querySelector(".calculate");

const buttonMultiplier = document.querySelector(".multiplier");
const buttonDivision = document.querySelector(".division");
const buttonMinus = document.querySelector(".minus");
const buttonPlus = document.querySelector(".plus");


[buttonNum0, buttonNum1, buttonNum2, buttonNum3, buttonNum4, 
 buttonNum5, buttonNum6, buttonNum7, buttonNum8, buttonNum9].forEach(button => {
    button.addEventListener('click', () => appendToDisplay(button.textContent));
});


[buttonPlus, buttonMinus, buttonMultiplier, buttonDivision].forEach(button => {
    button.addEventListener('click', () => appendOperator(button.textContent));
});


buttonOpenScaple.addEventListener('click', () => appendToDisplay('('));
buttonCloseScaple.addEventListener('click', () => appendToDisplay(')'));


buttonDot.addEventListener('click', () => appendDot());


buttonReset.addEventListener('click', clearDisplay);
buttonDelete.addEventListener('click', backspace);
buttonCalculate.addEventListener('click', calculate);

function updateDisplay() {
    display.textContent = currentInput;
    errorDisplay.textContent = '';
    errorDisplay.style.display = 'none';
}

function appendToDisplay(value) {
    if (currentInput === '0' && value !== '.') {
        currentInput = value;
    } else {
        currentInput += value;
    }
    lastChar = value;
    updateDisplay();
}

function appendOperator(operator) {

    if ('+-*/'.includes(lastChar)) {
        currentInput = currentInput.slice(0, -1) + operator;
    } else {
        currentInput += operator;
    }
    lastChar = operator;
    updateDisplay();
}

function appendDot() {

    const parts = currentInput.split(/[\+\-\*\/]/);
    const lastNumber = parts[parts.length - 1];

    if (!lastNumber.includes('.')) {
        currentInput += '.';
        lastChar = '.';
        updateDisplay();
    }
}

function clearDisplay() {
    currentInput = '0';
    lastChar = '';
    updateDisplay();
}

function backspace() {
    if (currentInput.length === 1) {
        currentInput = '0';
    } else {
        currentInput = currentInput.slice(0, -1);
        lastChar = currentInput[currentInput.length - 1] || '';
    }
    updateDisplay();
}

function calculate() {

    if ('+-*/'.includes(lastChar)) {
        errorDisplay.textContent = 'Выражение не может заканчиваться оператором';
        errorDisplay.style.display = 'block';
        return;
    }

    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'expression=' + encodeURIComponent(currentInput)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            errorDisplay.textContent = data.error;
            errorDisplay.style.display = 'block';
        } else {
            currentInput = data.result.toString();
            lastChar = currentInput[currentInput.length - 1];
            updateDisplay();
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        errorDisplay.textContent = 'Ошибка вычисления';
        errorDisplay.style.display = 'block';
    });
}

updateDisplay();