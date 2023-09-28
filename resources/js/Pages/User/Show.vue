<template>
<div class="py-12">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            Пользователь: #{{user.id}} - {{user.email}} <br>
            <ul v-if="messages.length > 0">
                <li v-for="message of messages">
                    - {{message}}
                </li>
            </ul>
            <!-- себя лайкать нельзя -->
            <PrimaryButton
                    v-if="$page.props.auth.user.id !== user.id"
                    @click="sendLike"
                    class="mt-3"
                >Лайкнуть</PrimaryButton>
        </div>
    </div>
</div>
</div>
</template>

<script setup>
    import PrimaryButton from "@/Components/PrimaryButton.vue";
    import {ref} from "vue";
    import {usePage} from '@inertiajs/vue3'

    const props = defineProps({
        user: Object
    })
    const messages = ref([])

    const sendLike = () => {
        axios.post(`/user/${props.user.id}`)
            .then(res => {
                messages.value.unshift(res.data.like_str)
            })
    }

    window.Echo.private(`send_like_${usePage().props.auth.user.id}`)
        .listen('.send_like', res => {
            messages.value.unshift(res.like_str)
        })

</script>

<style scoped>

</style>
