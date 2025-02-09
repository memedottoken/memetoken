<script setup>
	import { ArrowRight } from "lucide-vue-next";

	import BaseButton from "@/Components/BaseButton.vue";
	import Layout from "@/Pages/Install/Layout.vue";
</script>

<template>
	<Layout
		title="Welcome to Memex Installation"
		description="Let's get your meme launchpad up and running"
		:current-step="0">
		<div class="space-y-6">
			<div class="prose dark:prose-invert max-w-none">
				<p class="!text-primary">
					Before we begin, please ensure you have the following
					information ready:
				</p>

				<code>
					<div class="bg-gray-800 rounded p-4 mt-4">
						<ul class="space-y-2 list-disc ml-4">
							<li>Your application URL (domain)</li>
							<li>
								CoinCap API Key (from
								<a
									class="hover:underline"
									href="https://coincap.io/api-key">
									https://coincap.io/api-key
								</a>
								)
							</li>
							<li>
								Project ID (from
								<a
									class="hover:underline"
									href="https://cloud.reown.com/">
									https://cloud.reown.com/
								</a>
								)
							</li>
							<li>
								Ankr API Key (from
								<a
									class="hover:underline"
									href="https://www.ankr.com/rpc/projects/">
									https://www.ankr.com/rpc/projects/
								</a>
								)
							</li>
							<li>Admin wallet addresses (comma-separated)</li>
						</ul>
					</div>
				</code>

				<p class="mt-4 !text-primary">
					This installation process will:
				</p>
				<ul class="mt-2 space-y-2 list-disc ml-8">
					<li>Check your system requirements</li>
					<li>Verify directory permissions</li>
					<li>Configure your environment settings</li>
					<li>Set up your application</li>
				</ul>
			</div>

			<div class="flex justify-end">
				<BaseButton outlined link :href="route('install.requirements')">
					Continue to Requirements
					<ArrowRight class="w-4 h-4 ml-1 -mr-1 inline-flex" />
				</BaseButton>
			</div>
		</div>
	</Layout>
</template>
