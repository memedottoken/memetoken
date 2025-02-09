<script setup>
	import { computed } from "vue";

	import { NetworkIcon } from "@/Icons";
	import { networks } from "@/lib/wagmi";

	const props = defineProps({
		chainId: Number,
	});

	const chain = computed(() =>
		networks.find((c) => c.id === parseInt(props.chainId)),
	);
</script>
<template>
	<div v-if="chainId" class="flex flex-row align-middle items-center">
		<NetworkIcon
			class="w-5 h-5 rounded-full inline-table mr-3"
			:chain-id="chainId" />
		<span class="text-emerald-600 dark:text-emerald-400 font-bold text-xs">
			<slot>{{ chain?.name }}</slot>
		</span>
	</div>
</template>
