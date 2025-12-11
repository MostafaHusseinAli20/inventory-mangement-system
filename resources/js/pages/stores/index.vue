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
                            <h1 class="m-0 text-dark">المخزن</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link
                                        :to="{ name: 'stores.index' }">المخزن</router-link></li>
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
                            <h3 class="card-title card_title_center">بيانات المخزن</h3>
                            <router-link :to="{ name: 'stores.create' }" class="btn btn-sm btn-success 
                            text-light font-weight-bold">اضافة جديد</router-link>
                            <!-- <router-link :to="{ name: 'treasuries.trash' }" class="btn btn-sm btn-secondary mr-2
                            text-light font-weight-bold">الارشيف</router-link> -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-4 d-flex justify-content-between align-items-center gap-4">
                                <input type="text" v-model="searchText" placeholder="بحث بالاسم" class="form-control"><br>

                                <div class="d-flex justify-content-between align-items-center gap-4">
                                    <a href="/admin/stores/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
                                    <a href="/admin/stores/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
                                </div>

                            </div><br>
                            <div v-if="stores.length > 0">

                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <th>مسلسل</th>
                                        <th>اسم المخزن</th>
                                        <th> الهاتف</th>
                                        <th> العنوان</th>
                                        <th>حالة التفعيل</th>
                                        <th> تاريخ الاضافة</th>
                                        <th> تاريخ التحديث</th>
                                        <th>العمليات</th>
                                    </thead>
                                    <tbody v-for="store in stores" :key="store.id">
                                        <tr>
                                            <td>{{ store.id }}</td>
                                            <td>{{ store.name }}</td>
                                            <td>{{ store.phone }}</td>
                                            <td>{{ store.address }}</td>
                                            <td>
                                                <span v-if="store.active == 1"
                                                    class="font-weight-bold badge badge-success">
                                                    مفعل
                                                </span>
                                                <span v-else class="font-weight-bold badge badge-danger">غير مفعل</span>
                                            </td>

                                            <td>
                                                {{ store.added_by_admin ? store.added_by_admin : 'لا يوجد' }} <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                            </td>
                                            <td>
                                                {{ store.updated_by_admin ? store.updated_by_admin : 'لا يوجد' }}
                                                <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                            </td>

                                            <td>
                                                <!-- v-if="treasury.is_master == 1" -->
                                                <router-link :to="{ name: 'stores.edit', params: { id: store.id } }"
                                                    class="btn btn-sm btn-info mr-1">تعديل</router-link>

                                                <button @click="deleteStore(store.id)" type="button"
                                                    class="btn btn-sm btn-danger mr-1">حذف</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <PaginationComponent fetchUrl="/admin/stores/get-stores-data" :perPage="10"
                                    collection="stores" @dataLoaded="stores = $event" />
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
import axios from 'axios';
import Swal from 'sweetalert2';
import PaginationComponent from '../../components/PaginationComponent.vue'
export default {
    components: {
        PaginationComponent
    },
    data() {
        return {
            title: 'بيانات المخازن',
            stores: [],
            loading: false,
            date: '',
            time: '',
            newDateTimeType: '',
            searchText: ''
        }
    },
    methods: {
        async getStoreData() {
            this.loading = true;
            await axios.get('/admin/stores/get-stores-data')
                .then((res) => {
                    this.stores = res.data.stores.data;
                    this.date = res.data.date;
                    this.time = res.data.time;
                    this.newDateTimeType = res.data.newDateTimeType;
                }).catch((error) => {
                    console.log(error.response?.data || error.message);
                }).finally(() => {
                    this.loading = false;
                })
        },
        async deleteStore(id) {
            const result = await Swal.fire({
                title: 'هل انت متاكد من حذف المخزن؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'لا'
            });
            if (result.isConfirmed) {
                axios.delete('/admin/stores/' + id + '/destroy')
                    .then(() => {
                        this.getStoreData();
                    })
                    .catch((error) => {
                        console.log(error.response?.data || error.message);
                    });
            }
        },
        searchStores(name)
        {
            axios.get('/admin/stores/search', {
                params: {
                    name: name,
                }
            }).then((response) => {
                this.stores = response.data.stores;
            }).catch((error) => {
                console.log(error.response?.data || error.message);
            })
        }
    },
    watch:{
        searchText(newValue) {
            // Debounce لمنع الإرسال كل حرف = أفضل أداء
            clearTimeout(this.typingTimer);
            this.timer = setTimeout(() => {
                this.searchStores(newValue);
            }, 300);
        }
    },
    mounted() {
        this.getStoreData();
        this.searchStores("");
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    }
}
</script>
