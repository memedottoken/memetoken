<script setup>
	import { Clock, Eye, LucideScanQrCode } from "lucide-vue-next";

	import ChainSymbol from "@/Components/ChainSymbol.vue";
	import { useBillions } from "@/hooks";
	import { shortenAddress } from "@/lib/wagmi";
	import LatestUsers from "@/Pages/Admin/Dashboard/LatestUsers.vue";
	import MailSettings from "@/Pages/Admin/Dashboard/MailSettings.vue";
	import OrderBadge from "@/Pages/Admin/Dashboard/OrderBadge.vue";
	import SiteSettings from "@/Pages/Admin/Dashboard/SiteSettings.vue";

	defineProps({
		orders: Array,
		releases: Array,
	});
</script>
<template>
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
		<div class="lg:col-span-2 grid gap-8">
			<LatestUsers />
			<div class="card-border card">
				<div
					class="flex flex-row card-body items-center justify-between mb-6">
					<div class="flex items-center gap-3">
						<Clock class="w-7 h-7 stroke-1 !text-sky-500" />
						<h4 class="">Latest 10 Orders</h4>
					</div>
					<button
						class="button flex items-center bg-white border border-gray-300 dark:bg-gray-700 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 active:bg-gray-100 dark:active:bg-gray-500 dark:active:border-gray-500 text-gray-600 dark:text-gray-100 rounded-md h-9 px-3 py-2 text-sm">
						<Eye class="mr-2 -ml-1" />
						View All
					</button>
				</div>
				<div class="overflow-x-auto">
					<table class="table-default table-hover" role="table">
						<thead class="">
							<tr class="" role="row">
								<th class="" colspan="1" role="columnheader">
									Order
								</th>
								<th class="" colspan="1" role="columnheader">
									Type
								</th>
								<th class="" colspan="1" role="columnheader">
									Date
								</th>
								<th class="" colspan="1" role="columnheader">
									Customer
								</th>
								<th class="" colspan="1" role="columnheader">
									Amount
								</th>
							</tr>
						</thead>
						<tbody class="" role="rowgroup">
							<tr
								v-for="order in orders"
								:key="order.id"
								class=""
								role="row">
								<td class="" role="cell">
									<span
										class="cursor-pointer select-none font-semibold hover:text-blue-600">
										{{ useBillions(order.qty) }}
										{{ order.launchpad.symbol }}
									</span>
								</td>
								<td class="" role="cell">
									<OrderBadge
										:text="order.type"
										:type="
											order.type == 'prebond'
												? 'neutral'
												: order.type == 'buy'
												? 'success'
												: 'error'
										" />
								</td>
								<td class="" role="cell">
									<span>{{ order.date }}</span>
								</td>
								<td class="" role="cell">
									{{ shortenAddress(order.address, 8) }}
								</td>
								<td class="" role="cell">
									<ChainSymbol
										:chain-id="order.launchpad.chainId"
										v-slot="chain">
										<div
											class="flex flex-row align-middle items-center">
											{{
												parseFloat(
													order.amount,
												).toFixed(6) * 1
											}}
											<span class="ml-1">
												{{ chain?.symbol }}
											</span>
										</div>
									</ChainSymbol>
								</td>
							</tr>
							<!-- Empty State -->
							<tr v-if="!orders.length">
								<td
									colspan="5"
									class="px-6 py-10 text-center text-gray-500">
									<div
										class="h-[200px] flex flex-col items-center justify-center">
										<LucideScanQrCode
											class="h-16 opacity-50 w-16 stroke-[0.5]" />
										<h3 class="text-base">
											No orders found
										</h3>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div>
			<SiteSettings :setting="$page.props.setting" />
			<MailSettings class="mt-6" />
		</div>
	</div>
</template>
<style scoped>
	/* Optional: Add custom scrollbar styling */
	.table-container {
		@apply overflow-x-auto;
		scrollbar-width: thin;
	}

	/* Optional: Add responsive wrapper if needed */
	.table-responsive {
		@apply overflow-x-auto sm:rounded-lg shadow;
	}
</style>
