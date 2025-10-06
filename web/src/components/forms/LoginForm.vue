<script setup lang="ts">
import { ref } from "vue"
import ReactiveInput from "./inputs/ReactiveInput.vue"
import { auth } from '../../lib/api'

const email = ref("")
const password = ref("")
const error = ref("")
const success = ref(false)
const loading = ref(false)

type Props = {
    text: string
}

const props = defineProps<Props>()

const handleSubmit = async () => {
    loading.value = true
    error.value = ""

    try {
        const data = await auth(email.value, password.value)
        //console.log(data)
        success.value = true
    } catch (err: any) {
        console.error("Login Error: ", err);
        success.value = false
        error.value = err.message || "Error al iniciar sesión";
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <form @submit.prevent="handleSubmit" method="post" class="flex flex-col gap-4">
        <ReactiveInput label="Correo electrónico" name="email" type="email" placeholder="tu@email.com" required
            v-model="email" />

        <ReactiveInput label="Contraseña" name="password" type="password" placeholder="••••••••" required
            v-model="password" />

        <div class="pt-3">
            <button type="submit" :disabled="loading"
                class="relative flex w-full justify-center text-xl rounded-lg border border-transparent bg-blue-500 py-3 px-4 font-semibold text-white hover:bg-blue-500/90 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out transform hover:scale-[1.02] font-[Work_Sans] disabled:opacity-50 disabled:cursor-not-allowed">
                {{ loading ? "Cargando..." : props.text }}
            </button>
        </div>

        <p v-if="error" class="text-red-500 text-center text-sm mt-2">{{ error }}</p>
        <p v-else-if="success" class="text-green-500 text-center text-sm mt-2">
            Espere un momento, mientras lo trasladamos
        </p>
    </form>
</template>
