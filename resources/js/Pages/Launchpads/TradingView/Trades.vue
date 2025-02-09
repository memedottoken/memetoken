<script setup>
	import { onMounted, onUnmounted, ref } from "vue";

	import { usePage } from "@inertiajs/vue3";

	import ChainSymbol from "@/Components/ChainSymbol.vue";
	import LargeDecimal from "@/Components/LargeDecimal.vue";
	import Pagination from "@/Components/Pagination.vue";
	const props = defineProps({
		trades: Object,
		chainId: Number,
	});
	const page = usePage();
	const launchpad = page.props.launchpad;
	const recentTrades = ref([...props.trades.data]);

	const formatNumber = (number) => {
		return new Intl.NumberFormat("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 8,
		}).format(number);
	};

	// WebSocket handling
	const handleNewTrade = (trade) => {
		recentTrades.value.unshift(trade);
		if (recentTrades.value.length > 12) {
			recentTrades.value.pop();
		}
	};

	// Lifecycle
	onMounted(() => {
		window.Echo.channel(`launchpad.${launchpad.id}`).listen(
			"NewTradeEvent",
			handleNewTrade,
		);
	});

	onUnmounted(() => {
		window.Echo.leave(`launchpad.${launchpad.id}`);
	});
</script>

<template>
	<div class="border rounded border-gray-200 dark:border-gray-700">
		<div class="">
			<table
				class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
				<thead>
					<tr>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Time
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Type
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Price
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Amount
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							<ChainSymbol :chainId="chainId" />
						</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
					<tr
						v-for="trade in recentTrades"
						:key="trade.id"
						:class="
							trade.type === 'prebond'
								? 'text-gray-300'
								: trade.type === 'buy'
								? 'text-emerald-400'
								: 'text-red-400'
						"
						class="text-sm hover:bg-gray-800">
						<td class="px-4 py-2 whitespace-nowrap">
							{{ trade.date }}
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							<span
								class="px-2 inline-flex text-xs uppercase leading-5 font-semibold rounded-full">
								{{ trade.type }}
							</span>
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							$
							<LargeDecimal :value="trade.usd_price" />
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							{{ parseFloat(trade.qty).toFixed() }}
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							{{ formatNumber(trade.amount) }}
						</td>
					</tr>
				</tbody>
			</table>
			<Pagination v-if="trades?.meta" :meta="trades.meta" />
		</div>
	</div>
</template>
