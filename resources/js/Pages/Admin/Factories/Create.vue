<script setup>

import { useAccount } from "@wagmi/vue";
import { HiArrowLeft } from "oh-vue-icons/icons";

import PrimaryButton from "@/Components/PrimaryButton.vue";
import VueIcon from "@/Components/VueIcon.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CreateForm from "@/Pages/Admin/Factories/CreateForm.vue";

defineProps({
    foundry: { required: true, type: Object },
    config: { required: true, type: Object },
});

const { isConnected, chainId } = useAccount();

</script>
<template>

    <Head :title="`New Factory`" />
    <AdminLayout>
        <main class="h-full container sm:p-8">
            <div class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
                <div class="flex flex-col gap-4 h-full">
                    <div class="lg:flex items-center justify-between mb-4 gap-3">
                        <div class="mb-4 lg:mb-0">
                            <h3 class="h3">Deploy a new factory</h3>
                            <p>
                                The lastest factory on a network will be default
                                if more than one factory is active on that
                                newtwork
                            </p>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                            <PrimaryButton
                                size="sm"
                                link
                                :href="route('admin.factories.index')"
                            >
                                <VueIcon
                                    :icon="HiArrowLeft"
                                    class="w-4 h-4 -ml-1 mr-2 inline-block"
                                />
                                {{ $t("Back ") }}
                            </PrimaryButton>
                        </div>
                    </div>
                    <template v-if="isConnected">
                        <CreateForm
                            :key="chainId"
                            :foundry="foundry"
                            :config="config"
                        />
                    </template>

                </div>
            </div>
        </main>
    </AdminLayout>
</template>
