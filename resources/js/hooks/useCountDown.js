
import { ref, watch } from "vue";

import { get } from "@vueuse/core";

export const useCountDown = (eventCountDown, up = false) => {
    const years = ref(null);
    const months = ref(null);
    const days = ref(null);
    const hours = ref(null);
    const minutes = ref(null);
    const seconds = ref(null);
    const totalDays = ref(null);
    const timeout = ref(null);

    const stop = () => {
        if (timeout.value) clearInterval(timeout.value);
        timeout.value = null;
        years.value = null;
        months.value = null;
        days.value = null;
        hours.value = null;
        minutes.value = null;
        seconds.value = null;
        totalDays.value = null;
    };

    const calculateTimeUnits = (timeleft) => {
        const totalDaysValue = Math.floor(timeleft / (1000 * 60 * 60 * 24));
        totalDays.value = totalDaysValue;

        if (totalDaysValue >= 365) {
            // For periods longer than a year
            years.value = Math.floor(totalDaysValue / 365);
            const remainingDays = totalDaysValue % 365;
            months.value = Math.floor(remainingDays / 30);
            days.value = remainingDays % 30;
            hours.value = null;
            minutes.value = null;
            seconds.value = Math.floor((timeleft % (1000 * 60)) / 1000);
        } else if (totalDaysValue >= 100) {
            // For periods between 100 days and a year
            years.value = null;
            months.value = Math.floor(totalDaysValue / 30);
            days.value = totalDaysValue % 30;
            hours.value = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            minutes.value = null;
            seconds.value = Math.floor((timeleft % (1000 * 60)) / 1000);
        } else {
            // For periods less than 100 days
            years.value = null;
            months.value = null;
            days.value = totalDaysValue;
            hours.value = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            minutes.value = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
            seconds.value = Math.floor((timeleft % (1000 * 60)) / 1000);
        }
    };

    const start = () => {
        if (!get(eventCountDown)) {
            return;
        }
        stop();
        timeout.value = setInterval(function () {
            const now = new Date().getTime();
            const timeleft = up
                ? Math.abs(now - get(eventCountDown))
                : get(eventCountDown) - now;

            if (timeleft < 0) {
                stop();
                return;
            }

            calculateTimeUnits(timeleft);
        }, 1000);
    };

    start();
    watch(eventCountDown, start);

    return {
        years,
        months,
        days,
        hours,
        minutes,
        seconds,
        totalDays
    };
};