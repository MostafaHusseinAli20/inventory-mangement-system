<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">المخزن</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link :to="{ name: 'stores.index' }">المخزن</router-link>
                            </li>
                            <li class="breadcrumb-item active">تعديل</li>
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
                        <h3 class="card-title card_title_center">تعديل مخزن </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form @submit.prevent="updateStore" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>اسم المخزن</label>
                                <input v-model="stores.name" class="form-control" value=""
                                    placeholder="ادخل اسم المخزن">
                                <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label>هاتف المخزن</label>
                                <input 
                                    v-model="stores.phone" class="form-control" value=""
                                    placeholder="ادخل هاتف المخزن">
                                <spanv v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</spanv>
                            </div>

                            <div class="form-group">
                                <label> عنوان المخزن</label>
                                <input v-model="stores.address" class="form-control" value=""
                                    placeholder="ادخل عنوان المخزن">
                                <span v-if="errors.address" class="text-danger">{{ errors.address[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> حالة التفعيل</label>
                                <select v-model="stores.active" class="form-control px-5">
                                    <option value="" disabled selected>اختر الحالة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                                <span v-if="errors.active" class="text-danger">{{ errors.active[0] }}</span>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mr-2"> اضافة</button>
                                <router-link :to="{ name: 'stores.index' }"
                                    class="btn btn-danger">الغاء</router-link>
                            </div>
                        </form>
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
            title: 'تعديل مخزن',
            stores: {},
            errors: {}
        }
    },
    async mounted() {
        await axios.get('/admin/stores/' + this.$route.params.id + '/show')
        .then((response) => {
            this.stores = response.data.data;
        }).catch((error) => {
            console.log(error.response.data);
        })
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods: {
        async updateStore() {
            await axios.put('/admin/stores/' + this.$route.params.id + '/update-data', this.stores)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: 'تم التعديل بنجاح',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$router.push({ name: 'stores.index' });
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                if (error.response.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
    }
}
</script>