<template>
  <div>
    <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status"></div>
      <span class="ms-3 fs-4">جاري التحميل...</span>
    </div>

    <div v-else>
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">الشجرة المحاسبية</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link :to="{name: 'accounts.index'}">الشجرة المحاسبية</router-link>
                </li>
                <li class="breadcrumb-item active">عرض</li>
              </ol>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">الشجرة المحاسبية</h3>
          <router-link :to="{ name: 'accounts.create' }" class="btn btn-sm btn-success">اضافة جديد</router-link>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center gap-4 mb-3 mr-3">
              <a href="/admin/accounts/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
              <a href="/admin/accounts/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <label>بحث برقم او اسم الحساب</label>
              <input
                type="text"
                placeholder=" اسم  - رقم الحساب"
                class="form-control"
                @input="getAccounts"
                v-model="search"
              />
              <br />
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>بحث بنوع الحساب</label>

                <select v-model="account_search" class="form-control px-5" @change="getAccounts">
                  <option value="all">بحث بالكل</option>
                  <option v-for="account in account_types" :key="account.id" :value="account.id"
                  >{{ account.name }}</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>هل الحساب أب</label>
                <select v-model="is_parent_search" class="form-control px-5" @change="getAccounts">
                  <option value="all">بحث بالكل</option>
                  <option :value="1">نعم</option>
                  <option :value="0">لا</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>حالة التفعيل</label>
                <select v-model="active_search" class="form-control px-5" @change="getAccounts">
                  <option value="all">بحث بالكل</option>
                  <option :value="1">مفعل</option>
                  <option :value="0">معطل ومؤرشف</option>
                </select>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>

          <div v-if="accounts != null && accounts.length > 0" class="col-md-12">
            <table id="example2" class="table table-bordered table-hover">
              <thead class="custom_thead">
                <th>#</th>
                <th>الاسم</th>
                <th>رقم الحساب</th>
                <th>النوع</th>
                <th>هل أب</th>
                <th>الحساب الاب</th>
                <th>الرصيد</th>
                <th>التفعيل</th>
                <th></th>
              </thead>
              <tbody>
                <tr v-for="account in accounts" :key="account.id">
                  <td>{{ account.id }}</td>
                  <td>{{ account.name }}</td>
                  <td>{{ account.account_number }}</td>
                  <td>{{ account.account_type.name || 'لا يوجد' }}</td>
                  <td>
                    <span v-if="account.is_parent == 1" class="badge badge-success">نعم</span>
                    <span v-else class="badge badge-danger">لا</span>
                  </td>
                  <td>
                    {{ account.parent_account_number || 'لا يوجد' }}
                  </td>

                  <td>
                    <span v-if="account.is_parent == 0">
                      <span
                        v-if="account.current_balance > 0"
                        class="badge badge-success"
                      >مدين ({{ account.current_balance * 1 }})</span>

                      <span
                        v-else-if="account.current_balance < 0"
                        class="badge badge-danger"
                      >دائن ({{ account.current_balance * 1 * (-1) }})</span>

                      <span v-else class="badge badge-warning">متزن</span>
                    </span>

                    <span v-else>من ميزان المراجعه</span>
                  </td>

                  <td>
                    <span v-if="account.active == 1" class="badge badge-success">نعم</span>
                    <span v-else class="badge badge-danger">لا</span>
                  </td>

                  <td>
                    <span v-if="account.account_type.relatediternalaccounts == 0">
                      <router-link
                        :to="{name:'accounts.edit', params:{id:account.id}}"
                        class="btn btn-sm btn-primary"
                      >تعديل</router-link>
                    </span>
                    <span v-else>يعدل من شاشته</span>
                  </td>
                </tr>
              </tbody>
            </table>
            <PaginationComponent
              fetchUrl="/admin/accounts/get-accounts-data"
              :perPage="10"
              collection="accounts"
              @dataLoaded="accounts = $event"
            />
          </div>

          <div v-else>
            <div class="alert alert-danger">عفوا لاتوجد بيانات لعرضها !!</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import PaginationComponent from "../../components/PaginationComponent.vue";
export default {
  components: {
    PaginationComponent
  },
  data() {
    return {
      title: "الشجرة المحاسبية",
      loading: false,
      accounts: [],
      account_types: [],
      search: "",
      account_search: "all",
      is_parent_search: "all",
      active_search: "all"
    };
  },
  mounted() {
    var title = document.getElementById("title");
    title.innerHTML = this.title;
    this.getAccountsData();
    this.getAccounts();
  },
  methods: {
    async getAccounts() {
      // this.loading = true;
      try {
        let response = await axios.get(
          "/admin/accounts/search-filter-accounts",
          {
            params: {
              search: this.search,
              account_type: this.account_search,
              is_parent: this.is_parent_search,
              active: this.active_search
            }
          }
        );

        this.accounts = response.data.accounts.data;
        this.account_types = response.data.account_types;
      } catch (error) {
        console.log(error);
      }
    },
    async getAccountsData() {
      this.loading = true;
      await axios
        .get("/admin/accounts/get-accounts-data")
        .then(response => {
          this.accounts = response.data.accounts.data;
        })
        .catch(error => {
          console.log(error.response.data);
        })
        .finally(() => {
          this.loading = false;
        });
    }
  }
};
</script>
