<template>
    <component
        :is="to ? 'a' : 'div'"
        :href="to || undefined"
        class="card stat-card"
        :class="[variant, { 'stat-link': to }]"
    >
        <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon">
                <svg class="icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <g v-html="iconPaths[icon] || iconPaths.car"></g>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="stat-value" :class="{ 'stat-value-sm': isLongValue }">{{ value }}</div>
                <div class="stat-label">{{ label }}</div>
            </div>
        </div>
    </component>
</template>

<script>
export default {
    name: 'StatCard',
    props: {
        label: { type: String, required: true },
        value: { type: [String, Number], required: true },
        icon: { type: String, default: 'car' },
        variant: { type: String, default: 'stat-tersedia' },
        to: { type: String, default: '' },
    },
    data() {
        return {
            iconPaths: {
                car: '<path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>',
                check: '<path d="M20 6 9 17l-5-5"/>',
                key: '<circle cx="7.5" cy="15.5" r="5.5"/><path d="m21 2-9.6 9.6"/><path d="m15.5 7.5 3 3L22 7l-3-3"/>',
                users: '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                clipboard: '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>',
                'check-circle': '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>',
                refresh: '<path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/>',
                wallet: '<path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>',
            },
        };
    },
    computed: {
        isLongValue() {
            return String(this.value).length > 13;
        },
    },
};
</script>
