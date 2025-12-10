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
                            <h1 class="m-0 text-dark">فئات الفواتير</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link
                                        :to="{ name: 'sales-matrial-types.index' }">فئات الفواتير</router-link></li>
                                <li class="breadcrumb-item active">اضافة</li>
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
                            <h3 class="card-title card_title_center">تعديل فئة فواتير جديدة</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form @submit.prevent="updateSalesMatrialType" method="post">
                                <div class="form-group">
                                    <label>اسم فئة الفواتير</label>
                                    <input v-model="salesMatrialType.name" class="form-control"
                                        placeholder="ادخل اسم الشركة">
                                    <span v-if="errors.name" class="text-danger">
                                        {{ errors.name[0] }}
                                    </span>

                                    <div class="form-group mt-2">
                                        <label> حالة التفعيل</label>
                                        <select v-model="salesMatrialType.active" id="active" class="form-control px-5">
                                            <option value="" disabled selected>اختر الحالة</option>
                                            <option value="1">نعم</option>
                                            <option value="0">لا</option>
                                        </select>
                                        <span v-if="errors.active" class="text-danger">{{ errors.active[0] }}</span>

                                    </div>

                                    <div class="form-group text-center"> <br>
                                        <button type="submit" class="btn btn-primary mr-2">تعديل </button>
                                        <router-link :to="{ name: 'sales-matrial-types.index' }"
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
            title: 'تعديل فئة فاتورة',
            salesMatrialType: {},
            errors: {},
        }
    },
    methods: {
        updateSalesMatrialType() {
            let id = this.$route.params.id;
            axios.put('/admin/sales-matrial-types/' + id + '/update', this.salesMatrialType)
                .then((response) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التعديل بنجاح',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$router.push({ name: 'sales-matrial-types.index' });
                }).catch((error) => {
                    if (error.response.status === 422) {
                        if(error.response.data.errors.code == 422){
                            Swal.fire({
                                icon: 'error',
                                title: error.response.data.errors.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
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
                })
        }
    },
    mounted() {
        axios.get('/admin/sales-matrial-types/' + this.$route.params.id + '/show')
            .then((response) => {
                this.salesMatrialType = response.data.data;
            }).catch((error) => {
                console.log(error.response.data);
            });

            var title = document.getElementById("title");
            title.innerHTML = this.title;
    }
}
</script>
