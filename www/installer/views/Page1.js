import { createElement } from "../MiniReact.js";
import { LinkComponent } from "../components/Link.js";
import { BrowserLink } from "../components/BrowserRouter.js";

export default function Page1() {
  const DATA_KEY = "data";
  let data = localStorage.getItem(DATA_KEY);
  if (!data) {
    data = {};
  } else {
    data = JSON.parse(data);
  }

  return createElement("div", null, [
    BrowserLink("Page 2", "/page2"),
    createElement("table", null, [
      createElement("tbody", null, Array.from({ length: 5 }, function (_, i) {
        return createElement("tr", null, Array.from({ length: 5 }, function (_, j) {
          return createElement("td", { "data-key": `${i}-${j}`, onClick: changeTextIntoInput }, [
            LinkComponent(data[`${i}-${j}`] ?? "text", `/item/${i}-${j}`, null)
          ]);
        }));
      })),
    ]),
  ]);

  function changeTextIntoInput(event) {
    const td = event.currentTarget;
    const textNode = td.childNodes[0];
    const text = textNode.textContent;
    const input = document.createElement("input");
    input.value = text;
    td.removeChild(textNode);
    td.appendChild(input);
    input.focus();
    td.removeEventListener("click", changeTextIntoInput);
    input.addEventListener("blur", changeInputIntoText);
  }

  function changeInputIntoText(event) {
    const input = event.currentTarget;
    const textNode = document.createTextNode(input.value);
    data[input.parentNode.dataset.key] = input.value;
    localStorage.setItem(DATA_KEY, JSON.stringify(data));
    input.removeEventListener("blur", changeInputIntoText);
    input.parentNode.addEventListener("click", changeTextIntoInput);
    input.parentNode.replaceChild(textNode, input);
  }
}
