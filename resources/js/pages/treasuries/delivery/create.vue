<template>
    <div>
        <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            </div>
            <span class="ms-3 fs-4">جاري التحميل...</span>
        </div>

        <div v-else>
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">تفاصيل الخزنة</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link :to="{ name: 'treasuries.index' }">الخزن</router-link></li>
                                <li class="breadcrumb-item active">تفاصيل الخزنة</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title card_title_center">اضافة خزن فرعية للاستلام منها للخزنة الرئيسية </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form @submit.prevent="addTreasuryDelivery" method="post">
                                <div class="form-group">
                                    <label> اختر الخزنة الفرعية</label>
                                    <select v-model="treasuries.treasury_can_delivery_id" class="form-control px-5">
                                        <option value="" disabled selected>اختر الخزنة</option>
                                        <span v-if="treasuries != null">
                                            <option v-for="info in treasuries" :key="info.id" :value="info.id">
                                                {{ info.name }}
                                            </option>
                                        </span>
                                    </select>
                                    <span v-if="errors.treasury_can_delivery_id" class="text-danger">
                                        {{errors.treasury_can_delivery_id[0] }}
                                    </span>

                                    <div class="form-group text-center"> <br>
                                        <button type="submit" class="btn btn-primary mr-2">اضافة </button>
                                        <router-link :to="{ name: 'treasuries.index' }"
                                            class="btn btn-danger">الغاء</router-link>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
    data() {
        return {
            title: 'اضافة خزن للاستلام منها للخزنة الرئيسية',
            loading: false,
            treasuries: {},
            errors: {},
        }
    },
    mounted() {
        this.getTreasuryCanDeliveryId();
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods: {
        async getTreasuryCanDeliveryId() {
            await axios.get('/admin/treasuries/get-treasury-delivery-data')
                .then((res) => {
                    this.treasuries = res.data.treasury;
                    console.log(this.treasuries);
                }).catch((error) => {
                    console.log(error.response?.data || error.message);
                });
        },

        addTreasuryDelivery() {
            this.loading = true;
            axios.post('/admin/treasuries/' + this.$route.params.id + '/store-treasury-delivery', {
                treasury_can_delivery_id: this.treasuries.treasury_can_delivery_id,
                treasury_id: this.$route.params.id
            })
                .then((res) => {
                this.$router.push({name: 'treasuries.details', params: {id: this.$route.params.id}});
                Swal.fire({
                    icon: 'success',
                    title: res.data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }).finally(() => {
                this.loading = false;
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                if (error.response.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        },
    }
}
</script>
