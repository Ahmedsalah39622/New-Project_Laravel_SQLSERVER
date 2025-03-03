<template>
  <div>
    <FullCalendar :options="calendarOptions" />
  </div>
</template>


<script>
import FullCalendar from "@/components/FullCalendar.vue";
import { defineComponent, ref } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";

export default defineComponent({
  components: {
    FullCalendar,
  },
  setup() {
    const calendarOptions = ref({
      plugins: [dayGridPlugin],
      initialView: "dayGridMonth",
      events: [
        { title: "Doctor Appointment", start: "2025-02-27" },
        { title: "Meeting", start: "2025-02-28" },
      ],
    });

    return { calendarOptions };
  },
});
</script>

<style>
/* يمكنك تخصيص الستايل هنا */
</style>
