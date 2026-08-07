import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';
import { postFormDataRequest } from '../utils/postJsonAsFormData';

export const usePostsStore = defineStore('posts', () => {
  const posts = ref([]);
  const currentPost = ref(null);
  const loading = ref(false);
  const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 9,
    total: 0,
  });

  const fetchPosts = async (params = {}) => {
    loading.value = true;
    try {
      const response = await axios.get('/api/admin/posts', { params });
      posts.value = response.data.data;
      return posts.value;
    } finally {
      loading.value = false;
    }
  };

  const fetchPublicPosts = async (params = {}) => {
    loading.value = true;
    try {
      const response = await axios.get('/api/posts', {
        params: { paginate: 1, ...params },
      });
      posts.value = response.data.data;
      pagination.value = response.data.meta || pagination.value;
      return response.data;
    } finally {
      loading.value = false;
    }
  };

  const fetchPost = async (id) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/posts/${id}`);
      currentPost.value = response.data.data;
      return currentPost.value;
    } finally {
      loading.value = false;
    }
  };

  const fetchPostBySlug = async (slug) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/posts/slug/${slug}`);
      currentPost.value = response.data.data;
      return response.data;
    } finally {
      loading.value = false;
    }
  };

  const createPost = async (payload) => {
    const body = await postFormDataRequest('/api/posts', payload);
    posts.value.unshift(body.data);
    return body.data;
  };

  const updatePost = async (id, payload) => {
    const body = await postFormDataRequest(`/api/posts/${id}/save`, payload);
    const index = posts.value.findIndex((p) => p.id === id);
    if (index !== -1) {
      posts.value[index] = body.data;
    }
    currentPost.value = body.data;

    return {
      ...body.data,
      content_saved: body.content_saved,
      featured_image_saved: body.featured_image_saved,
    };
  };

  const deletePost = async (id) => {
    await axios.delete(`/api/posts/${id}`);
    posts.value = posts.value.filter((p) => p.id !== id);
  };

  const publishPost = async (id) => {
    const response = await axios.patch(`/api/posts/${id}/publish`);
    const index = posts.value.findIndex((p) => p.id === id);
    if (index !== -1) {
      posts.value[index] = response.data.data;
    }
    return response.data.data;
  };

  return {
    posts,
    currentPost,
    loading,
    pagination,
    fetchPosts,
    fetchPublicPosts,
    fetchPost,
    fetchPostBySlug,
    createPost,
    updatePost,
    deletePost,
    publishPost,
  };
});
