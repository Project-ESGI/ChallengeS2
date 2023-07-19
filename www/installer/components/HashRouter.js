import Component from "./Component.js";
import DomRenderer from '../core/DomRenderer.js';

export function HashLink(title, link) {
  return {
    type: "a",
    attributes: {
      href: "#" + link,
    },
    children: [title],
  };
}

export default class HashRouter extends Component {
  shouldUpdate(newProps, oldProps) {
    return (
        JSON.stringify(newProps.routes) !== JSON.stringify(oldProps.routes) ||
        newProps.rootElement !== oldProps.rootElement
    );
  }

  display(newProps) {
    const shouldUpdate = this.shouldUpdate(newProps, this.props);
    this.props = newProps;

    if (shouldUpdate) {
      const { routes, rootElement } = this.props;
      const pathname = location.hash.slice(1);
      rootElement.appendChild(DomRenderer(routes[pathname]()));

      window.onhashchange = function () {
        const pathname = location.hash.slice(1);
        rootElement.replaceChild(
            DomRenderer(routes[pathname]()),
            rootElement.childNodes[0]
        );
      };
    }
  }
}
