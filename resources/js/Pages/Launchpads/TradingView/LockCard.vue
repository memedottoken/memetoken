<script setup>
	import { useAccount } from "@wagmi/vue";
	import { Vault } from "lucide-vue-next";

	import BaseButton from "@/Components/BaseButton.vue";
	import ChainSymbol from "@/Components/ChainSymbol.vue";
	import CountDownWhite from "@/Components/CountDownWhite.vue";
	import TxStatus from "@/Components/TxStatus.vue";
	import {
		useLockInfo,
		useReactiveContractCall,
	} from "@/hooks/useContractCall";
	const props = defineProps({
		launchpad: Object,
	});

	const info = useLockInfo(props.launchpad);
	const state = useReactiveContractCall(
		props.launchpad.factory.lock_abi,
		props.launchpad.factory.lock,
	);
	const { address } = useAccount();
	const claimFees = async () => {
		await state.call("claimFees", [info.lpTokenId], 0, null);
		if (state.error) return;
		info.updateInfo();
	};

	const unlockNft = async () => {
		await state.call("unlockNFT", [info.lpTokenId, address.value], 0, null);
		if (state.error) return;
		info.updateInfo();
	};
</script>

<template>
	<div v-if="info.currentPhase === 2" class="w-full grid gap-4">
		<div
			class="bg-gray-800 p-4 text-center rounded-lg border border-none text-gray-400 grid gap-4">
			<h3 class="text-lg font-medium flex justify-center items-center">
				<Vault class="w-5 h-5 mr-2 inline-flex" />
				{{ $t("Claim Uniswap fees") }}
			</h3>
			<h3 class="font-extralight !text-primary">
				{{ parseFloat(info.tokenFees).toFixed(8) * 1 }}
				{{ launchpad.symbol }}
			</h3>
			<hr class="my-2 border-gray-650" />
			<h3 class="font-extralight !text-primary">
				{{ parseFloat(info.wethFees).toFixed(8) * 1 }}
				<ChainSymbol :chainId="launchpad.chainId" />
			</h3>
			<TxStatus v-if="state.called === 'claimFees'" :state="state" />
			<BaseButton secondary outlined @click="claimFees">
				{{ $t("Claim fees") }}
			</BaseButton>
		</div>
		<div
			v-if="info.isLocked"
			class="p-4 text-center rounded-lg border border-gray-800 text-gray-400 grid gap-4">
			<h3 class="font-extralight !text-primary">Unlock Timeleft</h3>
			<CountDownWhite
				simple
				v-if="info.unlocksAt > 0"
				:timestamp="info.unlocksAt" />
			<TxStatus v-if="state.called === 'unlockNFT'" :state="state" />
			<BaseButton primary outlined @click="unlockNft">
				{{ $t("Unlock Liquidity") }}
			</BaseButton>
		</div>
	</div>
</template>
