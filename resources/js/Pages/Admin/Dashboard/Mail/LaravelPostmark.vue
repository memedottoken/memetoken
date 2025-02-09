<script setup>
	import { useForm } from "@inertiajs/vue3";

	import FormInput from "@/Components/FormInput.vue";
	import Loading from "@/Components/Loading.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";

	const props = defineProps({
		postmark: Object,
		mailer: Object,
	});
	const form = useForm({
		MAIL_MAILER: "postmark",
		POSTMARK_TOKEN: props.postmark?.token,
		MAIL_FROM_ADDRESS: props.mailer?.address,
		MAIL_FROM_NAME: props.mailer?.name,
	});

	const save = () => {
		form.put(window.route("admin.settings.mail", { mailer: "postmark" }), {
			preserveScroll: true,
			preserveState: true,
		});
	};
</script>
<template>
	<div class="grid gap-4">
		<p class="font-semibold py-3 text-sm text-primary">
			Get your credentials
			<a
				class="text-sky-400 hover:text-sky-500 ml-1"
				href="https://postmarkapp.com/">
				Here
			</a>
		</p>
		<FormInput
			label="Universal Email from Address"
			class="max-w-lg"
			:error="form.errors.MAIL_FROM_ADDRESS"
			v-model="form.MAIL_FROM_ADDRESS" />
		<FormInput
			label="Universal Email from Name"
			:error="form.errors.MAIL_FROM_NAME"
			v-model="form.MAIL_FROM_NAME" />
		<FormInput
			label="Postmark Api Token"
			:error="form.errors.POSTMARK_TOKEN"
			v-model="form.POSTMARK_TOKEN" />
		<PrimaryButton
			:disabled="form.processing"
			@click="save"
			class="w-full mt-4"
			primary>
			<Loading class="mr-2 -ml-1" v-if="form.processing" />
			Save Postmark Settings
		</PrimaryButton>
	</div>
</template>
