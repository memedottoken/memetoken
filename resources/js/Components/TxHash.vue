<script setup>
	import { useTxHash } from "@/hooks/explorers";

	const props = defineProps({
		txhash: String,
		chainId: [String, Number],
		len: { type: Number, default: 33 },
	});
	const [shortTx, etherScanLink] = useTxHash(
		props.txhash,
		props.chainId,
		props.len,
	);
</script>
<template>
	<a
		:href="etherScanLink"
		target="_blank"
		class="cursor-pointer select-none font-semibold hover:text-primary">
		<slot>{{ shortTx }}</slot>
	</a>
</template>
