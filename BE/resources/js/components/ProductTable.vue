<template>
  <div>
    <h2>Product List</h2>
    <div>
      <input type="text" v-model="searchQuery" placeholder="Search..." />
      <button @click="fetchProducts">Search</button>
    </div>
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in filteredProducts" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>{{ product.price }}</td>
          <td>
            <button @click="editProduct(product)">Edit</button>
            <button @click="deleteProduct(product.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="pagination">
      <button :disabled="currentPage === 1" @click="changePage(currentPage - 1)">Previous</button>
      <span>Page {{ currentPage }} of {{ lastPage }}</span>
      <button :disabled="currentPage === lastPage" @click="changePage(currentPage + 1)">Next</button>
    </div>

    <div>
      <input v-model="form.name" placeholder="Product Name" />
      <input v-model="form.price" placeholder="Price" type="number" />
      <button @click="form.id ? updateProduct() : createProduct()">
        {{ form.id ? "Update" : "Add" }} Product
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      products: [],
      searchQuery: "",
      form: { id: null, name: "", price: "" },
      currentPage: 1,
      lastPage: 1,
      total: 0,
      perPage: 10
    };
  },
  computed: {
    filteredProducts() {
      return this.products;
    },
  },
  methods: {
    async fetchProducts() {
      const response = await axios.get('/api/products', {
        params: {
          page: this.currentPage,
          search: this.searchQuery
        }
      });
      const { data, current_page, last_page, total } = response.data;
      this.products = data;
      this.currentPage = current_page;
      this.lastPage = last_page;
      this.total = total;
    },
    async changePage(page) {
      this.currentPage = page;
      await this.fetchProducts();
    },
    async createProduct() {
      await axios.post('/api/products', this.form);
      this.form = { id: null, name: "", price: "" };
      this.fetchProducts();
    },
    editProduct(product) {
      this.form = { ...product };
    },
    async updateProduct() {
      await axios.put(`/api/products/${this.form.id}`, this.form);
      this.form = { id: null, name: "", price: "" };
      this.fetchProducts();
    },
    async deleteProduct(id) {
      await axios.delete(`/api/products/${id}`);
      this.fetchProducts();
    },
  },
  mounted() {
    this.fetchProducts();
  }
};
</script>

<style scoped>
.pagination {
  margin: 20px 0;
  display: flex;
  gap: 10px;
  align-items: center;
  justify-content: flex-start;
}
</style>
