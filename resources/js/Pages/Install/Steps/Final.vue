<script setup>
	import { CheckCircle } from "lucide-vue-next";

	import BaseButton from "@/Components/BaseButton.vue";
	import Layout from "@/Pages/Install/Layout.vue";
</script>

<template>
	<Layout
		title="Installation Complete"
		description="Your application has been successfully configured"
		:current-step="4">
		<div class="space-y-6">
			<div class="text-center">
				<CheckCircle class="w-16 h-16 mx-auto text-green-500 mb-4" />

				<h3
					class="text-lg font-medium text-gray-900 dark:text-gray-100">
					Installation Successful!
				</h3>

				<p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
					Your application has been successfully configured and is
					ready to use.
				</p>
			</div>

			<div class="prose dark:prose-invert max-w-none">
				<h4>Next Steps:</h4>
				<ul>
					<li>Connect your wallet to access the admin dashboard</li>
					<li>Configure your site settings</li>
					<li>Start adding content to your application</li>
				</ul>
			</div>

			<div class="flex justify-center">
				<BaseButton link href="/">Go to Homepage</BaseButton>
			</div>
		</div>
	</Layout>
</template>
