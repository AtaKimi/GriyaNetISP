<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from '@/Components/Textarea.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    nip: '',
});

defineProps({
    agents: Array,
    deleteAgentId: {
        type: Number,
        default: null
    },
    isCreateModalOpen: {
        type: Boolean,
        default: false
    },

    isDeleteModalOpen: {
        type: Boolean,
        default: false
    }
})

const createAgent = () => {
    form.post(route('admin.agent.store'), {
        onSuccess: () => form.reset('password', 'password_confirmation', 'name', 'nip', 'email'),
    });
};

const deleteAgent = (id) => {
    form.delete(route('admin.agent.destroy', id), {

    })
}
</script>

<template>
    <Head title="Manajemen Sales" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Sales</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between">
                            <h1 class="text-2xl font-bold">List Sales</h1>
                            <button @click="isCreateModalOpen = !isCreateModalOpen"
                                class="border-2 border-blue-500 rounded-md px-5 py-2.5 text-blue-900 font-bold tracking-wide hover:bg-blue-500 hover:text-white">Tambah</button>
                        </div>
                        <div class="py-3">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="border-b-2 py-3 px-3">Nama</th>
                                        <th class="border-b-2 py-3 px-3">NIP</th>
                                        <th class="border-b-2 py-3 px-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="agent in $page.props.agents" class="even:bg-slate-200">
                                        <td class="py-3 px-3">{{ agent.user.name }}</td>
                                        <td class="py-3 px-3 text-center">{{ agent.nip }}</td>
                                        <td class="py-3 px-3">
                                            <div class="flex justify-center gap-3">
                                                <button
                                                    @click="deleteAgentId = agent.id; isDeleteModalOpen = !isDeleteModalOpen"
                                                    class="bg-red-500 rounded-md py-2 px-5 text-white font-medium tracking-wide">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    <form @submit.prevent="createAgent">
                        <div class="mb-4">
                            <InputLabel for="name" value="Nama" />

                            <TextInput id="name" type="name" class="mt-1 block w-full p-2 border" v-model="form.name"
                                required autofocus autocomplete="name" />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="email" value="Email" />

                            <TextInput id="email" type="email" class="mt-1 block w-full p-2 border" v-model="form.email"
                                required autofocus autocomplete="email" />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="nip" value="NIP" />

                            <TextInput id="nip" type="nip" class="mt-1 block w-full p-2 border" v-model="form.nip" required
                                autofocus autocomplete="nip" />

                            <InputError class="mt-2" :message="form.errors.nip" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="password" value="Password" />

                            <TextInput id="password" type="password" class="mt-1 block w-full p-2 border"
                                v-model="form.password" required autocomplete="current-password" />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="password_confirmation" value="Konfirmasi Password" />

                            <Textarea id="password_confirmation" type="password" class="mt-1 block w-full p-2 border"
                                v-model="form.password_confirmation" required autocomplete="password_confirmation" />

                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>


                        <div class="flex items-center justify-end mb-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Log in
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>

        <Modal :show="isDeleteModalOpen" :maxWidth="'sm'">
            <div class="p-5">
                <div class="flex justify-between mb-5">
                    <h1 class="text-2xl font-bold">Hapus Sales</h1>
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
                    Apakah anda yakin ingin menghapus sales ini?
                </div>
                <form @submit.prevent="deleteAgent(deleteAgentId)">
                    <div class="flex items-center justify-between gap-4">
                        <button type="button" @click="isDeleteModalOpen = !isDeleteModalOpen"
                            class="w-full bg-red-500 text-white tracking-wide py-2.5 px-6 border-2 border-red-500 rounded-md hover:bg-white hover:text-red-950 font-bold">Batalkan</button>
                        <button 
                            class="w-full bg-blue-500 text-white tracking-wide py-2.5 px-6 border-2 border-blue-500 rounded-md hover:bg-white hover:text-blue-950 font-bold">Hapus</button>
                    </div>
                </form>
            </div>
        </Modal>

    </AuthenticatedLayout></template>
