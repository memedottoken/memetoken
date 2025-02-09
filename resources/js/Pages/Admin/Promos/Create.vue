<script setup>
	import { ref } from "vue";

	import { useForm } from "@inertiajs/vue3";
	import { UseTimeAgo } from "@vueuse/components";
	import { HiArrowLeft } from "oh-vue-icons/icons";
	import { uid } from "uid";
	import { DatePicker } from "v-calendar";

	import BaseButton from "@/Components/BaseButton.vue";
	import FileUploader from "@/Components/FileUploader.vue";
	import FileUploaderLocal from "@/Components/FileUploaderLocal.vue";
	import FormInput from "@/Components/FormInput.vue";
	import FormLabel from "@/Components/FormLabel.vue";
	import FormSwitch from "@/Components/FormSwitch.vue";
	import Loading from "@/Components/Loading.vue";
	import fakeLogo from "@/Components/no-image-available-icon.jpeg?url";
	import VueIcon from "@/Components/VueIcon.vue";
	import AdminLayout from "@/Layouts/AdminLayout.vue";

	defineProps({
		title: { required: false, type: String },
	});
	const form = useForm({
		name: "",
		image: "",
		url: "",
		starts_at: "",
		ends_at: "",
		active: true,
		image_uri: null,
		image_path: null,
		image_upload: true,
	});
	const refreshId = ref(uid());
	const save = () =>
		form.post(window.route("admin.promos.store"), {
			preserveScroll: true,
			preserveState: true,
			onFinish() {
				refreshId.value = uid();
			},
			onSuccess() {
				form.reset();
			},
		});
</script>
<template>
	<Head :title="title ?? `New Promo`" />
	<AdminLayout>
		<main class="h-full container sm:p-8">
			<div
				class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div
						class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">Add New Promo Image</h3>
							<p>
								Promotions images are displayed via random
								rotation in the index page header
							</p>
						</div>
						<div
							class="flex flex-col lg:flex-row lg:items-center gap-3">
							<BaseButton
								secondary
								link
								:href="route('admin.promos.index')">
								<VueIcon
									:icon="HiArrowLeft"
									class="w-4 h-4 -ml-1 mr-2 inline-block" />
								{{ $t("Back to promos list") }}
							</BaseButton>
						</div>
					</div>
					<div class="card sm:p-12 h-full border-0 card-border">
						<div class="card-body card-gutterless h-full">
							<form
								class="grid sm:grid-cols-2 gap-4"
								@submit.prevent="save()">
								<div class="grid">
									<div class="gap-3 grid">
										<FormInput
											v-model="form.image_uri"
											:disabled="form.image_upload"
											placeholder="https://"
											:error="form.errors.image_uri"
											:help="
												$t('Supports png, jpeg or svg')
											">
											<template #label>
												<div class="flex">
													<span class="mr-3">
														{{ $t("Image") }}
													</span>
													<label
														class="inline-flex items-center space-x-2">
														<input
															v-model="
																form.image_upload
															"
															class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:!bg-emerald-600 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
															type="checkbox" />
														<span>
															{{
																$t(
																	"Upload to server",
																)
															}}
														</span>
													</label>
												</div>
											</template>
										</FormInput>
										<template v-if="form.image_upload">
											<FileUploader
												v-if="$page.props.s3"
												v-model="form.image_uri"
												v-model:file="form.image_path"
												:key="refreshId"
												class="min-h-[200px]"
												auto />
											<FileUploaderLocal
												v-else
												:key="`u-${refreshId}`"
												v-model="form.image_uri"
												v-model:file="
													form.image_path
												" />
										</template>
										<img
											v-else
											class="w-auto h-24 my-auto rounded b-0"
											:src="form.image_uri ?? fakeLogo" />
									</div>
									<p
										v-if="form.errors.image"
										class="text-red-500">
										{{ form.errors.image }}
									</p>
									<p v-else class="text-xs">
										{{ $t("") }}
									</p>
								</div>
								<FormInput
									label="Promo Name"
									v-model="form.name"
									class="col-span-2 max-w-xs"
									type="text"
									:error="form.errors.name" />
								<FormInput
									label="Promotion Url"
									v-model="form.url"
									class="col-span-2"
									type="text"
									:error="form.errors.url" />

								<div>
									<FormLabel class="mb-1">
										{{ $t("Date & time") }}
									</FormLabel>
									<DatePicker
										v-model="form.starts_at"
										mode="dateTime"
										is-dark
										is24hr>
										<template
											v-slot="{
												inputValue,
												inputEvents,
											}">
											<input
												class="bg-white border-gray-300 text-gray-900 rounded-sm focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white border block w-full focus:outline-none focus:ring-1 appearance-none py-2 text-sm pl-2 pr-2"
												:value="inputValue"
												v-on="inputEvents" />
										</template>
									</DatePicker>
									<p
										v-if="form.errors.starts_at"
										class="text-red-500">
										{{ form.errors.starts_at }}
									</p>
									<UseTimeAgo
										v-else
										v-slot="{ timeAgo }"
										:time="form.starts_at">
										<p
											class="text-sx font-semibold text-emerald-500">
											{{ timeAgo }}
										</p>
									</UseTimeAgo>
								</div>
								<div>
									<FormLabel class="mb-1">
										{{ $t("End Date & time") }}
									</FormLabel>
									<DatePicker
										v-model="form.ends_at"
										mode="dateTime"
										is-dark
										is24hr>
										<template
											v-slot="{
												inputValue,
												inputEvents,
											}">
											<input
												class="bg-white border-gray-300 text-gray-900 rounded-sm focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white border block w-full focus:outline-none focus:ring-1 appearance-none py-2 text-sm pl-2 pr-2"
												:value="inputValue"
												v-on="inputEvents" />
										</template>
									</DatePicker>
									<p
										v-if="form.errors.ends_at"
										class="text-red-500">
										{{ form.errors.ends_at }}
									</p>
									<UseTimeAgo
										v-else
										v-slot="{ timeAgo }"
										:time="form.ends_at">
										<p
											class="text-sx font-semibold text-emerald-500">
											{{ timeAgo }}
										</p>
									</UseTimeAgo>
								</div>
								<FormSwitch v-model="form.active">
									{{ $t("Active") }}
								</FormSwitch>
								<div class="pt-5">
									<div
										class="flex items-center gap-3 justify-end">
										<BaseButton
											secondary
											as="button"
											:href="route('admin.promos.index')"
											type="button"
											link>
											{{ $t("Cancel") }}
										</BaseButton>
										<BaseButton
											type="submit"
											:disabled="form.processing">
											<Loading
												class="mr-2 -ml-1 inline-block w-5 h-5"
												v-if="form.processing" />
											{{ $t("Save Promo") }}
										</BaseButton>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</main>
	</AdminLayout>
</template>
