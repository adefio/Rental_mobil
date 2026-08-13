<template>
    <div>
        <div class="row g-3">
            <div class="col-sm-6 col-xl-3" v-for="card in cards" :key="card.label">
                <StatCard
                    :label="card.label"
                    :value="card.value"
                    :icon="card.icon"
                    :variant="card.variant"
                    :to="card.to"
                />
            </div>
        </div>
    </div>
</template>

<script>
import StatCard from './StatCard.vue';

export default {
    name: 'DashboardStats',
    components: { StatCard },
    props: {
        stats: { type: Object, required: true },
    },
    computed: {
        cards() {
            const s = this.stats;
            return [
                {
                    label: 'Total Mobil',
                    value: s.mobil,
                    icon: 'car',
                    variant: 'stat-tersedia',
                    to: '/mobil',
                },
                {
                    label: 'Total Pengguna',
                    value: s.pengguna,
                    icon: 'users',
                    variant: 'stat-pengguna',
                    to: '/pengguna',
                },
                {
                    label: 'Total Transaksi',
                    value: s.transaksi,
                    icon: 'clipboard',
                    variant: 'stat-lunas',
                    to: '/transaksi',
                },
                {
                    label: 'Pendapatan (Lunas)',
                    value: this.formatRupiah(s.pendapatan),
                    icon: 'wallet',
                    variant: 'stat-pengguna',
                    to: '/transaksi',
                },
            ];
        },
    },
    methods: {
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(value);
        },
    },
};
</script>
