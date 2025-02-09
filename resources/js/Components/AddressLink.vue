<script setup>
	import { useAddress } from "@/hooks/explorers";

	const props = defineProps({
		address: String,
		chainId: [String, Number],
		len: { type: Number, default: 16 },
	});
	const [shortAddress, etherScanLink] = useAddress(
		props.address,
		props.chainId,
		props.len,
	);
</script>
<template>
	<slot :shortAddress="shortAddress" :etherScanLink="etherScanLink">
		<a
			:href="etherScanLink"
			target="_blank"
			class="cursor-pointer select-none font-semibold hover:text-primary">
			{{ shortAddress }}
		</a>
	</slot>
</template>
