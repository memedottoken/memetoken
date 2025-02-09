<script setup>
	import FlashMessages from "@/Layouts/AppLayout/FlashMessages.vue";
	import Footer from "@/Layouts/AppLayout/Footer.vue";
	import TopNav from "@/Layouts/AppLayout/TopNav.vue";
	// Props
	defineProps({
		title: {
			type: String,
			default: "",
		},
		compact: Boolean,
	});

	// We'll add state management and other functionality as needed
</script>
<template>
	<div class="min-h-screen bg-gray-900">
		<!-- Flash Messages Component (Will be created next) -->
		<FlashMessages />
		<!-- Top Navigation (Will be created next) -->
		<TopNav class="sticky top-0 z-50" />
		<slot name="header" />
		<!-- Main Content -->
		<main
			:class="{ 'mt-[45px]': !compact }"
			class="min-h-[calc(100vh-4rem)]">
			<!-- Main Content Area -->
			<div class="max-w-7xl mx-auto">
				<slot></slot>
			</div>
		</main>
		<!-- Footer (Will be created next) -->
		<Footer />
	</div>
</template>
