import routes from "./routes.js";
import MiniReact, { createElement, render } from "./MiniReact.js";
import Component from "./components/Component.js";

const rootElement = document.getElementById("root");
const routingMode = "browser"; // Change to "hash" if you want to use HashRouter

MiniReact(routes, rootElement, routingMode);

// Example usage
const exampleComponent = createElement("h1", null, "Hello, Mini React!");
render(exampleComponent, rootElement);

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      counter: 0
    };
  }

  componentDidMount() {
    console.log("Component mounted");
  }

  componentDidUpdate(prevProps, prevState) {
    console.log("Component updated");
  }

  handleClick() {
    this.setState({ counter: this.state.counter + 1 });
  }

  render() {
    return createElement(
        "div", // Utiliser un nom d'élément HTML valide ici
        null,
        createElement("h2", null, "Counter: ", this.state.counter),
        createElement("button", { onClick: () => this.handleClick() }, "Increment")
    );
  }
}

const app = createElement(App, null); // Ne pas oublier de remplacer App par le nom d'un élément valide si vous souhaitez créer un élément ici
render(app, rootElement);
