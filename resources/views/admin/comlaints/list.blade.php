@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách đơn hàng khiếu nại</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Khiếu nại</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Đơn hàng khiếu nại</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects" id="list_complaints">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>Mã đơn hàng</th>
                                <th>Lý do khiếu nại</th>
                                <th>Tên khách hàng</th>
                                <th>Ngày khiếu nại</th>
                                {{-- <th>Trạng thái</th> --}}
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_complaints as $key => $complain)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $complain->order_id }}</td>
                                    <td>{{ $complain->complaint_type }}</td>
                                    <td>{{ $complain->user->name }}</td>
                                    <td>{{ $complain->created_at }}</td>
                                    <td>
                                        @can('view',App\Models\Complaints::class)
                                            <a href="{{ route('admin.comlaints.detailComplaints', ['id' => $complain->id]) }}"
                                            class="btn btn-info"> Xem chi tiết
                                        @endcan
                                            <a href="{{ route('admin.comlaints.deleteComplaint',['id'=>$complain->id]) }}" class="btn btn-danger ml-1" onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))"> Xóa
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')

    <script>
        let table = new DataTable('#list_complaints');
    </script>
    
@endpush
