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
              <h1 class="m-0 text-dark">الاصناف</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link
                    :to="{
                                            name: 'item-cards.index',
                                        }"
                  >الاصناف</router-link>
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
          <h3 class="card-title card_title_center">بيانات الاصناف</h3>
          <router-link :to="{ name: 'item-cards.create' }" class="btn btn-sm btn-success">اضافة جديد</router-link>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <label for="">بحث بالاسم او الباركود او كود الصنف</label>
              <input
                v-model="searchText"
                type="text"
                id="search_by_text"
                placeholder=" اسم - باركود - كود للصنف"
                class="form-control"
              />
              <br />
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>بحث بنوع الصنف</label>
                <select v-model="filterByType" class="form-control px-5">
                  <option value="all">بحث بالكل</option>
                  <option value="1">مخزني</option>
                  <option value="2">استهلاكي بتاريخ صلاحية</option>
                  <option value="3">عهدة</option>
                </select>
                <span v-if="errors.item_type" class="text-danger">{{ errors.item_type[0] }}</span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>بحث بفئة الصنف</label>
                <select
                  v-model="filterByCategory"
                  class="form-control px-5"
                >
                  <option value="all">بحث بالكل</option>
                  <span v-if="itemcard_categories != null">
                    <option
                      v-for="value in itemcard_categories"
                      :key="value.id"
                      :value="value.id"
                    >{{ value.name }}</option>
                  </span>
                </select>
                <span
                  v-if="errors.itemcard_categories_id"
                  class="text-danger"
                >{{ errors.itemcard_categories_id[0] }}</span>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center gap-4 mb-3 mr-3">
              <a href="/admin/item-cards/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
              <a href="/admin/item-cards/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
            </div>
          </div>

          <div v-if="itemCards.length > 0" class="col-md-12">
            <table id="example2" class="table table-bordered table-hover">
              <thead class="custom_thead">
                <!-- <th>#</th> -->
                <th>كود آلي</th>
                <th>الاسم</th>
                <th>النوع</th>
                <th>الفئة</th>
                <th>الوحدة الاب</th>
                <th>حالة التفعيل</th>
                <th></th>
              </thead>

              <tbody>
                <tr v-for="item in itemCards" :key="item.id">
                  <!-- <td>{{ item.id }}</td> -->
                  <td>{{ item.item_code }}</td>
                  <td>{{ item.name }}</td>
                  <td>
                    {{ 
                        item.item_type == 1 ? 'مخزني' : 
                        item.item_type == 2 ? 'استهلاكي بصلاحية' : 
                        item.item_type == 3 ? 'عهدة' : 'غير محدد'
                    }}
                  </td>

                  <td>{{ item.item_card_category_name }}</td>
                  <td>{{ item.uom_name }}</td>
                  <td>
                    <span :class="item.active == 1 ? 'badge badge-success' : 'badge badge-danger' "
                      >{{ item.active == 1 ? 'مفعل' : 'غير مفعل' }}</span>
                  </td>
                  <td>
                    <router-link :to="{name:'item-cards.edit',params:{id:item.id}}" class="btn btn-sm btn-primary mr-2">تعديل</router-link>
                    <router-link :to="{name:'item-cards.show',params:{id:item.id}}" class="btn btn-sm btn-info">عرض</router-link>
                    <a target="_blank" href class="btn btn-sm btn-success mr-2">
                      باركود
                      <i class="fa fa-print"></i>
                    </a>
                    <button @click="deleteItemCard(item.id)" class="btn btn-sm btn-danger">
                      حذف <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
            <PaginationComponent
              fetchUrl="/admin/item-cards/get-item-cards-data"
              :perPage="10"
              collection="item_cards"
              @dataLoaded="itemCards = $event"
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
      title: "بيانات الصنف",
      itemCards: {},
      loading: false,
      errors: {},
      itemcard_categories: [],
      filterByType: "all",
      filterByCategory: "all",
      searchText:"",
      pagination:{}
    };
  },

  mounted() {
      this.getItemCards();
      this.getItemCardCategories();
      this.searchItems("");
      var title = document.getElementById("title");
      title.innerHTML = this.title;
    },

  watch: {
    filterByType() {
      this.applyFilters();
    },
    filterByCategory() {
      this.applyFilters();
    },
    searchText(newValue) {
      clearTimeout(this.timer);
      this.timer = setTimeout(() => {
        this.searchItems(newValue);
      }, 300);
    },
  },

  methods: {
    applyFilters() {
      if (this.filterByType === 'all' && this.filterByCategory === 'all') {
        this.getItemCards(); // رجّع الداتا الأصلية
        return;
      }

      this.filterItemCards();
    },

    searchItems(value) {
      axios.get("/admin/item-cards/search", {
        params: {
          search: value
        }
      })
      .then(response => {
        this.itemCards = response.data.itemCard.data;
      })
      .catch(error => {
        console.log(error.response?.data || error.message);
      });
    },

    async getItemCards() {
      this.loading = true;
      await axios
        .get("/admin/item-cards/get-item-cards-data")
        .then(response => {
          this.itemCards = response.data.item_cards.data;
          this.itemcard_categories = response.data.itemcard_categories.data;
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
        }).finally(() => (this.loading = false));
    },

    async getItemCardCategories() {
      await axios
        .get("/admin/item-cards/get-categories-names")
        .then(response => {
          console.log(response.data);
          this.itemcard_categories = response.data.categories;
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
        });
    },

    async filterItemCards() {
      await axios
        .get("/admin/item-cards/filter", {
          params: {
            filter_by_type: this.filterByType,
            filter_by_category: this.filterByCategory
          }
        })
        .then(response => {
          this.itemCards = response.data.item_cards.data;
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
        });
    },

    deleteItemCard(id) {
      Swal.fire({
        title: "هل انت متاكد من عملية الحذف ؟",
        text: "لايمكن استرجاع البيانات بعد الحذف",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "نعم",
        cancelButtonText: "الغاء"
      }).then(result => {
        if (result.isConfirmed) {
          axios
            .delete("/admin/item-cards/" + id + "/destroy")
            .then(response => {
              Swal.fire("تم الحذف!", "تم حذف البيانات بنجاح.", "success");
              this.getItemCards();
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
            });
        }
      });
    }
  },
};
</script>

<style scoped></style>
