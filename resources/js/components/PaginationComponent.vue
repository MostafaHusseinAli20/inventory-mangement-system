<template>
    <div class="overflow-auto">
        <!-- Use emojis in props -->
        <BPagination v-model="currentPage" :total-rows="total" :per-page="perPage" first-text="⏭" prev-text="⏩"
            next-text="⏪" last-text="⏮" class="mt-4" @update:modelValue="loadData" />
    </div>
</template>

<script>
import { BPagination } from 'bootstrap-vue-next'
import axios from 'axios';
export default {
    components: {
        BPagination
    },
    props: {
        fetchUrl: {
            type: String, required: true
        },
        perPage: {
            type: Number, default: 5
        }
    },
    data() {
        return {
            currentPage: 1,
            total: 0,
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        async loadData() {
            const response = await axios.get(this.fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                params: {
                    page: this.currentPage,
                    per_page: this.perPage
                }
            });
            this.total = response.data.treasuries.total;
            this.$emit('dataLoaded', response.data.treasuries.data);
        }
    }
}
</script>

<style></style>
