<script setup>
	import { computed } from "vue";

	import { Link } from "@inertiajs/vue3";

	const props = defineProps({
		outlined: {
			type: Boolean,
			default: false,
		},
		link: {
			type: Boolean,
			default: false,
		},
		size: {
			type: String,
			default: "sm",
			validator: (value) =>
				["xs", "sm", "md", "lg", "xl"].includes(value),
		},
		iconMode: {
			type: Boolean,
			default: false,
		},
	});
	const comp = computed(() =>
		props.link ? Link : props.url ? "href" : "button",
	);
	const sizeClasses = computed(() => ({
		xs: props.iconMode
			? "w-6 h-6 text-xs"
			: "px-2.5 py-1.5 font-semibold text-xs",
		sm: props.iconMode ? "w-8 h-8 text-sm" : "px-3 py-2 text-sm",
		md: props.iconMode ? "w-10 h-10 text-base" : "px-4 py-2.5 text-base",
		lg: props.iconMode ? "w-12 h-12 text-lg" : "px-5 py-3 text-lg",
		xl: props.iconMode ? "w-14 h-14 text-xl" : "px-6 py-3.5 text-xl",
	}));
</script>

<template>
	<component
		:is="comp"
		:class="[
			'inline-flex items-center justify-center font-medium transition-colors duration-200',
			'focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2',
			sizeClasses[size],
			iconMode ? 'aspect-square p-0' : '',
			outlined
				? 'bg-transparent border-2 border-gray-400 text-gray-300 hover:bg-gray-700 hover:text-white'
				: 'bg-gray-600 text-white border-2 border-transparent hover:bg-gray-500 active:bg-gray-700',
			'rounded cursor-pointer',
		]"
		v-bind="$attrs">
		<slot></slot>
	</component>
</template>
