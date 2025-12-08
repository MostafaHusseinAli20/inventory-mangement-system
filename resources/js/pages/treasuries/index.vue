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
                            <h1 class="m-0 text-dark">الخزن</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link
                                        :to="{ name: 'treasuries.index' }">الخزن</router-link></li>
                                <li class="breadcrumb-item active">الخزن</li>
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
                            <h3 class="card-title card_title_center">بيانات الخزن</h3>
                            <router-link :to="{ name: 'treasuries.create' }" class="btn btn-sm btn-success 
                            text-light font-weight-bold">اضافة جديد</router-link>
                            <!-- <router-link :to="{ name: 'treasuries.trash' }" class="btn btn-sm btn-secondary mr-2
                            text-light font-weight-bold">الارشيف</router-link> -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-4 d-flex justify-content-between align-items-center gap-4">
                                <input type="text" v-model="searchText" placeholder="بحث بالاسم" class="form-control"><br>
                                
                                <div class="d-flex justify-content-between align-items-center gap-4">
                                    <a href="/admin/treasuries/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
                                    <a href="/admin/treasuries/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
                                </div>

                            </div><br>
                            <div v-if="treasuries.length > 0">

                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <th>مسلسل</th>
                                        <th>اسم الخزنة</th>
                                        <th>هل رئيسية</th>
                                        <th>اخر ايصال صرف</th>
                                        <th>اخر ايصال تحصيل</th>
                                        <th>حالة التفعيل</th>
                                        <th>تاريخ الاضافة</th>
                                        <th>تاريخ اخر تحديث</th>
                                        <th>العمليات</th>
                                    </thead>
                                    <tbody v-for="(treasury, index) in treasuries" :key="treasury.id">
                                        <tr>
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ treasury.name }}</td>

                                            <td>
                                                <span v-if="treasury.is_master == 1"
                                                    class="text-success font-weight-bold">
                                                    رئيسية
                                                </span>
                                                <span v-else class="text-danger font-weight-bold">فرعية</span>
                                            </td>

                                            <td>{{ treasury.last_recipt_exchange }}</td>
                                            <td>{{ treasury.last_recipt_collect }}</td>
                                            <td>
                                                <span v-if="treasury.active == 1"
                                                    class="font-weight-bold badge badge-success">
                                                    مفعل
                                                </span>
                                                <span v-else class="font-weight-bold badge badge-danger">غير مفعل</span>
                                            </td>

                                            <td>
                                                {{ treasury.added_by_admin ? treasury.added_by_admin : 'لا يوجد' }} <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                            </td>
                                            <td>
                                                {{ treasury.updated_by_admin ? treasury.updated_by_admin : 'لا يوجد' }}
                                                <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                            </td>

                                            <td>
                                                <router-link :to="{name: 'treasuries.edit', params: {id: treasury.id}}" 
                                                    class="btn btn-sm btn-warning mr-1">تعديل</router-link>
                                                    
                                                <button @click="deleteTreasury(treasury.id)" type="button"
                                                    class="btn btn-sm btn-danger mr-1">حذف</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <PaginationComponent fetchUrl="/admin/treasuries/get_treasury_data" :perPage="10"
                                    @dataLoaded="treasuries = $event" />
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
import PaginationComponent from '../../components/PaginationComponent.vue'
import Swal from 'sweetalert2';
export default {
    components: {
        PaginationComponent
    },
    data() {
        return {
            title: 'بيانات الخزن',
            treasuries: [],
            pagination: {},
            perPage: 10,
            currentPage: 1,
            time: '',
            date: '',
            newDateTimeType: '',
            loading: false,
            searchText: '',
            timer: null
        }
    },
    mounted() {
        this.getTreasuries();
        this.searchTreasuries("");
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    watch:{
        searchText(newValue) {
            // Debounce لمنع الإرسال كل حرف = أفضل أداء
            clearTimeout(this.typingTimer);
            this.timer = setTimeout(() => {
                this.searchTreasuries(newValue);
            }, 300);
        }
    },
    methods: {
        getTreasuries() {
            this.loading = true;

            axios.get('/admin/treasuries/get_treasury_data', {
                params: {
                    per_page: this.perPage,
                    page: this.currentPage,
                },
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then((response) => {
                this.treasuries = response.data.treasuries.data;

                this.time = response.data.time;
                this.date = response.data.date;
                this.newDateTimeType = response.data.newDateTimeType;

                this.pagination = {
                    total: response.data.treasuries.total,
                    last_page: response.data.treasuries.last_page,
                    per_page: response.data.treasuries.per_page
                };
            }).catch((error) => {
                console.log(error.response?.data || error.message);
            }).finally(() => {
                this.loading = false;
            });
        },

        async deleteTreasury(id) {
            const result = await Swal.fire({
                title: 'هل انت متاكد من حذف الخزنة؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'لا'
            });
            if (result.isConfirmed) {
                axios.delete('/admin/treasuries/destroy_treasury/' + id)
                    .then(() => {
                        this.getTreasuries();
                    })
                    .catch((error) => {
                        console.log(error.response?.data || error.message);
                    });
            }
        },
        
        searchTreasuries(name) {
            axios.get('/admin/treasuries/search', {
                params: {
                    name: name
                }
            }).then((response) => {
                this.treasuries = response.data.treasuries;
            }).catch((error) => {
                console.log(error.response?.data || error.message);
            })
        },
    }
}
</script>