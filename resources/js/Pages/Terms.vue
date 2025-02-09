<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'; /* PartiallyEnd: #3632/scriptSetup.vue */

</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-white dark:bg-gray-900">
            <div class="max-w-4xl mx-auto px-4 py-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Terms of Use</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-8">Last Updated: 27 Jan 2025</p>

                <div class="prose dark:prose-invert max-w-none">
                    <div class="text-gray-700 dark:text-gray-300 space-y-6">
                        <p>
                            These Terms of Use constitute a legally binding agreement between you
                            ("you" or "your") and {{ $page.props.appName }} ("{{ $page.props.appName }}", "we", "our" or
                            "us").
                        </p>

                        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg my-8">
                            <h2 class="text-xl font-semibold text-yellow-800 dark:text-yellow-200 mb-2">
                                RISK WARNING
                            </h2>
                            <p class="text-yellow-700 dark:text-yellow-300">
                                The value of Digital Assets can fluctuate significantly and there is a
                                material risk of economic loss when buying, selling, holding or
                                investing in Digital Assets. You should therefore consider whether
                                trading or holding Digital Assets is suitable for you taking into
                                account your personal circumstances, financial or otherwise.
                            </p>
                        </div>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-4">
                                1. Introduction
                            </h2>
                            <p>1.1. {{ $page.props.appName }} is a platform designed to assist with the creation and
                                trading of Digital Assets. The {{ $page.props.appName }} group provides users with a
                                platform to create Digital Assets.</p>
                            <p>1.2. By using the {{ $page.props.appName }} Platform you are entering into a legally
                                binding agreement with us. These Terms will govern your use of the
                                {{ $page.props.appName }} Platform.</p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-4">
                                2. Eligibility
                            </h2>
                            <p>2.1. To be eligible to use the {{ $page.props.appName }} Platform, you must:</p>
                            <!-- Continue with eligibility content -->
                        </section>

                        <!-- Continue with all sections from the terms document -->

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-4">
                                32. Definitions and interpretation
                            </h2>
                            <p>In these Terms:</p>
                            <!-- Continue with definitions -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>