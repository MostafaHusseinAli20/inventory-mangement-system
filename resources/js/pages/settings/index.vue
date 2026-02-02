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
                            <h1 class="m-0 text-dark">الضبط</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link
                                        :to="{ name: 'settings.index' }">الضبط</router-link></li>
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
                            <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div v-if="settings && Object.keys(settings).length > 0">

                                <table id="example2" class="table table-bordered table-hover">
                                    <tr>
                                        <td class="width30">اسم الشركة</td>
                                        <td> {{ settings.system_name }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">بريد الشركة</td>
                                        <td> {{ settings.email }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">كود الشركة</td>
                                        <td> {{ settings.com_code }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">حالة الشركة</td>
                                        <td>
                                            <span v-if="settings.active == 1" class="badge badge-success">مفعلة</span>
                                            <span v-else class="badge badge-danger">غير مفعلة</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="width30">عنوان الشركة</td>
                                        <td> {{ settings.address }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">هاتف الشركة</td>
                                        <td> {{ settings.phone }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> اسم الحساب المالي الاب للعملاء الاب</td>
                                        <td> {{ settings.customer_parent_account_name || '' }} رقم حساب مالي (
                                            {{ settings.customer_parent_account_number || '' }} )</td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> اسم الحساب المالي الاب للموردين الاب</td>
                                        <td> {{ settings.supplier_parent_account_name || '' }} رقم حساب مالي (
                                            {{ settings.suppliers_parent_account_number || '' }} )</td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> اسم الحساب المالي الاب للمناديب الاب</td>
                                        <td> {{ settings.delegates_parent_account_name || '' }} رقم حساب مالي (
                                            {{ settings.delegate_parent_account_number || '' }} )</td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> اسم الحساب المالي الاب للموظفين الاب</td>
                                        <td> {{ settings.employees_parent_account_name || '' }} رقم حساب مالي (
                                            {{ settings.employees_parent_account_number || '' }} )</td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> اسم الحساب المالي الاب لخطوط الانتاج الاب</td>
                                        <td> {{ settings.production_lines_parent_account_name || '' }} رقم حساب مالي (
                                            {{ settings.production_lines_parent_account || '' }} )</td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> رسالة التنبية اعلي الشاشة للشركة</td>
                                        <td> {{ settings.general_alert || '' }}</td>
                                    </tr>

                                    <tr>
                                        <td class="width30">لوجو الشركة</td>
                                        <td>
                                            <div class="image">
                                                <img class="custom_img" :src="/uploads/ + settings.logo" alt="لوجو الشركة"
                                                    width="300">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> نوع آلية عمل الباتشات بالنظام</td>
                                        <td>
                                            <span v-if="settings.is_set_Batches_setting == 1">
                                                <span v-if="settings.Batches_setting_type == 1">

                                                    يعمل بنظام تعدد الباتشات للصنف طبقا لاختلاف سعر الشراء وتواريخ
                                                    الانتاج
                                                    والانتهاء
                                                </span>
                                                <span v-else>
                                                    لايعمل بنظام الباتشات - فقط كمية لكل صنف
                                                </span>

                                            </span>
                                            <span v-else>
                                                لم يتم تحديد النوع بعد يرجي التحديث

                                            </span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td> نوع الوحده الاساسية للبيع بفواتير المبيعات</td>

                                        <td>

                                            <span v-if="settings.default_unit == 1">
                                                البيع بالوحده الاب الاساسية
                                            </span>
                                            <span v-else>
                                                البيع بالوحدة الفرعية التجزئة
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="width30"> تاريخ اخر تحديث</td>
                                        <td>
                                            <span v-if="settings.updated_by > 0 && settings.updated_by != null" class="mr-1">

                                                {{ date }}
                                                {{ time }}
                                                {{ newDateTimeType }}
                                                بواسطة
                                                {{ settings.updated_by_admin }}
                                            </span>

                                            <span v-else>
                                                لايوجد تحديث
                                            </span>

                                            <router-link :to="{ name: 'settings.edit' }"
                                                class="btn btn-sm btn-success">تعديل</router-link>

                                        </td>
                                    </tr>
                                </table>
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

export default {
    data() {
        return {
            title : 'بيانات الضبط العام',
            settings: [],
            date: '',
            time: '',
            newDateTimeType: '',
            errors: {},
            loading: false
        }
    },
    mounted() {
        this.getSettingData();
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods: {
        getSettingData() {
            this.loading = true;

            axios.get('/admin/settings/get_setting_data').then((response) => {
                this.settings = response.data.data;
                this.date = response.data.date;
                this.time = response.data.time;
                this.newDateTimeType = response.data.newDateTimeType;
            }).catch((error) => {
                console.log(error.response.data);
            }).finally(() => {
                this.loading = false;
            });
        }
    }
}
</script>