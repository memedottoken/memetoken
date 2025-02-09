<script setup>
	import { ref } from "vue";

	import { Head, router, useForm } from "@inertiajs/vue3";
	import { debouncedWatch, useUrlSearchParams } from "@vueuse/core";
	import { HiTrash } from "oh-vue-icons/icons";

	import ChainInfo from "@/Components/ChainInfo.vue";
	import ConfirmationModal from "@/Components/ConfirmationModal.vue";
	import FormSwitch from "@/Components/FormSwitch.vue";
	import Loading from "@/Components/Loading.vue";
	import Pagination from "@/Components/Pagination.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import SearchInput from "@/Components/SearchInput.vue";
	import SecondaryButton from "@/Components/SecondaryButton.vue";
	import VueIcon from "@/Components/VueIcon.vue";
	import AdminLayout from "@/Layouts/AdminLayout.vue";
	import { shortenAddress } from "@/lib/wagmi";

	defineProps({
		launchpads: Object,
		title: { required: false, type: String },
	});

	const params = useUrlSearchParams("history");
	const search = ref(params.search ?? "");
	const deleteLaunchpadForm = useForm({});
	const launchpadBeingDeleted = ref(null);

	const deleteLaunchpad = () => {
		deleteLaunchpadForm.delete(
			window.route(
				"admin.launchpads.destroy",
				launchpadBeingDeleted.value?.id,
			),
			{
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => (launchpadBeingDeleted.value = null),
			},
		);
	};
	debouncedWatch(
		[search],
		([search]) => {
			router.get(
				window.route("admin.launchpads.index"),
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

	const toggle = (launchpad) => {
		router.put(
			window.route("admin.launchpads.toggle", launchpad.id),
			{},
			{
				preserveScroll: true,
				preserveState: true,
			},
		);
	};

	const featured = (launchpad) => {
		router.put(
			window.route("admin.launchpads.featured", launchpad.id),
			{},
			{
				preserveScroll: true,
				preserveState: true,
			},
		);
	};

	const kingofthehill = (launchpad) => {
		router.put(
			window.route("admin.launchpads.kingofthehill", launchpad.id),
			{},
			{
				preserveScroll: true,
				preserveState: true,
			},
		);
	};
</script>
<template>
	<Head :title="title ?? 'Launchpads'" />
	<AdminLayout>
		<main class="h-full">
			<div
				class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div
						class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">
								{{ $t("Manage Launchpads") }}
							</h3>
							<p>{{ $t("Available Launchpads") }}</p>
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
													{{ $t("User Id") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Name") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Symbol") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Chainid") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Status") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Featured") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("King") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Active") }}
												</th>
												<td role="columnheader"></td>
											</tr>
										</thead>
										<tbody role="rowgroup">
											<tr
												v-for="launchpad in launchpads.data"
												:key="launchpad.id"
												role="row">
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{
														shortenAddress(
															launchpad.user
																.address,
														)
													}}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ launchpad.name }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ launchpad.symbol }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													<ChainInfo
														:chain-id="
															launchpad.chainId
														" />
												</td>

												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ launchpad.status }}
												</td>

												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													<FormSwitch
														:model-value="
															launchpad.featured
														"
														@update:model-value="
															featured(launchpad)
														" />
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													<FormSwitch
														:model-value="
															launchpad.kingofthehill
														"
														@update:model-value="
															kingofthehill(
																launchpad,
															)
														" />
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													<FormSwitch
														:model-value="
															launchpad.active
														"
														@update:model-value="
															toggle(launchpad)
														" />
												</td>
												<td role="cell">
													<div
														class="flex justify-end text-lg">
														<a
															href="#"
															@click.prevent="
																launchpadBeingDeleted =
																	launchpad
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
								<Pagination :meta="launchpads.meta" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<ConfirmationModal
			:show="launchpadBeingDeleted"
			@close="launchpadBeingDeleted = null">
			<template #title>
				{{
					$t("Are you sure about deleting {launchpad} ?", {
						launchpad: launchpadBeingDeleted.name,
					})
				}}
			</template>

			<template #content>
				<p>
					{{
						$t(
							"This Action will remove the launchpad from the database and cannot be undone",
						)
					}}
				</p>
				<p>
					{{ $t("Its Recommended to Disable the launchpad Instead") }}
				</p>
			</template>

			<template #footer>
				<SecondaryButton
					outlined
					class="uppercase text-xs font-semibold"
					@click="launchpadBeingDeleted = null">
					{{ $t("Cancel") }}
				</SecondaryButton>

				<SecondaryButton
					class="ml-2 uppercase text-xs font-semibold"
					v-if="launchpadBeingDeleted.active"
					@click="toggle(launchpadBeingDeleted)">
					<Loading v-if="launchpadBeingDeleted.busy" />
					{{ $t("Disable") }}
				</SecondaryButton>

				<PrimaryButton
					error
					class="ml-2 uppercase text-xs font-semibold"
					@click="deleteLaunchpad"
					:class="{ 'opacity-25': deleteLaunchpadForm.processing }"
					:disabled="deleteLaunchpadForm.processing">
					{{ $t("Delete") }}
				</PrimaryButton>
			</template>
		</ConfirmationModal>
	</AdminLayout>
</template>
