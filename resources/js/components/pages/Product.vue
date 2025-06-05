<template>
    <div class="container mx-auto">
        <v-row dense class="gap-2">
            <v-col cols="12" class="text-3xl font-bold text-center">Vue Page Products</v-col>
            <v-col cols="12" class="d-flex gap-4">
                <v-btn 
                @click="openAddEditProductDialog('Add', {})" class="bg-primary" height="40px">Add Product</v-btn>
                <v-text-field
                    hide-details
                    placeholder="Search..."
                ></v-text-field>
            </v-col>
            <v-col>
                <v-table height="calc(100vh - 200px)">
                    <thead>
                        <tr class="bg-slate-50">
                            <th v-for="(header, i) in productHeaders" :key="i" class="font-bold text-md">
                                {{ header.title }}
                            </th>
                            <th class="font-bold text-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, i) in productData" :key="i" :class="item.status ? 'hover:bg-slate-50' : 'bg-red-50'">
                            <td v-for="(header, ii) in productHeaders" :key="ii">
                                <div v-if="header.model === 'categories'">
                                    <li v-for="(list, iii) in item[header.model]" :key="iii">
                                        {{ list.category_name }}
                                    </li>
                                </div>
                                <div v-else-if="header.model === 'status'">
                                    {{ item[header.model] ? 'Active' : 'Inactive' }}
                                </div>
                                <div v-else-if="header.model === 'price'">
                                    ₱{{ Number(item[header.model]).toLocaleString() }}
                                </div>
                                <div v-else>
                                    {{ item[header.model] }}
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <v-btn @click="openAddEditProductDialog('Edit', item)" class="bg-success mr-2">Edit</v-btn>
                                <v-btn @click="deleteProduct(item)" class="bg-error">Delete</v-btn>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-col>
        </v-row>

        <v-dialog width="450px" persistent v-model="productDialog">
            <v-card>
                <v-card-title>{{ actionMode }} Product</v-card-title>
                <v-card-text class="pa-4">
                    <v-form ref="form">
                        <div v-for="(item, i) in productHeaders">
                            <v-text-field
                                v-if="item.component === 'textfield'"
                                class="mb-2"
                                :label="item.title"
                                :rules="[v => !!v || item.title + ' required']"
                                v-model="productObject[item.model]"
                            ></v-text-field>
                            <v-autocomplete
                                v-else-if="item.component === 'autocomplete'"
                                chips
                                multiple
                                class="mb-2"
                                :label="item.title"
                                item-value="id"
                                item-title="category_name"
                                :rules="[v => !!v && v.length !== 0 || item.title + ' required']"
                                :items="productCategoryData"
                                v-model="productObject[item.model]"
                            ></v-autocomplete>
                            <v-select
                                v-else-if="item.component === 'select'"
                                class="mb-2"
                                :label="item.title"
                                item-value="value"
                                item-title="title"
                                :rules="[v => !!v || v === 0 || item.title + ' required']"
                                :items="[{title: 'Active', value: 1}, {title: 'Inactive', value: 0}]"
                                v-model="productObject[item.model]"
                            ></v-select>
                        </div>
                    </v-form>
                </v-card-text>
                <v-card-actions class="justify-space-between">
                    <v-btn @click="productDialog = false;" class="bg-error w-[49%]">Cancel</v-btn>
                    <v-btn @click="saveProduct()" class="bg-success w-[49%]">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
const productHeaders = ref([
    {title: 'Product Name', model: 'product_name', component: 'textfield'},
    {title: 'Sell Price', model: 'price', component: 'textfield'},
    {title: 'Product Category', model: 'categories', component: 'autocomplete'},
    {title: 'Active/Inactive Status', model: 'status', component: 'select'},
]);

const productData = ref([]);
const productCategoryData = ref([]);

function getProductsAndCategories() {
    axios({
        method: 'get',
        url: 'products/data',
    })
    .then((res) => {
        productData.value = res.data.data.products;
        productCategoryData.value = res.data.data.categories;
    })
    .catch((err) => {
        console.error('Error getting producst: ', err);
    })
};

onMounted(() => {
    getProductsAndCategories();
});

//*********** OPEN ADD / EDIT DIALOG **********//
const actionMode = ref('')
const productDialog = ref(false);
const productObject = reactive({
    product_name: '',
    price: '',
    categories: [],
    status: ''
});

const openAddEditProductDialog = (action, item) => {
    productDialog.value = true;
    actionMode.value = action;

    if (action === 'Add') {
        productObject.product_name = '';
        productObject.price = '';
        productObject.categories = [];
        productObject.status = '';
    } else {
        productObject.id = item.id;
        productObject.product_name = item.product_name;
        productObject.price = item.price;
        productObject.categories = item.categories.map((item) => item.id);
        productObject.status = item.status;
    }
};


//*********** ADD / EDIT SAVE FUNCTION **********//
const form = ref();
async function saveProduct() {
    const { valid } = await form.value.validate();

    const method = actionMode.value === 'Add' ? 'post' : 'put';
    const url = actionMode.value === 'Add' ? 'products/store' : `products/update/${productObject.id}`;

    if (valid) {
        axios({
            method: method,
            url: url,
            data: productObject
        })
        .then((res) => {
            alert(res.data.message);
            getProductsAndCategories();
            productDialog.value = false;
        })
        .catch((err) => {
            console.error('Error saving product: ', err);
        })
    }
};

//*********** DELETE FUNCTION **********//
function deleteProduct(product) {
    if (confirm(`Are you sure you want to delete ${product.product_name}?`)) {
        axios({
            method: 'delete',
            url: `products/delete/${product.id}`
        })
        .then((res) => {
            alert(res.data.message);
            getProductsAndCategories();
        })
        .catch(() => {
            console.error('Error deleting product: ', err)
        })
    }
}
</script>

<style scoped>

</style>