(() => {
    const container = document.querySelector('[data-toast-container]');

    if (!container) {
        return;
    }

    const dismissToast = (toast) => {
        if (!toast.isConnected || toast.classList.contains('is-leaving')) {
            return;
        }

        toast.classList.add('is-leaving');
        window.setTimeout(() => toast.remove(), 180);
    };

    const showToast = (message, type = 'info', duration = 6000) => {
        const toast = document.createElement('div');
        const text = document.createElement('p');
        const dismissButton = document.createElement('button');

        toast.className = 'toast';
        toast.dataset.toastType = ['success', 'warning', 'error', 'info'].includes(type) ? type : 'info';
        toast.setAttribute('role', toast.dataset.toastType === 'error' ? 'alert' : 'status');

        text.className = 'toast-message';
        text.textContent = message;

        dismissButton.className = 'toast-dismiss';
        dismissButton.type = 'button';
        dismissButton.setAttribute('aria-label', 'Tutup notifikasi');
        dismissButton.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m18 6-12 12M6 6l12 12"/></svg>';
        dismissButton.addEventListener('click', () => dismissToast(toast));

        toast.append(text, dismissButton);
        container.append(toast);

        if (duration > 0) {
            window.setTimeout(() => dismissToast(toast), duration);
        }

        return toast;
    };

    container.querySelectorAll('[data-toast]').forEach((toast) => {
        const message = toast.dataset.toastMessage;
        const type = toast.dataset.toastType;

        if (message) {
            showToast(message, type);
        }

        toast.remove();
    });

    window.showToast = showToast;
})();
