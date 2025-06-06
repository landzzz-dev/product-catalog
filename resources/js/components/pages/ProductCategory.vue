<template>
    <div class="container mx-auto">
        <v-row dense class="gap-2">
            <v-col cols="12" class="text-3xl font-bold text-center">Vue Page Product Categories</v-col>
            <v-col cols="12" class="d-flex gap-4 justify-between">
                <v-btn @click="openAddEditProductDialog('Add', {})" class="bg-primary" height="40px">Add Product Category</v-btn>
                <v-btn to="products" class="bg-primary" height="40px">Switch to Products</v-btn>
                <!-- <v-text-field
                    hide-details
                    placeholder="Search..."
                ></v-text-field> -->
            </v-col>
            <v-col>
                <v-table height="calc(100vh - 200px)">
                    <thead>
                        <tr class="bg-slate-50">
                            <th v-for="(header, i) in productCategoryHeaders" :key="i" class="font-bold text-md">
                                {{ header.title }}
                            </th>
                            <th class="font-bold text-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, i) in productCategoryData" :key="i" class="hover:bg-slate-50">
                            <td v-for="(header, ii) in productCategoryHeaders" :key="ii">
                                <div>
                                    {{ item[header.model] }}
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <v-btn @click="openAddEditProductDialog('Edit', item)" class="bg-success mr-2">Edit</v-btn>
                                <v-btn @click="deleteProductCategory(item)" class="bg-error">Delete</v-btn>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-col>
        </v-row>

        <v-dialog width="450px" persistent v-model="productCategoryDialog">
            <v-card>
                <v-card-title>{{ actionMode }} Product Category</v-card-title>
                <v-card-text class="pa-4">
                    <v-form ref="form">
                        <div v-for="(item, i) in productCategoryHeaders">
                            <v-text-field
                                v-if="item.component === 'textfield'"
                                class="mb-2"
                                :label="item.title"
                                :rules="[v => !!v || item.title + ' required']"
                                v-model="productCategoryObject[item.model]"
                            ></v-text-field>
                        </div>
                    </v-form>
                </v-card-text>
                <v-card-actions class="justify-space-between">
                    <v-btn @click="productCategoryDialog = false;" class="bg-error w-[49%]">Cancel</v-btn>
                    <v-btn @click="saveProductCategory()" class="bg-success w-[49%]">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
const productCategoryHeaders = ref([
    {title: 'Id', model: 'id'},
    {title: 'Category Name', model: 'category_name', component: 'textfield'},
]);

const productCategoryData = ref([]);

function getCategories() {
    axios({
        method: 'get',
        url: 'categories/category_data',
    })
    .then((res) => {
        productCategoryData.value = res.data.data;
    })
    .catch((err) => {
        console.error('Error getting product categories: ', err);
    })
};

onMounted(() => {
    getCategories();
});

//*********** OPEN ADD / EDIT DIALOG **********//
const actionMode = ref('')
const productCategoryDialog = ref(false);
const productCategoryObject = reactive({
    category_name: '',
});

const openAddEditProductDialog = (action, item) => {
    productCategoryDialog.value = true;
    actionMode.value = action;

    if (action === 'Add') {
        productCategoryObject.category_name = '';
    } else {
        productCategoryObject.id = item.id;
        productCategoryObject.category_name = item.category_name;
    }
};


//*********** ADD / EDIT SAVE FUNCTION **********//
const form = ref();
async function saveProductCategory() {
    const { valid } = await form.value.validate();

    const method = actionMode.value === 'Add' ? 'post' : 'put';
    const url = actionMode.value === 'Add' ? 'categories/store' : `categories/update/${productCategoryObject.id}`;

    if (valid) {
        axios({
            method: method,
            url: url,
            data: productCategoryObject
        })
        .then((res) => {
            alert(res.data.message);
            getCategories();
            productCategoryDialog.value = false;
        })
        .catch((err) => {
            if (err.status === 422) alert(err.response.data.message);
            console.error('Error saving product category: ', err);
        })
    }
};

//*********** DELETE FUNCTION **********//
function deleteProductCategory(category) {
    if (confirm(`Are you sure you want to delete ${category.category_name}?`)) {
        axios({
            method: 'delete',
            url: `categories/delete/${category.id}`
        })
        .then((res) => {
            alert(res.data.message);
            getCategories();
        })
        .catch(() => {
            console.error('Error deleting product categories: ', err)
        })
    }
}
</script>

<style scoped>

</style>