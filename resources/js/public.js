import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/modal';

document.querySelectorAll('.form-group').forEach((group) => {
    const err = group.querySelector(':scope > .text-danger');
    if (err && err.textContent.trim()) {
        const field = group.querySelector('input, select, textarea');
        if (field) field.classList.add('is-invalid');
    }
});
