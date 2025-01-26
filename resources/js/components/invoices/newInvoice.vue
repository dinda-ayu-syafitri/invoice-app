<template>
    <div class="container mx-auto py-8 px-4">
        <h1 class="flex justify-center text-3xl mb-8">New invoices</h1>

        <div>
            <form class="mx-auto">
                <div class="mb-4">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Select your country</label
                    >
                    <select
                        id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="customer_id"
                    >
                        <option disabled>Select Customer</option>
                        <option
                            :value="customer.id"
                            v-for="customer in allCustomers"
                            :key="customer.id"
                        >
                            {{ customer.firstname }}
                        </option>
                    </select>
                </div>

                <div class="relative max-w-sm">
                    <div
                        class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none"
                    >
                        <svg
                            class="w-4 h-4 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                            />
                        </svg>
                    </div>
                    <input
                        datepicker
                        id="default-datepicker"
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date"
                        v-model="form.due_date"
                    />
                </div>

                <div class="mb-5">
                    <label
                        for="number"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Number</label
                    >
                    <input
                        type="text"
                        id="number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.number"
                    />
                </div>
                <div class="mb-5">
                    <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Reference (Optional)</label
                    >
                    <input
                        type="text"
                        id="reference"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.reference"
                    />
                </div>

                <div
                    class="flex gap-5 justify-between items-center mb-5"
                    v-for="(itemCart, i) in listCart"
                    :key="itemCart.id"
                >
                    <p>#{{ itemCart.item_code }} {{ itemCart.description }}</p>
                    <p>
                        <input
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="itemCart.unit_price"
                        />
                    </p>
                    <p>
                        <input
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="itemCart.quantity"
                        />
                    </p>
                    <p v-if="itemCart.quantity">
                        Rp {{ itemCart.unit_price * itemCart.quantity }}
                    </p>
                    <p v-else></p>
                    <p class="px-5 py-3 bg-slate-500" @click="removeItem(i)">
                        -
                    </p>
                </div>
                <div class="mb-5">
                    <!-- Modal toggle -->
                    <button
                        data-modal-target="default-modal"
                        data-modal-toggle="default-modal"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                    >
                        Toggle modal
                    </button>

                    <!-- Main modal -->
                    <div
                        id="default-modal"
                        tabindex="-1"
                        aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
                    >
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div
                                class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700"
                            >
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <ul
                                        class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    >
                                        <li
                                            class="w-full flex justify-between px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600"
                                            v-for="(item, i) in listProducts"
                                            :key="item.id"
                                        >
                                            <p>{{ i + 1 }}</p>
                                            <p>
                                                {{ item.item_code }}
                                                {{ item.description }}
                                            </p>
                                            <p
                                                @click="addCart(item)"
                                                class="px-5 py-3 bg-slate-600"
                                            >
                                                +
                                            </p>
                                            <!-- <button @click="addCart(item)">
                                                +
                                            </button> -->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="flex justify-between items-center mb-5">
                <div>
                    <p>SubTotal</p>
                    <p>{{ subTotal() }}</p>
                </div>

                <div>
                    <p>Discount</p>
                    <input type="text" class="bg-gray-50 border border-gray-300
                    text-gray-900 text-sm rounded-lg focus:ring-blue-500
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
                    dark:border-gray-600 dark:placeholder-gray-400
                    dark:text-white dark:focus:ring-blue-500
                    dark:focus:border-blue-500" v-model="form.discount"
                </div>
            </div>
            <div>
                <p>Total</p>
                <p>{{ total() }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

let form = ref([]);
let allCustomers = ref([]);
let customer_id = ref([]);
let item = ref([]);
let listCart = ref([]);
let listProducts = ref([]);

onMounted(async () => {
    indexForm();
    getAllCustomers();
    getProducts();
});

const indexForm = async () => {
    let response = await axios.get("/api/invoices/create");
    // console.log(response.data);
    form.value = response.data;
};

const getAllCustomers = async () => {
    let response = await axios.get("/api/customers");
    allCustomers.value = response.data.customers;
    console.log("Customers", response.data.customers);
};

const addCart = (item) => {
    // console.log("test");
    const itemCart = {
        id: item.id,
        item_code: item.item_code,
        description: item.description,
        unit_price: item.unit_price,
        quantity: item.quantity,
    };
    console.log(itemCart);
    listCart.value.push(itemCart);
};

const removeItem = (index) => {
    listCart.value.splice(index, 1);
};

const getProducts = async () => {
    let response = await axios.get("/api/products");
    listProducts.value = response.data.products;
    console.log("Products", response.data.products);
};

const subTotal = () => {
    let total = 0;
    listCart.value.map((item) => {
        total = total + item.unit_price * item.quantity;
    });
    return total;
};

const total = () => {
    return subTotal() - form.value.discount;
};
</script>
