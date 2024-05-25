<script lang="ts" setup>
import { GoogleImage } from "@/Components/GoogleMaps/google-maps";
import { Loader } from "@googlemaps/js-api-loader";
import { ref, onMounted, watch } from "vue";

const emit = defineEmits<{
  (event: "position", id: { lat: number; lng: number }): void;
}>();

const image = ref<GoogleImage>();

const loader = new Loader({
  apiKey: import.meta.env.VITE_API_GOOGLE_MAPS_KEY,
  version: "weekly",
  libraries: ["places"],
});

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
    icon: image.value,
  });
};

watch(props, (newProps) => {
  if (map.value) {
    map.value.setCenter({ lat: newProps.lat, lng: newProps.lng });
    marker.value?.setPosition({ lat: newProps.lat, lng: newProps.lng });
  }
});

onMounted(async () => {
  await loader.load();
  image.value = {
    url: "/images/place_icon.svg",
    scaledSize: new google.maps.Size(60, 60),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(30, 30),
  };

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

<style></style>
