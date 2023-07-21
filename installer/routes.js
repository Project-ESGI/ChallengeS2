import Page1 from "./views/Page1.js";
import Page2 from "./views/Page2.js";
import Page3 from "./views/Page3.js";
import { createElement } from "./MiniReact.js";

const routes = {
  "": () => createElement(Page3),
  "/page1": () => createElement(Page1),
  "/page2": () => createElement(Page2),
  "/articles": () => createElement(Page1),
};

export default routes;
