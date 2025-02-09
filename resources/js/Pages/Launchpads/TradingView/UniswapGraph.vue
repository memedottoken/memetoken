<script setup>
	import { Card } from "@/Components/ui/card";

	defineProps({
		priceChanges: {
			type: Object,
			default: () => ({
				"1H": 0,
				"24H": 0,
				"7D": 0,
			}),
		},
		stats: {
			type: Object,
			default: () => ({
				volume24h: 0,
				tvl: 0,
				feeTier: 0.3,
				transactions24h: 0,
				totalTransactions: 0,
				liquidity: 0,
				currentPrice: 0,
				minPrice: 0,
				maxPrice: 0,
			}),
		},
	});

	const formatCurrency = (value) => {
		return new Intl.NumberFormat("en-US", {
			style: "currency",
			currency: "USD",
			notation: "compact",
			maximumFractionDigits: 2,
		}).format(value);
	};

	const formatPrice = (value) => {
		return new Intl.NumberFormat("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 6,
		}).format(value);
	};

	const formatPercent = (value) => {
		const num = parseFloat(value);
		return `${num >= 0 ? "+" : ""}${num.toFixed(2)}%`;
	};

	const getPriceChangeClass = (value) => {
		const num = parseFloat(value);
		return num >= 0 ? "text-green-500" : "text-red-500";
	};
</script>
<template>
	<Card class="bg-gray-900 text-white p-6 rounded-xl">
		<!-- Price Changes -->
		<div class="grid grid-cols-3 gap-4 mb-6">
			<div
				v-for="(value, period) in priceChanges"
				:key="period"
				class="text-center">
				<div class="text-gray-400 text-sm mb-1">{{ period }}</div>
				<div :class="getPriceChangeClass(value)">
					{{ formatPercent(value) }}
				</div>
			</div>
		</div>

		<!-- Pool Stats -->
		<div class="bg-gray-800 rounded-lg p-4 space-y-6">
			<!-- Volume & Liquidity -->
			<div class="grid grid-cols-3 gap-4">
				<div>
					<div class="text-gray-400 text-sm mb-1">24H VOLUME</div>
					<div class="text-lg font-semibold">
						{{ formatCurrency(stats.volume24h) }}
					</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">TVL</div>
					<div class="text-lg font-semibold">
						{{ formatCurrency(stats.tvl) }}
					</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">FEE TIER</div>
					<div class="text-lg font-semibold">
						{{ stats.feeTier }}%
					</div>
				</div>
			</div>

			<!-- Transactions -->
			<div class="grid grid-cols-3 gap-4">
				<div>
					<div class="text-gray-400 text-sm mb-1">24H TXNS</div>
					<div class="text-lg font-semibold">
						{{ stats.transactions24h }}
					</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">TOTAL TXNS</div>
					<div class="text-lg font-semibold">
						{{ stats.totalTransactions }}
					</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">LIQUIDITY</div>
					<div class="text-lg font-semibold">
						{{ formatCurrency(stats.liquidity) }}
					</div>
				</div>
			</div>

			<!-- Price Info -->
			<div class="grid grid-cols-2 gap-4">
				<div>
					<div class="text-gray-400 text-sm mb-1">CURRENT PRICE</div>
					<div class="text-lg font-semibold">
						{{ formatPrice(stats.currentPrice) }}
					</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">PRICE RANGE</div>
					<div class="text-lg font-semibold">
						{{ formatPrice(stats.minPrice) }} -
						{{ formatPrice(stats.maxPrice) }}
					</div>
				</div>
			</div>
		</div>
	</Card>
</template>
