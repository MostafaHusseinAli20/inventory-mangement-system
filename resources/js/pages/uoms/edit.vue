<template>
    <div>
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
                <li class="breadcrumb-item active">تعديل</li>
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
            <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form @submit.prevent="updateInvUom" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label>نوع الوحدة</label>
                <input
                  v-model="uoms.name"
                  id="name"
                  class="form-control"
                  value
                  placeholder="ادخل اسم نوع الوحدة"
                />
                <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
              </div>

              <div class="form-group">
                <label>هل رئيسية ؟</label>
                <select v-model="uoms.is_master" id="is_master" class="form-control px-5">
                  <option value disabled selected>اختر النوع</option>

                  <option value="1">وحدة أب</option>
                  <option value="0">وحدة تجزئة</option>
                </select>
                <spanv v-if="errors.is_master" class="text-danger">{{ errors.is_master[0] }}</spanv>
              </div>

              <div class="form-group">
                <label>حالة التفعيل</label>
                <select v-model="uoms.active" class="form-control px-5">
                  <option value disabled selected>اختر الحالة</option>
                  <option value="1">نعم</option>
                  <option value="0">لا</option>
                </select>
                <span v-if="errors.active" class="text-danger">{{ errors.active[0] }}</span>
              </div>
              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary mr-2">اضافة</button>
                <router-link :to="{ name: 'uoms.index' }" class="btn btn-danger">الغاء</router-link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';
export default {
    data(){
        return {
            title:'تعديل وحدة',
            errors:{},
            uoms:{}
        }
    },
    mounted(){
        axios.get('/admin/uoms/' + this.$route.params.id + '/show').then((response) => {
            this.uoms = response.data.data;
        }).catch((error) => {
            console.log(error.response.data);
        });
        var title = document.getElementById("title");
        title.innerHTML = this.title;
    },
    methods:{
        updateInvUom(){
            axios.put('/admin/uoms/' + this.$route.params.id + '/update', this.uoms)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$router.push({ name: 'uoms.index' });
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                if (error.response.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    }
}
</script>