<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import Pagination from '@/Components/Pagination.vue';
import FileInput from '@/Components/FileInput.vue';

defineProps({
    isShowModalOpen: {
        type: Boolean,
        default: false,
    },
    isCreateModalOpen: {
        type: Boolean,
        default: false,
    },
    isEditModalOpen: {
        type: Boolean,
        default: false,
    },
    customer_index: {
        type: Number,
        default: -1,
    },
    customers: Array,
    customer_id: Number,
})

const form = useForm({
    name: '',
    phone_number: '',
    address: '',
    identity_card: null,
    house_picture: null,
});

const editForm = (customer) => {
    form.name = customer.name
    form.phone_number = customer.phone_number
    form.address = customer.address
    form.identity_card = null
    form.house_picture = null
}

const storeCustomer = () => {
    form.post(route('agent.customer.store'), {
        onSuccess: () => form.reset('name', 'phone_number', 'address', 'identity_card', 'house_picture'),
    })
}

const updateCustomer = (customer_id) => {
    router.post(route('agent.customer_id.update', customer), {
        _method: 'put',
        name: form.name,
        phone_number: form.phone_number,
        address: form.address,
        identity_card: form.identity_card,
        house_picture: form.house_picture,
    })
}

const deleteCustomer = (customer_id) => {
    router.delete(route('agent.customer.destroy', customer_id))
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Sales</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-xl font-bold">Data Kostumer</h1>
                            <button type="button" @click="isCreateModalOpen = !isCreateModalOpen"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">Tambah
                                Kostumer</button>
                        </div>

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Nama
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Alamat
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Nomor Telpon
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                        v-for="(customer, index) in $page.props.customers.data">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ customer.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ customer.address }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ customer.phone_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
                                                <button type="button"
                                                    @click="isShowModalOpen = !isShowModalOpen; customer_index = index"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">
                                                    Detail
                                                </button>
                                                <button type="button"
                                                    @click="isEditModalOpen = !isEditModalOpen; customer_id = customer.id; editForm(customer);"
                                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                                    Edit
                                                </button>
                                                <button type="button" @click="deleteCustomer(customer.id)"
                                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="$page.props.customers.links" />
                    </div>
                </div>
            </div>
        </div>

        <!-- ----------------------- show modal start ---------------------------- -->
        <Modal :show="isShowModalOpen">
            <div class="p-5">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Detail Kostumer</h1>
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
                        <table v-if="customer_index != -1"
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-4">
                            <tbody>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Nama Kostumer
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $page.props.customers.data[customer_index].name }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Nomor Telpon Kostumer
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $page.props.customers.data[customer_index].phone_number }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Alamat:
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $page.props.customers.data[customer_index].address }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Foto Identitas:
                                    </th>
                                    <td class="px-6 py-4">
                                        <div v-for="image in $page.props.customers.data[customer_index].media">
                                            <div v-if="image.collection_name == 'identity_card'">
                                                <img :src="image.original_url">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        Foto Rumah:
                                    </th>
                                    <td class="px-6 py-4">
                                        <div v-for="image in $page.props.customers.data[customer_index].media">
                                            <div v-if="image.collection_name == 'house_picture'">
                                                <img :src="image.original_url">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Modal>
        <!-- ----------------------- show modal end ---------------------------- -->

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
                    <form @submit.prevent="storeCustomer" enctype="multipart/form-data">
                        <div class="mb-4">
                            <InputLabel for="name" value="Nama Kostumer" />
                            <TextInput id="name" type="text" class="mt-1 block w-full p-2 border" v-model="form.name"
                                required autofocus autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="phone_number" value="Nomor Telpon Kostumer" />
                            <TextInput id="phone_number" type="text" class="mt-1 block w-full p-2 border"
                                v-model="form.phone_number" required autofocus autocomplete="phone_number" />
                            <InputError class="mt-2" :message="form.errors.phone_number" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="address" value="Alamat Kostumer" />
                            <Textarea id="address" class="mt-1 block w-full p-2 border" v-model="form.address" required
                                autofocus autocomplete="address"></Textarea>
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="identity_card" value="Foto Kartu Identitas Kostumer" />
                            <FileInput id="identity_card" class="mt-1 block w-full border"
                                @input="form.identity_card = $event.target.files[0]" required autofocus />
                            <InputError class="mt-2" :message="form.errors.identity_card" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="house_picture" value="Foto Rumah Kostumer" />
                            <FileInput id="house_picture" class="mt-1 block w-full border"
                                @input="form.house_picture = $event.target.files[0]" required autofocus />
                            <InputError class="mt-2" :message="form.errors.house_picture" />
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

        <!-- ----------------------- edit modal start ---------------------------- -->
        <Modal :show="isEditModalOpen">
            <div class="p-5">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Tambah Transaksi Kostumer</h1>
                    <button @click="isEditModalOpen = !isEditModalOpen"
                        class="rounded-md p-2 fill-red-500 font-bold tracking-wide hover:bg-red-500 hover:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="32" height="32">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </button>
                </div>
                <div class="mb-3">
                    <form @submit.prevent="updateCustomer(customer_id)" enctype="multipart/form-data">
                        <div class="mb-4">
                            <InputLabel for="name" value="Nama Kostumer" />
                            <TextInput id="name" type="text" class="mt-1 block w-full p-2 border" v-model="form.name"
                                required autofocus autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="phone_number" value="Nomor Telpon Kostumer" />
                            <TextInput id="phone_number" type="text" class="mt-1 block w-full p-2 border"
                                v-model="form.phone_number" required autofocus autocomplete="phone_number" />
                            <InputError class="mt-2" :message="form.errors.phone_number" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="address" value="Alamat Kostumer" />
                            <Textarea id="address" class="mt-1 block w-full p-2 border" v-model="form.address" required
                                autofocus autocomplete="address"></Textarea>
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="identity_card" value="Foto Kartu Identitas Kostumer" />
                            <FileInput id="identity_card" class="mt-1 block w-full border"
                                @input="form.identity_card = $event.target.files[0]" autofocus />
                            <InputError class="mt-2" :message="form.errors.identity_card" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="house_picture" value="Foto Rumah Kostumer" />
                            <FileInput id="house_picture" class="mt-1 block w-full border"
                                @input="form.house_picture = $event.target.files[0]" autofocus />
                            <InputError class="mt-2" :message="form.errors.house_picture" />
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
        <!-- ----------------------- edit modal end ---------------------------- -->
    </AuthenticatedLayout>
</template>
