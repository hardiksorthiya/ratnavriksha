// Product form: category checkbox dropdown
(() => {
    const root = document.querySelector('[data-category-multiselect]');
    if (!root) {
        return;
    }

    const toggle = root.querySelector('[data-category-toggle]');
    const menu = root.querySelector('[data-category-menu]');
    const label = root.querySelector('[data-category-label]');
    const checkboxes = root.querySelectorAll('input[type="checkbox"][name="category_ids[]"]');

    const updateLabel = () => {
        if (!label) {
            return;
        }

        const selected = Array.from(checkboxes).filter((cb) => cb.checked);
        const placeholder = checkboxes.length ? 'Select categories...' : 'No categories available';

        if (selected.length === 0) {
            label.textContent = placeholder;
            return;
        }

        if (selected.length === 1) {
            label.textContent = selected[0].dataset.categoryName || selected[0].value;
            return;
        }

        label.textContent = selected
            .map((cb) => cb.dataset.categoryName || cb.value)
            .join(', ');
    };

    const setOpen = (open) => {
        if (!toggle || !menu) {
            return;
        }

        root.classList.toggle('is-open', open);
        menu.hidden = !open;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    if (toggle && menu) {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            if (!checkboxes.length) {
                return;
            }
            setOpen(menu.hidden);
        });

        document.addEventListener('click', (e) => {
            if (!root.contains(e.target)) {
                setOpen(false);
            }
        });

        menu.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    checkboxes.forEach((cb) => {
        cb.addEventListener('change', updateLabel);
    });

    updateLabel();
})();

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