<template>
    <Modal title="Konfirmasi" @close="$emit('close')">
        <slot></slot>
    </Modal>
</template>

<script>

import Modal from '../partials/Modal';

export default {
    components: {
        Modal,
    },
}
</script>

<style>

</style>
