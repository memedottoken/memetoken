<script setup>
	import { computed } from "vue";

	import { Link } from "@inertiajs/vue3";

	const props = defineProps({
		href: {
			type: String,
			required: true,
		},
		active: {
			type: Boolean,
		},
	});

	const classes = computed(() =>
		props.active
			? "inline-flex rounded items-center bg-gray-800 hover:bg-gray-750 px-3 py-2  text-sm font-medium leading-5  text-primary focus:outline-none focus:border-primary transition duration-150 ease-in-out"
			: "inline-flex rounded items-center  bg-gray-800 hover:bg-gray-750  px-3 py-2   text-sm font-medium leading-5 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300  transition duration-150 ease-in-out",
	);
</script>

<template>
	<div class="flex items-center">
		<Link :href="href" :class="classes">
			<slot />
		</Link>
	</div>
</template>
