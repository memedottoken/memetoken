<script setup>
	import { computed } from "vue";

	import {
		Card,
		CardContent,
		CardDescription,
		CardHeader,
		CardTitle,
	} from "@/Components/ui/card";

	const steps = [
		{ name: "Welcome", route: "install.index" },
		{ name: "Requirements", route: "install.requirements" },
		{ name: "Permissions", route: "install.permissions" },
		{ name: "Environment", route: "install.environment" },
		{ name: "Final", route: "install.final" },
	];

	const props = defineProps({
		title: {
			type: String,
			required: true,
		},
		description: {
			type: String,
			default: "",
		},
		currentStep: {
			type: Number,
			required: true,
		},
	});

	const progress = computed(
		() => (props.currentStep / (steps.length - 1)) * 100,
	);
</script>

<template>
	<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
		<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Progress bar -->
			<div class="mb-8">
				<div class="relative">
					<div
						class="overflow-hidden h-2 bg-gray-200 dark:bg-gray-700 rounded">
						<div
							class="h-2 bg-primary transition-all duration-500 rounded"
							:style="{ width: `${progress}%` }"></div>
					</div>
					<div class="flex justify-between mt-2">
						<template
							v-for="(step, index) in steps"
							:key="step.name">
							<div
								class="flex flex-col items-center"
								:class="{
									'text-primary': index <= currentStep,
									'text-gray-400': index > currentStep,
								}">
								<div class="text-xs">{{ step.name }}</div>
							</div>
						</template>
					</div>
				</div>
			</div>

			<!-- Content -->
			<Card>
				<CardHeader>
					<CardTitle>
						<span class="text-primary">{{ title }}</span>
					</CardTitle>
					<CardDescription v-if="description">
						{{ description }}
					</CardDescription>
				</CardHeader>
				<hr class="border-gray-700 mb-6" />
				<CardContent>
					<slot></slot>
				</CardContent>
			</Card>
		</div>
	</div>
</template>
