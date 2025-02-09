<script setup>
	import { useForm } from "@inertiajs/vue3";

	import FormInput from "@/Components/FormInput.vue";
	import FormLabel from "@/Components/FormLabel.vue";
	import Loading from "@/Components/Loading.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import RadioSelect from "@/Components/RadioSelect.vue";
	const props = defineProps({
		smtp: Object,
		mailer: Object,
	});
	const form = useForm({
		MAIL_MAILER: "smtp",
		MAIL_HOST: props.smtp.host,
		MAIL_PORT: props.smtp.port,
		MAIL_USERNAME: props.smtp.username,
		MAIL_PASSWORD: props.smtp.password,
		MAIL_ENCRYPTION: props.smtp.encryption,
		MAIL_FROM_ADDRESS: props.mailer?.address,
		MAIL_FROM_NAME: props.mailer?.name,
	});

	const save = () => {
		form.put(window.route("admin.settings.mail", { mailer: "smtp" }), {
			preserveScroll: true,
			preserveState: true,
		});
	};
</script>
<template>
	<div class="grid gap-4">
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
			label="SMTP Host"
			:error="form.errors.MAIL_HOST"
			v-model="form.MAIL_HOST" />
		<FormInput
			label="SMTP Port"
			:error="form.errors.MAIL_PORT"
			v-model="form.MAIL_PORT" />
		<FormInput
			label="Username"
			:error="form.errors.MAIL_USERNAME"
			v-model="form.MAIL_USERNAME" />
		<FormInput
			label="Password"
			:error="form.errors.MAIL_PASSWORD"
			v-model="form.MAIL_PASSWORD" />

		<div>
			<FormLabel class="mb-2">Mail Encryption</FormLabel>
			<RadioSelect
				:options="[
					{ label: 'NONE', key: 'none', value: null },
					{ label: 'TLS', key: 'tls', value: 'tls' },
					{ label: 'SSL', key: 'ssl', value: 'ssl' },
				]"
				v-model="form.MAIL_ENCRYPTION" />
			<p
				v-if="form.errors.MAIL_ENCRYPTION"
				class="!text-red-500 mt-5 text-xs font-semibold">
				{{ form.errors.MAIL_ENCRYPTION }}
			</p>
		</div>
		<PrimaryButton
			:disabled="form.processing"
			@click="save"
			class="w-full mt-4"
			primary>
			<Loading class="mr-2 -ml-1" v-if="form.processing" />
			Save Smtp Settings
		</PrimaryButton>
	</div>
</template>
