(function() {

  // ignore if routing is enabled
  if (dmx.routing) return;

  dmx.config.mapping['a.nav-link:not([href^="#"])'] = 'nav-link';

  dmx.Component('nav-link', {

    init (node) {
      this._stateHandler = this._stateHandler.bind(this);
      window.addEventListener("popstate", this._stateHandler);
      window.addEventListener("pushstate", this._stateHandler);
      window.addEventListener("replacestate", this._stateHandler);
      window.addEventListener('hashchange', this._stateHandler);
      this._stateHandler();
    },

    destroy () {
      window.removeEventListener("popstate", this._stateHandler);
      window.removeEventListener("pushstate", this._stateHandler);
      window.removeEventListener("replacestate", this._stateHandler);
      window.removeEventListener('hashchange', this._stateHandler);
    },

    _stateHandler () {
      const node = this.$node;
      const active = node.href == window.location.href || node.href == window.location.href.split("?")[0].split("#")[0];

      node.classList.toggle('active', active);

      if (node.classList.contains('dropdown-item')) {
        const items = node.parentNode.querySelectorAll('.dropdown-item');
        node.classList.remove('active');

        for (let i = 0; i < items.length; i++) {
          const match = items[i].href == window.location.href || items[i].href == window.location.href.split("?")[0].split("#")[0];
          if (match) {
            items[i].classList.add('active');
            node.classList.add('active');
          } else {
            items[i].classList.remove('active');
          }
        }
      }
    },

  });

})()