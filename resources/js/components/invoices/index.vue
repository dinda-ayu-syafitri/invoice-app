<template>
    <div class="container mx-auto py-8 px-4">
        <h1 class="flex justify-center text-3xl mb-8">List of invoices</h1>

        <div class="relative overflow-x-auto">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Invoice Number</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Reference</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                    </tr>
                </thead>
                <tbody
                    v-for="invoice in invoices"
                    :key="invoice.id"
                    v-if="invoices.length > 0"
                >
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                    >
                        <td
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            ${{ invoice.number }}
                        </td>
                        <td class="px-6 py-4">${{ invoice.date }}</td>
                        <td class="px-6 py-4">{{ invoice.reference }}</td>
                        <td class="px-6 py-4">{{ invoice.total }}</td>
                    </tr>
                </tbody>
                <div v-else>
                    <p>No invoices found</p>
                </div>
            </table>
        </div>
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

    invoices.value = response.data.invoices;
};
</script>
