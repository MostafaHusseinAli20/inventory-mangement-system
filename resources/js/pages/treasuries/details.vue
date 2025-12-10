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
                                <li class="breadcrumb-item"><router-link
                                        :to="{ name: 'treasuries.index' }">الخزن</router-link></li>
                                <li class="breadcrumb-item active">تفاصيل الخزنة</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->


            <!-- v-if="treasuries.is_master == 1" -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title card_title_center">تفاصيل الخزنة</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">

                            <div v-if="treasuries && Object.keys(treasuries).length > 0">

                                <table id="example2" class="table table-bordered table-hover">
                                    <tr>
                                        <td class="width30">اسم الخزنة</td>
                                        <td> {{ treasuries.name }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">اخر ايصال صرف</td>
                                        <td> {{ treasuries.last_recipt_exchange }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">اخر ايصال تحصيل</td>
                                        <td> {{ treasuries.last_recipt_collect }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">حالة الشركة</td>
                                        <td>
                                            <span v-if="treasuries.active == 1" class="badge badge-success">مفعلة</span>
                                            <span v-else class="badge badge-danger">غير مفعلة</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="width30">هل رئيسية</td>
                                        <td>
                                            <span v-if="treasuries.is_master == 1">نعم</span>
                                            <span v-else>لا</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="width30">حالة تفعيل الخزنة</td>
                                        <td>
                                            <span v-if="treasuries.active == 1" class="badge badge-success">
                                                مفعلة
                                            </span>
                                            <span v-else class="badge badge-danger">
                                                غير مفعلة
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="width30">تاريخ الاضافة</td>
                                        <td>
                                            <span v-if="treasuries.added_by > 0 && treasuries.added_by != null"
                                                class="mr-1">

                                                {{ date || '-' }}
                                                {{ time || '-' }}
                                                {{ newDateTimeType || '-' }}
                                                بواسطة
                                                {{ treasuries.added_by_admin || '-' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> تاريخ اخر تحديث</td>
                                        <td>
                                            <span v-if="treasuries.updated_by > 0 && treasuries.updated_by != null"
                                                class="mr-1">

                                                {{ date || '-' }}
                                                {{ time || '-' }}
                                                {{ newDateTimeType || '-' }}
                                                بواسطة
                                                {{ treasuries.updated_by_admin || '-' }}
                                            </span>

                                            <span v-else>
                                                لايوجد تحديث
                                            </span>
                                            <router-link :to="{ name: 'treasuries.edit' }"
                                                class="btn btn-sm btn-success ml-2">تعديل</router-link>
                                            <router-link :to="{ name: 'treasuries.index' }"
                                                class="btn btn-sm btn-secondary">عودة</router-link>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Treasury Delivery Details -->
                                <div class="card-header">
                                    <router-link
                                        :to="{ name: 'treasuries.delivery.create', params: { id: treasuries.id } }"
                                        class="btn btn-sm btn-primary">اضافة جديد</router-link>

                                    <h3 class="card-title card_title_center">الخزن الفرعية التي سوف تسلم عهدتها الي
                                        الخزنة الرئيسية ( {{ treasuries.name }} )
                                    </h3>
                                </div>

                                <div v-if="treasuriesDetail && Object.keys(treasuriesDetail).length > 0">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead class="custom_thead">
                                            <th>مسلسل</th>
                                            <th>اسم الخزنة</th>
                                            <th>تاريخ الاضافة</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(info, i) in treasuriesDetail" :key="info.id">
                                                <td>{{ i + 1 }}</td>
                                                <td>{{ info.name || '-' }}</td>
                                                <td>
                                                    {{ info.date || '-' }} <br>
                                                    {{ info.time || '-' }}
                                                    {{ info.newDateTimeType || '-' }} <br>
                                                    بواسطة
                                                    {{ info.added_by_admin || '-' }}
                                                </td>
                                                <td>
                                                    <button @click="deleteTreasuryDelivery(info.id)"
                                                        class="btn btn-sm btn-danger">
                                                        حذف
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div v-else>
                                <div class="alert alert-danger">
                                    عفوا لاتوجد بيانات لعرضها !!
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- <div v-else>
                <div class="alert alert-danger">
                    هذه الخزنة فرعية
                </div>
            </div> -->


        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
    data() {
        return {
            title: 'تفاصيل الخزنة',
            loading: false,
            treasuries: [],
            treasuriesDetail: [],
            date: '',
            time: '',
            newDateTimeType: ''
        }
    },
    mounted() {
        this.getDetailsTreasury();
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods: {
        getDetailsTreasury() {
            this.loading = true;
            axios.get('/admin/treasuries/' + this.$route.params.id + '/get_details')
                .then((response) => {
                    this.treasuriesDetail = response.data.treasuries_delivery;
                    this.treasuries = response.data.treasury;
                    this.time = response.data.time;
                    this.date = response.data.date;
                    this.newDateTimeType = response.data.newDateTimeType;

                }).catch((error) => {
                    console.log(error.response?.data || error.message);
                }).finally(() => {
                    this.loading = false;
                })
        },
        deleteTreasuryDelivery(id) {
            Swal.fire({
                title: 'هل انت متاكد من حذف الخزنة الفرعية؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'لا'
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete('/admin/treasuries/' + id + '/treasury-delivery-destroy')
                    .then(() => {
                        this.getDetailsTreasury();
                    })
                    .catch((error) => {
                        console.log(error.response?.data || error.message);
                    });
                }
            })
        },
    }
}
</script>