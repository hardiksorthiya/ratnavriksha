
// toggle sidebar
(() => {
    const body = document.body;
    const sidebarToggleBtn = document.getElementById('sidebarToggle');

    if (!sidebarToggleBtn) {
        return;
    }

    sidebarToggleBtn.addEventListener('click', () => {
        if (window.innerWidth < 992) {
            body.classList.toggle('sidebar-open');
        } else {
            body.classList.toggle('sidebar-collapsed');
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
            body.classList.remove('sidebar-open');
        } else {
            body.classList.remove('sidebar-collapsed');
        }
    });
})();