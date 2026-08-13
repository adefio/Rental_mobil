<template>
    <div class="row g-3 chart-layout">
        <div class="col-lg-8">
            <div class="row g-3 chart-stack h-100">
                <div v-for="chart in chartsStack" :key="chart.key" class="col-12 d-flex">
                    <div class="chart-box w-100">
                        <div class="chart-box-head">
                            <div class="chart-box-title">{{ chart.title }}</div>
                            <div class="chart-box-sub">{{ chart.subtitle }}</div>
                        </div>
                        <div class="chart-container">
                            <canvas
                                v-if="!isEmpty(chart.key)"
                                :ref="'canvas-' + chart.key"
                                :aria-label="'Grafik pendapatan ' + chart.title"
                            ></canvas>
                            <div v-else class="chart-empty">
                                <svg class="icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
                                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
                                    <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
                                </svg>
                                <div>Belum ada pendapatan</div>
                            </div>
                        </div>
                        <div class="chart-box-foot">
                            Total: <strong>{{ compactRupiah(totalOf(chart.key)) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 chart-col-tall">
            <div class="chart-box chart-box-tall w-100">
                <div class="chart-box-head">
                    <div class="chart-box-title">{{ chartTall.title }}</div>
                    <div class="chart-box-sub">{{ chartTall.subtitle }}</div>
                </div>
                <div class="chart-container">
                    <canvas
                        v-if="!isEmpty(chartTall.key)"
                        :ref="'canvas-' + chartTall.key"
                        :aria-label="'Grafik pendapatan ' + chartTall.title"
                    ></canvas>
                    <div v-else class="chart-empty">
                        <svg class="icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
                            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
                            <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
                        </svg>
                        <div>Belum ada pendapatan</div>
                    </div>
                </div>
                <div class="chart-box-foot">
                    Total: <strong>{{ compactRupiah(totalOf(chartTall.key)) }}</strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
} from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend);

export default {
    name: 'RevenueChart',
    props: {
        series: { type: Object, default: () => ({ harian: [], bulanan: [], tahunan: [] }) },
    },
    data() {
        return {
            instances: {},
            chartsStack: [
                { key: 'harian', title: 'Per Hari', subtitle: '7 hari terakhir' },
                { key: 'tahunan', title: 'Per Tahun', subtitle: '5 tahun terakhir' },
            ],
            chartTall: { key: 'bulanan', title: 'Per Bulan', subtitle: '6 bulan terakhir' },
        };
    },
    mounted() {
        this.ensureChart(this.chartTall);
        this.chartsStack.forEach((chart) => this.ensureChart(chart));
    },
    methods: {
        ensureChart(chart) {
            if (this.isEmpty(chart.key) || this.instances[chart.key]) return;
            const data = this.series[chart.key] || [];
            this.instances[chart.key] = new Chart(this.$refs['canvas-' + chart.key], {
                type: 'bar',
                data: {
                    labels: data.map((item) => item.label),
                    datasets: [
                        {
                            label: 'Pendapatan',
                            data: data.map((item) => item.total),
                            backgroundColor: this.barGradient,
                            borderColor: '#4f46e5',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 34,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (context) => `Pendapatan: Rp ${Number(context.raw).toLocaleString('id-ID')}`,
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#eef2f7' },
                            ticks: {
                                maxTicksLimit: 5,
                                callback: (value) => this.compactRupiah(value),
                            },
                        },
                        x: {
                            grid: { display: false },
                        },
                    },
                },
            });
        },
        isEmpty(key) {
            return (this.series[key] || []).reduce((sum, item) => sum + item.total, 0) === 0;
        },
        totalOf(key) {
            return (this.series[key] || []).reduce((sum, item) => sum + item.total, 0);
        },
        compactRupiah(value) {
            const abs = Math.abs(value);
            if (abs >= 1e9) {
                return `Rp${(value / 1e9).toLocaleString('id-ID', { maximumFractionDigits: 1 })} M`;
            }
            if (abs >= 1e6) {
                return `Rp${(value / 1e6).toLocaleString('id-ID', { maximumFractionDigits: 1 })} jt`;
            }
            if (abs >= 1e3) {
                return `Rp${(value / 1e3).toLocaleString('id-ID', { maximumFractionDigits: 0 })} rb`;
            }
            return `Rp${value}`;
        },
        barGradient(context) {
            const { ctx, chartArea } = context.chart;
            if (!chartArea) return 'rgba(99, 102, 241, 0.8)';
            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
            gradient.addColorStop(0, '#6366f1');
            gradient.addColorStop(1, '#8b5cf6');
            return gradient;
        },
    },
    beforeUnmount() {
        Object.values(this.instances).forEach((chart) => {
            if (chart) chart.destroy();
        });
    },
};
</script>
