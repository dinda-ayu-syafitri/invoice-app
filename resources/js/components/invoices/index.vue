<template>
    <div class="container mx-auto py-8 px-4">
        <h1 class="flex justify-center text-3xl mb-8">List of invoices</h1>

        <div class="relative overflow-x-auto">
            <div class="flex justify-between items-center mb-5">
                <form class="w-full max-w-md">
                    <label
                        for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                        >Search</label
                    >
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                            type="search"
                            id="default-search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search Invoice..."
                            v-model="searchInvoice"
                            v-on:keyup="search()"
                            required
                        />
                    </div>
                </form>
                <button
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    @click="newInvoice()"
                >
                    New Invoice
                </button>
            </div>

            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Invoice Number</th>
                        <th scope="col" class="px-6 py-3">Customer Name</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Reference</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Delete</th>
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
                        <td class="px-6 py-4">
                            {{ invoice.customer.firstname }}
                        </td>
                        <td class="px-6 py-4">{{ invoice.date }}</td>
                        <td class="px-6 py-4">{{ invoice.reference }}</td>
                        <td class="px-6 py-4">{{ invoice.total }}</td>

                        <td
                            class="px-6 py-4"
                            @click="deleteInvoice(invoice.id)"
                        >
                            Delete
                        </td>
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
import { useRouter } from "vue-router";
import router from "../../router";

let invoices = ref([]);
let searchInvoice = ref([]);

onMounted(async () => {
    getInvoices();
});

const getInvoices = async () => {
    let response = await axios.get("/api/invoices");
    console.log(response.data.invoices);
    invoices.value = response.data.invoices;
};

const search = async () => {
    let response = await axios.get(
        "/api/search_invoice?s=" + searchInvoice.value
    );
    console.log(response.data.invoices);
    invoices.value = response.data.invoices;
};

const newInvoice = async () => {
    let form = await axios.get("/api/invoices/create");
    console.log("form", form.data);
    router.push("/invoice/new");
};

const deleteInvoice = async (id) => {
    let response = await axios.delete("/api/delete_invoice/" + id);
    console.log(response.data);
    getInvoices();
};
</script>
