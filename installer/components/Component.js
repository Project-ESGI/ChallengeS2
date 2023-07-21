export default class Component {
    shouldUpdate(newProps, oldProps) {
      // Compare les nouvelles et anciennes propriétés pour décider si une mise à jour est nécessaire
      // Renvoie true si une mise à jour est nécessaire, false sinon
      // Implémentez votre logique de comparaison ici
      return JSON.stringify(newProps) !== JSON.stringify(oldProps);
    }
  
    display(newProps) {
      const shouldUpdate = this.shouldUpdate(newProps, this.props);
      this.props = newProps;
  
      if (shouldUpdate) {
        // Appelle la fonction `render` du composant
        const renderedComponent = this.render();
  
        // Si `render` invoque d'autres composants, le composant courant appelle la fonction `display(compProps)` des sous-composants
        if (typeof renderedComponent === 'object' && renderedComponent instanceof Component) {
          renderedComponent.display(renderedComponent.props);
        }
  
        // Ajoute le résultat de `display` au DOM sous le nœud parent
        const parentElement = this.getParentElement();
        parentElement.appendChild(renderedComponent);
      }
    }
  }
  