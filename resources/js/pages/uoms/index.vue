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
              <h1 class="m-0 text-dark">الوحدات</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link :to="{ name: 'uoms.index' }">الوحدات</router-link>
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
          <h3 class="card-title card_title_center">بيانات وحدات القياس للأصناف</h3>
          <router-link :to="{ name: 'uoms.create' }" class="btn btn-sm btn-success">اضافة جديد</router-link>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <label>بحث بالاسم</label>
              <input type="text" v-model="searchText" placeholder="بحث بالاسم" class="form-control" />
              <br />
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>بحث بالنوع</label>
                <select v-model="filter" id="is_master_search" class="form-control px-5">
                  <option value="2">بحث بالكل</option>
                  <option value="1">وحدة اب</option>
                  <option value="0">وحدة تجزئة</option>
                </select>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center gap-4">
              <a href="/admin/uoms/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
              <a href="/admin/uoms/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12">
              <div id="ajax_responce_serarchDiv" v-if="uoms.length > 0">
                <table id="example2" class="table table-bordered table-hover">
                  <thead class="custom_thead">
                    <th>مسلسل</th>
                    <th>اسم الوحدة</th>
                    <th>نوع الوحدة</th>
                    <th>حالة التفعيل</th>
                    <th>تاريخ الاضافة</th>
                    <th>تاريخ التحديث</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <tr v-for="uom in uoms" :key="uom.id">
                      <td>{{ uom.id }}</td>
                      <td>{{ uom.name }}</td>
                      <td>
                        <span v-if="uom.is_master == 1">وحدة اب</span>
                        <span v-else>وحدة تجزئة</span>
                      </td>
                      <td>
                        <span v-if="uom.active == 1">مفعل</span>
                        <span v-else>معطل</span>
                      </td>
                      <td>
                        {{ date }}
                        <br />
                        {{ time }}
                        {{ newDateTimeType }}
                        <br />
                        بواسطة
                        {{ uom.added_by_admin }}
                      </td>
                      <td>
                        {{ date }}
                        <br />
                        {{ time }}
                        {{ newDateTimeType }}
                        <br />
                        بواسطة
                        {{ uom.updated_by_admin }}
                      </td>
                      <td>
                        <router-link
                          :to="{
                                                        name: 'uoms.edit',
                                                        params: { id: uom.id },
                                                    }"
                          class="btn btn-sm btn-primary mr-1"
                        >تعديل</router-link>
                        <button @click="deleteUom(uom.id)" class="btn btn-sm btn-danger">حذف</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <PaginationComponent
                  fetchUrl="/admin/uoms/get-uoms-data"
                  :perPage="10"
                  collection="uoms"
                  @dataLoaded="uoms = $event"
                />
                <br />
              </div>

              <div v-else>
                <div class="alert alert-danger">عفوا لاتوجد بيانات لعرضها !!</div>
              </div>
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
import PaginationComponent from "../../components/PaginationComponent.vue";
export default {
  components: {
    PaginationComponent
  },
  data() {
    return {
      title: "بيانات وحدات القياس للأصناف",
      uoms: [],
      loading: false,
      date: "",
      time: "",
      newDateTimeType: "",
      searchText: "",
      filter: null
    };
  },
  mounted() {
    this.getUomsData();
    this.searchUoms("");
    var title = document.getElementById("title");
    title.innerHTML = this.title;
  },
  watch: {
    searchText(newValue) {
      // Debounce لمنع الإرسال كل حرف = أفضل أداء
      clearTimeout(this.typingTimer);
      this.timer = setTimeout(() => {
        this.searchUoms(newValue);
      }, 300);
    },
    filter(newValue) {
      clearTimeout(this.typingTimer);
      this.timer = setTimeout(() => {
        this.filterUomsByType(newValue);
      }, 300);
    }
  },
  methods: {
    async getUomsData() {
      this.loading = true;
      await axios
        .get("/admin/uoms/get-uoms-data")
        .then(response => {
          this.uoms = response.data.uoms.data;
          this.date = response.data.date;
          this.time = response.data.time;
          this.newDateTimeType = response.data.newDateTimeType;
        })
        .catch(error => {
          if (error.response.status == 422) {
            Swal.fire({
              icon: "error",
              title: "خطأ",
              text: error.response.data.message
            });
          }

          if (error.response.status == 500) {
            Swal.fire({
              icon: "error",
              title: "خطأ",
              text: error.response.data.message
            });
          }
        })
        .finally(() => (this.loading = false));
    },
    deleteUom(id) {
      Swal.fire({
        title: "هل انت متاكد من حذف الوحدة؟",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "نعم",
        cancelButtonText: "لا"
      }).then(result => {
        if (result.isConfirmed) {
          axios
            .delete("/admin/uoms/" + id + "/destroy")
            .then(() => {
              this.getUomsData();
            })
            .catch(error => {
              console.log(error.response?.data || error.message);
            });
        }
      });
    },
    searchUoms(name) {
      axios
        .get("/admin/uoms/search", {
          params: {
            name: name
          }
        })
        .then(response => {
          this.uoms = response.data.uoms;
        })
        .catch((error) => {
          console.log(error.response?.data || error.message);
        });
    },
    filterUomsByType(type){
      axios.get('/admin/uoms/filter-by-type',{
        params: {
          filter: type
        }
      }).then(response => {
        this.uoms = response.data.uoms.data;
        time = response.data.time;
        date = response.data.date;
        newDateTimeType = response.data.newDateTimeType;
      }).catch((error) => {
        console.log(error.response?.data || error.message);
      })
    }
  }
};
</script>
