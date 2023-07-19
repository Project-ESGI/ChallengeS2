import Component from "./Component.js";

export default class Link extends Component {
  /**
   * @param {object} newProps - Les nouvelles propriétés du composant
   * @param {object} oldProps - Les anciennes propriétés du composant
   * @returns {boolean} - Indique si une mise à jour est nécessaire
   */
  shouldUpdate(newProps, oldProps) {
    return JSON.stringify(newProps) !== JSON.stringify(oldProps);
  }

  /**
   * @param {object} newProps - Les nouvelles propriétés du composant
   */
  display(newProps) {
    const shouldUpdate = this.shouldUpdate(newProps, this.props);
    this.props = newProps;

    if (shouldUpdate) {
      console.log(`Title: ${this.props.title}`);
      console.log(`Link: ${this.props.link}`);
      console.log(`onClick: ${this.props.onClick}`);
    }
  }
}

/**
 * @param {string} title - Le titre du lien
 * @param {string} link - L'URL du lien
 * @param {function} onClick - La fonction de rappel à exécuter lors du clic sur le lien
 * @returns {object} - L'élément de lien formaté
 */
export function LinkComponent(title, link, onClick) {
  const style = {
    color: "cyan",
    textDecoration: "none",
  };
  const events = {};
  if (onClick) {
    events.click = onClick;
  }
  return {
    type: "a",
    attributes: {
      href: link,
      style: style,
    },
    events: events,
    children: [title],
  };
}
