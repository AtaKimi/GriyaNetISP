<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import html2pdf from 'html2pdf.js';

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-xl font-bold mb-4">Analitik</h1>
                        <div class="flex flex-wrap gap-6 justify-center">
                            <div
                                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Jumlah
                                    Pendapatan Sales</h5>
                                <p class="font-normal text-gray-700 dark:text-gray-400">Jumlah dari pendapatan sales selama
                                    ini adalah <span class="italic font-mono font-extrabold text-amber-600">
                                        {{ new Intl.NumberFormat('id-ID', {
                                            style: 'currency', currency: 'IDR'
                                        }).format(
                                            $page.props.agent_total_income,
                                        ) }}</span>
                                </p>
                            </div>
                            <div
                                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Jumlah
                                    Anggota Sales</h5>
                                <p class="font-normal text-gray-700 dark:text-gray-400">Anggota Sales pada Insitusi ini
                                    adalah <span class="text-blue-500 font-bold">{{ $page.props.agent_total }}</span></p>
                            </div>
                            <div
                                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Jumlah
                                    Paket Penjualan</h5>
                                <p class="font-normal text-gray-700 dark:text-gray-400">Jumlah Ragam Paket Penjualan selama
                                    ini adalah <span class="underline font-medium text-red-950">{{
                                        $page.props.sales_package_total }}</span>
                                </p>
                            </div>
                            <div
                                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Jumlah
                                    Transaksi Kostumer</h5>
                                <p class="font-normal text-gray-700 dark:text-gray-400">Jumlah Transaksi yang sudah
                                    dilakukan dengan kostumer adalah <span class="text-green-600 font-black text-lg">{{
                                        $page.props.customer_transaction_total }}</span>
                                </p>
                            </div>
                            <div
                                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Jumlah
                                    Transaksi Kostumer Yang Ditermia / yang belum diterima</h5>
                                <p
                                    class="font-normal text-center text-3xl bg-slate-50 rounded-lg py-4  text-gray-700 dark:text-gray-400">
                                    <span class="text-green-600 font-bold tracking-widest">{{
                                        $page.props.validated_customer_transaction_total }}</span>/<span
                                        class="text-red-600 font-bold tracking-widest">{{
                                            $page.props.unvalidated_customer_transaction_total }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="mt-16 py-8 px-4 rounded-md border-t bg-slate-100">
                            <div class="flex justify-between mb-4 items-center">
                                <h1 class="text-xl font-bold">Data Penjualan Sales</h1>
                                <button type="button" @click="html2pdf($refs.exportToPdf)"
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Export
                                    PDF</button>
                            </div>
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" ref="exportToPdf">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Agent
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jumlah Transaksi Kostumer
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jumlah Transaksi Kostumer Tervalidasi
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jumlah Pendapatan (Tervalidasi)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="agent in $page.props.agents"
                                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ agent.user.name }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ agent.customer_transactions.length }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ agent.validated_customer_transaction.length }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ new Intl.NumberFormat('id-ID', {
                                                    style: 'currency', currency: 'IDR'
                                                }).format(
                                                    agent.total_income,
                                                ) }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
