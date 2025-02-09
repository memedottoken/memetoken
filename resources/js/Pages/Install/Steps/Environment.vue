<script setup>
	import { useForm } from "@inertiajs/vue3";
	import {
		ArrowLeft,
		ArrowRight,
		Database,
		ExternalLink,
	} from "lucide-vue-next";

	import BaseButton from "@/Components/BaseButton.vue";
	import CollapseTransition from "@/Components/CollapseTransition.vue";
	import Input from "@/Components/FormInput.vue";
	import { Alert, AlertDescription } from "@/Components/ui/alert";
	import { Label } from "@/Components/ui/label";
	import Layout from "@/Pages/Install/Layout.vue";

	const props = defineProps({
		current: {
			type: Object,
			required: true,
		},
		installed: Boolean,
	});

	const form = useForm({
		APP_URL: props.current.APP_URL || window.location.origin,
		COINCAP_APIKEY: props.current.COINCAP_APIKEY || "",
		PROJECT_ID: props.current.PROJECT_ID || "",
		ANKR_KEY: props.current.ANKR_KEY || "",
		ADMIN: props.current.ADMIN || "",
		// Database settings
		DB_HOST: props.current.DB_HOST || "127.0.0.1",
		DB_PORT: props.current.DB_PORT || "3306",
		DB_DATABASE: props.current.DB_DATABASE || "",
		DB_USERNAME: props.current.DB_USERNAME || "",
		DB_PASSWORD: props.current.DB_PASSWORD || "",
	});

	const links = {
		COINCAP_APIKEY: "https://coincap.io/api-key",
		PROJECT_ID: "https://cloud.reown.com/",
		ANKR_KEY: "https://www.ankr.com/rpc/projects/",
	};
</script>

<template>
	<Layout
		title="Environment Configuration"
		description="Configure your application environment"
		:current-step="3">
		<form
			@submit.prevent="form.post(route('install.environment.save'))"
			class="space-y-6">
			<!-- Alert for any errors -->
			<Alert variant="destructive" v-if="form.errors.length > 0">
				<AlertDescription>
					Please correct the errors below.
				</AlertDescription>
			</Alert>

			<!-- APP URL -->
			<div class="space-y-2">
				<Label for="app_url">Application URL</Label>
				<Input
					id="app_url"
					v-model="form.APP_URL"
					:error="form.errors.APP_URL"
					placeholder="http://localhost" />
			</div>

			<!-- CoinCap API Key -->
			<div class="space-y-2">
				<div class="flex items-center justify-between">
					<Label for="coincap_key">CoinCap API Key</Label>
					<a
						:href="links.COINCAP_APIKEY"
						target="_blank"
						class="text-xs text-primary flex items-center gap-1">
						Get Key
						<ExternalLink class="w-3 h-3" />
					</a>
				</div>
				<Input
					id="coincap_key"
					v-model="form.COINCAP_APIKEY"
					:error="form.errors.COINCAP_APIKEY"
					placeholder="Enter your CoinCap API key" />
			</div>

			<!-- Project ID -->
			<div class="space-y-2">
				<div class="flex items-center justify-between">
					<Label for="project_id">Project ID</Label>
					<a
						:href="links.PROJECT_ID"
						target="_blank"
						class="text-xs text-primary flex items-center gap-1">
						Get ID
						<ExternalLink class="w-3 h-3" />
					</a>
				</div>
				<Input
					id="project_id"
					v-model="form.PROJECT_ID"
					:error="form.errors.PROJECT_ID"
					placeholder="Enter your Project ID" />
			</div>

			<!-- Ankr Key -->
			<div class="space-y-2">
				<div class="flex items-center justify-between">
					<Label for="ankr_key">Ankr API Key</Label>
					<a
						:href="links.ANKR_KEY"
						target="_blank"
						class="text-xs text-primary flex items-center gap-1">
						Get Key
						<ExternalLink class="w-3 h-3" />
					</a>
				</div>
				<Input
					id="ankr_key"
					v-model="form.ANKR_KEY"
					:error="form.errors.ANKR_KEY"
					placeholder="Enter your Ankr API key" />
			</div>

			<!-- Admin Addresses -->
			<div class="space-y-2">
				<Label for="admin">Admin Wallet Addresses</Label>
				<Input
					id="admin"
					v-model="form.ADMIN"
					:error="form.errors.ADMIN"
					placeholder="Comma-separated wallet addresses" />
				<p class="text-xs text-gray-500 dark:text-gray-400">
					Enter comma-separated wallet addresses that will have admin
					access
				</p>
			</div>

			<!-- Database Configuration -->
			<div class="border-t border-gray-700 pt-6 mt-6">
				<h3
					class="text-lg font-medium mb-4 !text-primary flex items-center">
					<Database class="w-5 h-6 mr-2" />
					Database Configuration
				</h3>
				<!-- Database Host -->
				<div class="grid md:grid-cols-3 gap-4">
					<div class="space-y-2 mt-4">
						<Label for="db_host">Database Host</Label>
						<Input
							id="db_host"
							v-model="form.DB_HOST"
							:error="form.errors.DB_HOST"
							placeholder="127.0.0.1" />
					</div>
					<!-- Database Port -->
					<div class="space-y-2 mt-4">
						<Label for="db_port">Database Port</Label>
						<Input
							id="db_port"
							v-model="form.DB_PORT"
							:error="form.errors.DB_PORT"
							placeholder="3306" />
					</div>
					<!-- Database Name -->
					<div class="space-y-2 mt-4">
						<Label for="db_database">Database Name</Label>
						<Input
							id="db_database"
							v-model="form.DB_DATABASE"
							:error="form.errors.DB_DATABASE"
							placeholder="Enter your database name" />
					</div>
				</div>

				<!-- Database Username -->
				<div class="grid gap-4 md:grid-cols-2 mt-4">
					<div class="space-y-2">
						<Label for="db_username">Database Username</Label>
						<Input
							id="db_username"
							v-model="form.DB_USERNAME"
							:error="form.errors.DB_USERNAME"
							placeholder="Enter database username" />
					</div>
					<!-- Database Password -->
					<div class="space-y-2">
						<Label for="db_password">Database Password</Label>
						<Input
							id="db_password"
							type="password"
							v-model="form.DB_PASSWORD"
							:error="form.errors.DB_PASSWORD"
							placeholder="Enter database password" />
					</div>
				</div>
			</div>
			<CollapseTransition>
				<div
					v-show="form.processing"
					class="flex justify-between p-4 rounded bg-emerald-600/10 text-emerald-400">
					Please wait as your database is migrated and seeded! This
					may take a few minutes
				</div>
			</CollapseTransition>
			<div class="flex justify-between">
				<BaseButton
					outlined
					secondary
					link
					:href="route('install.permissions')">
					<ArrowLeft class="w-4 h-4 -ml-1 mr-1 inline-flex" />
					Back
				</BaseButton>

				<BaseButton type="submit" :disabled="form.processing">
					Save and Continue
					<Loading
						class="ml-1 -mr-1 inline-flex"
						v-if="form.processing" />
					<ArrowRight v-else class="w-4 h-4 ml-1 -mr-1 inline-flex" />
				</BaseButton>
			</div>
		</form>
	</Layout>
</template>
