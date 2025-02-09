<script setup>
	import { ref, watch } from "vue";

	const props = defineProps({
		length: {
			type: Number,
			default: 6,
		},
		modelValue: {
			type: String,
			default: "",
		},
		errors: {
			type: String,
			default: "",
		},
	});

	const emit = defineEmits(["update:modelValue"]);

	const otpInputs = ref(Array(props.length).fill(""));
	const inputRefs = ref(Array(props.length).fill(null));

	const handleInput = (index) => {
		if (index < props.length - 1 && otpInputs.value[index]) {
			inputRefs.value[index + 1].focus();
		}
		updateModelValue();
	};

	const handleKeyDown = (e, index) => {
		if (e.key === "Backspace" && !otpInputs.value[index] && index > 0) {
			inputRefs.value[index - 1].focus();
		}
	};

	const handlePaste = (e) => {
		e.preventDefault();
		const pastedData = e.clipboardData
			.getData("text")
			.slice(0, props.length);
		const pastedChars = pastedData.split("");
		otpInputs.value = [
			...pastedChars,
			...Array(props.length - pastedChars.length).fill(""),
		];
		updateModelValue();
		// Focus on the next empty input or the last input if all are filled
		const nextEmptyIndex = otpInputs.value.findIndex((val) => val === "");
		const focusIndex =
			nextEmptyIndex === -1 ? props.length - 1 : nextEmptyIndex;
		inputRefs.value[focusIndex].focus();
	};

	const updateModelValue = () => {
		emit("update:modelValue", otpInputs.value.join(""));
	};

	watch(
		() => props.modelValue,
		(newValue) => {
			otpInputs.value = `${newValue}`
				.split("")
				.concat(Array(props.length - `${newValue}`.length).fill(""));
		},
		{ immediate: true },
	);
</script>

<template>
	<div class="flex justify-between mb-6">
		<input
			v-for="(_, index) in otpInputs"
			:key="index"
			type="text"
			inputmode="numeric"
			maxlength="1"
			:class="
				errors
					? 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-white '
					: 'bg-gray-50 dark:bg-gray-900'
			"
			class="w-12 h-12 font-bold text-center text-2xl text-white rounded-md focus:outline-none focus:border-primary focus:ring-primary"
			v-model="otpInputs[index]"
			:ref="(el) => (inputRefs[index] = el)"
			@input="() => handleInput(index)"
			@keydown="(e) => handleKeyDown(e, index)"
			@paste="handlePaste" />
	</div>
</template>
