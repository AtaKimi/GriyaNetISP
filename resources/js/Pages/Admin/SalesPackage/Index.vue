<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import FileInput from '@/Components/FileInput.vue';


const props = defineProps({
    sales_packages: Array,
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
    sales_package_id: Number,
    last_image: String,
})


const form = useForm({
    title: '',
    subtitle: '',
    description: '',
    image: '',
});

const createSalesPackage = () => {
    form.post(route('admin.sales-package.store'), {
        onSuccess: () => form.reset('title', 'subtitle', 'description', 'image'),
    })
}

const editSalesPackage = (sales_package) => {
    form.reset('image')
    form.title = sales_package.title
    form.subtitle = sales_package.subtitle
    form.description = sales_package.description
}

const updateSalesPackage = (sales_package_id) => {
    router.post(route('admin.sales-package.update', sales_package_id), {
        _method: 'put',
        image: form.image,
        title: form.title,
        subtitle: form.subtitle,
        description: form.description,
    })
}

const destroySalesPackage = (sales_package_id) => {
    form.delete(route('admin.sales-package.destroy', sales_package_id), {
    })
}


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Paket Penjualan</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between mb-4">
                            <h1 class="text-2xl font-bold">Paket Penjualan</h1>
                            <button
                                @click="isCreateModalOpen = !isCreateModalOpen; form.reset('title', 'subtitle', 'description', 'image')"
                                class="border-2 border-blue-500 rounded-md px-5 py-2.5 text-blue-900 font-bold tracking-wide hover:bg-blue-500 hover:text-white">Tambah</button>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div v-for="sales_package in $page.props.sales_packages"
                                class="rounded-md border border-grey-400 shadow w-full p-4 flex gap-4 items-start">
                                <div>
                                    <img v-bind:src="sales_package.media[0].original_url" alt="Foto Paket Penjualan"
                                        class="w-32 h-32 rounded-sm">
                                </div>
                                <div class="w-full">
                                    <div class="flex justify-between w-full items-center">
                                        <h1 class="text-2xl font-bold mb-2">{{ sales_package.title }}</h1>
                                        <div class="flex gap-2">
                                            <button @click="editSalesPackage(sales_package); isEditModalOpen = !isEditModalOpen; sales_package_id = sales_package.id; last_image = sales_package.media[0].file_name
                                                "
                                                class="bg-amber-500 fill-white w-10 h-10 flex justify-center items-center rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24"
                                                    height="24">
                                                    <path
                                                        d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z" />
                                                </svg>
                                            </button>
                                            <button @click="isDeleteModalOpen = !isDeleteModalOpen; sales_package_id = sales_package.id"
                                                class="bg-red-500 fill-white w-10 h-10 flex justify-center items-center rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24"
                                                    height="24">
                                                    <path
                                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <h1 class="text-xl font-medium text-gray-500 mb-2">{{ sales_package.subtitle }}</h1>
                                    <p class="text-sm">{{ sales_package.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ----------------------- create modal start ---------------------------- -->
        <Modal :show="isCreateModalOpen">
            <div class="p-5">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Tambah Sales</h1>
                    <button @click="isCreateModalOpen = !isCreateModalOpen"
                        class="rounded-md p-2 fill-red-500 font-bold tracking-wide hover:bg-red-500 hover:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="32" height="32">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </button>
                </div>
                <div class="mb-3">
                    <form @submit.prevent="createSalesPackage">
                        <div class="mb-4">
                            <InputLabel for="image" value="Foto" />
                            <FileInput id="image" @input="form.image = $event.target.files[0]" required />
                            <InputError class="mt-2" :message="form.errors.image" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="title" value="Judul" />
                            <TextInput id="title" type="title" class="mt-1 block w-full p-2 border" v-model="form.title"
                                required autofocus autocomplete="title" />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="subtitle" value="Subjudul" />

                            <TextInput id="subtitle" type="subtitle" class="mt-1 block w-full p-2 border"
                                v-model="form.subtitle" required autofocus autocomplete="subtitle" />
                            <InputError class="mt-2" :message="form.errors.subtitle" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="description" value="Deskripsi" />
                            <Textarea id="description" type="description" class="mt-1 block w-full p-2 border"
                                v-model="form.description" required autofocus autocomplete="description" />
                            <InputError class="mt-2" :message="form.errors.description" />
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
                    <h1 class="text-2xl font-bold">Tambah Sales</h1>
                    <button @click="isEditModalOpen = !isEditModalOpen"
                        class="rounded-md p-2 fill-red-500 font-bold tracking-wide hover:bg-red-500 hover:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="32" height="32">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </button>
                </div>
                <div class="mb-3">
                    <form @submit.prevent="updateSalesPackage(sales_package_id)">
                        <div class="mb-4">
                            <InputLabel for="edit_image" value="Foto" />
                            <FileInput id="edit_image" @input="form.image = $event.target.files[0]" />
                            <p class="text-blue-800">Foto Terakhir: {{ last_image }}</p>
                            <InputError class="mt-2" :message="form.errors.image" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="title" value="Judul" />
                            <TextInput id="title" type="title" class="mt-1 block w-full p-2 border" v-model="form.title"
                                required autofocus autocomplete="title" />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="subtitle" value="Subjudul" />

                            <TextInput id="subtitle" type="subtitle" class="mt-1 block w-full p-2 border"
                                v-model="form.subtitle" required autofocus autocomplete="subtitle" />
                            <InputError class="mt-2" :message="form.errors.subtitle" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="description" value="Deskripsi" />
                            <Textarea id="description" type="description" class="mt-1 block w-full p-2 border"
                                v-model="form.description" required autofocus autocomplete="description" />
                            <InputError class="mt-2" :message="form.errors.description" />
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

        <!-- ----------------------- delete modal end ---------------------------- -->

        <Modal :show="isDeleteModalOpen" :maxWidth="'sm'">
            <div class="p-5">
                <div class="flex justify-between mb-5">
                    <h1 class="text-2xl font-bold">Hapus Paket Penjualan</h1>
                    <button @click="isDeleteModalOpen = !isDeleteModalOpen"
                        class="rounded-md p-2 fill-red-500 font-bold tracking-wide hover:bg-red-500 hover:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="32" height="32">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-center fill-red-500 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="128" height="128">
                        <path
                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                    </svg>
                </div>
                <div class="text-gray-500 mb-4 font-medium">
                    Apakah anda yakin ingin menghapus paket penjualan ini?
                </div>
                <form @submit.prevent="destroySalesPackage(sales_package_id)">
                    <div class="flex items-center justify-between gap-4">
                        <button type="button" @click="isDeleteModalOpen = !isDeleteModalOpen"
                            class="w-full bg-red-500 text-white tracking-wide py-2.5 px-6 border-2 border-red-500 rounded-md hover:bg-white hover:text-red-950 font-bold">Batalkan</button>
                        <button
                            class="w-full bg-blue-500 text-white tracking-wide py-2.5 px-6 border-2 border-blue-500 rounded-md hover:bg-white hover:text-blue-950 font-bold">Hapus</button>
                    </div>
                </form>
            </div>
        </Modal>
        <!-- ----------------------- delete modal end ---------------------------- -->

    </AuthenticatedLayout>
</template>
