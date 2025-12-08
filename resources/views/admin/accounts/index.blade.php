<x-app-layout>

    <div class="container-fluid">
        <section class="content mt-5">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3></h3>

                            <p> الحسابات </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ url('/accounts/show') }}" class="small-box-footer">عرض <i
                                class="fas fa-arrow-circle-right"></i></a>
                        {{--              <a href="{{ url('/accounts/add') }}" class="small-box-footer">اضافة <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3></h3>
                            <p> الفئات</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ url('/categories/show') }}" class="small-box-footer">عرض <i
                                class="fas fa-arrow-circle-right"></i></a>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3></h3>

                            <p> العناصر </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ url('/items/show') }}" class="small-box-footer">عرض <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3></h3>
                            <p> أذون الإضاقة </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ url('/add_to_stores/dashboard') }}" class="small-box-footer">عرض <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3></h3>

                            <p> أذون الصرف </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-exit"></i>
                        </div>
                        <a href="{{ url('/dismissal_notice/dashboard') }}" class="small-box-footer">عرض <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3></h3>
                            <p> أذون التحويل </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-arrow-swap"></i>
                        </div>
                        <a href="{{ url('/transfer/show') }}" class="small-box-footer">عرض <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</x-app-layout>