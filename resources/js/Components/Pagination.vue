<script setup>
	import {
		ChevronLeftIcon,
		ChevronRightIcon,
	} from "@heroicons/vue/24/outline";
	import { Link } from "@inertiajs/vue3";

	defineProps({
		meta: Object,
	});
</script>
<template>
	<!-- pagination buttons -->
	<div
		v-if="meta?.links?.length > 3"
		class="mt-5 flex space-x-2 text-xs items-center justify-center">
		<template v-for="link in meta.links" :key="link.label">
			<Link
				v-if="link.label == 'pagination.previous'"
				:href="link.url"
				as="button"
				:disabled="!link.url"
				class="disabled:pointer-events-none disabled:bg-gray-50 dark:disabled:bg-gray-700 disabled:text-gray-400 rounded px-2 py-1 text-gray-500 dark:text-white font-semibold bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 hover:border-emerald-500 dark:hover:border-emerald-500 transition duration-200">
				<ChevronLeftIcon class="w-4 h-4" />
			</Link>
			<Link
				v-else-if="link.label == 'pagination.next'"
				:href="link.url"
				:disabled="!link.url"
				class="disabled:pointer-events-none disabled:bg-gray-50 dark:disabled:bg-gray-700 disabled:text-gray-400 rounded px-2 py-1 text-gray-500 dark:text-white font-semibold bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-600 hover:border-emerald-500 dark:hover:border-emerald-500 transition duration-200">
				<ChevronRightIcon class="w-4 h-4" />
			</Link>

			<Link
				v-else
				:disabled="link.active"
				:href="link.url"
				:class="
					link.active
						? 'text-emerald-500 dark:text-emerald-400  border-emerald-500 dark:border-emerald-500'
						: ' text-gray-900 dark:text-white  border-gray-200 dark:border-gray-600'
				"
				class="rounded px-2 py-1 font-semibold bg-white dark:bg-gray-800 border hover:border-emerald-500 dark:hover:border-emerald-500 transition duration-200">
				{{ link.label }}
			</Link>
		</template>

		<!-- active class text-emerald-500 border-emerald-500 dark:border-emerald-500 -->
	</div>
	<!-- ./ pagination buttons -->
</template>
