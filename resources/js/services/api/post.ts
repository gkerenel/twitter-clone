import axios from 'axios'
import { useAuthStore } from '@/stores/auth'

interface PostResult {
    success: boolean,
    user?: object,
    posts?: Array<object>,
    error?: Array<string>,
    post?: object
}

interface PostService {
    create(body): Promise<PostResult>,
    update(post_id: number, body: string): Promise<PostResult>,
    delete(post_id: number): Promise<PostResult>,
    get(): Promise<PostResult>,
    post(post_id: number): Promise<PostResult>
}

const TOKEN: string = useAuthStore().get()
const BASE_URL: string = 'http://127.0.0.1:8000/api'

export const PostApi: PostService = {
    async create(body: string): Promise<PostResult> {
        return axios.post(`${BASE_URL}/post`, { body }, { headers: { Authorization: `Bearer ${TOKEN}` }})
        .then(() => {
            return { success: true }
        })
        .catch((error) => {
            return { success: false, error: error.response.datae.errors  }
        })
    },

    async update(post_id: number, body: string): Promise<PostResult> {
        return axios.put(`${BASE_URL}/post/${post_id}`, { body }, { headers: { Authorization: `Bearer ${TOKEN}` }})
        .then(() => {
            return { success: true }
        })
        .catch((error) => {
            return { success: false, error: error.response.datae.errors }
        })
    },

    async delete(post_id: number): Promise<PostResult> {
        return axios.delete(`${BASE_URL}/post/${post_id}`, { headers: { Authorization: `Bearer ${TOKEN}` }})
        .then(() => {
            return { success: true }
        })
        .catch((error) => {
            return { success: false, error: error.response.datae.errors }
        })
    },

    async get(): Promise<PostResult> {
        return axios.get(`${BASE_URL}/post`, { headers: { Authorization: `Bearer ${TOKEN}` }})
        .then((response) => {
            return { success: true, posts: response.data.posts }
        })
        .catch((error) => {
            return { success: false, error: error.response.datae.errors }
        })
    },

    async post(post_id: number): Promise<PostResult> {

    }
}
