<template>
    <div class="table-container">
        <table class="product-table">
            <thead>
                <tr>
                    <th @click="$emit('sort', 'id')" class="sortable">
                        ID
                        <i class="fas" :class="{
                            'fa-sort': sortBy !== 'id',
                            'fa-sort-up': sortBy === 'id' && sortDirection === 'asc',
                            'fa-sort-down': sortBy === 'id' && sortDirection === 'desc'
                        }"></i>
                    </th>
                    <th @click="$emit('sort', 'name')" class="sortable">
                        Product Name
                        <i class="fas" :class="{
                            'fa-sort': sortBy !== 'name',
                            'fa-sort-up': sortBy === 'name' && sortDirection === 'asc',
                            'fa-sort-down': sortBy === 'name' && sortDirection === 'desc'
                        }"></i>
                    </th>
                    <th @click="$emit('sort', 'price')" class="sortable">
                        Price
                        <i class="fas" :class="{
                            'fa-sort': sortBy !== 'price',
                            'fa-sort-up': sortBy === 'price' && sortDirection === 'asc',
                            'fa-sort-down': sortBy === 'price' && sortDirection === 'desc'
                        }"></i>
                    </th>
                    <th @click="$emit('sort', 'created_at')" class="sortable">
                        Created At
                        <i class="fas" :class="{
                            'fa-sort': sortBy !== 'created_at',
                            'fa-sort-up': sortBy === 'created_at' && sortDirection === 'asc',
                            'fa-sort-down': sortBy === 'created_at' && sortDirection === 'desc'
                        }"></i>
                    </th>
                    <th @click="$emit('sort', 'updated_at')" class="sortable">
                        Updated At
                        <i class="fas" :class="{
                            'fa-sort': sortBy !== 'updated_at',
                            'fa-sort-up': sortBy === 'updated_at' && sortDirection === 'asc',
                            'fa-sort-down': sortBy === 'updated_at' && sortDirection === 'desc'
                        }"></i>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>
                        <span class="price-badge">${{ product.price }}</span>
                    </td>
                    <td>{{ formatDate(product.created_at) }}</td>
                    <td>{{ formatDate(product.updated_at) }}</td>
                    <td>
                        <div class="action-buttons">
                            <button @click="$emit('edit', product)" class="edit-btn">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="$emit('delete', product)" class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        products: {
            type: Array,
            required: true
        },
        sortBy: {
            type: String,
            default: 'id'
        },
        sortDirection: {
            type: String,
            default: 'desc'
        }
    },
    emits: ['edit', 'delete', 'sort'],
    setup() {
        const formatDate = (dateString) => {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        };

        return {
            formatDate
        };
    }
}
</script>

<style lang="scss" scoped>
@use '../assets/common-styles.scss' as *;

.table-container {
    overflow-x: auto;
}

.product-table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
    background: $white;
    box-shadow: $shadow-sm;

    th,
    td {
        padding: $spacing-md;
        text-align: left;
        border-bottom: 1px solid $border-color;
    }

    th {
        background-color: $background-light;
        font-weight: 600;
        color: $text-secondary;
        font-size: $font-size-sm;
        text-transform: uppercase;
    }

    tr:hover {
        background-color: $background-light;
    }

    .price-badge {
        @extend .badge-success;
    }

    .action-buttons {
        @include flex-center;
        gap: $spacing-md;

        button {
            padding: $spacing-sm;
            border-radius: $radius-full;
            transition: $transition-base;
            border: none;
            cursor: pointer;

            &:hover {
                background-color: $background-light;
            }

            &.edit-btn {
                color: $primary-color;

                &:hover {
                    background-color: rgba($primary-color, 0.1);
                }
            }

            &.delete-btn {
                color: $danger-color;

                &:hover {
                    background-color: $danger-bg;
                }
            }
        }
    }
}

.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
    padding-right: $spacing-xl;

    &:hover {
        background-color: $background-light;
    }

    i {
        position: absolute;
        right: $spacing-sm;
        top: 50%;
        transform: translateY(-50%);
        color: $text-secondary;
    }
}
</style>