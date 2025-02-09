<script setup>
	import { ref } from "vue";

	import { Head, Link, router, useForm } from "@inertiajs/vue3";
	import { debouncedWatch, useUrlSearchParams } from "@vueuse/core";
	import { HiPencil, HiTrash } from "oh-vue-icons/icons";

	import ConfirmationModal from "@/Components/ConfirmationModal.vue";
	import Loading from "@/Components/Loading.vue";
	import Pagination from "@/Components/Pagination.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import SearchInput from "@/Components/SearchInput.vue";
	import VueIcon from "@/Components/VueIcon.vue";
	import AdminLayout from "@/Layouts/AdminLayout.vue";

	defineProps({
		holders: Object,
		title: { required: false, type: String },
	});

	const params = useUrlSearchParams("history");
	const search = ref(params.search ?? "");
	const deleteHolderForm = useForm({});
	const holderBeingDeleted = ref(null);

	const deleteHolder = () => {
		deleteHolderForm.delete(
			window.route("admin.holders.destroy", holderBeingDeleted.value?.id),
			{
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => (holderBeingDeleted.value = null),
			},
		);
	};
	debouncedWatch(
		[search],
		([search]) => {
			router.get(
				window.route("admin.holders.index"),
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

	const toggle = (holder) => {
		holder.busy = true;
		router.put(
			window.route("admin.holders.toggle", holder.id),
			{},
			{
				preserveScroll: true,
				preserveState: true,
				onFinish: () => {
					holder.busy = false;
					holderBeingDeleted.value = null;
				},
			},
		);
	};
</script>
<template>
	<Head :title="title ?? 'Holders'" />
	<AdminLayout>
		<main class="h-full">
			<div
				class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div
						class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">
								{{ $t("Manage Holders") }}
							</h3>
							<p>{{ $t("Available Holders") }}</p>
						</div>
						<div
							class="flex flex-col lg:flex-row lg:items-center gap-3">
							<PrimaryButton
								secondary
								link
								:href="route('admin.holders.create')">
								{{ $t("Create New Holders") }}
							</PrimaryButton>
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
													{{ $t("User Id") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Address") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Qty") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Prebond") }}
												</th>
												<td role="columnheader"></td>
											</tr>
										</thead>
										<tbody role="rowgroup">
											<tr
												v-for="holder in holders.data"
												:key="holder.id"
												role="row">
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ holder.launchpad_id }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ holder.user_id }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ holder.address }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ holder.qty }}
												</td>
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ holder.prebond }}
												</td>
												<td role="cell">
													<div
														class="flex justify-end text-lg">
														<Link
															:href="
																route(
																	'admin.holders.edit',
																	holder.id,
																)
															"
															class="cursor-pointer p-2 hover:text-blue-600">
															<VueIcon
																:icon="HiPencil"
																class="w-4 h-4" />
														</Link>
														<a
															href="#"
															@click.prevent="
																holderBeingDeleted =
																	holder
															"
															class="cursor-pointer p-2 hover:text-red-500">
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
								<Pagination :meta="holders.meta" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<ConfirmationModal
			:show="holderBeingDeleted"
			@close="holderBeingDeleted = null">
			<template #title>
				{{
					$t("Are you sure about deleting {holder} ?", {
						holder: holderBeingDeleted.name,
					})
				}}
			</template>

			<template #content>
				<p>
					{{
						$t(
							"This Action will remove the holder from the database and cannot be undone",
						)
					}}
				</p>
				<p>
					{{ $t("Its Recommended to Disable the holder Instead") }}
				</p>
			</template>

			<template #footer>
				<PrimaryButton
					primary
					class="uppercase text-xs font-semibold"
					@click="holderBeingDeleted = null">
					{{ $t("Cancel") }}
				</PrimaryButton>

				<PrimaryButton
					secondary
					class="ml-2 uppercase text-xs font-semibold"
					v-if="holderBeingDeleted.active"
					@click="toggle(holderBeingDeleted)">
					<Loading v-if="holderBeingDeleted.busy" />
					{{ $t("Disable") }}
				</PrimaryButton>

				<PrimaryButton
					error
					class="ml-2 uppercase text-xs font-semibold"
					@click="deleteHolder"
					:class="{ 'opacity-25': deleteHolderForm.processing }"
					:disabled="deleteHolderForm.processing">
					{{ $t("Delete") }}
				</PrimaryButton>
			</template>
		</ConfirmationModal>
	</AdminLayout>
</template>
