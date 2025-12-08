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
                            <h1 class="m-0 text-dark">تعديل الضبط</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link
                                        :to="{ name: 'settings.index' }">الضبط</router-link></li>
                                <li class="breadcrumb-item active">تعديل الضبط</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات الضبط العام</h3>
                </div>

                <div class="card-body">

                    <div v-if="Object.keys(setting).length > 0">
                        <form @submit.prevent="updateSetting" enctype="multipart/form-data">
                            <div class="row">

                                <!-- اسم الشركة -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>اسم الشركة</label>
                                        <input v-model="setting.system_name" class="form-control"
                                            placeholder="ادخل اسم الشركة">
                                        <span v-if="errors.system_name" class="text-danger">
                                            {{ errors.system_name[0] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- عنوان الشركة -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>عنوان الشركة</label>
                                        <input v-model="setting.address" class="form-control"
                                            placeholder="ادخل عنوان الشركة">
                                        <span v-if="errors.address" class="text-danger">
                                            {{ errors.address[0] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- هاتف الشركة -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>هاتف الشركة</label>
                                        <input v-model="setting.phone" id="phone" class="form-control"
                                            placeholder="ادخل اسم الشركة">

                                        <span v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</span>
                                    </div>
                                </div>

                                <!-- الحساب الاب للعملاء -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> الحساب الاب للعملاء بالشجرة المحاسبية</label>
                                        <select v-model="setting.customer_parent_account_number"
                                            id="customer_parent_account_number" class="form-control select2">
                                            <option value="" disabled selected>اختر الحساب </option>
                                            <span v-if="setting.parent_accounts > 0">
                                                <span v-for="info in parent_accounts" :key="info.id">
                                                    <option :value="info.account_number"> {{ info.name }} </option>
                                                </span>
                                            </span>
                                            <!-- <span v-else>
                                            <option value="">لا يوجد حسابات </option>
                                        </span> -->
                                        </select>

                                        <span v-if="errors.customer_parent_account_number" class="text-danger">{{
                                            errors.customer_parent_account_number[0] }}</span>
                                    </div>
                                </div>

                                <!-- الحساب الاب للموردين -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> الحساب الاب للموردين بالشجرة المحاسبية</label>

                                        <select v-model="setting.suppliers_parent_account_number"
                                            id="suppliers_parent_account_number" class="form-control select2 ">
                                            <option value="" disabled selected>اختر الحساب </option>
                                            <span v-if="setting.parent_accounts > 0">
                                                <span v-for="info in parent_accounts" :key="info.id">
                                                    <option :value="info.account_number"> {{ info.name }} </option>
                                                </span>
                                            </span>
                                        </select>

                                        <span v-if="errors.suppliers_parent_account_number" class="text-danger">{{
                                            errors.suppliers_parent_account_number[0] }}</span>
                                    </div>
                                </div>

                                <!-- الحساب الاب للمناديب -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> الحساب الاب للمناديب بالشجرة المحاسبية</label>
                                        <select v-model="setting.delegate_parent_account_number"
                                            id="delegate_parent_account_number" class="form-control select2 ">
                                            <option value="" disabled selected>اختر الحساب </option>
                                            <span v-if="setting.parent_accounts > 0">
                                                <span v-for="info in parent_accounts" :key="info.id">
                                                    <option :value="info.account_number"> {{ info.name }} </option>
                                                </span>
                                            </span>
                                        </select>

                                        <span v-if="errors.delegate_parent_account_number" class="text-danger">{{
                                            errors.delegate_parent_account_number[0] }}</span>
                                    </div>
                                </div>

                                <!-- الحساب الاب للموظفين -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> الحساب الاب للموظفين بالشجرة المحاسبية</label>
                                        <select v-model="setting.employees_parent_account_number"
                                            id="employees_parent_account_number" class="form-control select2">
                                            <option value="" disabled selected>اختر الحساب </option>
                                            <span v-if="setting.parent_accounts > 0">
                                                <span v-for="info in parent_accounts" :key="info.id">
                                                    <option :value="info.account_number"> {{ info.name }} </option>
                                                </span>
                                            </span>
                                        </select>

                                        <span v-if="errors.employees_parent_account_number" class="text-danger">{{
                                            errors.employees_parent_account_number[0] }}</span>
                                    </div>
                                </div>

                                <!-- الحساب الاب لخطوط الانتاج -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> الحساب الاب لخطوط الانتاج بالشجرة المحاسبية</label>
                                        <select v-model="setting.production_lines_parent_account"
                                            id="production_lines_parent_account" class="form-control select2">
                                            <option value="" disabled selected>اختر الحساب </option>
                                            <span v-if="setting.parent_accounts > 0">
                                                <span v-for="info in parent_accounts" :key="info.id">
                                                    <option :value="info.account_number"> {{ info.name }} </option>
                                                </span>
                                            </span>

                                        </select>

                                        <span v-if="errors.production_lines_parent_account" class="text-danger">{{
                                            errors.production_lines_parent_account[0] }}</span>
                                    </div>
                                </div>

                                <span v-if="setting.is_set_Batches_setting == 0">
                                    <!-- نوع الباتشات -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label> نوع آلية عمل الباتشات بالنظام</label>
                                            <select v-model="setting.Batches_setting_type" id="Batches_setting_type"
                                                class="form-control">
                                                <option value="" disabled selected>اختر النوع </option>
                                                <option value="1"> يعمل بنظام تعدد الباتشات للصنف طبقا لاختلاف سعر
                                                    الشراء
                                                    وتواريخ الانتاج والانتهاء </option>
                                                <option value="2"> لايعمل بنظام الباتشات - فقط كمية لكل صنف</option>

                                            </select>
                                            <span v-if="errors.Batches_setting_type" class="text-danger">{{
                                                errors.Batches_setting_type[0] }}</span>
                                        </div>
                                    </div>
                                </span>

                                <span v-else></span>

                                <!-- وحدة البيع الاساسية -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> وحدة البيع الاساسية بالفواتير</label>
                                        <select v-model="setting.default_unit" id="default_unit" class="form-control  ">
                                            <option v-if="setting.default_unit == 1" :value="1">
                                                بيع تلقائي بالوحدة الاساسية الاب
                                            </option>
                                            <option v-else-if="setting.default_unit == 2" :value="2">
                                                بيع تلقائي بالوحدة الفرعية التجزئة
                                            </option>

                                        </select>
                                        <span v-if="errors.default_unit" class="text-danger">{{ errors.default_unit[0]
                                            }}</span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <!-- رسالة تنبية -->
                                    <div class="form-group">
                                        <label>رسالة تنبية اعلي الشاشة </label>
                                        <input v-model="setting.general_alert" id="general_alert" class="form-control"
                                            placeholder="ادخل اسم الشركة">
                                    </div>
                                    <span v-if="errors.general_alert">
                                        <span class="text-danger">{{ errors.general_alert[0] }}</span>
                                    </span>
                                </div>

                                <div class="col-md-12">
                                    <!-- رسالة تنبية -->
                                    <div class="form-group">
                                        <label>بريد الشركة</label>
                                        <input type="email" v-model="setting.email" id="email" class="form-control"
                                            placeholder="ادخل بريد الشركة">
                                    </div>
                                    <span v-if="errors.email">
                                        <span class="text-danger">{{ errors.email[0] }}</span>
                                    </span>
                                </div>

                                <div class="col-sm-12 text-center mx-auto col-md-12 mb-4">
                                        <span class="text-center mx-auto text-success">يجب الصورة تكون من نوع .png, .jpg, .jpeg 
                                            <span class="text-danger">*</span></span>
                                    <div class="avatar-upload mt-3">

                                        <div class="avatar-edit">
                                            <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg"
                                                @change="handleFileUpload($event)" />
                                            <label for="imageUpload">
                                                <i class="fas fa-pen"></i>
                                            </label>
                                        </div>

                                        <div class="avatar-preview">
                                            <div id="imagePreview"
                                                :style="{ backgroundImage: imagePreview ? 'url(' + imagePreview + ')' : 'none' }">
                                            </div>
                                        </div>

                                    </div>

                                    <p class="form-label text-center">
                                        <span class="text-info">صورة الشركة</span> <br>
                                        <span class="text-center mx-auto" v-if="errors.logo">
                                            <span class="text-danger text-center mx-auto">{{ errors.logo[0] }}</span>
                                        </span>
                                    </p>

                                </div>

                            </div>

                            <button class="btn btn-success mt-3">حفظ التعديل</button>
                        </form>
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
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            title: "تعديل بيانات الضبط العام",
            setting: {},
            errors: {},
            loading: false,
            form: {
                logo: null
            },
            imagePreview: null
        };
    },

    mounted() {
        this.getSettingData();
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },

    methods: {
        getSettingData() {
            this.loading = true;
            axios.get("/admin/settings/get_setting_data")
                .then((response) => {
                    this.setting = response.data.data;

                    // إذا فيه صورة قديمة
                    if (this.setting.logo) {
                        this.form.logo = this.setting.logo;
                        this.imagePreview = encodeURI('/uploads/' + this.setting.logo);
                    }
                    console.log(this.form.logo);
                })
                .catch((error) => {
                    console.log(error.response.data);
                }).finally(() => {
                    this.loading = false;
                });
        },

        updateSetting() {
            let formData = new FormData();
            formData.append("system_name", this.setting.system_name);
            formData.append("address", this.setting.address);
            formData.append("phone", this.setting.phone);
            formData.append("email", this.setting.email);
            formData.append("general_alert", this.setting.general_alert);
            formData.append("logo", this.form.logo);
            axios.post("/admin/settings/update_setting_data", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        this.$router.push({ name: "settings.index" });
                    })
                    this.errors = {};
                })
                .catch((error) => {
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
        handleFileUpload(e) {
            const file = e.target.files[0];
            if (file) {
                this.form.logo = file;

                const reader = new FileReader();
                reader.onload = (e) => {
                    // هنا preview للصورة الجديدة
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
    }
};
</script>

<style>
.avatar-upload {
    position: relative;
    max-width: 180px;
    margin: auto;
}

.avatar-edit {
    position: absolute;
    right: 12px;
    z-index: 1;
    top: 10px;
}

.avatar-edit input {
    display: none;
}

.avatar-edit label {
    display: inline-block;
    width: 35px;
    height: 35px;
    background: #fff;
    border-radius: 100%;
    border: 1px solid #ddd;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
    line-height: 35px;
}

.avatar-edit label:hover {
    background: #f1f1f1;
}

.avatar-preview {
    width: 180px;
    height: 180px;
    position: relative;
    border-radius: 100%;
    border: 6px solid #f8f8f8;
    box-shadow: 0px 2px 4px rgb(0 0 0 / 10%);
}

#imagePreview {
    width: 100%;
    height: 100%;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
</style>