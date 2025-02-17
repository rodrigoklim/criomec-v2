<script lang="ts" setup>
import { ref, onMounted, watch } from "vue";

const emit = defineEmits<{
  (event: "position", id: { lat: number; lng: number }): void;
}>();

const map = ref<google.maps.Map>();
const mapRef = ref<HTMLElement>();
const marker = ref<google.maps.Marker>();

const props = defineProps({
  lat: {
    type: Number,
    required: true,
  },
  lng: {
    type: Number,
    required: true,
  },
});

const newMarker = (lat: number, lng: number) => {
  marker.value = new google.maps.Marker({
    position: { lat, lng },
    map: map.value,
  });
};

watch(props, (newProps) => {
  if (map.value) {
    map.value.setCenter({ lat: newProps.lat, lng: newProps.lng });
    marker.value?.setPosition({ lat: newProps.lat, lng: newProps.lng });
  }
});

onMounted(async () => {
  if (!mapRef.value) {
    return;
  }

  map.value = new google.maps.Map(mapRef.value, {
    center: { lat: props.lat, lng: props.lng },
    zoom: 17,
  });

  newMarker(props.lat, props.lng);

  map.value.addListener("drag", () => {
    const center = map.value?.getCenter();
    if (center && marker.value) {
      marker.value.setPosition({ lat: center.lat(), lng: center.lng() });
    }
  });

  map.value.addListener("dragstop", () => {
    const center = map.value?.getCenter();
    if (center) {
      emit("position", { lat: center.lat(), lng: center.lng() });
    }
  });
});
</script>

<template>
  <div ref="mapRef" class="rounded-xl w-full h-full" />
</template>
