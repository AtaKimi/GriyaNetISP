<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Pagination from '@/Components/Pagination.vue';
import FileInput from '@/Components/FileInput.vue';

const form = useForm({
    customer_id: '',
    sales_package_id: '',
    payment_proof: null,
});

const props = defineProps({
    isCreateModalOpen: {
        type: Boolean,
        default: false
    },
    isEditModalOpen: {
        type: Boolean,
        default: false
    },
    isDeleteModalOpen: {
        type: Boolean,
        default: false
    },
    isShowModalOpen: {
        type: Boolean,
        default: false
    },
    customer_transaction_index: Number
})

const createCustumerTransaction = () => {
    form.post(route('agent.customer-transaction.store'), {
        onSuccess: () => form.reset('title', 'subtitle', 'description', 'image'),
    })
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi Kostumer</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between mb-4 items-center">
                            <h1 class="text-xl font-bold">Transaksi Kostumer</h1>
                            <button type="button" @click="isCreateModalOpen = !isCreateModalOpen"
                                class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none ">Tambah</button>

                        </div>
                        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Kostumer
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nomor Kostumer
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Sales
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Paket
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status Validasi
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(transaction, index) in $page.props.customer_transactions.data"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ transaction.customer.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ transaction.customer.phone_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $page.props.auth.user.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ transaction.sales_package.title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ transaction.sales_package.validated ? 'Tervalidasi' : 'Belum Tervalidasi' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <button type="button"
                                            @click="isShowModalOpen = !isShowModalOpen; customer_transaction_index = index;"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 ">Detail</button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :links="$page.props.customer_transactions.links" />
                    </div>
                </div>
            </div>
        </div>

        <!-- ----------------------- create modal start ---------------------------- -->
        <Modal :show="isCreateModalOpen">
            <div class="p-5">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Tambah Transaksi Kostumer</h1>
                    <button @click="isCreateModalOpen = !isCreateModalOpen"
                        class="rounded-md p-2 fill-red-500 font-bold tracking-wide hover:bg-red-500 hover:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="32" height="32">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </button>
                </div>
                <div class="mb-3">
                    <form @submit.prevent="createCustumerTransaction">
                        <div class="mb-4">
                            <InputLabel for="customer_id" value="Kostumer" />
                            <SelectInput id="customer_id" v-model="form.customer_id" required autofocus
                                autocomplete="customer_id">
                                <option v-for="customer in $page.props.customers" :value="customer.id">
                                    {{ customer.id }} - {{ customer.name }}</option>
                            </SelectInput>
                            <InputError class="mt-2" :message="form.errors.customer_id" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="sales_package_id" value="Paket Pilihan" />
                            <SelectInput id="sales_package_id" v-model="form.sales_package_id" required autofocus
                                autocomplete="sales_package_id">
                                <option v-for="sales_package in $page.props.sales_packages" :value="sales_package.id"
                                    ref="sales_package_option_id">
                                    {{ sales_package.id }} - {{ sales_package.title }}</option>
                            </SelectInput>
                            <div v-if="form.sales_package_id != ''" class="mt-2 font-medium">Harga: <span>
                                    {{ new Intl.NumberFormat('id-ID', {
                                        style: 'currency', currency: 'IDR'
                                    }).format(
                                        $page.props.sales_packages[form.sales_package_id].price,
                                    ) }}</span></div>
                            <InputError class="mt-2" :message="form.errors.sales_package_id" />
                        </div>
                        <div class="mb-4">
                            <FileInput id="payment_proof" class="mt-1 block w-full border"
                                @input="form.payment_proof = $event.target.files[0]" required autofocus />
                            <InputError class="mt-2" :message="form.errors.payment_proof" />
                        </div>

                        <div class="flex items-center justify-end mb-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Simpan
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>
        <!-- ----------------------- create modal end ---------------------------- -->

        <!-- ----------------------- show modal start ---------------------------- -->
        <Modal :show="isShowModalOpen">
            <div class="p-5">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Detail Transaksi Kostumer</h1>
                    <button @click="isShowModalOpen = !isShowModalOpen"
                        class="rounded-md p-2 fill-red-500 font-bold tracking-wide hover:bg-red-500 hover:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="32" height="32">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </button>
                </div>
                <div class="mb-3">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-4">
                            <tbody>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Nama Kostumer
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $page.props.customer_transactions.data[customer_transaction_index].customer.name
                                        }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Nomor Telpon Kostumer
                                    </th>
                                    <td class="px-6 py-4">
                                        {{
                                            $page.props.customer_transactions.data[customer_transaction_index].customer.phone_number
                                        }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Nama Sales
                                    </th>
                                    <td class="px-6 py-4">
                                        {{
                                            $page.props.customer_transactions.data[customer_transaction_index].agent.user.name
                                        }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Nama Paket
                                    </th>
                                    <td class="px-6 py-4">
                                        {{
                                            $page.props.customer_transactions.data[customer_transaction_index].sales_package.title
                                        }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Harga Paket
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ new Intl.NumberFormat('id-ID', {
                                            style: 'currency', currency: 'IDR'
                                        }).format(
                                            $page.props.customer_transactions.data[customer_transaction_index].sales_package.price,
                                        ) }}

                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Tervalidasi
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $page.props.customer_transactions.data[customer_transaction_index].validated ?
                                            'Tervalidasi' : 'Tidak Tervalidasi' }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Tanggal Transaksi
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ new
                                            Date($page.props.customer_transactions.data[customer_transaction_index].created_at)
                                        }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Bukti Pembayaran
                                    </th>
                                    <td class="px-6 py-4">
                                        <img :src="$page.props.customer_transactions.data[customer_transaction_index].media[0].original_url"
                                            alt="" srcset="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Modal>
        <!-- ----------------------- show modal end ---------------------------- -->
    </AuthenticatedLayout>
</template>
