<script setup>
import { ref, computed } from "vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3"; // Legg til router for å navigere eller sende forespørsler
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Pagination from "@/Components/Pagination.vue";

// Props from the server-side
const props = defineProps({
  project: Object,
  keywordLists: Object,
});

// Initialize form data for Inertia.js
const form = useForm({});

// Define breadcrumbs
const breadcrumbs = [
  { name: "Keywords", href: "/keywords", current: false },
  { name: "Keyword Lists", current: true },
];

// Funksjon for å kjøre getWebsiteKeywords
const getWebsiteKeywords = () => {
  if (!props.project) {
    alert("No project selected.");
    return;
  }

  // Kjør API-kall til getWebsiteKeywords-ruten med projectId
  router.post(
    route("website.keywords", { projectId: props.project.id }),
    {},
    {
      onSuccess: () => {
        alert("Website keywords fetched successfully.");
      },
      onError: () => {
        alert("Failed to fetch website keywords.");
      },
    }
  );
};

// Funksjon for å slette en keyword-liste
const deleteKeywordList = (list_uuid) => {
  if (confirm("Are you sure you want to delete this keyword list?")) {
    form.delete(route("keyword-lists.destroy", list_uuid), {
      onError: () => alert("Failed to delete keyword list."),
    });
  }
};
</script>

<template>
  <Head title="Keyword Lists" />
  <AppLayout title="Keyword Lists">
    <template #header>
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <Breadcrumbs :pages="breadcrumbs" />
          </h2>
        </div>
        <div class="flex space-x-4">
          <Link
            :href="route('keyword-lists.create')"
            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-500"
          >
            + New List
          </Link>
          <!-- Knapp for å kjøre getWebsiteKeywords-funksjonen -->
          <button
            @click="getWebsiteKeywords"
            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500"
          >
            Fetch Website Keywords
          </button>
        </div>
      </div>
    </template>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th
                scope="col"
                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
              >
                Name
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
              >
                Description
              </th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="list in keywordLists.data" :key="list.list_uuid">
              <td
                class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap"
              >
                {{ list.name }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                {{ list.description || "No description provided" }}
              </td>
              <td
                class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap"
              >
                <Link
                  :href="route('keyword-lists.show', [list.list_uuid])"
                  class="text-indigo-600 hover:text-indigo-900"
                >
                  View
                </Link>
                <Link
                  :href="route('keyword-lists.edit', [list.list_uuid])"
                  class="ml-4 text-indigo-600 hover:text-indigo-900"
                >
                  Edit
                </Link>
                <button
                  @click="deleteKeywordList(list.list_uuid)"
                  class="ml-4 text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      <Pagination :links="keywordLists.links" />
    </div>
  </AppLayout>
</template>
