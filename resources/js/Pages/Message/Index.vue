<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-3">
                        <InputLabel for="body" value="Сообщение" />
                        <TextInput
                            id="body"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.body"
                            required
                            autofocus
                        />
                        <PrimaryButton
                            @click="store"
                            class="mt-3"
                        >Отправить</PrimaryButton>
                    </div>
                    <ul
                        v-if="messages.length > 0"
                        class="mt-3"
                    >
                        <li
                            v-for="message in messages"
                            :key="message.id"
                        >
                            #{{message.id}}: {{message.body}}
                            <small class="font-light">{{message.time}}</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {reactive} from "vue";

const props = defineProps({
    messages: Array
})

const form = reactive({
    body: ''
})

const store = () => {
   axios.post('/messages', form)
       .then(res => {
            props.messages.unshift(res.data)
            form.body = ''
    })
}

window.Echo.channel('store_message')
    .listen('.store_message', res => {
        props.messages.unshift(res.message)
    })

</script>

<style scoped>

</style>
