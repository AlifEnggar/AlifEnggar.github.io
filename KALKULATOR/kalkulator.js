const result = document.getElementById("result");
const historyList = document.getElementById("historyList");
const miniHistory = document.getElementById("miniHistory");

let currentInput = "";

function append(value) {
  if (result.innerText === "0") {
    currentInput = "";
  }

  currentInput += value;
  result.innerText = currentInput;
}

function clearDisplay() {
  currentInput = "";
  result.innerText = "0";
  miniHistory.innerText = "";
}

function deleteLast() {
  currentInput = currentInput.slice(0, -1);

  if (currentInput === "") {
    result.innerText = "0";
  } else {
    result.innerText = currentInput;
  }
}

function calculate() {
  if (currentInput === "") return;

  try {
    let expression = currentInput.replace("%", "/100");
    let answer = eval(expression);

    addHistory(currentInput, answer);

    miniHistory.innerText = currentInput;
    result.innerText = answer;

    currentInput = answer.toString();
  } catch {
    result.innerText = "Error";
  }
}

function addHistory(expression, answer) {
  if (historyList.innerHTML.includes("Belum ada")) {
    historyList.innerHTML = "";
  }

  const item = document.createElement("div");
  item.classList.add("history-item");

  item.innerHTML = `
    <p>${expression}</p>
    <h3>${answer}</h3>
  `;

  historyList.prepend(item);
}

function clearHistory() {
  historyList.innerHTML = `
    <p style="color:#94a3b8">
      Belum ada perhitungan
    </p>
  `;
}

document.addEventListener("keydown", (e) => {
  const allowed = "0123456789/*-+.%";

  if (allowed.includes(e.key)) {
    append(e.key);
  }

  if (e.key === "Enter") {
    calculate();
  }

  if (e.key === "Backspace") {
    deleteLast();
  }

  if (e.key === "Escape") {
    clearDisplay();
  }
});
