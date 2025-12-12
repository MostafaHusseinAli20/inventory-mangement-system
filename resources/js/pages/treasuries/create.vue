<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark font-weight-bold">اضافة خزنة</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item font-weight-bold"><router-link
                                    :to="{ name: 'treasuries.index' }">الخزن</router-link></li>
                            <li class="breadcrumb-item active font-weight-bold">اضافة خزنة</li>
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
                        <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form @submit.prevent="addTreasury" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>اسم الخزنة</label>
                                <input v-model="treasuries.name" id="name" class="form-control" value=""
                                    placeholder="ادخل اسم خزنة الشركة">
                                <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> هل رئيسية</label>
                                <select v-model="treasuries.is_master" id="is_master" class="form-control px-5">
                                    <option value="" disabled selected>اختر النوع</option>

                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>

                                </select>
                                <spanv v-if="errors.is_master" class="text-danger">{{ errors.is_master[0] }}</spanv>
                            </div>

                            <div class="form-group">
                                <label> اخر رقم ايصال صرف نقدية لهذة الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                    v-model="treasuries.last_recipt_exchange" id="last_isal_exhcange"
                                    class="form-control" placeholder="ادخل اسم الشركة">
                                <span v-if="errors.last_recipt_exchange" class="text-danger">{{
                                    errors.last_recipt_exchange[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> اخر رقم ايصال تحصيل نقدية لهذة الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                    v-model="treasuries.last_recipt_collect" id="last_isal_collect" class="form-control"
                                    placeholder="ادخل اسم الشركة">
                                <span v-if="errors.last_recipt_collect" class="text-danger">{{
                                    errors.last_recipt_collect[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label> حالة التفعيل</label>
                                <select v-model="treasuries.active" class="form-control px-5">
                                    <option value="" disabled selected>اختر الحالة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                                <span v-if="errors.active" class="text-danger">{{ errors.active[0] }}</span>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mr-2"> اضافة</button>
                                <router-link :to="{ name: 'treasuries.index' }" class="btn btn-danger">الغاء</router-link>
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
            title: 'اضافة خزنة جديدة',
            treasuries: {},
            errors: {}
        }
    },
    mounted() {
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods: {
        addTreasury() {
            axios.post('/admin/treasuries/store_treasury_data', this.treasuries)
                .then((res) => {
                    if (res.data.message == 'مسموح بصندوق رئيسي واحد فقط') {
                        Swal.fire({
                            icon: 'error',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    } else if(res.data.message == 'اسم الصندوق موجود بالفعل')
                    {
                        Swal.fire({
                            icon: 'error',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 2000,
                        }).then(() => {
                            this.$router.push({ name: 'treasuries.index' });
                        })
                    }
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        Swal.fire({
                            icon: 'error',
                            title: error.response.data.message,
                            showConfirmButton: false,
                            timer: 5000,
                        })
                        this.errors = error.response.data.errors;
                    }

                    if (error.response.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: error.response.data.message,
                            showConfirmButton: false,
                            timer: 5000,
                        })
                    }
                })
            }
    }
}
</script>