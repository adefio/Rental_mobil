import './bootstrap';

import { createApp } from 'vue';
import DashboardStats from './components/DashboardStats.vue';
import DataTable from './components/DataTable.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import RevenueChart from './components/RevenueChart.vue';

const components = {
    DashboardStats,
    DataTable,
    ExampleComponent,
    RevenueChart,
};

document.querySelectorAll('[data-vue]').forEach((el) => {
    const name = el.getAttribute('data-vue');
    if (components[name]) {
        const props = {};
        el.getAttributeNames()
            .filter((attr) => attr.startsWith('data-') && attr !== 'data-vue')
            .forEach((attr) => {
                const key = attr.replace(/^data-/, '');
                const value = el.getAttribute(attr);
                props[key] = (value.startsWith('{') || value.startsWith('[')) ? JSON.parse(value) : value;
            });

        createApp(components[name], props).mount(el);
    }
});

const fotoInput = document.getElementById('foto_profil');
if (fotoInput) {
    fotoInput.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;

        const img = document.getElementById('avatarPreview');
        const initial = document.getElementById('avatarInitial');
        const help = document.getElementById('fotoHelp');

        if (!img || !initial) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const check = new Image();
            check.onload = () => {
                if (check.naturalWidth < 400 || check.naturalHeight < 400) {
                    alert('Foto terlalu kecil (minimal 400 x 400 piksel). Pilih foto yang lebih besar.');
                    fotoInput.value = '';
                    return;
                }
                img.src = e.target.result;
                img.style.display = '';
                initial.style.display = 'none';
                if (help) help.textContent = 'Foto sudah dipilih. Simpan untuk menerapkan perubahan.';
            };
            check.onerror = () => {
                alert('File tidak dapat dibaca sebagai gambar.');
                fotoInput.value = '';
            };
            check.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

document.querySelectorAll('.form-group').forEach((group) => {
    const err = group.querySelector(':scope > .text-danger');
    if (err && err.textContent.trim()) {
        const field = group.querySelector('input, select, textarea');
        if (field) field.classList.add('is-invalid');
    }
});
