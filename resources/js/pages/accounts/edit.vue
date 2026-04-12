<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title card_title_center">تعديل حساب مالي جديد</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form @submit.prevent="updateAccount" method="post">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>اسم الحساب المالي</label>
                <input v-model="form.accounts.name" type="text" class="form-control" />
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
                  <option value>اختر الحالة</option>
                  <option value="1">دائن</option>
                  <option value="2">مدين</option>
                  <option value="3">متزن</option>
                </select>
                <span
                  v-if="errors.start_balance_status"
                  class="text-danger"
                >{{ errors.start_balance_status[0] }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>رصيد أول المدة للحساب</label>
                <input
                  v-model="form.accounts.start_balance"
                  class="form-control"
                  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                />
                <span v-if="errors.start_balance" class="text-danger">{{ errors.start_balance[0] }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>ملاحظات</label>
                <input v-model="form.accounts.notes" class="form-control" />
                <span v-if="errors.notes" class="text-danger">{{ errors.notes[0] }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>حالة التفعيل</label>
                <select v-model="form.accounts.active" id="active" class="form-control px-5">
                  <option value disabled selected>اختر الحالة</option>
                  <option value="1">نعم</option>
                  <option value="0">لا</option>
                </select>
                <span v-if="errors.active" class="text-danger">{{ errors.active[0] }}</span>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group text-center d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-sm">تعديل</button>
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
import axios from "axios";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      title: "تعديل حساب مالي جديد",
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
          active: ""
        }
      }
    };
  },
  async mounted() {
    var title = document.getElementById("title");
    title.innerHTML = this.title;
    this.getAccountTypes();
    await axios
      .get("/admin/accounts/" + this.$route.params.id + "/get-item-data")
      .then(res => {
        let data = res.data.data;
        this.form.accounts.name = data.name;
        this.form.accounts.account_type_id = data.account_type?.id;
        this.form.accounts.is_parent = data.is_parent;
        this.form.accounts.parent_account_number = data.parent_account_number;
        this.form.accounts.start_balance_status = data.start_balance_status;
        this.form.accounts.start_balance = data.start_balance;
        this.form.accounts.notes = data.notes;
        this.form.accounts.active = data.active;
      })
      .catch(error => {
        console.log(error.response.data);
      });
      this.getParentAccount();
  },
  methods: {
    async getAccountTypes() {
      try {

      let res = await axios.get(
        "/admin/account-types/get-accounts-types-data"
      );

      this.account_types = res.data.account_types.data;

    } catch (error) {
      console.log(error);
    }
    },
    updateAccount() {
      axios
        .put("/admin/accounts/" + this.$route.params.id + "/update", this.form.accounts)
        .then(response => {
          Swal.fire({
            title: response.data.message,
            icon: "success",
            confirmButtonText: "تم"
          }).then(() => {
            this.$router.push({ name: "accounts.index" });
          });
        })
        .catch(error => {
          this.errors = error.response.data.errors;
        });
    },
      async getParentAccount() {
      try {
        let res = await axios.get(
          "/admin/accounts/get-parent-accounts-data/" + this.$route.params.id
        );

        this.parent_accounts = res.data.parent_accounts.data;

      } catch (error) {
        console.log(error);
      }
    },
  }
};
</script>