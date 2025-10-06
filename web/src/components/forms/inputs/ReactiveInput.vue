<script setup lang="ts">
interface Props {
    inputId?: string
    label: string
    type: string
    name: string
    placeholder?: string
    required?: boolean
    modelValue?: string
}

const props = withDefaults(defineProps<Props>(), {
    type: "text",
    placeholder: "",
    required: false,
    modelValue: ""
})

const inputId = props.inputId ?? `input-${props.name}`

const emit = defineEmits(["update:modelValue"])
</script>

<template>
    <label :for="inputId" class="text-sm font-medium text-slate-500">
        {{ props.label }}
        <input :id="inputId" :type="props.type" :name="props.name" :placeholder="props.placeholder"
            :required="props.required" :value="props.modelValue"
            @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
            class="mt-1 block w-full appearance-none rounded-lg border border-[#c2c2c2] bg-transparent px-4 py-3 placeholder-slate-400 transition duration-200 focus:border-[#c2c2c2] focus:outline-none focus:ring-2" />
    </label>
</template>
