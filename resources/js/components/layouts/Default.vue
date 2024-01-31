<template>

    <Nav />

    <router-view />

    <Footer />


</template>

<script>
    import Nav from '../partials/Nav.vue';
    import Footer from '../partials/Footer.vue';
    export default {
        components: {
            Footer,
            Nav,
        },
    };
</script>
