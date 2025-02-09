<script setup>
	import { Link } from "@inertiajs/vue3";

	defineProps({
		href: {
			type: String,
			required: true,
		},
		active: Boolean,
	});
</script>

<template>
	<Link
		:href="href"
		:class="active ? 'text-primary' : 'text-gray-700 dark:text-gray-300'"
		class="block w-full px-4 py-2 text-start text-sm leading-5 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
		<slot />
	</Link>
</template>
