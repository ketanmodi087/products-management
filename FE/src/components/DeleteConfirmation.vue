<template>
    <div v-if="show" class="modal-overlay">
        <div class="modal-content">
            <h2>Delete Product</h2>
            <div class="confirmation-message">
                <p>Are you sure you want to delete this product?</p>
                <p class="product-name">{{ product.name }}</p>
            </div>
            <div class="button-group">
                <button @click="handleCancel" class="cancel-btn">No, Cancel</button>
                <button @click="handleConfirm" class="delete-btn">Yes, Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true
        },
        product: {
            type: Object,
            required: true
        }
    },
    emits: ['close', 'confirm'],
    setup(props, { emit }) {
        const handleConfirm = () => {
            emit('confirm');
        };

        const handleCancel = () => {
            emit('close');
        };

        return {
            handleConfirm,
            handleCancel
        };
    }
};
</script>

<style lang="scss" scoped>
@use '../assets/common-styles.scss' as *;

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: $white;
    padding: $spacing-lg;
    border-radius: $radius-md;
    width: 100%;
    max-width: 400px;
    box-shadow: $shadow-md;

    h2 {
        font-size: $font-size-xl;
        font-weight: 600;
        margin-bottom: $spacing-lg;
        color: $danger-color;
    }
}

.confirmation-message {
    margin-bottom: $spacing-lg;
    
    p {
        margin-bottom: $spacing-sm;
        color: $text-primary;
    }

    .product-name {
        font-weight: 600;
        color: #1f2937;
        font-size: $font-size-lg;
    }
}

.button-group {
    display: flex;
    justify-content: center;
    gap: $spacing-md;

    .cancel-btn {
        @extend .button-secondary;
    }

    .delete-btn {
        @extend .button-primary;
        background-color: #dc2626;
        border-color: #dc2626;

        &:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
        }
    }
}
</style> 