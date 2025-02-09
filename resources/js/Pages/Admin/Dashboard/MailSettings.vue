<script setup>
	import { ref } from "vue";

	import { router } from "@inertiajs/core";
	import { HiRefresh, RiMailAddLine } from "oh-vue-icons/icons";

	import CollapseTransition from "@/Components/CollapseTransition.vue";
	import RadioSelect from "@/Components/RadioSelect.vue";
	import VueIcon from "@/Components/VueIcon.vue";
	import LaravelMailersend from "@/Pages/Admin/Dashboard/Mail/LaravelMailersend.vue";
	import LaravelMailGun from "@/Pages/Admin/Dashboard/Mail/LaravelMailGun.vue";
	import LaravelPostmark from "@/Pages/Admin/Dashboard/Mail/LaravelPostmark.vue";
	import LaravelResend from "@/Pages/Admin/Dashboard/Mail/LaravelResend.vue";
	import LaravelSmtp from "@/Pages/Admin/Dashboard/Mail/LaravelSmtp.vue";
	const drivers = [
		{ label: "SMTP", value: "smtp" },
		{
			label: "Mailgun",
			value: "mailgun",
			img: "https://images.ctfassets.net/y6oq7udscnj8/6bfhvqjWqiC8dCzBNHxtJP/d682492374473b2e0d1377f0d4247bda/MG-Icon.png",
		},

		{
			label: "Postmark",
			img: "https://postmarkapp.com/images/apple-touch-icon.png",
			value: "postmark",
		},
		{
			label: "MailerSend",
			img: "https://www.mailersend.com/favicon/favicon.svg",
			value: "mailersend",
		},
		{
			label: "Resend",
			img: "https://resend.com/static/favicons/favicon@180x180.png",
			value: "resend",
		},
	];
	const mailer = ref("smtp");
</script>
<template>
	<div class="card">
		<div class="card-body p-6 grid gap-4">
			<div class="flex justify-between items-center">
				<div class="flex items-center">
					<VueIcon
						:icon="RiMailAddLine"
						class="mr-2 h-6 w-6 text-amber-600 dark:text-amber-400" />
					<h3 class="text-lg">Mailer Configuration</h3>
				</div>
				<a
					@click.prevent="router.reload()"
					v-tippy="$t('Reload')"
					href="#">
					<VueIcon :icon="HiRefresh" />
				</a>
			</div>
			<RadioSelect
				class=""
				v-model="mailer"
				:options="drivers"
				:grid="2" />
			<div class="p-4 border dark:border-gray-600 rounded-md">
				<CollapseTransition>
					<LaravelMailersend
						v-show="mailer == 'mailersend'"
						:mailersend="$page.props.mail?.mailersend"
						:mailer="$page.props.mail?.mailer" />
				</CollapseTransition>
				<CollapseTransition>
					<LaravelMailGun
						v-show="mailer == 'mailgun'"
						:mailgun="$page.props.mail?.mailgun"
						:mailer="$page.props.mail?.mailer" />
				</CollapseTransition>
				<CollapseTransition>
					<LaravelPostmark
						v-show="mailer == 'postmark'"
						:postmark="$page.props.mail?.postmark"
						:mailer="$page.props.mail?.mailer" />
				</CollapseTransition>
				<CollapseTransition>
					<LaravelResend
						v-show="mailer == 'resend'"
						:resend="$page.props.mail?.resend"
						:mailer="$page.props.mail?.mailer" />
				</CollapseTransition>
				<CollapseTransition>
					<LaravelSmtp
						v-show="mailer == 'smtp'"
						:smtp="$page.props.mail?.smtp"
						:mailer="$page.props.mail?.mailer" />
				</CollapseTransition>
			</div>
		</div>
	</div>
</template>
