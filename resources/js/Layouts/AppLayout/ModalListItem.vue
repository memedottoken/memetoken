<script setup>
	import { useBillions } from "@/hooks";

	defineProps({
		rate: Number,
		config: Object,
	});
</script>
<template>
	<li class="flex items-center text-yellow-400">
		<DollarSign class="w-4 h-4 mr-2" />
		{{ config.bondingTarget }} {{ config.symbol }} (~${{
			useBillions(config.bondingTarget * rate)
		}})
	</li>
</template>
