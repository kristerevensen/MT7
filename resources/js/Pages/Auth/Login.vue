<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember ? "on" : "",
    }))
    .post(route("login"), {
      onFinish: () => form.reset("password"),
    });
};
</script>

<template>
  <Head title="Logg inn" />

  <div class="flex min-h-screen">
    <!-- Left Side - Login Form -->
    <div
      class="flex items-center justify-center w-full p-8 bg-white lg:w-1/2 dark:bg-gray-50"
    >
      <div class="w-full max-w-md space-y-8">
        <!-- Logo and Header -->
        <div class="text-center">
          <!-- Measuretank logo som tekst -->
          <h1 class="text-4xl font-bold text-gray-900">Measuretank</h1>
        </div>

        <!-- Status Message -->
        <div
          v-if="status"
          class="p-4 text-sm text-blue-700 rounded-lg bg-blue-50"
        >
          {{ status }}
        </div>

        <!-- Login Form -->
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Email Field -->
          <div>
            <TextInput
              id="email"
              v-model="form.email"
              type="email"
              class="block w-full px-4 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-lg focus:border-gray-500 focus:ring-gray-500"
              required
              placeholder="E-post"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <!-- Password Field -->
          <div>
            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              class="block w-full px-4 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-lg focus:border-gray-500 focus:ring-gray-500"
              required
              placeholder="Passord"
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input
                type="checkbox"
                v-model="form.remember"
                class="w-4 h-4 text-gray-900 border-gray-300 rounded"
              />
              <span class="ml-2 text-sm text-gray-600">Husk meg</span>
            </label>

            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm font-medium text-gray-900 hover:text-gray-700"
            >
              Glemt passord?
            </Link>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white bg-gray-900 border border-transparent rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            <span v-if="form.processing">Logger inn...</span>
            <span v-else>Logg inn</span>
          </button>

          <!-- Register Link -->
          <p class="text-sm text-center text-gray-600">
            Ikke medlem?
            <Link
              :href="route('register')"
              class="font-medium text-gray-900 hover:text-gray-700"
            >
              Registrer deg her
            </Link>
          </p>
        </form>
      </div>
    </div>

    <!-- Right Side - Dark Theme with Quote -->
    <div class="relative hidden bg-gray-900 lg:flex lg:w-1/2">
      <div class="relative flex items-center justify-center w-full h-full p-12">
        <div class="max-w-md text-center text-white">
          <p class="mb-2 text-lg font-medium">
            "Beyond UI: It's the design equivalent of discovering the theory of
            relativity for your creativity."
          </p>
          <p class="text-sm text-gray-400">- Albert Einstein</p>
        </div>
      </div>

      <!-- Background Pattern -->
      <div
        class="absolute inset-0 bg-[radial-gradient(#ffffff33_1px,#00091d_1px)] bg-[size:20px_20px]"
      ></div>
    </div>
  </div>
</template>