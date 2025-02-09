<script setup>
	import { ref } from "vue";

	import { Head, router, useForm } from "@inertiajs/vue3";
	import { debouncedWatch, useUrlSearchParams } from "@vueuse/core";
	import { HiTrash } from "oh-vue-icons/icons";

	import ConfirmationModal from "@/Components/ConfirmationModal.vue";
	import DangerButton from "@/Components/DangerButton.vue";
	import Pagination from "@/Components/Pagination.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import SearchInput from "@/Components/SearchInput.vue";
	import SecondaryButton from "@/Components/SecondaryButton.vue";
	import VueIcon from "@/Components/VueIcon.vue";
	import AdminLayout from "@/Layouts/AdminLayout.vue";
	import { shortenAddress } from "@/lib/wagmi";

	defineProps({
		msgs: Object,
		statuses: { required: false, type: Array },
	});

	const params = useUrlSearchParams("history");
	const search = ref(params.search ?? "");
	const deleteMsgForm = useForm({});
	const msgBeingDeleted = ref(null);

	const deleteMsg = () => {
		deleteMsgForm.delete(
			window.route("admin.msgs.destroy", msgBeingDeleted.value?.id),
			{
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => (msgBeingDeleted.value = null),
			},
		);
	};
	debouncedWatch(
		[search],
		([search]) => {
			router.get(
				window.route("admin.msgs.index"),
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

	const toggle = (msg, status) => {
		router.put(
			window.route("admin.msgs.status", { msg: msg.id, status }),
			{},
			{
				preserveScroll: true,
				preserveState: true,
			},
		);
	};
	const ucfirst = (string) => {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};
</script>
<template>
	<Head :title="title ?? 'Msgs'" />
	<AdminLayout>
		<main class="h-full">
			<div
				class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div
						class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">
								{{ $t("Manage Messages") }}
							</h3>
							<p>
								{{ $t("Available Messages in the group chat") }}
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
													{{ $t("User") }}
												</th>
												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Launch") }}
												</th>

												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("Message") }}
												</th>

												<th
													scope="col"
													class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{ $t("MODERATION") }}
												</th>
												<td role="columnheader"></td>
											</tr>
										</thead>
										<tbody role="rowgroup">
											<tr
												v-for="msg in msgs.data"
												:key="msg.id"
												role="row">
												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													{{
														shortenAddress(
															msg.user.address,
														)
													}}
												</td>
												<td
													class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ msg.launchpad.symbol }}
												</td>

												<td
													class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">
													{{ msg.message }}
												</td>

												<td
													class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
													<div
														class="flex items-center gap-2">
														<PrimaryButton
															@click="
																toggle(
																	msg,
																	status,
																)
															"
															v-for="status in statuses"
															:key="status"
															:outlined="
																status !=
																msg.status
															"
															size="xss">
															{{
																ucfirst(status)
															}}
														</PrimaryButton>
													</div>
												</td>
												<td role="cell">
													<div
														class="flex justify-end text-lg">
														<a
															href="#"
															@click.prevent="
																msgBeingDeleted =
																	msg
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
								<Pagination :meta="msgs.meta" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<ConfirmationModal
			:show="msgBeingDeleted"
			@close="msgBeingDeleted = null">
			<template #title>
				{{
					$t("Are you sure about deleting {msg} ?", {
						msg: msgBeingDeleted.name,
					})
				}}
			</template>

			<template #content>
				<p>
					{{
						$t(
							"This Action will remove the msg from the database and cannot be undone",
						)
					}}
				</p>
				<p>
					{{ $t("Its Recommended to Disable the msg Instead") }}
				</p>
			</template>

			<template #footer>
				<SecondaryButton
					class="uppercase text-xs font-semibold"
					@click="msgBeingDeleted = null">
					{{ $t("Cancel") }}
				</SecondaryButton>

				<DangerButton
					error
					class="ml-2 uppercase text-xs font-semibold"
					@click="deleteMsg"
					:class="{ 'opacity-25': deleteMsgForm.processing }"
					:disabled="deleteMsgForm.processing">
					{{ $t("Delete") }}
				</DangerButton>
			</template>
		</ConfirmationModal>
	</AdminLayout>
</template>
