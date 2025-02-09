<template>
	<button
		:class="[
			'inline-flex items-center justify-center font-medium transition-colors duration-200',
			'focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2',
			sizeClasses[size],
			iconMode ? 'aspect-square p-0' : '',
			outlined
				? 'bg-transparent border-2 border-red-400 text-red-400 hover:bg-red-600 hover:text-white'
				: 'bg-red-600 text-white border-2 border-transparent hover:bg-red-500 active:bg-red-700',
			'rounded cursor-pointer',
		]"
		v-bind="$attrs">
		<slot></slot>
	</button>
</template>

<script setup>
	import { computed } from "vue";

	const props = defineProps({
		outlined: {
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
