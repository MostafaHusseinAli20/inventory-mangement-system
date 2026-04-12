<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title card_title_center">اضافة حساب مالي جديد</h3>
      </div>
      <!-- /.card-header -->

      <div class="card-body">
        <form @submit.prevent="createAccount" method="post">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>اسم الحساب المالي</label>
                <input v-model="form.accounts.name" type="text" class="form-control"/>
                <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>نوع الحساب</label>
                <select v-model="form.accounts.account_type_id" class="form-control px-5">
                  <option value disabled selected>اختر النوع</option>
                  <span v-if="account_types.length > 0">
                    <option
                      v-for="account_type in account_types"
                      :key="account_type.id"
                      :value="account_type.id"
                    >{{ account_type.name }}</option>
                  </span>
                </select>
                <span v-if="errors.account_type" class="text-danger">{{ errors.account_type[0] }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>هل الحساب أب</label>
                <select v-model="form.accounts.is_parent" class="form-control px-5">
                  <option value disabled selected>اختر الحالة</option>
                  <option value="1">نعم</option>
                  <option value="0">لا</option>
                </select>
                <span v-if="errors.is_parent" class="text-danger">{{ errors.is_parent[0] }}</span>
              </div>
            </div>

            <div
              class="col-md-6"
              :style="{
                            display:
                                form.accounts.is_parent == 1 ? 'block' : 'none',
                        }"
            >

              <div class="form-group">
                <label>الحسابات الأب</label>
                <select v-model="form.accounts.parent_account_number" class="form-control px-5">
                  <option value>اختر الحساب الاب</option>
                  <span v-if="parent_accounts.length > 0">
                    <option
                      v-for="parent_account in parent_accounts"
                      :key="parent_account.id"
                      :value="parent_account.account_number"
                    >{{ parent_account.name }}</option>
                  </span>
                </select>
                <span
                  v-if="errors.parent_account_number"
                  class="text-danger"
                >{{ errors.parent_account_number[0] }}</span>
              </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                <label>حالة رصيد اول المدة</label>
                <select v-model="form.accounts.start_balance_status" class="form-control px-5">
                    <option value="">اختر الحالة</option>
                    <option value="1"> دائن</option>
                    <option value="2"> مدين</option>
                    <option value="3"> متزن</option>
                </select>
                <span v-if="errors.start_balance_status" class="text-danger">
                        {{ errors.start_balance_status[0] }}
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>   رصيد أول المدة للحساب</label>
                    <input  v-model="form.accounts.start_balance" class="form-control"  
                    oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                    <span v-if="errors.start_balance" class="text-danger">
                                {{ errors.start_balance[0] }}
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>ملاحظات</label>
                    <input v-model="form.accounts.notes" class="form-control">
                    <span v-if="errors.notes" class="text-danger">
                        {{ errors.notes[0] }}
                    </span>
                </div>
            </div>



            <div class="col-md-6">
                <div class="form-group">
                    <label>حالة التفعيل</label>
                    <select v-model="form.accounts.active" id="active" class="form-control px-5">
                        <option value="" disabled selected>اختر الحالة</option>
                        <option value="1"> نعم</option>
                        <option value="0"> لا</option>
                    </select>
                    <span v-if="errors.active" class="text-danger">
                        {{ errors.active[0] }}
                    </span>
                </div>
            </div>

             <div class="col-md-12">
                <div class="form-group text-center d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                    <router-link :to="{ name: 'accounts.index' }" class="btn btn-sm btn-danger">الغاء</router-link>    
                </div>
            </div>


          </div>
        </form>
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
      title: "اضافة حساب مالي جديد",
      account_types: [],
      parent_accounts: [],
      errors: {},
      form: {
        accounts: {
          name: "",
          account_type_id: "",
          is_parent: "",
          parent_account_number: "",
          start_balance_status: "",
          start_balance: "",
          notes: "",
          active: "",
        }
      }
    };
  },
  mounted() {
    var title = document.getElementById("title");
    title.innerHTML = this.title;
    this.getAccountTypesData();
  },
  methods: {
    async getAccountTypesData()
    {
        await axios.get('/admin/accounts/get-account-types-data').then((response) => {
            this.account_types = response.data.account_types;
            this.parent_accounts = response.data.parent_accounts;
        }).catch((error) => {
            Swal.fire({
                icon: "error",
                title: "خطأ",
                text: error.response.data.message
            });
        })
    },
    createAccount(){
        axios.post('/admin/accounts/store', this.form.accounts)
        .then((response) => {
            if (response.data.message == 'تم إضافة الحساب بنجاح') {
                Swal.fire({
                    icon: "success",
                    text: response.data.message,
                    showConfirmButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$router.push({ name: "accounts.index" });
                    }
                });
            }
        }).catch((error) => {
            if (error.response.status == 422) {
                this.errors = error.response.data.errors;
                Swal.fire({
                    icon: "error",
                    text: error.response.data.message || 'حدث خطأ ما',
                    showConfirmButton: true
                });
            }
            if (error.response.status == 500) {
                Swal.fire({
                    icon: "error",
                    text: error.response.data.message || 'حدث خطأ ما',
                    showConfirmButton: true
                });
            }
        })
    }
  }
};
</script>