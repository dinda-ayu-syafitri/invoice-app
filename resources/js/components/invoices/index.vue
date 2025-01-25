<template>
    <div>
        <h1>Index invoice page</h1>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

let invoices = ref([]);

onMounted(async () => {
    getInvoices();
});

const getInvoices = async () => {
    let response = await axios.get("/api/invoices");
    console.log("response", response);
};
</script>
