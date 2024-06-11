(() => {
  document.addEventListener('DOMContentLoaded', () => {
    function onApiChange(api) {
      [...document.querySelectorAll('[data-spamfilter]')].forEach((el) => {
        el.disabled = api === 'selfhosted';
      });
    }
    const apiEl = document.querySelector('#altcha_api');
    if (apiEl) {
      apiEl.addEventListener('change', (ev) => onApiChange(ev.target.value));
      onApiChange(apiEl.value);
    }
  });
})();