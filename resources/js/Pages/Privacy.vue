<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-white dark:bg-gray-900">
            <div class="max-w-4xl mx-auto px-4 py-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Privacy Notice</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-8">Last Updated: 1 Jan 2025</p>

                <div class="prose dark:prose-invert max-w-none">
                    <div class="text-gray-700 dark:text-gray-300 space-y-6">
                        <p>
                            This "Privacy Notice" describes the privacy practices of {{ $page.props.appName }} and
                            {{ $page.props.appName }} Affiliates (collectively, "{{ $page.props.appName }}", "our", "us"
                            or
                            "we"), in connection with the Sites and the {{ $page.props.appName }} Platform
                            (collectively, "Services").
                        </p>

                        <p>
                            Please read this Privacy Notice carefully to understand our policies and
                            practices regarding your information. If you do not agree with our
                            policies and practices, please do not use the {{ $page.props.appName }} Platform. By
                            accessing or using the {{ $page.props.appName }} Platform, you acknowledge and agree to
                            the terms of this Privacy Notice.
                        </p>

                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-4">
                            Personal Data Controller
                        </h2>
                        <p>
                            The term "Personal Data" as used in this policy, describes information
                            that can be associated with a specific person and can identify that
                            person.
                        </p>

                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-4">
                            Types of Personal Data Collected
                        </h2>
                        <p>
                            The types of Personal Data that we may collect from you or through third
                            parties will depend on our interactions with you and may include...
                        </p>

                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-4">
                            Information We Automatically Collect
                        </h2>
                        <p>
                            When you visit the {{ $page.props.appName }} Platform, we may automatically collect
                            certain information about your device...
                        </p>

                        <!-- Continue with all sections from the privacy policy -->
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>