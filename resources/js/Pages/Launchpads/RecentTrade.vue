<script setup>
import { Link } from "@inertiajs/vue3";
import { ArrowRightToLine } from "lucide-vue-next";

import ChainSymbol from "@/Components/ChainSymbol.vue";
import { useBillions } from "@/hooks";
import { shortenAddress } from "@/lib/wagmi";

defineProps({
    trade: Object,
});
</script>
<template>
    <Link
        class="px-2 text-white"
        v-if="trade?.contract"
        :href="route('launchpads.show', { launchpad: trade?.contract })"
    >
    <div class="bg-gray-800 border border-gray-700 hover:bg-gray-750 p-4 rounded">
        <div class="flex items-center justify-between rounded transition-colors duration-200">
            <span
                v-if="trade.type == 'sell'"
                class="text-red-300 rounded text-xs uppercase border px-3 py-1 border-red-500 bg-red-500/10 font-bold"
            >
                # SELL
            </span>
            <span
                v-if="trade.type == 'buy'"
                class="text-emerald-300 rounded text-xs uppercase border px-3 py-1 border-emerald-500 bg-emerald-500/10 font-bold"
            >
                # BUY
            </span>
            <span
                v-if="trade.type == 'prebond'"
                class="text-gray-300 rounded text-xs uppercase border px-3 py-1 border-gray-500 bg-gray-500/10 font-bold"
            >
                BOND
            </span>
            <div class="flex items-center gap-2">
                <img
                    :alt="trade.name"
                    class="block w-6 h-6 rounded-full"
                    :src="trade.logo"
                    loading="lazy"
                />
                <span
                    class="box-border f text-sm font-semibold break-words max-w-32 overflow-hidden text-ellipsis whitespace-nowrap"
                >
                    {{ useBillions(trade.qty) }} {{ trade.symbol }}
                </span>
                <ArrowRightToLine class="w-5 h-5 ml-2" />
                <div class="flex items-center text-sm font-semibold text-[#f0b90b]">
                    {{ parseFloat(trade.amount).toFixed(4) * 1 }}
                    <ChainSymbol :chain-id="trade.chainId" />
                </div>
                <div class="flex items-center text-sm font-semibold text-[#f0b90b]">
                    (~${{ useBillions(trade.usd) }})
                </div>
            </div>
        </div>
        <div class="flex mt-1 items-center justify-between">
            <div>{{ shortenAddress(trade.address, 10) }}</div>
            <div class="text-xs px-1.5 py-0.5 text-gray-400 border rounded-full border-gray-600">
                {{ trade.date }}
            </div>
        </div>
    </div>
    </Link>
</template>
