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
                <li class="breadcrumb-item active">عرض تفاصيل الصنف</li>
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
            <h3 class="card-title card_title_center">  عرض بيانات صنف</h3>
        </div>
        <div class="card-body">
            <div v-if="itemCardDetails != null">
                <div class="row">
                    <table id="example2" class="table table-bordered table-hover">
                        <tr>
                            <td colspan="3">
                                <label>كود الصنف الثابت الالي من النظام</label> <br>
                                {{ itemCardDetails.item_code }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>باركود الصنف</label> <br>
                                {{ itemCardDetails.barcode }}
                            </td>

                            <td>
                            <label>اسم الصنف</label> <br>
                                {{ itemCardDetails.name }}
                            </td>

                            <td>
                            <label>نوع الصنف</label> <br>
                                <span v-if="itemCardDetails.item_type == 1">مخزني</span> 
                                <span v-else-if="itemCardDetails.item_type == 2">استهلاكي بصلاحية</span> 
                                <span v-else-if="itemCardDetails.item_type == 3">عهدة</span>
                                <span v-else>غير محدد</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>فئة الصنف</label> <br>
                                    <span :class="itemCardDetails.category_name ? 'font-weight-bold text-success' : 'text-danger'">
                                        {{ itemCardDetails.category_name || 'لايوجد' }}
                                    </span>
                                </td>

                                <td>
                                    <label> الصنف الاب</label> <br>
                                    <span :class="itemCardDetails.parent_inv_name ? 'font-weight-bold text-success' : 'text-danger'">
                                        {{ itemCardDetails.parent_inv_name || 'لايوجد' }}
                                    </span>
                                </td>

                                <td>
                                    <label>وحدة القياس الاب </label> <br>
                                    <span :class="itemCardDetails.uom_name ? 'font-weight-bold text-success' : 'text-danger'">
                                        {{ itemCardDetails.uom_name || 'لايوجد'}}
                                    </span>
                                </td>
                        </tr>

                        <tr>
                            <td v-if="itemCardDetails.does_has_retailunit == 0">
                                <label for="هل للصنف وحدة تجزئة ابن">هل للصنف وحدة تجزئة ابن</label> <br>
                                <span v-if="itemCardDetails.does_has_retailunit == 1">نعم</span>
                                <span v-else>لا</span>
                            </td>
                            <td>
                                <label>وحدة القياس التجزئة</label><br>
                                {{ itemCardDetails.retail_uom_name }}
                            </td>

                            <td>
                                <label>
                                    عدد وحدات  التجزئة <span class="text-success">{{ itemCardDetails.retail_uom_name  }}</span> بالنسبة 
                                    <span class="text-success">{{ itemCardDetails.uom_name  }}</span>
                                </label><br>
                                {{ itemCardDetails.retail_uom_quntToParent * 1 }}
                            </td>
                        </tr>

                        <tr>
                            <td v-if="itemCardDetails.does_has_retailunit == 0" >
                                <label for="هل للصنف وحدة تجزئة ابن">هل للصنف وحدة تجزئة ابن</label> <br>
                                <span v-if="itemCardDetails.does_has_retailunit == 1">نعم</span>
                                <span v-else>لا</span>
                            </td>
                            <td>
                                <label>وحدة القياس التجزئة</label><br>
                                {{ itemCardDetails.retail_uom_name }}
                            </td>

                            <td>
                                 <label>
                                    عدد وحدات  التجزئة <span class="text-success">{{ itemCardDetails.retail_uom_name  }}</span> بالنسبة 
                                    <span class="text-success">{{ itemCardDetails.uom_name  }}</span>
                                </label><br>
                                {{ itemCardDetails.retail_uom_quntToParent * 1 }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label> سعر القطاعي جملة بوحدة ({{ itemCardDetails.uom_name  }})</label> <br>
                                    {{ itemCardDetails.price_uom * 1 }}
                                </td>
                                <td>
                                <label> سعر النص جملة بوحدة ({{ itemCardDetails.uom_name  }})</label> <br>
                                    {{ itemCardDetails.half_gomla_price_uom *1 }}
                                </td>
                                <td>
                                <label> سعر  جملة بوحدة ({{ itemCardDetails.uom_name  }})</label> <br>
                                    {{ itemCardDetails.gomla_price_uom *1 }}
                            </td>
                        </tr>

                        <tr>
                            <td v-if="itemCardDetails.does_has_retailunit==0" colspan="3">
                            <label> سعر تكلفة الشراء  بوحدة (  {{ itemCardDetails.uom_name  }})</label> <br>
                            {{ itemCardDetails.cost_price * 1 }}
                            </td>
                            <span v-if="itemCardDetails.does_has_retailunit==1">
                                <td>
                                    <label> سعر القطاعي  بوحدة (  {{ itemCardDetails.retail_uom_name  }})</label> <br>
                                    {{ itemCardDetails.price_retail  * 1 }}
                                </td>
                                <td>
                                    <label> سعر  النص جملة بوحدة (  {{ itemCardDetails.retail_uom_name  }})</label> <br>
                                    {{ itemCardDetails.half_gomla_price_retail  * 1 }}
                                </td>
                                <td>
                                    <label> سعر  الجملة بوحدة (  {{ itemCardDetails.retail_uom_name  }})</label> <br>
                                    {{ itemCardDetails.gomla_price_retail  * 1 }}
                                </td>
                            </span>
                        </tr>

                        <tr v-if="itemCardDetails.does_has_retailunit==1">
                            <td colspan="1">
                                <label> سعر تكلفة الشراء  بوحدة (  {{ itemCardDetails.retail_uom_name  }})</label> <br>
                            {{ itemCardDetails.cost_price_retail * 1 }} 
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                 كمية الصنف الحالية (  {{ itemCardDetails.All_QUENTITY * 1  }} {{ itemCardDetails.uom_name  }})
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label> هل للصنف سعر ثابت</label> <br>
                                <span class="badge-success p-1 rounded" v-if="itemCardDetails.has_fixed_price == 1">نعم</span>
                                <span class="badge-danger p-1 rounded" v-else>لا</span>
                            </td>

                            <td>
                                <label> حالة التفعيل</label> <br>
                                <span class="badge-success p-1 rounded" v-if="itemCardDetails.active == 1">نعم</span>
                                <span class="badge-danger p-1 rounded" v-else>لا</span>
                            </td>
                        </tr>

                        <tr>
                            <td >لوجو  الصنف</td>
                            <td>
                                <div class="image">
                                    <img width="75" :src="itemCardDetails.image"  alt="لوجو الشركة">       
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>  تاريخ اخر تحديث</td>
                            <td colspan="2">
                                <span v-if="itemCardDetails.updated_by != null">
                                    {{itemCardDetails.date}}
                                    {{ itemCardDetails.time }}
                                    {{ itemCardDetails.newDateTimeType  }}
                                    بواسطة
                                    {{ itemCardDetails.updated_by_admin }}
                                </span>
                                <span v-else>
                                    لايوجد تحديث
                                </span>
                                <router-link :to="{name:'item-cards.edit',params:{id:itemCardDetails.id}}" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i>
                                    تعديل
                                </router-link>
                            </td>
                        </tr>
                    </table>
                </div>
                <hr style="border:1px solid #3c8dbc;">
                <h3 class="customh3"> سجل الحركة علي الصنف  (  كارت الصنف )</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>  بحث بالمخازن </label>
                            <select name="store_id_move_search" id="store_id_move_search" class="form-control select2 px-5">
                                <option value="all">بحث بالكل </option>
                                <option v-if="stores != null" v-for="store in stores" :value="store.id">
                                    {{ store.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>  بحث بقسم الحركة </label>
                            <select name="movements_categoriesMoveSearch" id="movements_categoriesMoveSearch" class="form-control select2 px-5">
                                <option value="all">بحث بالكل </option>
                                <option v-if="movements_categories != null" v-for="movements_category in movements_categories" 
                                :value="movements_category.id">
                                    {{ movements_category.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                     <div class="col-md-4">
                        <div class="form-group">
                            <label>  بحث بنوع الحركة </label>
                            <select name="movements_typesMoveSearch" id="movements_typesMoveSearch" class="form-control select2 px-5">
                                <option value="all">بحث بالكل </option>
                                <option v-if="movements_types != null" v-for="movements_type in movements_types" 
                                :value="movements_type.id">
                                    {{ movements_type.name }}
                                </option>
                            </select>
                        </div>
                     </div>

                     <div class="col-md-4">
                         <div class="form-group">
                            <label>بحث من تاريخ حركة</label>
                            <input name="from_date_moveSearch" id="from_date_moveSearch" class="form-control" type="date" value="">
                         </div>
                     </div>

                     <div class="col-md-4">
                         <div class="form-group">
                            <label>بحث من تاريخ حركة</label>
                            <input name="from_date_moveSearch" id="from_date_moveSearch" class="form-control" type="date" value="">
                         </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group">
                            <label>  بحث  بالترتيب </label>
                            <select name="moveDateorderType" id="moveDateorderType" class="form-control select2 px-5">
                            <option value="DESC">بحث ترتيب تنازلي </option>
                            <option value="ASC">بحث ترتيب تصاعدي </option>
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-12 text-center" id="ajaxSearchMovementsDiv">
                        <button class="btn btn-sm btn-danger" id="ShowMovementsBtn">عرض سجل الحركة </button>
                    </div>

                </div>

            </div>
            
            <div v-else class="alert alert-danger">
                عفوا لاتوجد بيانات لعرضها !!
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
      loading: false,
      itemCardDetails: [],
      stores: [],
      movements_categories: [],
      movements_types: []
    };
  },
    mounted() {
        this.getData();
    },
  methods: {
    getData(){
        axios
        .get("/admin/item-cards/" + this.$route.params.id + "/show-data")
        .then((response) => {
            this.itemCardDetails = response.data.data;
            console.log(response.data.data);
        })
        .catch((error) => {
            console.log(error.response.data);
        });
    }
  },
};
</script>
