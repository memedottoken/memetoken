<script setup>
	import { computed } from "vue";

	import { networks } from "@/lib/wagmi";

	const props = defineProps({
		chainId: Number,
	});

	const chain = computed(() =>
		networks.find((c) => c.id === parseInt(props.chainId)),
	);
</script>
<template>
	<slot v-if="chainId && chain" :symbol="chain?.nativeCurrency.symbol">
		<span v-bind="$attrs">
			{{ chain?.nativeCurrency.symbol }}
		</span>
	</slot>
</template>
