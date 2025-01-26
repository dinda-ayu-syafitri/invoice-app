<template>
    <div class="container mx-auto py-8 px-4">
        <h1 class="flex justify-center text-3xl mb-8">New invoices</h1>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

let form = ref([]);
let allCustomers = ref([]);
let customer_id = ref([]);

onMounted(async () => {
    indexForm();
    getAllCustomers();
});

const indexForm = async () => {
    let response = await axios.get("/api/invoices/create");
    // console.log(response.data);
    form.value = response.data;
};

const getAllCustomers = async () => {
    let response = await axios.get("/api/customers");
    allCustomers.value = response.data.customers;
    console.log("respnse", response.data.customers);
};
</script>
