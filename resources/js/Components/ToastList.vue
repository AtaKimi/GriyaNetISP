<script setup>
import ToastListItem from "@/Components/ToastListItem.vue";
import { onUnmounted, ref } from "vue";
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3';
import toast from "@/Stores/toast.js"

const page = usePage();

let removeFinshEventListener = router.on("finish", () => {
  if (page.props.toast) {
    toast.add({
      message: page.props.toast.message,
      toastType:  page.props.toast.toastType
    });
  }
});

onUnmounted(() => removeFinshEventListener());

function remove(index) {
  toast.remove(index);
}
</script>
<template>
  <TransitionGroup tag="div" enter-from-class="translate-x-full opacity-0" enter-active-class="duration-500"
    leave-active-class="duration-500" leave-to-class="translate-x-full opacity-0"
    class="fixed top-4 right-4 z-50 w-full max-w-xs space-y-4">
    <ToastListItem v-for="(item, index) in toast.items" :key="item.key" :message="item.message" :toast-type="item.toastType" @remove="remove(index)" />
  </TransitionGroup>
</template>