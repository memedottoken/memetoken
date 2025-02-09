<script setup>
	import { useForm } from "@inertiajs/vue3";

	import FormInput from "@/Components/FormInput.vue";
	import Loading from "@/Components/Loading.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	const props = defineProps({
		mailgun: Object,
		mailer: Object,
	});
	const form = useForm({
		MAIL_MAILER: "mailgun",
		MAILGUN_SECRET: props.mailgun.domain,
		MAILGUN_DOMAIN: props.mailgun.secret,
		MAILGUN_ENDPOINT: props.mailgun.endpoint,
		MAIL_FROM_ADDRESS: props.mailer?.address,
		MAIL_FROM_NAME: props.mailer?.name,
	});

	const save = () => {
		form.put(window.route("admin.settings.mail", { mailer: "mailgun" }), {
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
				href="https://mailgun.com/">
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
			label="Mailgun Secret Key"
			:error="form.errors.MAILGUN_SECRET"
			v-model="form.MAILGUN_SECRET" />
		<FormInput
			label="Mailgun Domain"
			:error="form.errors.MAILGUN_DOMAIN"
			v-model="form.MAILGUN_DOMAIN" />
		<FormInput
			label="Mailgun Endpoint"
			:error="form.errors.MAILGUN_ENDPOINT"
			v-model="form.MAILGUN_ENDPOINT" />
		<PrimaryButton
			:disabled="form.processing"
			@click="save"
			class="w-full mt-4"
			primary>
			<Loading class="mr-2 -ml-1" v-if="form.processing" />
			Save Mailgun Settings
		</PrimaryButton>
	</div>
</template>
