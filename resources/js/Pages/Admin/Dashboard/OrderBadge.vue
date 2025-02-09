<script setup>
	import { computed } from "vue";

	const props = defineProps({
		type: {
			type: String,
			default: "neutral",
			validator: (value) =>
				["success", "error", "warning", "neutral", "info"].includes(
					value,
				),
		},
		text: {
			type: String,
			required: true,
		},
	});

	// Color mappings for different states
	const colorMap = {
		success: {
			dot: "bg-emerald-500",
			text: "text-emerald-500",
		},
		error: {
			dot: "bg-red-500",
			text: "text-red-500",
		},
		warning: {
			dot: "bg-amber-500",
			text: "text-amber-500",
		},
		neutral: {
			dot: "bg-gray-500",
			text: "text-gray-500",
		},
		info: {
			dot: "bg-blue-500",
			text: "text-blue-500",
		},
	};

	// Computed styles based on type
	const badgeStyles = computed(() => colorMap[props.type]);
</script>

<template>
	<div class="flex items-center">
		<span class="badge-dot" :class="badgeStyles.dot"></span>
		<span class="ml-2 capitalize font-semibold" :class="badgeStyles.text">
			{{ text }}
		</span>
	</div>
</template>

<style scoped>
	.badge-dot {
		@apply h-2 w-2 rounded-full;
	}
</style>
