<script setup>
	import { ref } from "vue";

	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import AuthModal from "@/Pages/Auth/AuthModal.vue";
	const show = ref(false);
</script>
<template>
	<div v-if="$page.props.auth.user?.canVerify">
		<PrimaryButton size="xs" outlined @click.prevent="show = !show">
			Verify Email Address
		</PrimaryButton>
		<AuthModal v-model:show="show" />
	</div>
</template>
