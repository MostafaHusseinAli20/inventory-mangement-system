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
                                    <router-link :to="{ name: 'item-cards.index' }"
                                        >الاصناف</router-link
                                    >
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
            <!-- /.content-header -->

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">اضافة صنف جديد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form @submit.prevent="addItemCard" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        >باركود الصنف - في حالة عدم الادخال سيولد
                                        بشكل الي</label
                                    >
                                    <input
                                        v-model="form.itemsCard.barcode"
                                        autofocus
                                        class="form-control"
                                        placeholder="ادخل  باركود الصنف"
                                    />
                                    <span
                                        v-if="errors.barcode"
                                        class="text-danger"
                                        >{{ errors.barcode[0] }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم الصنف</label>
                                    <span id="nameCheckMessage"></span>
                                    <input
                                        v-model="form.itemsCard.name"
                                        class="form-control"
                                        placeholder="ادخل اسم الصنف"
                                        id="name"
                                    />
                                    <span
                                        v-if="errors.name"
                                        class="text-danger"
                                        >{{ errors.name[0] }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نوع الصنف</label>
                                    <select
                                        v-model="form.itemsCard.item_type"
                                        class="form-control px-5"
                                        id="item_type"
                                    >
                                        <option value="">اختر النوع</option>
                                        <option value="1">مخزني</option>
                                        <option value="2">
                                            استهلاكي بتاريخ صلاحية
                                        </option>
                                        <option value="3">عهدة</option>
                                    </select>
                                    <span
                                        v-if="errors.item_type"
                                        class="text-danger"
                                        >{{ errors.item_type[0] }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                            
                                <div class="form-group">
                                    <label>فئة الصنف</label>
                                    <select
                                        id="inv_item_card_category_id"
                                        v-model="
                                            form.itemsCard.inv_item_card_category_id
                                        "
                                        class="form-control px-5"
                                    >
                                        <option value>اختر الفئة</option>
                                        <option
                                            v-for="value in itemCardCategories"
                                            :key="value.id"
                                            :value="value.id"
                                        >
                                            {{ value.name }}
                                        </option>
                                    </select>
                                    <span
                                        v-if="errors.inv_item_card_category_id"
                                        class="text-danger"
                                        >{{
                                            errors.inv_item_card_category_id[0]
                                        }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الصنف الاب له</label>
                                    <select
                                        id="parent"
                                        v-model="form.itemsCard.parent_inv_item_card_id"
                                        class="form-control px-5"
                                    >
                                        <option selected disabled value="0">اختر الاب اذا له أب</option>
                                        <option
                                            v-for="value in inv_parent_data"
                                            :key="value.id"
                                            :value="value.id"
                                        >
                                            {{ value.name }}
                                        </option>
                                    </select>
                                    <span
                                        v-if="errors.parent_inv_item_card_id"
                                        class="text-danger"
                                        >{{
                                            errors.parent_inv_item_card_id[0]
                                        }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>وحدة القياس الاب</label>
                                    <select
                                        v-model="form.itemsCard.inv_uom_id"
                                        id="inv_uom_id"
                                        class="form-control px-5"
                                    >
                                        <option value>اختر الوحدة الاب</option>
                                        <span v-if="inv_uoms_parent != null">
                                            <option
                                                v-for="value in inv_uoms_parent"
                                                :key="value.id"
                                                :value="value.id"
                                            >
                                                {{ value.name }}
                                            </option>
                                        </span>
                                    </select>
                                    <span
                                        v-if="errors.inv_uom_id"
                                        class="text-danger"
                                        >{{ errors.inv_uom_id[0] }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>هل للصنف وحدة تجزئة ابن</label>
                                    <select
                                        v-model="form.itemsCard.does_has_retailunit"
                                        class="form-control px-5"
                                        id="does_has_retailunit"
                                    >
                                        <option value disabled selected>
                                            اختر الحالة
                                        </option>
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                    </select>
                                    <span
                                        v-if="errors.does_has_retailunit"
                                        class="text-danger"
                                        >{{ errors.does_has_retailunit[0] }}</span
                                    >
                                </div>
                            </div>

                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.does_has_retailunit == 1
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        وحدة القياس التجزئة الابن بالنسبة للأب ({{ selectedParentUom ? selectedParentUom.name : '---' }})
                                    </label>
                                    <select
                                        v-model="form.itemsCard.inv_retail_uom_id"
                                        class="form-control px-5"
                                        :disabled="form.itemsCard.does_has_retailunit != 1 || !form.itemsCard.inv_uom_id"
                                        id="inv_retail_uom_id"
                                    >
                                        <option value="" disabled>اختر الوحدة الابن</option>

                                        <option
                                        v-for="value in inv_uoms_child"
                                        :key="value.id"
                                        :value="value.id"
                                        >
                                        {{ value.name }}
                                        </option>
                                    </select>

                                    <span
                                        v-if="errors.inv_retail_uom_id"
                                        class="text-danger"
                                        >{{ errors.inv_retail_uom_id[0] }}</span
                                    >
                                </div>
                            </div>

                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_retail_uom_id != null && form.itemsCard.inv_retail_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        عدد وحدات التجزئة ({{ selectedChildUom ? selectedChildUom.name : '---' }}) بالنسبة للأب ({{ selectedParentUom ? selectedParentUom.name : '---'  }})
                                    </label>
                                    <!-- oniput:"this.value=this.value.replace(/[^0-9.]/g,'');" -->
                                    <input
                                        v-model.number="form.itemsCard.retail_uom_quntToParent"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل  عدد وحدات التجزئة"
                                        id="retail_uom_quntToParent"
                                    />
                                    <span
                                        v-if="errors.retail_uom_quntToParent"
                                        class="text-danger"
                                        >{{
                                            errors.retail_uom_quntToParent[0]
                                        }}</span
                                    >
                                </div>
                            </div>
                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_uom_id != null && form.itemsCard.inv_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        السعر القطاعي بوحدة الأب ({{ selectedParentUom ? selectedParentUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.price_uom"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر القطاعي بوحدة الأب"
                                        id="price_uom"
                                    />
                                    <span
                                        v-if="errors.price_uom"
                                        class="text-danger"
                                        >{{
                                            errors.price_uom[0]
                                        }}</span
                                    >
                                </div>
                            </div>


                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_uom_id != null && form.itemsCard.inv_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        سعر النص جملة بوحدة الأب ({{ selectedParentUom ? selectedParentUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.half_gomla_price_uom"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر النص جملة بوحدة الأب"
                                        id="half_gomla_price_uom"
                                    />
                                    <span
                                        v-if="errors.half_gomla_price_uom"
                                        class="text-danger"
                                        >{{
                                            errors.half_gomla_price_uom[0]
                                        }}</span
                                    >
                                </div>
                            </div>


                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_uom_id != null && form.itemsCard.inv_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        سعر الجملة بوحدة الأب ({{ selectedParentUom ? selectedParentUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.gomla_price_uom"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر الجملة بوحدة الأب"
                                        id="gomla_price_uom"
                                    />
                                    <span
                                        v-if="errors.gomla_price_uom"
                                        class="text-danger"
                                        >{{
                                            errors.gomla_price_uom[0]
                                        }}</span
                                    >
                                </div>
                            </div>


                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_retail_uom_id != null && form.itemsCard.inv_retail_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        السعر القطاعي بوحدة التجزئة ({{ selectedChildUom ? selectedChildUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.price_retail"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر القطاعي بوحدة التجزئة"
                                        id="price_retail"
                                    />
                                    <span
                                        v-if="errors.price_retail"
                                        class="text-danger"
                                        >{{
                                            errors.price_retail[0]
                                        }}</span
                                    >
                                </div>
                            </div>

                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_retail_uom_id != null && form.itemsCard.inv_retail_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        السعر النص جملة بوحدة التجزئة ({{ selectedChildUom ? selectedChildUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.half_gomla_price_retail"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر النص جملة بوحدة التجزئة"
                                        id="half_gomla_price_retail"
                                    />
                                    <span
                                        v-if="errors.half_gomla_price_retail"
                                        class="text-danger"
                                        >{{
                                            errors.half_gomla_price_retail[0]
                                        }}</span
                                    >
                                </div>
                            </div>

                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_retail_uom_id != null && form.itemsCard.inv_retail_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        السعر الجملة بوحدة التجزئة ({{ selectedChildUom ? selectedChildUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.gomla_price_retail"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر الجملة بوحدة التجزئة"
                                        id="gomla_price_retail"
                                    />
                                    <span
                                        v-if="errors.gomla_price_retail"
                                        class="text-danger"
                                        >{{
                                            errors.gomla_price_retail[0]
                                        }}</span
                                    >
                                </div>
                            </div>


                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_uom_id != null && form.itemsCard.inv_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        سعر تكلفة الشراء لوحدة الأب ({{ selectedParentUom ? selectedParentUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.cost_price"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر الشراء لوحدة الأب"
                                        id="cost_price"
                                    />
                                    <span
                                        v-if="errors.cost_price"
                                        class="text-danger"
                                        >{{
                                            errors.cost_price[0]
                                        }}</span
                                    >
                                </div>
                            </div>

                            <div
                                class="col-md-6"
                                :style="{
                                    display:
                                        form.itemsCard.inv_retail_uom_id != null && form.itemsCard.inv_retail_uom_id != ''
                                            ? 'block'
                                            : 'none',
                                }"
                            >
                                <div class="form-group">
                                    <label>
                                        سعر تكلفة الشراء لوحدة التجزئة ({{ selectedChildUom ? selectedChildUom.name : '---'  }})
                                    </label>

                                    <input
                                        v-model.number="form.itemsCard.cost_price_retail"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="ادخل سعر الشراء لوحدة التجزئة"
                                        id="cost_price_retail"
                                    />
                                    <span
                                        v-if="errors.cost_price_retail"
                                        class="text-danger"
                                        >{{
                                            errors.cost_price_retail[0]
                                        }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    <select
                                        v-model="form.itemsCard.active"
                                        class="form-control px-5"
                                        id="active"
                                    >
                                        <option value disabled selected>
                                            اختر الحالة
                                        </option>
                                        <option value="1">مفعل</option>
                                        <option value="0">غير مفعل</option>
                                    </select>
                                    <span
                                        v-if="errors.active"
                                        class="text-danger"
                                        >{{ errors.active[0] }}</span
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>هل للمنتج سعر ثابت</label>
                                    <select
                                        v-model="form.itemsCard.has_fixed_price"
                                        class="form-control px-5"
                                        id="has_fixed_price"
                                    >
                                        <option value disabled selected>
                                            اختر الحالة
                                        </option>
                                        <option value="1">نعم ثابت ولايتغير بالفواتير</option>
                                        <option value="0">لا وقابل للتغير بالفواتير</option>
                                    </select>
                                    <span
                                        v-if="errors.has_fixed_price"
                                        class="text-danger"
                                        >{{ errors.has_fixed_price[0] }}</span
                                    >
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                            <div class="avatar-upload text-center">

                                <!-- Upload button -->
                                <div class="avatar-edit">
                                <input
                                    type="file"
                                    id="imageUpload"
                                    accept=".png, .jpg, .jpeg"
                                    @change="handleFileUpload"
                                />
                                <label for="imageUpload">
                                    <i class="fas fa-pen"></i>
                                </label>
                                </div>

                                <!-- Image Preview -->
                                <div class="avatar-preview mt-2">
                                <div
                                    class="avatar-image"
                                    :style="{ backgroundImage: `url(${imagePreview})` }"
                                ></div>
                                </div>

                                <!-- Remove image -->
                                <button
                                v-if="imageFile"
                                type="button"
                                class="btn btn-sm btn-outline-danger mt-2"
                                @click="removeImage"
                                >
                                إزالة الصورة
                                </button>

                            </div>

                            <p class="form-label text-center mt-2">
                                صورة للصنف إذا وُجد
                            </p>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mr-2" :disabled="loading">
                                    <span v-if="loading">جاري الحفظ...</span>
                                    <span v-else>اضافة</span>
                                </button>
                                <router-link
                                    :to="{ name: 'item-cards.index' }"
                                    class="btn btn-danger"
                                    >الغاء</router-link
                                >
                            </div>
                        </div>
                    </form>
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
            title: "اضافة صنف",
            loading: false,
            form:{
                itemsCard: {
                    barcode: "",
                    name: "",
                    item_type: "",
                    inv_item_card_category_id: "",
                    parent_inv_item_card_id: "",
                    inv_uom_id: "",
                    does_has_retailunit: "",
                    inv_retail_uom_id: "",
                    retail_uom_quntToParent: "",
                    price_uom: "",
                    half_gomla_price_uom: "",
                    gomla_price_uom: "",
                    price_retail: "",
                    half_gomla_price_retail: "",
                    gomla_price_retail: "",
                    cost_price: "",
                    cost_price_retail: "",
                    active: "",
                    has_fixed_price: '',
                }
            },
            imageFile: null,
            imagePreview: '/assets/img/default-item.png', // صورة افتراضية
            errors: {},
            itemCardCategories: [],
            inv_uoms_parent: [],
            inv_uoms_child: [],
            inv_parent_data: [],
        };
    },

    computed: {
      selectedParentUom() {
        return this.inv_uoms_parent?.find(
          uom => uom.id == this.form.itemsCard.inv_uom_id
        );
      },

      selectedChildUom() {
        return this.inv_uoms_child?.find(
          uom => uom.id == this.form.itemsCard.inv_retail_uom_id
        );
      },
    },

    watch: {
      'form.itemsCard.inv_uom_id'(val) {
          // رجّع الابن لما الأب يتغير
          this.form.itemsCard.inv_retail_uom_id = null;
          this.inv_uoms_child = [];

          if (val) {
              this.fetchChildUoms(val);
          }
      },

      'form.itemsCard.does_has_retailunit'(val) {
        if (val == 1 && !this.form.itemsCard.inv_uom_id) 
        {
          // رجّع كل القيم المتعلقة بالابن

          this.form.itemsCard.inv_retail_uom_id = null;
          this.inv_uoms_child = [];

          Swal.fire({
            icon: "error",
            title: "خطأ",
            text: "يجب اختيار وحدة القياس الاب",
          })
          this.form.itemsCard.does_has_retailunit = '';
        } else if (val == 0 || val == '0') {
          // حذف جميع الحقول المتعلقة بالتجزئة عند اختيار "لا"
          this.form.itemsCard.inv_retail_uom_id = "";
          this.form.itemsCard.retail_uom_quntToParent = "";
          this.form.itemsCard.price_retail = "";
          this.form.itemsCard.half_gomla_price_retail = "";
          this.form.itemsCard.gomla_price_retail = "";
          this.form.itemsCard.cost_price_retail = "";
        }
      }
  },


    mounted() {
        this.getCategoriesData();
        var title = document.getElementById("title");
        title.innerHTML = this.title;
        // search in select
        // this.$nextTick(() => {
        //     $("#inv_item_card_category_id").select2({
        //         placeholder: "ابحث عن تصنيف",
        //         allowClear: false,
        //     });

        //     $("#parent").select2({
        //         placeholder: "ابحث عن وحدة اب",
        //         allowClear: false,
        //     });
        // });
    },
    methods: {
      async fetchChildUoms(parentId) {
          try {
              const response = await axios.get(`/admin/item-cards/get-child-uoms/${parentId}`);
              this.inv_uoms_child = response.data; // array
          } catch (error) {
              console.log(error);
          }
      },
        async getCategoriesData() {
            await axios
                .get("/admin/item-cards/get-categories-data")
                .then((response) => {
                    this.itemCardCategories = response.data.categories;
                    this.inv_uoms_parent = response.data.inv_uoms_parent;
                    this.inv_uoms_child = response.data.inv_uoms_child;
                    this.inv_parent_data = response.data.inv_parent_data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
        },
        async addItemCard() {
            try {
                // Client-side validation for ID inputs
                if (!this.form.itemsCard.name || this.form.itemsCard.name.trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب إدخال اسم الصنف',
                    });
                    return;
                }

                if (!this.form.itemsCard.item_type || this.form.itemsCard.item_type === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب اختيار نوع الصنف',
                    });
                    return;
                }

                if (!this.form.itemsCard.inv_item_card_category_id || this.form.itemsCard.inv_item_card_category_id === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب اختيار فئة الصنف',
                    });
                    return;
                }

                if (!this.form.itemsCard.inv_uom_id || this.form.itemsCard.inv_uom_id === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب اختيار وحدة القياس الأب',
                    });
                    return;
                }

                if (this.form.itemsCard.does_has_retailunit === '' || this.form.itemsCard.does_has_retailunit === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب تحديد هل للصنف وحدة تجزئة ابن',
                    });
                    return;
                }

                if (this.form.itemsCard.does_has_retailunit == 1) {
                    if (!this.form.itemsCard.inv_retail_uom_id || this.form.itemsCard.inv_retail_uom_id === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'يجب اختيار وحدة القياس التجزئة الابن',
                        });
                        return;
                    }

                    

                    if (!this.form.itemsCard.price_retail || this.form.itemsCard.price_retail < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب إدخال السعر القطاعي بشكل صحيح للتجزئة',
                    });
                    return;
                }

                    if (!this.form.itemsCard.half_gomla_price_retail || this.form.itemsCard.half_gomla_price_retail < 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'يجب إدخال سعر النص جملة بشكل صحيح للتجزئة',
                        });
                        return;
                    }

                    if (!this.form.itemsCard.gomla_price_retail || this.form.itemsCard.gomla_price_retail < 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'يجب إدخال سعر الجملة بشكل صحيح للتجزئة',
                        });
                        return;
                    }

                    if (!this.form.itemsCard.cost_price_retail || this.form.itemsCard.cost_price_retail < 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'يجب إدخال التكلفة بشكل صحيح للتجزئة',
                        });
                        return;
                    }

                }

                if (!this.form.itemsCard.price_uom || this.form.itemsCard.price_uom < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب إدخال السعر القطاعي بشكل صحيح للأب',
                    });
                    return;
                }

                if (!this.form.itemsCard.half_gomla_price_uom || this.form.itemsCard.half_gomla_price_uom < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب إدخال سعر النص جملة بشكل صحيح للأب',
                    });
                    return;
                }

                if (!this.form.itemsCard.gomla_price_uom || this.form.itemsCard.gomla_price_uom < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب إدخال سعر الجملة بشكل صحيح للأب',
                    });
                    return;
                }

                if (!this.form.itemsCard.cost_price || this.form.itemsCard.cost_price < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب إدخال التكلفة بشكل صحيح للأب',
                    });
                    return;
                }

                if (this.form.itemsCard.active === '' || this.form.itemsCard.active === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب تحديد حالة التفعيل',
                    });
                    return;
                }

                if (this.form.itemsCard.has_fixed_price === '' || this.form.itemsCard.has_fixed_price === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يجب تحديد ما إذا كان للمنتج سعر ثابت',
                    });
                    return;
                }

                const formData = new FormData();

                // Add all form fields
                Object.keys(this.form.itemsCard).forEach(key => {
                    formData.append(key, this.form.itemsCard[key]);
                });

                // Add image file if exists
                if (this.imageFile) {
                    formData.append('image', this.imageFile);
                }

                this.loading = true;

                const response = await axios.post('/admin/item-cards/store', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'نجح',
                    text: 'تم إضافة الصنف بنجاح',
                }).then(() => {
                    this.$router.push({ name: 'item-cards.index' });
                });
            } catch (error) {
                if (error.response && error.response.status == 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: error.response.data.message,
                    });
                    this.errors = error.response.data.errors;
                } else if (error.response && error.response.status == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: error.response.data.message,
                    });
                } else {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'حدث خطأ غير متوقع، حاول مرة اخرى',
                    });
                }
            } finally {
                this.loading = false;
            }
        },
        handleFileUpload(event) {
              const file = event.target.files[0];

              if (!file) return;

              // تحقق من النوع
              if (!file.type.startsWith('image/')) {
                alert('من فضلك اختر صورة صحيحة');
                return;
              }

              this.imageFile = file;

              // preview
              this.imagePreview = URL.createObjectURL(file);
        },
        removeImage() {
          this.imageFile = null;
          this.imagePreview = '/assets/img/default-item.png';
        }
    },
};

</script>

<style>
.select2-container {
    width: 100% !important;
}

.select2-selection--single {
    height: 38px !important;
}

.select2-selection__rendered {
    line-height: 38px !important;
}

.avatar-preview {
  width: 200px;
  height: 200px;
  margin: auto;
}

.avatar-image {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
