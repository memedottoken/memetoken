<script setup>
	import { Link } from "@inertiajs/vue3";
	import { UserIcon } from "lucide-vue-next";

	import FormSwitch from "@/Components/FormSwitch.vue";
	import { shortenAddress } from "@/lib/wagmi";
</script>
<template>
	<div class="card border-0 card-border">
		<div class="card-body px-0 card-gutterless">
			<div
				class="flex flex-row card-body items-center justify-between mb-6">
				<div class="flex items-center gap-3">
					<UserIcon class="w-7 h-7 stroke-1 !text-sky-500" />
					<h4 class="">Latest 10 Users</h4>
				</div>
				<Link
					:href="route('admin.users.index')"
					class="button flex items-center bg-white border border-gray-300 dark:bg-gray-700 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 active:bg-gray-100 dark:active:bg-gray-500 dark:active:border-gray-500 text-gray-600 dark:text-gray-100 rounded-md h-9 px-3 py-2 text-sm">
					<Eye class="mr-2 -ml-1" />
					View All
				</Link>
			</div>
			<div>
				<div class="overflow-x-auto">
					<table class="table-default table-hover" role="table">
						<thead>
							<tr role="row">
								<th role="columnheader">
									{{ $t("User") }}
								</th>
								<th role="columnheader">
									{{ $t("Email") }}
								</th>
								<th role="columnheader">
									{{ $t("Verified") }}
								</th>
								<th role="columnheader">
									{{ $t("Date Time ") }}
								</th>
							</tr>
						</thead>
						<tbody role="rowgroup">
							<tr
								v-for="user in $page.props.users"
								:key="user.id"
								role="row">
								<td role="cell">
									<div
										class="flex flex-row align-middle items-center">
										<img
											class="w-5 h-5 mr-2 rounded-full"
											:src="user.profile_photo_url" />
										<span>
											{{
												shortenAddress(user.address, 8)
											}}
										</span>
									</div>
								</td>
								<td role="cell">
									{{ user.email }}
								</td>

								<td role="cell">
									<FormSwitch
										disabled
										:model-value="user.verified" />
								</td>
								<td role="cell">
									{{ user.joinedAgo }}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>
