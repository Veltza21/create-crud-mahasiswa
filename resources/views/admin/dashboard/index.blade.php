@extends('template.admin.index')
@section('content_admin')
    <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{asset('template_admin')}}/index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
        <div class="row">
            <div class="col-xxl-6 col-md-6">
                <div class="card info-card sales-card">                
                    <div class="card-body">
                    <h5 class="card-title">Data Mahasiswa <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-hdd-rack"></i>
                        </div>
                        <div class="ps-3">
                        <h6>{{$mahasiswa}}</h6>
                        </div>
                    </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-6 col-md-6">
                <div class="card info-card revenue-card">                
                    <div class="card-body">
                    <h5 class="card-title">Data User <span>| Today</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-life-preserver"></i>
                        </div>
                        <div class="ps-3">
                        <h6>{{$user}}</h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>          

            <div class="col-xxl-6 col-md-6">
                <div class="card info-card sales-card">                
                    <div class="card-body">
                    <h5 class="card-title">Data Admin <span>| Today</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-life-preserver"></i>
                        </div>
                        <div class="ps-3">
                        <h6>{{$admin}}</h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>   
            <div class="col-xxl-6 col-md-6">
                <div class="card info-card revenue-card">                
                    <div class="card-body">
                    <h5 class="card-title">Data Jurusan <span>| Today</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-broadcast"></i>
                        </div>
                        <div class="ps-3">
                        <h6>{{$jurusan}}</h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>          

            

            <!-- Reports -->

        </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
    </div>
    </section>
@endsection