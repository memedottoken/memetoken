<script setup>
	import { useForm } from "@inertiajs/vue3";

	import BaseButton from "@/Components/BaseButton.vue";
	import FormInput from "@/Components/FormInput.vue";
	import Loading from "@/Components/Loading.vue";
	const props = defineProps({
		mailersend: Object,
		mailer: Object,
	});
	const form = useForm({
		MAIL_MAILER: "mailersend",
		MAILERSEND_API_KEY: props.mailersend?.apiKey,
		MAIL_FROM_ADDRESS: props.mailer?.address,
		MAIL_FROM_NAME: props.mailer?.name,
	});

	const save = () => {
		form.put(
			window.route("admin.settings.mail", { mailer: "mailersend" }),
			{
				preserveScroll: true,
				preserveState: true,
			},
		);
	};
</script>
<template>
	<div class="grid gap-4">
		<p class="font-semibold text-sm text-primary">
			Get your credentials
			<a
				class="text-sky-400 hover:text-sky-500 ml-1"
				href="https://www.mailersend.com/">
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
			label="MailerSend API Key"
			:error="form.errors.MAILERSEND_API_KEY"
			v-model="form.MAILERSEND_API_KEY" />
		<BaseButton
			:disabled="form.processing"
			@click="save"
			class="w-full mt-4"
			primary>
			<Loading class="mr-2 -ml-1" v-if="form.processing" />
			Save Mailersend Settings
		</BaseButton>
	</div>
</template>
