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
              <h1 class="m-0 text-dark">انواع الحسابات المالية</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link
                    :to="{
                                            name: 'accounts-types.index',
                                        }"
                  >انواع الحسابات المالية</router-link>
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
          <h3 class="card-title card_title_center">بيانات انواع الحسابات المالية</h3>
          <!-- <router-link :to="{ name: 'item-cards.create' }" class="btn btn-sm btn-success">اضافة جديد</router-link> -->
        </div>
        <!-- /.card-header -->

        <div class="card-body">
          <div class="row">
            <div class="d-flex justify-content-between align-items-center gap-4 mb-3 mr-3">
              <a href="/admin/accounts-types/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
              <a href="/admin/accounts-types/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
            </div>
          </div>

          <div v-if="accountTypes != null" id="ajax_responce_serarchDiv">
            <table id="example2" class="table table-bordered table-hover">
              <thead class="custom_thead">
                <th>مسلسل</th>
                <th>اسم النوع</th>
                <th>حالة التفعيل</th>
                <th>هل يضاف من شاشه داخلية</th>
              </thead>
              <tbody>
                <tr v-for="(item, index) in accountTypes" :key="item.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.name }}</td>
                  <td>
                    <span
                      v-if="item.relatediternalaccounts == 0"
                      class="badge badge-success"
                    >نعم ويضاف من شاشته الداخلية ويسمع بشاشة الحسابات الرئيسية</span>
                    <span v-else class="badge badge-danger">لا ويضاف من شاشة الحسابات الرئيسية</span>
                  </td>
                  <td>
                    <span v-if="item.active == 1" class="badge badge-success">نعم</span>
                    <span v-else class="badge badge-danger"></span>
                  </td>
                </tr>
              </tbody>
            </table>
            <br />
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
export default {
  data() {
    return {
      title: "انواع الحسابات المالية",
      loading: false,
      accountTypes: []
    };
  },
  mounted() {
    this.getAccountTypes();
    var title = document.getElementById("title");
    title.innerHTML = this.title;
  },
  methods: {
    async getAccountTypes() {
      this.loading = true;
      await axios
        .get("/admin/account-types/get-accounts-types-data")
        .then(response => {
          this.accountTypes = response.data.account_types.data;
          // console.log(response.data.account_types.data);
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>