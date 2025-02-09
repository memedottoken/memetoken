<script setup>
	import { computed } from "vue";

	import { Link } from "@inertiajs/vue3";

	const props = defineProps({
		// Button type props
		primary: {
			type: Boolean,
			default: true,
		},
		secondary: {
			type: Boolean,
			default: false,
		},
		danger: {
			type: Boolean,
			default: false,
		},
		// Common props
		outlined: {
			type: Boolean,
			default: false,
		},
		link: {
			type: Boolean,
			default: false,
		},
		url: {
			type: Boolean,
			default: false,
		},
		size: {
			type: String,
			default: "sm",
			validator: (value) =>
				["xss", "xs", "sm", "md", "lg", "xl"].includes(value),
		},
		iconMode: {
			type: Boolean,
			default: false,
		},
	});

	const sizeClasses = computed(() => ({
		xss: props.iconMode ? "w-5 h-5 text-xs" : "px-1.5 py-0.5 text-xs",
		xs: props.iconMode
			? "w-6 h-6 text-xs"
			: "px-2.5 py-1.5 font-semibold text-xs",
		sm: props.iconMode ? "w-8 h-8 text-sm" : "px-3 py-2 text-sm",
		md: props.iconMode ? "w-10 h-10 text-base" : "px-4 py-2.5 text-base",
		lg: props.iconMode ? "w-12 h-12 text-lg" : "px-5 py-3 text-lg",
		xl: props.iconMode ? "w-14 h-14 text-xl" : "px-6 py-3.5 text-xl",
	}));

	const comp = computed(() =>
		props.link ? Link : props.url ? "a" : "button",
	);

	const colorClasses = computed(() => {
		if (props.danger) {
			return props.outlined
				? "bg-transparent border-red-400 text-red-400 hover:bg-red-600 hover:text-white focus:ring-red-500"
				: "bg-red-600 text-white  border-transparent hover:bg-red-500 active:bg-red-700 focus:ring-red-500";
		}

		if (props.secondary) {
			return props.outlined
				? "bg-transparent  border-gray-600 text-gray-300 hover:bg-gray-750 hover:text-white focus:ring-gray-400"
				: "bg-gray-700 text-gray-200 hover:text-white border-transparent hover:bg-gray-600 active:bg-gray-750 focus:ring-gray-400";
		}

		// Primary (default)
		return props.outlined
			? "bg-transparent  border-primary text-primary hover:bg-primary hover:text-black focus:ring-primary"
			: "bg-primary text-black  border-transparent hover:bg-primary-dark focus:ring-primary";
	});
</script>

<template>
	<component
		:is="comp"
		:class="[
			'inline-flex items-center justify-center font-medium transition-colors duration-200',
			'focus:outline-none focus:ring-2 focus:ring-offset-2',
			sizeClasses[size],
			iconMode ? 'aspect-square p-0' : '',
			colorClasses,
			['xss', 'xs'].includes(size) ? 'border' : 'border-2',
			'rounded cursor-pointer disabled:pointer-events-none disabled:opacity-70 ring-offset-gray-900',
		]"
		v-bind="$attrs">
		<slot></slot>
	</component>
</template>
