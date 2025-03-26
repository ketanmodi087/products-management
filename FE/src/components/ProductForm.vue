<template>
    <div v-if="show" class="modal-overlay">
        <div class="modal-content">
            <h2>{{ isEditing ? 'Edit Product' : 'Add New Product' }}</h2>
            <form @submit.prevent="handleSubmit">
                <div class="form-group">
                    <label>Product Name</label>
                    <input 
                        v-model="formData.name" 
                        type="text" 
                        :class="{ 'error': errors.name }"
                        @input="validateField('name')"
                    />
                    <span v-if="errors.name" class="error-message">{{ errors.name }}</span>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input 
                        v-model="formData.price" 
                        type="number" 
                        step="0.01" 
                        min="0"
                        :class="{ 'error': errors.price }"
                        @input="validateField('price')"
                    />
                    <span v-if="errors.price" class="error-message">{{ errors.price }}</span>
                </div>
                <div class="button-group">
                    <button type="button" @click="closeDialog" class="cancel-btn">Cancel</button>
                    <button type="submit" class="submit-btn" :disabled="!isFormValid">
                        {{ isEditing ? 'Update' : 'Add' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref, computed, watch } from 'vue';

export default {
    props: {
        show: {
            type: Boolean,
            required: true
        },
        product: {
            type: Object,
            default: () => null
        }
    },
    emits: ['close', 'submit'],
    setup(props, { emit }) {
        const formData = ref({
            name: '',
            price: ''
        });

        const errors = ref({
            name: '',
            price: ''
        });

        const isEditing = computed(() => {
            return props.product && typeof props.product === 'object' && props.product !== null;
        });

        const isFormValid = computed(() => {
            return formData.value.name.trim() !== '' && 
                   formData.value.price > 0 && 
                   !errors.value.name && 
                   !errors.value.price;
        });

        const validateField = (field) => {
            switch (field) {
                case 'name':
                    if (!formData.value.name.trim()) {
                        errors.value.name = 'Product name is required';
                    } else if (formData.value.name.length < 3) {
                        errors.value.name = 'Product name must be at least 3 characters';
                    } else {
                        errors.value.name = '';
                    }
                    break;
                case 'price':
                    if (!formData.value.price) {
                        errors.value.price = 'Price is required';
                    } else if (formData.value.price <= 0) {
                        errors.value.price = 'Price must be greater than 0';
                    } else {
                        errors.value.price = '';
                    }
                    break;
            }
        };

        const resetForm = () => {
            formData.value = {
                name: '',
                price: ''
            };
            errors.value = {
                name: '',
                price: ''
            };
        };

        const closeDialog = () => {
            resetForm();
            emit('close');
        };

        watch(() => props.product, (newProduct) => {
            if (newProduct) {
                formData.value = {
                    name: newProduct.name || '',
                    price: newProduct.price || ''
                };
                validateField('name');
                validateField('price');
            } else {
                resetForm();
            }
        }, { immediate: true });

        watch(() => props.show, (newValue) => {
            if (newValue) {
                if (isEditing.value && props.product) {
                    formData.value = {
                        name: props.product.name || '',
                        price: props.product.price || ''
                    };
                    validateField('name');
                    validateField('price');
                } else {
                    resetForm();
                }
            }
        });

        const handleSubmit = async () => {
            // Validate all fields before submission
            validateField('name');
            validateField('price');

            if (!isFormValid.value) {
                emit('error', 'Please fix the errors before submitting');
                return;
            }

            try {
                const url = isEditing.value
                    ? `${import.meta.env.VITE_APP_API_URL}/products/${props.product.id}`
                    : `${import.meta.env.VITE_APP_API_URL}/products`;
                
                const method = isEditing.value ? 'PUT' : 'POST';
                
                const response = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData.value)
                });

                if (!response.ok) {
                    throw new Error('Failed to save product');
                }

                // First emit success message
                emit('success', isEditing.value ? 'Product updated successfully' : 'Product added successfully');
                // Then emit submit event with isNewProduct flag
                emit('submit', !isEditing.value);
                // Finally close the dialog
                closeDialog();
            } catch (error) {
                console.error('Error saving product:', error);
                emit('error', 'Failed to save product. Please try again.');
            }
        };

        return {
            formData,
            errors,
            isEditing,
            isFormValid,
            handleSubmit,
            closeDialog,
            validateField
        };
    }
};
</script>

<style lang="scss">
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
        color: $text-primary;
    }
}

.form-group {
    margin-bottom: $spacing-md;

    label {
        display: block;
        margin-bottom: $spacing-sm;
        font-weight: 500;
        color: $text-secondary;
    }

    input {
        @include input-base;
        
        &.error {
            border-color: #f44336;
            &:focus {
                border-color: #f44336;
                box-shadow: 0 0 0 2px rgba(244, 67, 54, 0.2);
            }
        }
    }

    .error-message {
        color: #f44336;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }
}

.button-group {
    display: flex;
    justify-content: flex-end;
    gap: $spacing-md;
    margin-top: $spacing-lg;

    .cancel-btn {
        @extend .button-secondary;
    }

    .submit-btn {
        @extend .button-primary;
        
        &:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    }
}
</style>