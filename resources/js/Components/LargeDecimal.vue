<template>
	<span class="inline-flex items-baseline" :class="className">
		{{ formatNumber.whole }}
		<sub v-if="formatNumber.zeroCount > 0" class="text-[9px] mx-0.5">
			{{ formatNumber.zeroCount }}
		</sub>
		{{ formatNumber.remainingDecimals }}
	</span>
</template>

<script setup>
	import { computed } from "vue";

	const props = defineProps({
		value: {
			type: [Number, String],
			required: true,
		},
		className: {
			type: String,
			default: "",
		},
	});

	const formatNumber = computed(() => {
		// Convert number to string, ensuring we don't get scientific notation
		const strNum =
			typeof props.value === "string"
				? props.value
				: props.value.toString();

		// If not a decimal, return original
		if (!strNum.includes(".")) {
			return { whole: strNum, zeroCount: 0, remainingDecimals: "" };
		}

		const [whole, decimal] = strNum.split(".");
		let zeroCount = 0;

		// Count leading zeros
		for (let i = 0; i < decimal.length; i++) {
			if (decimal[i] === "0") {
				zeroCount++;
			} else {
				return {
					whole: whole + ".0",
					zeroCount,
					remainingDecimals: decimal.slice(i),
				};
			}
		}

		// If all zeros after decimal
		return {
			whole: whole + ".0",
			zeroCount,
			remainingDecimals: "",
		};
	});
</script>
