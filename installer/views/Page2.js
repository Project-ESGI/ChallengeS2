import { BrowserLink } from "../components/BrowserRouter.js";
import { LinkComponent } from "../components/Link.js";
import Button from "../components/Button.js";
import Compteur from "../components/Compteur.js";
import { createElement } from "../MiniReact.js";

export default function Page2() {
  return createElement("div", null, [
    BrowserLink("Page 1", "/page1"),
    LinkComponent("Index", "/", () => {}),
    LinkComponent("Page 1", "/articles/page1", () => {}),
    createElement("h1", null, ["Coucou"]),
    createElement("h2", null, ["Bonsoir"]),
    createElement("h3", null, ["Tout le monde"]),
    createElement("p", null, ["Ici le javascript"]),
    Button({
      title: "Coucou button",
      style: {
        backgroundColor: "blue",
        color: "white",
      },
      onClick: () => alert("coucou"),
    }),
    Compteur({ initialValue: 10 }),
  ]);
}
