<!-- LaunchpadCard.vue -->
<script setup>
import { Link } from "@inertiajs/vue3";
import { Globe2, Send } from "lucide-vue-next";
import { DiscordIcon, XIcon } from "vue3-simple-icons";

import BaseButton from "@/Components/BaseButton.vue";
import { useBillions } from "@/hooks";
import NetworkIcon from "@/Icons/NetworkIcon.vue";

defineProps({
    launchpad: {
        type: Object,
        required: true,
    },
});

const formatVolume = (value) => {
    return `$${value}`;
};
</script>

<template>
    <Link :href="route('launchpads.show', { launchpad: launchpad.contract })">
    <div class="bg-gray-850 hover:bg-gray-800 rounded border border-gray-700 p-4 relative">
        <!-- Bonding Curve Type Banner -->
        <div
            v-if="launchpad.status"
            :class="launchpad.isFinalized
                    ? 'bg-red-500 text-white '
                    : launchpad.status == 'Prebond'
                        ? 'border border-gray-700 bg-gray-900 text-primary'
                        : 'bg-primary text-black '
                "
            class="absolute -top-3 left-1/2 -translate-x-1/2 uppercase text-center right-0 px-3 py-0.5 rounded-full text-xs font-medium"
        >
            {{ launchpad.status }}
        </div>
        <div class="text-white absolute right-2 top-2">
            <NetworkIcon
                class="w-5 h-5"
                :chainId="launchpad.chainId"
            />
        </div>
        <div class="grid">
            <!-- Token Image -->
            <div class="flex items-start gap-4 mb-1">
                <div class="relative">
                    <img
                        :src="launchpad.logo"
                        :alt="launchpad.name"
                        class="w-12 h-12 rounded"
                    />
                    <span class="absolute top-0 right-0 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                        {{ launchpad.percentage }}%
                    </span>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold">
                        {{ launchpad.name }} ({{ launchpad.symbol }})
                    </h3>
                    <div class="flex z-10 items-center gap-2">
                        <p>{{ launchpad.createdAgo }}</p>
                        <BaseButton
                            iconMode
                            outlined
                            secondary
                            size="xss"
                        >
                            <XIcon class="w-3 h-3" />
                        </BaseButton>
                        <BaseButton
                            iconMode
                            outlined
                            secondary
                            size="xss"
                        >
                            <Send class="w-3 h-3" />
                        </BaseButton>
                        <BaseButton
                            iconMode
                            outlined
                            secondary
                            size="xss"
                        >
                            <Globe2 class="w-3 h-3" />
                        </BaseButton>
                        <BaseButton
                            iconMode
                            outlined
                            secondary
                            size="xss"
                        >
                            <DiscordIcon class="w-3 h-3" />
                        </BaseButton>
                    </div>
                </div>
            </div>
            <!-- Token Info -->
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <div class="h-14">
                        <p
                            v-if="launchpad.description"
                            class="text-gray-400 line-clamp-3 text-sm mt-1"
                        >
                            {{ launchpad.description }}
                        </p>
                    </div>
                </div>
                <!-- Stats -->
                <div class="mt-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-primary text-lg">
                                {{ launchpad.percentage }}%
                            </span>
                            <span class="text-white">
                                MCap ${{ useBillions(launchpad.marketCap) }}
                            </span>
                        </div>
                        <div class="flex items-center text-gray-400 text-sm space-x-2">
                            <span>{{ launchpad.trades_count }} txns</span>
                            <span>/</span>
                            <span>
                                {{ formatVolume(launchpad.volume24h) }} 24h
                                vol
                            </span>
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-700 rounded-full h-1.5">
                        <div
                            class="h-full rounded-full bg-gradient-to-r to-emerald-500 from-primary"
                            :style="{
                                width: `${Math.min(
                                    launchpad.percentage,
                                    100,
                                )}%`,
                            }"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </Link>
</template>
