<script setup>
	import {
		ArrowLeft,
		ArrowRight,
		CheckCircle,
		XCircle,
	} from "lucide-vue-next";

	import BaseButton from "@/Components/BaseButton.vue";
	import Layout from "@/Pages/Install/Layout.vue";

	defineProps({
		requirements: {
			type: Object,
			required: true,
		},
		meets_requirements: {
			type: Boolean,
			required: true,
		},
	});
</script>

<template>
	<Layout
		title="System Requirements"
		description="Checking your system requirements"
		:current-step="1">
		<div class="space-y-6">
			<div class="divide-y divide-gray-200 dark:divide-gray-700">
				<div
					v-for="(met, requirement) in requirements"
					:key="requirement"
					class="flex items-center justify-between py-3">
					<div class="flex items-center">
						<span class="text-sm font-medium">
							{{ requirement }}
						</span>
					</div>
					<div class="flex items-center">
						<CheckCircle
							v-if="met"
							class="w-5 h-5 text-green-500" />
						<XCircle v-else class="w-5 h-5 text-red-500" />
					</div>
				</div>
			</div>

			<div class="flex justify-between">
				<BaseButton
					outlined
					secondary
					link
					:href="route('install.index')">
					<ArrowLeft class="w-4 h-4 -ml-1 mr-1 inline-flex" />
					Back
				</BaseButton>
				<BaseButton
					link
					:href="route('install.permissions')"
					:disabled="!meets_requirements">
					Continue to Permissions
					<ArrowRight class="w-4 h-4 ml-1 -mr-1 inline-flex" />
				</BaseButton>
			</div>

			<p v-if="!meets_requirements" class="text-sm text-red-500 mt-4">
				Please ensure all system requirements are met before continuing.
			</p>
		</div>
	</Layout>
</template>
