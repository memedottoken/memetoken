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
		permissions: {
			type: Object,
			required: true,
		},
		meets_permissions: {
			type: Boolean,
			required: true,
		},
	});
</script>

<template>
	<Layout
		title="Directory Permissions"
		description="Checking directory write permissions"
		:current-step="2">
		<div class="space-y-6">
			<div class="divide-y divide-gray-200 dark:divide-gray-700">
				<div
					v-for="(isWritable, directory) in permissions"
					:key="directory"
					class="flex items-center justify-between py-3">
					<div class="flex items-center">
						<span class="text-sm font-medium">{{ directory }}</span>
					</div>
					<div class="flex items-center">
						<CheckCircle
							v-if="isWritable"
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
					:href="route('install.requirements')">
					<ArrowLeft class="w-4 h-4 -ml-1 mr-1 inline-flex" />
					Back
				</BaseButton>
				<BaseButton
					link
					:href="route('install.environment')"
					:disabled="!meets_permissions">
					Continue to Environment Setup
					<ArrowRight class="w-4 h-4 ml-1 -mr-1 inline-flex" />
				</BaseButton>
			</div>

			<p v-if="!meets_permissions" class="text-sm text-red-500 mt-4">
				Please ensure all directories are writable before continuing.
				<br />
				You may need to run:
				<code>chmod -R 775 storage bootstrap/cache</code>
			</p>
		</div>
	</Layout>
</template>
