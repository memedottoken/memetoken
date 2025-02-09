<script setup>
	defineProps({ state: Object });
</script>
<template>
	<p
		v-if="state.error"
		class="mt-1 p-3 bg-red-300/10 !text-red-400 text-sm font-mono">
		{{ state.error }}
	</p>
	<p
		v-else
		:class="
			state.isConfirmed
				? '!text-green-500 bg-green-300/10'
				: '!text-gray-200 bg-gray-750'
		"
		class="p-3 text-sm font-mono">
		<span :class="{ 'text-green-500': state.isConfirmed }">
			{{ state.status }}
		</span>
		<a
			:href="state.etherScanLink"
			class="ml-2 mt-1 text-emerald-500"
			target="_blank"
			v-if="state.txhash">
			{{ state.shortTx }}
		</a>
	</p>
</template>
