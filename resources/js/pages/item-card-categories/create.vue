<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">فئات الاصناف</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'item-card-categories.index' }">فئات الاصناف</router-link>
              </li>
              <li class="breadcrumb-item active">اضافة</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title card_title_center">اضافة صنف جديد</h3>
      </div>

      <div class="card-body">
        <form action method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>اسم الصنف</label>
                <span id="nameCheckMessage"></span>
                <input v-model="inv_itemcard_categories.name" class="form-control" placeholder="ادخل اسم الصنف" />

                <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group mt-2">
                <label>حالة التفعيل</label>
                <select v-model="inv_itemcard_categories.active" id="active" class="form-control px-5">
                  <option value disabled selected>اختر الحالة</option>
                  <option value="1">نعم</option>
                  <option value="0">لا</option>
                </select>
                <span v-if="errors.active" class="text-danger">{{ errors.active[0] }}</span>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group text-center">
                <button type="button" @click="addInvItemCardCategory" class="btn btn-primary mr-2">اضافة</button>
                <router-link :to="{ name: 'item-card-categories.index' }" class="btn btn-danger">الغاء</router-link>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- /.content-header -->
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      title: "اضافة صنف جديد",
      inv_itemcard_categories:{},
      errors: {}
    };
  },
  mounted() {
    var title = document.getElementById("title");
    title.innerHTML = this.title;
  },
  methods: {
    addInvItemCardCategory() {
      axios
        .post(
          "/admin/item-card-categories/store",
          this.inv_itemcard_categories
        )
        .then(response => {
          if (response.data.message == 'تم الاضافة بنجاح') {
            Swal.fire({
              icon: "success",
              text: response.data.message,
              showConfirmButton: true
            }).then(result => {
              if (result.isConfirmed) {
                this.$router.push({ name: "item-card-categories.index" });
              }
            });
          }
        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
            Swal.fire({
              icon: "error",
              text: error.response.data.message,
              showConfirmButton: true
            });
          }
          if (error.response.status == 500) {
            Swal.fire({
              icon: "error",
              text: error.response.data.message,
              showConfirmButton: true
            });
          }
        });
    }
  }
};
</script>

<style></style>