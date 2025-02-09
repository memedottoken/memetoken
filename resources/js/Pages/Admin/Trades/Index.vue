<script setup>
	import { ref } from "vue";

	import { Head, router, useForm } from "@inertiajs/vue3";
	import { debouncedWatch, useUrlSearchParams } from "@vueuse/core";
	import { HiTrash } from "oh-vue-icons/icons";

	import ChainSymbol from "@/Components/ChainSymbol.vue";
	import ConfirmationModal from "@/Components/ConfirmationModal.vue";
	import Pagination from "@/Components/Pagination.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import SearchInput from "@/Components/SearchInput.vue";
	import SecondaryButton from "@/Components/SecondaryButton.vue";
	import TxHash from "@/Components/TxHash.vue";
	import VueIcon from "@/Components/VueIcon.vue";
	import { useBillions } from "@/hooks";
	import AdminLayout from "@/Layouts/AdminLayout.vue";
	import OrderBadge from "@/Pages/Admin/Dashboard/OrderBadge.vue";

	defineProps({
		trades: Object,
		title: { required: false, type: String },
	});

	const params = useUrlSearchParams("history");
	const search = ref(params.search ?? "");
	const deleteTradeForm = useForm({});
	const tradeBeingDeleted = ref(null);

	const deleteTrade = () => {
		deleteTradeForm.delete(
			window.route("admin.trades.destroy", tradeBeingDeleted.value?.id),
			{
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => (tradeBeingDeleted.value = null),
			},
		);
	};
	debouncedWatch(
		[search],
		([search]) => {
			router.get(
				window.route("admin.trades.index"),
				{ search },
				{
					preserveState: true,
					preserveScroll: true,
				},
			);
		},
		{
			maxWait: 700,
		},
	);
</script>
<template>
	<Head :title="title ?? 'Trades'" />
	<AdminLayout>
		<main class="h-full">
			<div
				class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div
						class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">
								{{ $t("Manage Trades") }}
							</h3>
							<p>
								{{
									$t(
										"View Trades on the bonding curve, updated every five minutes",
									)
								}}
							</p>
						</div>
					</div>
					<div class="card border-0 card-border">
						<div class="card-body card-gutterless h-full">
							<div
								class="lg:flex items-center justify-end mb-4 px-6">
								<div class="flex gap-x-3 sm:w-1/2 lg:w-1/4">
									<SearchInput
										class="max-w-md"
										v-model="search" />
								</div>
							</div>
							<div>
								<div class="overflow-x-auto">
									<table
										class="table-default table-hover"
										role="table">
										<thead>
											<tr role="row">
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Launchpad Id") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Txid") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Qty") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Amount") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Type") }}
												</th>
												<td role="columnheader"></td>
											</tr>
										</thead>
										<tbody role="rowgroup">
											<tr
												v-for="trade in trades.data"
												:key="trade.id"
												role="row">
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ trade.launchpad.name }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													<TxHash
														:chainId="
															trade.launchpad
																.chainId
														"
														:len="14"
														:txhash="trade.txid" />
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ useBillions(trade.qty) }}
													{{ trade.launchpad.symbol }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{
														parseFloat(
															trade.amount,
														).toFixed(5) * 1
													}}
													<ChainSymbol
														:chainId="
															trade.launchpad
																.chainId
														" />
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													<OrderBadge
														:text="trade.type"
														:type="
															trade.type ==
															'prebond'
																? 'neutral'
																: trade.type ==
																  'buy'
																? 'success'
																: 'error'
														" />
												</td>
												<td role="cell">
													<div
														class="flex justify-end text-lg">
														<a
															href="#"
															@click.prevent="
																tradeBeingDeleted =
																	trade
															"
															class="cursor-pointer link p-2 hover:text-red-500">
															<VueIcon
																:icon="HiTrash"
																class="w-4 h-4" />
														</a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<Pagination :meta="trades.meta" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<ConfirmationModal
			:show="tradeBeingDeleted"
			@close="tradeBeingDeleted = null">
			<template #title>
				{{
					$t("Are you sure about deleting {trade} ?", {
						trade: tradeBeingDeleted.name,
					})
				}}
			</template>

			<template #content>
				<p>
					{{
						$t(
							"This Action will remove the trade from the database but the trade record will remain on the blockchain",
						)
					}}
				</p>
				<p>
					{{ $t("A next sync event may reload the trade!") }}
				</p>
			</template>

			<template #footer>
				<SecondaryButton
					class="uppercase text-xs font-semibold"
					@click="tradeBeingDeleted = null">
					{{ $t("Cancel") }}
				</SecondaryButton>

				<PrimaryButton
					error
					class="ml-2 uppercase text-xs font-semibold"
					@click="deleteTrade"
					:class="{ 'opacity-25': deleteTradeForm.processing }"
					:disabled="deleteTradeForm.processing">
					{{ $t("Delete") }}
				</PrimaryButton>
			</template>
		</ConfirmationModal>
	</AdminLayout>
</template>
