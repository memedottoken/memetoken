<script setup>
	import { Head } from "@inertiajs/vue3";

	// eslint-disable-next-line import/order
	import AdminLayout from "@/Layouts/AdminLayout.vue";
	import History from "@/Pages/Admin/Dashboard/History.vue";
	defineProps({
		stats: Array,
		trades: Array,
		releases: Array,
	});
</script>

<template>
	<Head title="Dashboard" />

	<AdminLayout>
		<div
			class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-4 sm:py-6 md:px-8">
			<div class="flex flex-col gap-4 h-full">
				<div class="lg:flex items-center justify-between mb-4 gap-3">
					<div class="mb-4 lg:mb-0">
						<h3>Welcome Admin</h3>
						<p>View your current earnings summary</p>
					</div>
				</div>
				<div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
					<div
						v-for="stat in stats"
						:key="stat.name"
						class="card card-border">
						<div class="card-body">
							<h6
								class="font-semibold text-gray-800 dark:text-gray-400 mb-4 text-sm">
								{{ stat.title }}
							</h6>
							<div class="flex justify-between items-center">
								<div>
									<div class="flex items-center">
										<h3 class="h3 font-bold">
											{{ stat.total }}
											<span v-if="stat.symbol">
												{{ stat.symbol }}
											</span>
										</h3>
									</div>

									<p>{{ stat.subtitle }}</p>
								</div>
								<div
									class="badge gap-1 font-bold border-0 text-amber-600 bg-amber-100 dark:bg-amber-500/10 dark:text-primary">
									{{ stat.today }}
									<span>Today</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<History :orders="trades" :releases="releases" />
			</div>
		</div>
	</AdminLayout>
</template>
