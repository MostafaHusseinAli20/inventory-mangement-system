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
                                <li class="breadcrumb-item active">عرض</li>
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
                            <h3 class="card-title card_title_center">فئات الفواتير</h3>
                            <router-link :to="{ name: 'sales-matrial-types.create' }" class="btn btn-sm btn-success 
                            text-light font-weight-bold">اضافة جديد</router-link>

                            <!-- <router-link :to="{ name: 'treasuries.trash' }" class="btn btn-sm btn-secondary mr-2
                            text-light font-weight-bold">الارشيف</router-link> -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-4 d-flex justify-content-between align-items-center gap-4">
                                
                                <div class="d-flex justify-content-between align-items-center gap-4">
                                    <a href="/admin/sales-matrial-types/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
                                    <a href="/admin/sales-matrial-types/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
                                </div>

                            </div><br>
                            <div v-if="salesMatrialTypes.length > 0">

                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <th>مسلسل</th>
                                        <th>اسم الفئة</th>
                                        <th>حالة التفعيل</th>
                                        <th>تاريخ الاضافة</th>
                                        <th>تاريخ اخر تحديث</th>
                                        <th>العمليات</th>
                                    </thead>
                                    <tbody v-for="item in salesMatrialTypes" :key="item.id">
                                        <tr>
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.name }}</td>

                                            <td>
                                                <span v-if="item.active == 1"
                                                    class="font-weight-bold badge badge-success">
                                                    مفعل
                                                </span>
                                                <span v-else class="font-weight-bold badge badge-danger">غير مفعل</span>
                                            </td>

                                            <td>
                                                {{ item.added_by_admin ? item.added_by_admin : 'لا يوجد' }} <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                            </td>

                                            <td>
                                                {{ item.updated_by_admin ? item.updated_by_admin : 'لا يوجد' }}
                                                <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                            </td>

                                            <td>
                                                <router-link :to="{name: 'sales-matrial-types.edit', params: {id: item.id}}" 
                                                    class="btn btn-sm btn-info mr-1">تعديل</router-link>
                                                    
                                                <button @click="deleteSalesMatrialType(item.id)" type="button"
                                                    class="btn btn-sm btn-danger mr-1">حذف</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <PaginationComponent 
                                    fetchUrl="/admin/sales-matrial-types/get-sales-matrial-types-data" 
                                    :perPage="10"
                                    collection="data"
                                    @dataLoaded="salesMatrialTypes = $event"
                                />
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
        
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
import PaginationComponent from '../../components/PaginationComponent.vue'
export default {
    components: {
        PaginationComponent
    },
    data() {
        return {
            title: 'بيانات الفواتير',
            loading: false,
            salesMatrialTypes:[],
            date: '',
            time: '',
            newDateTimeType: ''
        }
    },
    mounted() {
        this.getSalesMatrialTypesData();
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods:{
        getSalesMatrialTypesData()
        {
            this.loading = true;
            axios.get('/admin/sales-matrial-types/get-sales-matrial-types-data')
            .then((response) => {
                this.salesMatrialTypes = response.data.data.data;
                this.date = response.data.date;
                this.time = response.data.time;
                this.newDateTimeType = response.data.newDateTimeType;
                console.log(response.data.data);
            }).catch((error) => {
                console.log(error.response.data);
            }).finally(() => {
                this.loading = false;
            });
        },
        deleteSalesMatrialType(id)
        {
            Swal.fire({
                title: 'هل انت متاكد من الحذف',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'لا'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/admin/sales-matrial-types/' + id + '/destroy')
                    .then((response) => {
                        this.getSalesMatrialTypesData();
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحذف بنجاح',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }).catch((error) => {
                        if(error.response.status == 500){
                            Swal.fire({
                                icon: 'error',
                                title: error.response.data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        }
    }
}
</script>

<style></style>