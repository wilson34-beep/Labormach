const confirmDialog = (() => {
  let modal;
  let title;
  let message;
  let cancelButton;
  let confirmButton;
  let onConfirm = null;

  const close = () => {
    if (!modal) {
      return;
    }
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    onConfirm = null;
  };

  const ensureModal = () => {
    if (modal) {
      return;
    }

    modal = document.createElement('div');
    modal.className = 'confirm-modal';
    modal.setAttribute('aria-hidden', 'true');
    modal.innerHTML = `
      <div class="confirm-backdrop" data-confirm-cancel></div>
      <section class="confirm-box" role="dialog" aria-modal="true" aria-labelledby="confirmModalTitle">
        <button type="button" class="confirm-close" data-confirm-cancel aria-label="Close confirmation">&times;</button>
        <span class="confirm-icon" aria-hidden="true">!</span>
        <h2 id="confirmModalTitle"></h2>
        <p></p>
        <div class="actions">
          <button type="button" class="mini" data-confirm-cancel>Cancel</button>
          <button type="button" class="mini danger" data-confirm-ok>Delete</button>
        </div>
      </section>
    `;
    document.body.appendChild(modal);

    title = modal.querySelector('h2');
    message = modal.querySelector('p');
    cancelButton = modal.querySelector('[data-confirm-cancel].mini');
    confirmButton = modal.querySelector('[data-confirm-ok]');

    modal.querySelectorAll('[data-confirm-cancel]').forEach((control) => {
      control.addEventListener('click', close);
    });
    confirmButton.addEventListener('click', () => {
      const callback = onConfirm;
      close();
      if (callback) {
        callback();
      }
    });
  };

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && modal?.classList.contains('is-open')) {
      close();
    }
  });

  return {
    open(options) {
      ensureModal();
      title.textContent = options.title || 'Confirm Action';
      message.textContent = options.message || 'Continue?';
      confirmButton.textContent = options.action || 'Continue';
      onConfirm = options.onConfirm;
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
      cancelButton.focus();
    },
  };
})();

document.querySelectorAll('[data-confirm]').forEach((button) => {
  button.addEventListener('click', (event) => {
    if (button.dataset.confirmed === 'true') {
      delete button.dataset.confirmed;
      return;
    }

    event.preventDefault();
    confirmDialog.open({
      title: button.dataset.confirmTitle,
      message: button.dataset.confirm,
      action: button.dataset.confirmAction,
      onConfirm: () => {
        if (button instanceof HTMLAnchorElement && button.href) {
          window.location.href = button.href;
          return;
        }

        if (button.form) {
          button.dataset.confirmed = 'true';
          if (button.form.requestSubmit) {
            button.form.requestSubmit(button);
          } else {
            if (button.name) {
              const hidden = document.createElement('input');
              hidden.type = 'hidden';
              hidden.name = button.name;
              hidden.value = button.value;
              button.form.appendChild(hidden);
            }
            button.form.submit();
          }
          return;
        }

        button.dataset.confirmed = 'true';
        button.click();
      },
    });
  });
});

document.querySelectorAll('.alert.success').forEach((alert) => {
  window.setTimeout(() => {
    alert.classList.add('is-hiding');
    window.setTimeout(() => alert.remove(), 260);
  }, 3500);
});

document.querySelectorAll('[data-account-toggle]').forEach((button) => {
  const menu = button.closest('.account-menu');
  if (!menu) {
    return;
  }

  button.addEventListener('click', (event) => {
    event.stopPropagation();
    const shouldOpen = !menu.classList.contains('is-open');
    document.querySelectorAll('.account-menu.is-open').forEach((openMenu) => {
      openMenu.classList.remove('is-open');
      openMenu.querySelector('[data-account-toggle]')?.setAttribute('aria-expanded', 'false');
    });
    menu.classList.toggle('is-open', shouldOpen);
    button.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
  });
});

document.addEventListener('click', (event) => {
  document.querySelectorAll('.account-menu.is-open').forEach((menu) => {
    if (!menu.contains(event.target)) {
      menu.classList.remove('is-open');
      menu.querySelector('[data-account-toggle]')?.setAttribute('aria-expanded', 'false');
    }
  });
});

document.addEventListener('keydown', (event) => {
  if (event.key !== 'Escape') {
    return;
  }
  document.querySelectorAll('.account-menu.is-open').forEach((menu) => {
    menu.classList.remove('is-open');
    menu.querySelector('[data-account-toggle]')?.setAttribute('aria-expanded', 'false');
  });
});

document.querySelectorAll('[data-toggle-password]').forEach((button) => {
  button.addEventListener('click', () => {
    const targetIds = (button.dataset.passwordTargets || '').split(/\s+/).filter(Boolean);
    const fields = targetIds
      .map((id) => document.getElementById(id))
      .filter(Boolean);
    const nearbyField = button.closest('.password-field')?.querySelector('input');

    if (!fields.length && nearbyField) {
      fields.push(nearbyField);
    }
    if (!fields.length) {
      return;
    }

    const shouldShow = fields.some((field) => field.type === 'password');
    fields.forEach((field) => {
      field.type = shouldShow ? 'text' : 'password';
    });
    button.classList.toggle('is-visible', shouldShow);
    button.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');
    button.setAttribute('title', shouldShow ? 'Hide password' : 'Show password');
  });
});
