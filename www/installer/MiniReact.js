import BrowserRouter from "./components/BrowserRouter";
import HashRouter from "./components/HashRouter";

export { BrowserRouter, HashRouter };

export default function MiniReact(routes, rootElement, routingMode = "browser") {
  const Router = routingMode === "hash" ? HashRouter : BrowserRouter;
  Router(routes, rootElement);
}

export function render(element, rootElement) {
  rootElement.innerHTML = "";
  rootElement.appendChild(element);
}

export function createElement(type, attributes, ...children) {
  if (typeof type === "function") {
    // Si le type est une fonction, c'est un composant
    const component = new type(attributes);
    return component.render();
  }

  const element = document.createElement(type);

  if (attributes) {
    for (let attrName in attributes) {
      if (attrName.startsWith("data-")) {
        element.dataset[attrName.replace("data-", "")] = attributes[attrName];
      } else if (attrName === "style") {
        Object.assign(element.style, attributes[attrName]);
      } else {
        element.setAttribute(attrName, attributes[attrName]);
      }
    }
  }

  if (children) {
    for (let child of children) {
      if (typeof child === "string") {
        element.appendChild(document.createTextNode(child));
      } else if (child instanceof Node) {
        element.appendChild(child);
      } else if (child && child.children) {
        element.appendChild(createElement(child.type, child.attributes, ...child.children));
      }
    }
  }

  return element;
}
