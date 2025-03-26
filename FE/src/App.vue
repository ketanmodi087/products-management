<template>
  <div class="app-container">
    <div class="content-wrapper">
      <ErrorAlert :error="error" />

      <div class="card">
        <div class="card-header">
          <h2>Products List</h2>
          <div class="header-actions">
            <div class="search-box">
              <input type="text" v-model="searchQuery" placeholder="Search products..." @input="handleSearch" />
              <i class="fas fa-search"></i>
            </div>
            <button @click="openAddModal" class="add-button">
              <i class="fas fa-plus"></i> Add Product
            </button>
          </div>
        </div>

        <!-- Table Skeleton Loader -->
        <ProductSkeleton v-if="loading" />

        <!-- Products Table -->
        <ProductTable 
          v-else 
          :products="products" 
          :sort-by="sortBy"
          :sort-direction="sortDirection"
          @edit="editProduct" 
          @delete="deleteProduct"
          @sort="handleSort" 
        />

        <!-- Pagination -->
        <div class="pagination">
          <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
            class="page-button">
            Previous
          </button>
          <span class="page-info">
            Page {{ pagination.current_page }} of {{ pagination.last_page }}
          </span>
          <button @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page" class="page-button">
            Next
          </button>
        </div>
      </div>
    </div>

    <!-- Product Form Modal -->
    <ProductForm 
      :show="showAddModal || showEditModal" 
      :product="selectedProduct" 
      @close="closeModal"
      @submit="handleProductSubmit"
      @success="handleSuccess"
      @error="handleError"
    />

    <!-- Notification -->
    <Notification
      :show="notification.show"
      :message="notification.message"
      :type="notification.type"
      @close="closeNotification"
    />

    <!-- Delete Confirmation Modal -->
    <DeleteConfirmation
      :show="showDeleteModal"
      :product="productToDelete"
      @close="closeDeleteModal"
      @confirm="handleDeleteConfirm"
    />
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import ErrorAlert from './components/ErrorAlert.vue';
import ProductSkeleton from './components/ProductSkeleton.vue';
import ProductTable from './components/ProductTable.vue';
import ProductForm from './components/ProductForm.vue';
import Notification from './components/Notification.vue';
import DeleteConfirmation from './components/DeleteConfirmation.vue';
import debounce from 'lodash/debounce';

export default {
  components: {
    ErrorAlert,
    ProductSkeleton,
    ProductTable,
    ProductForm,
    Notification,
    DeleteConfirmation
  },
  setup() {
    const products = ref([]);
    const loading = ref(true);
    const error = ref(null);
    const apiUrl = ref(import.meta.env.VITE_APP_API_URL);
    const pagination = ref({
      current_page: 1,
      from: 0,
      to: 0,
      total: 0,
      last_page: 1
    });

    // Modal state
    const showAddModal = ref(false);
    const showEditModal = ref(false);
    const selectedProduct = ref(null);
    const searchQuery = ref('');
    const sortBy = ref('id'); // Default sort column
    const sortDirection = ref('desc'); // Default sort direction
    const showDeleteModal = ref(false);
    const productToDelete = ref(null);

    // Notification state
    const notification = ref({
      show: false,
      message: '',
      type: 'success'
    });

    const handleSuccess = (message) => {
      notification.value = {
        show: true,
        message,
        type: 'success'
      };
    };

    const handleError = (message) => {
      notification.value = {
        show: true,
        message,
        type: 'error'
      };
    };

    const closeNotification = () => {
      notification.value.show = false;
    };

    const handleSearch = debounce(() => {
      // Reset to first page when searching
      fetchProducts(1, searchQuery.value);
    }, 1000);

    const handleSort = (column) => {
      if (sortBy.value === column) {
        // If clicking the same column, toggle the direction
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
      } else {
        // If clicking a new column, set it as sort column with ascending direction
        sortBy.value = column;
        sortDirection.value = 'asc';
      }
      // Reset to first page when sorting changes
      fetchProducts(1, searchQuery.value);
    };

    const openAddModal = () => {
      showAddModal.value = true;
      selectedProduct.value = null;
    };

    const fetchProducts = async (page = 1, search = '') => {
      try {
        loading.value = true;
        const url = new URL(`${apiUrl.value}/products`);
        url.searchParams.append('page', page);
        if (search) {
          url.searchParams.append('search', search);
        }
        // Add sorting parameters
        url.searchParams.append('sort_by', sortBy.value);
        url.searchParams.append('sort_direction', sortDirection.value);

        const response = await fetch(url.toString());
        
        if (!response.ok) {
          throw new Error(`Failed to fetch products: ${response.status}`);
        }

        const data = await response.json();
        
        if (!data || !data.data) {
          throw new Error('Invalid data format received from API');
        }

        products.value = data.data;
        pagination.value = {
          current_page: data.current_page || 1,
          from: data.from || 0,
          to: data.to || 0,
          total: data.total || 0,
          last_page: data.last_page || 1
        };
      } catch (err) {
        console.error('Error in fetchProducts:', err);
        error.value = err.message;
        products.value = [];
      } finally {
        loading.value = false;
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= pagination.value.last_page) {
        fetchProducts(page, searchQuery.value);
      }
    };

    const editProduct = (product) => {
      selectedProduct.value = product;
      showEditModal.value = true;
    };

    const deleteProduct = (product) => {
      productToDelete.value = product;
      showDeleteModal.value = true;
    };

    const handleDeleteConfirm = async () => {
      try {
        const response = await fetch(`${apiUrl.value}/products/${productToDelete.value.id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json'
          }
        });

        if (!response.ok) {
          throw new Error('Failed to delete product');
        }

        handleSuccess('Product deleted successfully');
        showDeleteModal.value = false;
        productToDelete.value = null;
        // Refresh the products list with current search query
        fetchProducts(pagination.value.current_page, searchQuery.value);
      } catch (err) {
        console.error('Error deleting product:', err);
        handleError('Failed to delete product. Please try again.');
      }
    };

    const closeDeleteModal = () => {
      showDeleteModal.value = false;
      productToDelete.value = null;
    };

    const closeModal = () => {
      showAddModal.value = false;
      showEditModal.value = false;
      selectedProduct.value = null;
    };

    const handleProductSubmit = (isNewProduct = false) => {
      if (isNewProduct) {
        // For new products, reset to page 1 and sort by ID descending
        pagination.value.current_page = 1;
        sortBy.value = 'id';
        sortDirection.value = 'desc';
        // Clear any existing search query
        searchQuery.value = '';
      }
      // Fetch products with updated parameters
      fetchProducts(pagination.value.current_page, searchQuery.value);
    };

    onMounted(() => {
      fetchProducts();
    });

    return {
      products,
      loading,
      error,
      pagination,
      changePage,
      editProduct,
      deleteProduct,
      showAddModal,
      showEditModal,
      selectedProduct,
      closeModal,
      handleProductSubmit,
      openAddModal,
      searchQuery,
      handleSearch,
      sortBy,
      sortDirection,
      handleSort,
      notification,
      handleSuccess,
      handleError,
      closeNotification,
      showDeleteModal,
      productToDelete,
      handleDeleteConfirm,
      closeDeleteModal
    };
  }
};
</script>

<style lang="scss">
@use './assets/common-styles' as *;

.app-container {
  min-height: 100vh;
  background: linear-gradient(135deg, #e0f2fe 0%, #e0e7ff 100%);
  padding: $spacing-xl;
}

.content-wrapper {
  max-width: 1200px;
  margin: 0 auto;
}

.main-title {
  font-size: $font-size-2xl;
  font-weight: 800;
  margin-bottom: $spacing-xl;
  text-align: center;
  background: linear-gradient(to right, $primary-color, $secondary-color);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.card {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: all 0.3s;

  &:hover {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
  }
}

.card-header {
  padding: 0px 0px 20px 0px;
  border-bottom: 1px solid $border-color;
  display: flex;
  justify-content: space-between;
  align-items: center;

  h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: $text-primary;
  }

  .header-actions {
    @include flex-between;
    gap: $spacing-md;
  }

  .search-box {
    position: relative;
    display: flex;
    align-items: center;

    input {
      @include input-base;
      width: 300px;
      padding-right: $spacing-xl;
    }

    i {
      position: absolute;
      right: $spacing-md;
      color: $text-secondary;
    }
  }
}

.add-button {
  @extend .button-primary;
}

.pagination {
  padding: $spacing-md;
  border-top: 1px solid $border-color;
  @include flex-center;
  gap: $spacing-md;
}

.page-button {
  @extend .button-secondary;
  padding: $spacing-sm $spacing-md;

  &:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
}

.page-info {
  color: $text-secondary;
  font-weight: 500;
}
</style>
