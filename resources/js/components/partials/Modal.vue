<template>
    <transition name="modal">
        <div class="modal__wrapper" @click="$emit('close')">
            <div class="modal-content" @click.stop="">
                <!-- header -->
                <div class="modal-header w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h3 class="modal-title">{{ title }}</h3>
                        <button type="button" class="btn btn-xs p-0 btn-secondary" @click="$emit('close')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- body -->
                <div class="modal-body mb-2" style="font-size:15px !important;">
                    <slot></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        }
    },
    mounted () {
        document.body.addEventListener('keyup', e => {
            if (e.key === 'Escape') this.$emit('close')
        })
    },
    computed: {},
    methods: {}
}
</script>

<style>
/* animations */
.modal-enter,
.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-content,
.modal-leave-active .modal-content {
    transform: scale(1.2);
}

/* modal styles */
.modal__wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    transition: opacity .2s ease;
    right: 0;
    z-index: 998;
    background-color: rgba(0, 0, 0, 0.48);
}

.modal-content {
    position: relative;
    max-width: 600px;
    padding: 20px 18px;
    background-color: #fff;
    border: 1px solid #dcdfe6;
    transition: all .2s ease;
    border-radius: 8px;
    z-index: 999;
    overflow: hidden;
}

@media screen and (min-width: 900px) {
    .modal-content {
        min-width: 500px;
    }
}

.modal-header {
    display: flex;
    align-self: center;
    justify-content: space-between;
    padding-bottom: 20px;
}

.modal-header span {
    font-size: 24px;
}

.modal-header .button-close {
    cursor: pointer;
}

.modal-body {
    text-align: center;
}

.modal-bottom {
    padding-top: 40px;
}

a.another-modal {
    color: #000;
    border-bottom: 1px solid #000;
}

</style>
