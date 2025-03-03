
<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">المواعيد المتاحة</h1>
    <FullCalendar />
  </div>
</template>

<script>
import FullCalendar from "@/components/FullCalendar.vue";

export default {
  components: {
    FullCalendar,
  },
};
</script>
