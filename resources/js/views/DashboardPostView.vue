<script setup lang="ts">
    import { onMounted, ref } from "vue";
    import { useRoute } from 'vue-router'
    import { Post } from '@/interfaces/post'
    import {PostApi} from "@/services/api/post";
    import {ProfileApi} from "@/services/api/profile";
    import router from "@/router";

    const post = ref({
        post_id: -1,
        body: ''
    })

    const isCreate = ref(true)
    const errors = ref('')
    const errors_show = ref(false)

    const MAX_BIO_LENGTH = 1024
    const remaining = ref(MAX_BIO_LENGTH)

    function onBodyInput() {
        if (post.value.body.length > MAX_BIO_LENGTH) {
            post.value.body = post.value.body.slice(0, MAX_BIO_LENGTH)
        }

        remaining.value = MAX_BIO_LENGTH - post.value.body.length;
    }

    function showError(error) {
        errors_show.value = true
        errors.value = error.join('\n')
        setTimeout(() => {
            errors_show.value = false
        }, 20000)
    }

    async function onSubmit() {
        if (isCreate.value) {
            const response = await PostApi.create(post.value.body)

            if (response.success) {
                await router.push('/dashboard')
            } else {
                showError(response.error)
            }
        } else {
            const response = await PostApi.update(post.value.post_id, post.value.body)

            if (response.success) {
                await router.push('/dashboard')
            } else {
                showError(response.error)
            }
        }
    }

    onMounted(async () => {
        const route = useRoute()

        if (route.params.id) {
            const response = await PostApi.post(route.params.id)

            if (response.success) {
                isCreate.value = false
                post.value = { post_id: route.params.id, body: response.post.body }
            }
        }

        onBodyInput()
    })
</script>

<template>
    <main class="flex-1 p-8">
        <pre v-show="errors_show" class="bg-red-400 w-full text-white p-2 mb-2">{{ errors }}</pre>
        <div class=" border border-[#2E3044] p-4 rounded-xl">
            <label class="block text-sm font-medium text-gray-500 mb-2">Post</label>
            <textarea v-model="post.body" @input="onBodyInput" class="w-full bg-[#151821] border border-[#2E3039] rounded-lg p-3 text-[#E8E8E8] focus:outline-none focus:border-[#4e89f5] min-h-[100px] resize-none" rows="5" placeholder="Tell the world about your thoughts"></textarea>
            <div class="text-right text-sm text-gray-500 mt-2">{{ remaining }}/{{ MAX_BIO_LENGTH }} remaining</div>
        </div>
        <button @click="onSubmit" class="mt-4 bg-[#4e89f5] text-white border-none rounded px-4 py-2 cursor-pointer text-sm transition-colors duration-300 hover:bg-[#357ae8]">{{ isCreate ? 'Create Post' : 'Update Post' }}</button>
    </main>
</template>
