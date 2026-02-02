<template>
    <div>
        <div
            v-if="loading"
            class="d-flex justify-content-center align-items-center py-5"
        >
            <div
                class="spinner-border text-primary"
                style="width: 3rem; height: 3rem"
                role="status"
            ></div>
            <span class="ms-3 fs-4">جاري التحميل...</span>
        </div>
        <div v-else>
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
                                    <router-link
                                        :to="{
                                            name: 'sales-matrial-types.index',
                                        }"
                                        >فئات الاصناف</router-link
                                    >
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title card_title_center">
                                بيانات  فئات الاصناف
                            </h3>
                            <router-link
                                :to="{ name: 'item-card-categories.create' }"
                                class="btn btn-sm btn-success text-light font-weight-bold"
                                >اضافة جديد</router-link
                            >
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-between align-items-center gap-4">
                                <input type="text" placeholder="بحث بالاسم" class="form-control"><br>

                                <div class="d-flex justify-content-between align-items-center gap-4">
                                    <a href="/admin/item-card-categories/export-excel" class="btn btn-sm btn-primary">تصدير excel</a>
                                    <a href="/admin/item-card-categories/export-pdf" class="btn btn-sm btn-primary">تصدير pdf</a>
                                </div>

                            </div><br>
                                <div class="clearfix"></div>
                            </div>

                            <div
                                id="ajax_responce_serarchDiv"
                                class="col-md-12"
                                v-if="item_card_categories.length > 0"
                            >
                                <table
                                    id="example2"
                                    class="table table-bordered table-hover mt-3"
                                >
                                    <thead>
                                        <tr>
                                            <th>مسلسل</th>
                                            <th>الاسم</th>
                                            <th>تاريخ الاضافة</th>
                                            <th>تاريخ التحديث</th>
                                            <th>حالة التفعيل</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="item in item_card_categories"
                                            :key="item.id"
                                        >
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.name }}</td>
                                            <td>
                                              {{ item.added_by_admin ? item.added_by_admin : 'لا يوجد' }} <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                            </td>
                                            <td>
                                              <span v-if="item.updated_by_admin && date && time && newDateTimeType != null ">
                                              {{ item.updated_by_admin }} <br>
                                                {{ date }} <br>
                                                {{ time }}
                                                {{ newDateTimeType }}<br>
                                              </span>

                                              <span v-else>لايوجد تحديث</span>
                                            </td>

                                            <!-- <td>
                                                <span v-if="item.item_type == 1"
                                                    >مخزني</span
                                                >
                                                <span
                                                    v-else-if="
                                                        item.item_type == 2
                                                    "
                                                    >استهلاكي بصلاحية</span
                                                >
                                                <span v-if="item.item_type == 3"
                                                    >عهدة</span
                                                >
                                                <span v-else>غير محدد</span>
                      </td>-->

                                            <!-- <td>
                                                {{
                                                    item.inv_itemcard_categories_name
                                                }}
                                            </td>
                                            <td>{{ item.Uom_name }}</td>
                                            <td>
                                                {{ item.All_QUENTITY * 1 }}
                                                {{ item.Uom_name }}
                      </td>-->

                                            <td>
                                                <span
                                                    v-if="item.active == 1"
                                                    class="badge badge-success"
                                                    >مفعل</span
                                                >
                                                <span
                                                    v-else
                                                    class="badge badge-danger"
                                                    >غير مفعل</span
                                                >
                                            </td>

                                            <td>
                                                <router-link
                                                    :to="{
                                                        name: 'item-card-categories.edit',
                                                        params: { id: item.id },
                                                    }"
                                                    class="btn btn-sm btn-primary mr-1"
                                                    >تعديل</router-link
                                                >

                                                <router-link
                                                    :to="{
                                                        name: 'item-card-categories.show',
                                                        params: { id: item.id },
                                                    }"
                                                    class="btn btn-sm btn-info"
                                                    >عرض</router-link
                                                >

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-danger mr-1"
                                                    @click="
                                                        deleteItemCard(item.id)
                                                    "
                                                >
                                                    حذف
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                                <!-- <a
                                                    target="_blank"
                                                    href
                                                    class="btn btn-sm btn-success"
                                                >
                                                    باركود
                                                    <i class="fa fa-print"></i>
                        </a>-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <pagination-component
                                    fetchUrl="/admin/item-card-categories/get-item-card-categories-data" 
                                    :perPage="10"
                                    collection="itemCards"
                                    @dataLoaded="itemCards = $event"
                                    />
                                <br />
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
import axios from "axios";
import Swal from "sweetalert2";
import PaginationComponent from "../../components/PaginationComponent.vue";
export default {
    components: {
        PaginationComponent,
    },
    data() {
        return {
            title: "فئات الاصناف",
            loading: false,
            errors: {},
            item_card_categories: [],
            time: "",
            date: "",
            newDateTimeType: "",
        };
    },
    mounted() {
        this.getItemCardCategoriesData();
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods: {
        getItemCardCategoriesData() {
            this.loading = true;
            axios
                .get(
                    "/admin/item-card-categories/get-item-card-categories-data"
                )
                .then((response) => {
                    this.item_card_categories = response.data.itemCards.data;
                    this.time = response.data.time;
                    this.date = response.data.date;
                    this.newDateTimeType = response.data.newDateTimeType;
                })
                .catch((error) => {
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        deleteItemCard(id) {
            Swal.fire({
                title: "هل أنت متأكد من الحذف ؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(
                            "/admin/item-card-categories/" + id + "/destroy"
                        )
                        .then(() => {
                            this.getItemCardCategoriesData();
                            Swal.fire({
                                icon: "success",
                                title: "تم الحذف بنجاح",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        })
                        .catch((error) => {
                            if (error.response.status == 500) {
                                Swal.fire({
                                    icon: "error",
                                    title: error.response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            }
                        });
                }
            });
        },
    },
};
</script>
