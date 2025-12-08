<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">تعديل بيانات الخزن</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link
                                    :to="{ name: 'treasuries.index' }">الخزن</router-link></li>
                            <li class="breadcrumb-item active">تعديل بيانات الخزن</li>
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
                        <h3 class="card-title card_title_center">تعديل خزنة </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form @submit.prevent="updateTreasury" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>اسم الخزنة</label>
                                <input v-model="treasury.name" class="form-control" placeholder="ادخل اسم خزنة الشركة">
                                <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> هل رئيسية</label>
                                <select v-model="treasury.is_master" class="form-control px-5">
                                    <option value="" disabled selected>اختر النوع</option>

                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>

                                </select>
                                <span v-if="errors.is_master" class="text-danger">{{ errors.is_master[0] }}</span>
                                <span v-if="errorsV2.is_master" class="text-danger">{{ errorsV2.is_master[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> اخر رقم ايصال صرف نقدية لهذة الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                    v-model="treasury.last_recipt_exchange" class="form-control"
                                    placeholder="ادخل اسم الشركة">
                                <span v-if="errors.last_recipt_exchange" class="text-danger">{{
                                    errors.last_recipt_exchange[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> اخر رقم ايصال تحصيل نقدية لهذة الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                    v-model="treasury.last_recipt_collect" class="form-control"
                                    placeholder="ادخل اسم الشركة">
                                <span v-if="errors.last_recipt_collect" class="text-danger">{{
                                    errors.last_recipt_collect[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> حالة التفعيل</label>
                                <select v-model="treasury.active" class="form-control px-5">
                                    <option value="" disabled selected>اختر الحالة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                                <span v-if="errors.active" class="text-danger">{{ errors.active[0] }}</span>
                            </div>

                            <!-- <div class="form-group">
                                <label> تاريخ التفعيل</label>
                                <input type="date" v-model="date" class="form-control">
                                <span v-if="errors.date" class="text-danger">{{ errors.date[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> توقيت التفعيل</label>
                                <input type="time" v-model="time" class="form-control">
                                <span v-if="errors.time" class="text-danger">{{ errors.time[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label> تاريخ التفعيل</label>
                                <select v-model="newDateTimeType" class="form-control px-5">
                                    <option value="" disabled selected>اختر النوع</option>
                                    <option value="صباحا">صباحا</option>
                                    <option value="مساء">مساء</option>
                                </select>
                                <span v-if="errors.newDateTimeType" class="text-danger">{{ errors.newDateTimeType[0] }}</span>
                            </div> -->

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mr-2"> تعديل</button>
                                <router-link :to="{ name: 'treasuries.index' }"
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
import axios from 'axios'
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            title: 'تعديل بيانات الخزن',
            treasury: {},
            errors: {},
            errorsV2: {},
            loading: false,
            time: '',
            date: '',
            newDateTimeType: ''
        }
    },

    mounted() {
        let id = this.$route.params.id
        axios.get('/admin/treasuries/' + id + '/show', {
            headers: {
                'Accept': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
            }
        }).then((response) => {
            this.treasury = response.data.treasury;

            this.time = response.data.time;
            this.date = response.data.date;
            this.newDateTimeType = response.data.newDateTimeType;
        }).catch((error) => {
            console.log(error.response?.data || error.message);
        })
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },

    methods: {
        updateTreasury() {
            let id = this.$route.params.id
            axios.put('/admin/treasuries/' + id + '/update', this.treasury)
                .then((res) => {
                    if (res.data.message == 'تم التعديل بنجاح') {
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
                        this.errors = error.response.data.errors;
                            // هنا تجي الـ validation errors
                            if (error.response.data.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: error.response.data.message,
                                    showConfirmButton: false,
                                    timer: 3000,
                                });
                            }

                            // لو فيه errors per field
                            this.errorsV2 = error.response.data.errors || {};
                    }

                    if (error.response.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: error.response.data.message,
                            showConfirmButton: false,
                            timer: 2000,
                        })
                    }
                })
        }
    }
}
</script>