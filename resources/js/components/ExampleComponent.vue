<template>
    <div class="card">
        <div class="card-header">
            {{ title }}
        </div>
        <div class="card-body">
            <p>Ini komponen Vue yang di-mount dari halaman Blade.</p>
            <button class="btn btn-primary" @click="count++">
                Tombol diklik {{ count }} kali
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ExampleComponent',
    props: {
        title: {
            type: String,
            default: 'Komponen Vue',
        },
    },
    data() {
        return {
            count: 0,
        };
    },
};
</script>
