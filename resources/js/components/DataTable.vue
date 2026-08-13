<template>
    <div class="card page-card">
        <div class="card-header d-flex flex-wrap align-items-center gap-2 justify-content-between">
            <span class="d-inline-flex align-items-center gap-2">
                <span class="fw-semibold">{{ title }}</span>
                <span v-if="pagination.total > 0" class="text-muted small fw-normal">
                    {{ filteredRows.length }} dari {{ pagination.total }} data
                </span>
            </span>
                <div class="d-flex align-items-center gap-2">
                    <div class="position-relative">
                        <span class="search-icon">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </span>
                        <input
                            type="text"
                            class="form-control form-control-sm search-input ps-4"
                            placeholder="Cari..."
                            aria-label="Cari data"
                            v-model="search"
                        />
                    </div>
                    <a v-if="createUrl" :href="createUrl" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="M12 5v14"></path>
                        </svg>
                        {{ createLabel }}
                    </a>
                </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th v-for="col in visibleColumns" :key="col.key">{{ col.label }}</th>
                            <th v-if="actions || editRoute || deleteRoute" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, i) in filteredRows" :key="i">
                            <td v-for="col in visibleColumns" :key="col.key">
                                <template v-if="col.type === 'currency'">
                                    {{ formatRupiah(row[col.key]) }}
                                </template>
                                <template v-else-if="col.type === 'image'">
                                    <img
                                        v-if="Array.isArray(row[col.key]) && row[col.key].length"
                                        :src="imageUrl(row[col.key][0])"
                                        alt="Gambar"
                                        class="data-table-thumb"
                                        loading="lazy"
                                        decoding="async"
                                    />
                                    <span v-else class="text-muted">-</span>
                                </template>
                                <template v-else-if="col.type === 'badge'">
                                    <span
                                        class="badge badge-status"
                                        :class="badgeClass(row[col.key], col.badgeMap || {})"
                                    >{{ badgeLabel(row[col.key], col.badgeMap || {}) }}</span>
                                </template>
                                <template v-else-if="col.type === 'date'">
                                    {{ formatDate(row[col.key]) }}
                                </template>
                                <template v-else-if="col.type === 'datetime'">
                                    {{ formatDateTime(row[col.key]) }}
                                </template>
                                <template v-else-if="col.accessor">
                                    {{ accessorValue(row, col.accessor) }}
                                </template>
                                <template v-else>
                                    {{ row[col.key] }}
                                </template>
                            </td>
                            <td v-if="actions || editRoute || deleteRoute" class="text-end text-nowrap">
                                <a
                                    v-if="editRoute"
                                    :href="editRoute.replace('__ID__', row.id)"
                                    class="btn btn-sm btn-primary me-1 d-inline-flex align-items-center gap-1"
                                    aria-label="Edit data"
                                >
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                        <path d="m15 5 4 4"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form
                                    v-if="deleteRoute"
                                    :action="deleteRoute.replace('__ID__', row.id)"
                                    method="POST"
                                    class="d-inline"
                                    @submit="confirmDelete"
                                >
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <input type="hidden" name="_token" :value="csrfToken" />
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1" aria-label="Hapus data">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr v-if="filteredRows.length === 0">
                            <td :colspan="columnCount" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon mx-auto">
                                        <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                            <circle cx="12" cy="13" r="3"></circle>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold mt-3 mb-1">Tidak ada data</h5>
                                    <p class="text-muted small mb-0">Data yang Anda cari tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="pagination.total > pagination.per_page" class="card-footer d-flex flex-wrap align-items-center justify-content-between gap-2">
            <span class="text-muted small">{{ shownFrom }}–{{ shownTo }} dari {{ pagination.total }} data</span>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                    <a class="page-link" :href="pagination.prev_url || '#'" aria-label="Halaman sebelumnya">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li
                    v-for="page in pagination.last_page"
                    :key="page"
                    class="page-item"
                    :class="{ active: page === pagination.current_page }"
                >
                    <a class="page-link" :href="paginationHref(page)" :aria-label="'Halaman ' + page">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                    <a class="page-link" :href="pagination.next_url || '#'" aria-label="Halaman berikutnya">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DataTable',
    props: {
        title: { type: String, default: 'Data' },
        rows: { type: Array, default: () => [] },
        columns: { type: Array, default: () => [] },
        createUrl: { type: String, default: '' },
        createLabel: { type: String, default: 'Tambah' },
        editRoute: { type: String, default: '' },
        deleteRoute: { type: String, default: '' },
        actions: { type: Boolean, default: false },
        pagination: {
            type: Object,
            default: () => ({ total: 0, per_page: 999999, current_page: 1, last_page: 1, next_url: null, prev_url: null }),
        },
        paginationPath: { type: String, default: '' },
    },
    data() {
        return {
            search: '',
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.content || '',
        };
    },
    computed: {
        visibleColumns() {
            return (this.columns || []).filter((col) => col.key !== '__hidden');
        },
        filteredRows() {
            const term = this.search.trim().toLowerCase();
            if (!term) return this.rows;
            return this.rows.filter((row) => {
                return this.visibleColumns.some((col) => {
                    const val = col.accessor
                        ? this.accessorValue(row, col.accessor)
                        : row[col.key];
                    return val !== undefined && val !== null && String(val).toLowerCase().includes(term);
                });
            });
        },
        columnCount() {
            return this.visibleColumns.length + ((this.actions || this.editRoute || this.deleteRoute) ? 1 : 0);
        },
        shownFrom() {
            if (!this.pagination.total) return 0;
            return (this.pagination.current_page - 1) * this.pagination.per_page + 1;
        },
        shownTo() {
            return Math.min(this.pagination.current_page * this.pagination.per_page, this.pagination.total);
        },
    },
    methods: {
        formatRupiah(value) {
            const num = Number(value || 0);
            return 'Rp ' + num.toLocaleString('id-ID');
        },
        imageUrl(path) {
            return '/storage/' + path;
        },
        formatDate(value) {
            if (!value) return '-';
            const date = new Date(value);
            if (isNaN(date)) return value;
            return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
        },
        formatDateTime(value) {
            if (!value) return '-';
            const date = new Date(value);
            if (isNaN(date)) return value;
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) +
                ', ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        },
        accessorValue(row, accessor) {
            return (accessor || []).reduce((acc, key) => (acc ? acc[key] : null), row);
        },
        badgeClass(value, map) {
            const entry = Object.entries(map).find(([k, v]) => v.value === value);
            return entry ? entry[1].class : 'bg-secondary';
        },
        badgeLabel(value, map) {
            const entry = Object.entries(map).find(([k, v]) => v.value === value);
            return entry ? entry[1].label : value;
        },
        confirmDelete(e) {
            if (!window.confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        },
        paginationHref(page) {
            if (!this.paginationPath) return '#';
            const sep = this.paginationPath.includes('?') ? '&' : '?';
            return this.paginationPath + sep + 'page=' + page;
        },
    },
};
</script>
