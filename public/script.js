(() => {
  document.addEventListener('DOMContentLoaded', () => {
    requestAnimationFrame(() => {
      [...document.querySelectorAll('altcha-widget')].forEach((el) => {
        // add the name attr to fix input validation exception
        const altcha = el.querySelector('.altcha')
        const checkbox = el.querySelector('input[type="checkbox"]')
        checkbox?.setAttribute('name', '');
        const form = el.closest('form');
        if (form && checkbox && altcha?.getAttribute('data-state') !== 'code') {
          form.addEventListener('submit', (ev) => {
            if (altcha?.getAttribute('data-state') !== 'code' && !checkbox.reportValidity()) {
              ev.preventDefault();
              ev.stopPropagation();
            }
          }, true);
        }
      });

      // Removes duplicate widgets when manipulated with JS such as elementor popups and wpdiscuz
      const observer = new MutationObserver((mutations) => {
        [...document.querySelectorAll('altcha-widget')].forEach((el) => {
          const altchas = [...el.querySelectorAll('.altcha')];
          if (altchas.length > 1) {
            altchas.slice(0, -1).forEach((altcha) => altcha.remove());
          }
        })
      });
      observer.observe(document.body, {
        childList: true,
        subtree: true,
      });
    });
  });
})();
