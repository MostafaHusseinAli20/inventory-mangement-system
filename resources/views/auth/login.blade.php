<x-guest-layout>
    <style>
        body {
            overflow: hidden !important;
        }

        .container {
            overflow: hidden !important;
        }
    </style>
    <div class="" style="overflow: hidden;    background: #efefef;">
        <div class="container">
            <div class="row my-4"
                style="overflow: hidden;height: 95vh; overflow: hidden;    border: 1px solid #fff;
                    border-radius: 20px; box-shadow: 0 4px 6px rgba(50,50,93,.1), 0 1px 3px rgba(0,0,0,.08); background: #fff">

                <div class="col-6" style="padding: 10px 0px;">
                    <!-- /.login-logo -->
                    <div class="justify-content-center d-flex flex-column" style="margin: auto 0px;">
                        <div class="card-body align-items-left" style="text-align: left;top: 30%;position: absolute;">
                            <h4 class="" style="text-align: right;margin: 10px;">تسجيل الدخول </h4>
                            <p class="" style="text-align: right;margin: 10px;"> برنامج الحسابات الخاص بالاداره
                                الماليه ،المخازن </p>

                            <form action="{{ route('login') }}" method="POST" class="mt-4">
                                @csrf
                                <div class="row mb-3" style="gap: 31px;">
                                    @if (Session::has('auth_error'))
                                        <div class="alert alert-danger col-12" style="text-align: justify;">
                                            {{ Session::get('auth_error') }}
                                        </div>
                                    @endif
                                    <div class="input-group col-12"
                                        style="text-align-last: right;justify-content: end;">
                                        <div class=" w-100 d-flex">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email" autocomplete="off"
                                                style="border-radius: 0.5rem;
                                                        font-size: .875rem;
                                                        padding: 1.5rem 3rem;
                                            ">
                                        </div>
                                    </div>
                                    <div class="input-group col-12"
                                        style="text-align-last: right;justify-content: end;">
                                        <div class="w-100 d-flex">
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Password"
                                                style="border-radius: 0.5rem;
                                                font-size: .875rem;
                                                padding: 1.5rem 3rem;
                                            ">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-12" style="text-align: center ;    text-align: -webkit-center;">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat"
                                            style="box-shadow: 0 4px 6px rgba(50,50,93,.1), 0 1px 3px rgba(0,0,0,.08);
                                            letter-spacing: -.025rem;
                                            border-radius: 0.5rem;
                                            font-size: .875rem;
                                            padding: 0.875rem 4rem;">دخول</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                            
                        </div>
                        <!-- /.login-card-body -->

                    </div>
                </div>

                <div class="col-6"
                    style="
                        overflow: hidden;
                        padding: inherit;">
                    <div class="position-relative h-100 border-radius-lg d-flex flex-column overflow-hidden"
                        style="background-image: url('')!important;
                        background-size: cover!important;background-repeat:no-repeat;overflow: hidden">
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
