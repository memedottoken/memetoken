<script setup>
import { ref, watch } from 'vue';



import { useForm } from '@inertiajs/vue3';

import BaseButton from './BaseButton.vue';
import FormTextArea from './FormTextArea.vue';
import Loading from './Loading.vue';

const props = defineProps({
    launchpad: Object
});
const emit = defineEmits(['update:livestreamId', 'error']);

const form = useForm({
    input: '',
    livestreamId: null
});

const error = ref('');
const copyStatus = ref('Copy');

// Universal YouTube URL regex pattern
const youtubeRegex = /(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\/?\?(?:\S*?&?v\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11})/g;

const extractLivestreamId = () => {
    // Reset states
    form.livestreamId = null;
    error.value = '';

    if (!form.input.trim()) return;

    // Extract video ID using the regex
    const matches = [...form.input.matchAll(youtubeRegex)];
    if (matches.length > 0 && matches[0][1]) {
        form.livestreamId = matches[0][1];
        emit('update:livestreamId', matches[0][1]);
        return;
    }
    // If no pattern matches, show error and emit
    error.value = 'Could not extract video ID. Please check the URL format.';
    emit('error', error.value);
};

const copyToClipboard = async () => {
    try {
        await navigator.clipboard.writeText(form.livestreamId);
        copyStatus.value = 'Copied!';
        setTimeout(() => {
            copyStatus.value = 'Copy';
        }, 2000);
    } catch (err) {
        error.value = 'Failed to copy to clipboard';
    }
};

// Watch for input changes
watch(() => form.input, () => {
    if (copyStatus.value === 'Copied!') {
        copyStatus.value = 'Copy';
    }
    extractLivestreamId();
});

const updateLivestream = () => {
    form.post(window.route('launchpads.update.livestream', { launchpad: props.launchpad.id }), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => form.input = ''
    });
};
</script>
<template>
    <div class=" mx-auto py-3">
        <div class="space-y-4">
            <!-- Input Area -->
            <div class="space-y-2">
                <label for="youtubeInput" class="block text-sm font-medium text-gray-300">
                    Paste YouTube Livestream URL or Embed Code
                </label>
                <FormTextArea rows="2" placeholder="Enter YouTube Livestream URL or Embed Code" :emoji="false"
                    v-model="form.input">
                    <template #clear>
                        <BaseButton @click="form.input = ''" danger size="xs">Clear</BaseButton>
                    </template>
                </FormTextArea>
            </div>
            <!-- Result Area -->
            <div v-if="form.livestreamId" class="space-y-4">
                <div class="p-4 bg-green-700/10 rounded-md">
                    <h3 class="text-lg font-medium !text-green-400">Extracted livestream ID:</h3>
                    <div class="mt-2 flex items-center space-x-2">
                        <code class="px-2 py-1 bg-black rounded border border-green-600/10 text-green-400">
                {{ form.livestreamId }}
            </code>
                        <button @click="copyToClipboard"
                            class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                            {{ copyStatus }}
                        </button>
                        <BaseButton @click="updateLivestream" :outlined="form.recentlySuccessful"
                            :class="{ '!text-emerald-400 !border-emerald-400': form.recentlySuccessful }" size="xs">
                            <Loading v-if="form.processing" class="!w-4 !h-4 mr-2 -ml-1" />
                            {{
                                form.recentlySuccessful
                                    ? 'Livestream Updated!'
                                    : 'Update Livestream'
                            }}
                        </BaseButton>
                    </div>
                </div>
            </div>
            <!-- Error Message -->
            <div v-if="error" class="p-4 bg-red-700/10 rounded-md">
                <p class="text-sm !text-red-400 font-mono">{{ error }}</p>
            </div>
        </div>
    </div>
</template>
