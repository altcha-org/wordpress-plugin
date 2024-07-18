(() => {
  document.addEventListener('DOMContentLoaded', () => {
    requestAnimationFrame(() => {
      if ('ALTCHA_WIDGET_ATTRS' in window && typeof window['ALTCHA_WIDGET_ATTRS'] === 'object') {
        [...document.querySelectorAll('altcha-widget')].forEach((el) => {
          if (typeof el['configure'] === 'function' && !el.getAttribute('challengeurl')) {
            el.configure(window['ALTCHA_WIDGET_ATTRS']);
          }
        });
      }
    });
  });
})();
