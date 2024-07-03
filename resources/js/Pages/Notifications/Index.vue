<template>
    <div>

        <Head title="Notifications Dashboard" />

        <h1 class="mb-8 text-xl font-bold text-indigo-700">Notifications Dashboard</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- BCP Section -->
            <div>
                <h2 class="text-xl font-semibold mb-4">BCP Notifications</h2>
                <div class="bg-white rounded-lg p-4 mb-8">
                    <h3 class="text-sm text-orange-500 font-semibold mb-2">Transactions by Date BCP</h3>
                    <column-chart :seriesData="bcpTransactionsData" :categories="bcpTransactionsCategories" />
                </div>

                <div class="bg-white rounded-lg p-4">
                    <h3 class="text-sm text-orange-500 font-semibold mb-2">Top 10 Depositors BCP</h3>
                    <bar-chart :seriesData="bcpTopDepositorsData" :categories="bcpTopDepositorsCategories" />
                </div>
            </div>

            <!-- IBK Section -->
            <div>
                <h2 class="text-xl font-semibold mb-4">IBK Notifications</h2>
                <div class="bg-white rounded-lg p-4  mb-8">
                    <h3 class="text-sm text-green-500 font-semibold mb-2">Transactions by Date IBK</h3>
                    <column-chart :seriesData="ibkTransactionsData" :categories="ibkTransactionsCategories" />
                </div>
                <div class="bg-white rounded-lg p-4">
                    <h3 class="text-sm text-green-500 font-semibold mb-2">Top 10 Depositors IBK</h3>
                    <bar-chart :seriesData="ibkTopDepositorsData" :categories="ibkTopDepositorsCategories" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ColumnChart from '@/Shared/ColumnChart.vue';
import BarChart from '@/Shared/BarChart.vue'
import Layout from '@/Layout/Layout.vue'
import { Head } from '@inertiajs/vue3'

export default {
    components: {
        Head,
        BarChart,
        ColumnChart,
    },
    props: {
        bcp: Object,
        ibk: Object,
    },
    layout: Layout,
    data() {
        return {
            selectedChartType: 'bar'
        }
    },
    computed: {

        // BCP
        bcpTopDepositorsData() {
            return this.bcp.topDepositors.map(depositor => depositor.total_amount)
        },
        bcpTopDepositorsCategories() {
            return this.bcp.topDepositors.map(depositor => depositor.beneficiary)
        },
        bcpTransactionsData() {
            return this.bcp.transactionsByDate.map(transaction => transaction.total_amount)
        },
        bcpTransactionsCategories() {
            return this.bcp.transactionsByDate.map(transaction => transaction.date)
        },

        // IBK
        ibkTopDepositorsData() {
            return this.ibk.topDepositors.map(depositor => depositor.total_amount)
        },
        ibkTopDepositorsCategories() {
            return this.ibk.topDepositors.map(depositor => depositor.beneficiary)
        },
        ibkTransactionsData() {
            return this.ibk.transactionsByDate.map(transaction => transaction.total_amount)
        },
        ibkTransactionsCategories() {
            return this.ibk.transactionsByDate.map(transaction => transaction.date)
        }
    }
}
</script>