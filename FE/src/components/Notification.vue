<template>
    <div v-if="show" :class="['notification', type]">
        {{ message }}
    </div>
</template>

<script>
import { ref, watch } from 'vue';

export default {
    props: {
        show: {
            type: Boolean,
            default: false
        },
        message: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: 'success',
            validator: (value) => ['success', 'error'].includes(value)
        },
        duration: {
            type: Number,
            default: 3000
        }
    },
    emits: ['close'],
    setup(props, { emit }) {
        const timeout = ref(null);

        const startTimer = () => {
            if (props.duration > 0) {
                timeout.value = setTimeout(() => {
                    emit('close');
                }, props.duration);
            }
        };

        watch(() => props.show, (newValue) => {
            if (newValue) {
                startTimer();
            }
        });

        return {};
    }
};
</script>

<style lang="scss">
@use '../assets/common-styles.scss' as *;

.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: $spacing-md $spacing-lg;
    border-radius: $radius-md;
    color: $white;
    font-weight: 500;
    z-index: 1100;
    animation: slideIn 0.3s ease-out;
    box-shadow: $shadow-md;

    &.success {
        background-color: $success-bg;
        color: $success-color;
    }

    &.error {
        background-color: $danger-bg;
        color: $danger-color;
    }
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style> 