<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
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
                        <h1 class="text-2xl font-bold mb-4">Paket Penjualan</h1>
                        <div class="flex flex-col gap-4">
                            <div v-for="sales_package in $page.props.sales_packages.data"
                                class="rounded-md border border-grey-400 shadow w-full p-4 flex gap-4 items-start">
                                <div>
                                    <img v-bind:src="sales_package.media[0].original_url" alt="Foto Paket Penjualan"
                                        class="w-32 h-32 rounded-sm">
                                </div>
                                <div class="w-full">
                                    <h1 class="text-2xl font-bold mb-2">{{ sales_package.title }}</h1>
                                    <h1 class="text-xl font-medium text-gray-500 mb-2">{{ sales_package.subtitle }}</h1>
                                    <p class="text-md font-bold ">Harga:
                                        <span>
                                            {{ new Intl.NumberFormat('id-ID', {
                                                style: 'currency', currency: 'IDR'
                                            }).format(
                                                sales_package.price,
                                            ) }}
                                        </span>
                                    </p>
                                    <p class="text-sm">{{ sales_package.description }}</p>
                                </div>
                            </div>
                        </div>
                        <Pagination :links="$page.props.sales_packages.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
