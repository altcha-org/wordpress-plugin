(() => {
  document.addEventListener('DOMContentLoaded', () => {
    requestAnimationFrame(() => {
      [...document.querySelectorAll('altcha-widget')].forEach((el) => {
        // add the name attr to fix input validation exception
        const checkbox = el.querySelector('input[type="checkbox"]')
        checkbox?.setAttribute('name', '');
        const form = el.closest('form');
        if (form && checkbox) {
          form.addEventListener('submit', (ev) => {
            if (!checkbox.reportValidity()) {
              ev.preventDefault();
              ev.stopPropagation();
            }
          }, true);
        }
      });
    });
  });
})();
