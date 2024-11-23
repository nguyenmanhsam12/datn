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
                                <th>Trạng thái</th>
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
                                        <select class="form-control status_complaints"
                                            data-complaints-id = "{{ $complain->id }}">
                                            <option value="Chờ xử lý"
                                                {{ $complain->status == 'Chờ xử lý' ? 'selected' : '' }}
                                                {{ $complain->status != 'Chờ xử lý' ? 'disabled' : '' }}
                                        
                                                >Chờ xử lý</option>
                                            <option value="Giải quyết thành công"
                                                {{ $complain->status == 'Giải quyết thành công' ? 'selected' : '' }}>Giải
                                                quyết thành công</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.comlaints.detailComplaints', ['id' => $complain->id]) }}"
                                            class="btn btn-info"> Xem chi tiết
                                            <a href="" class="btn btn-danger ml-1"> Xóa
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

    {{-- cập nhật trạng thái khiếu nại --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusDropdowns = document.querySelectorAll('.status_complaints');

            statusDropdowns.forEach(function(dropdown) {

                let previousSelectedStatus = dropdown.value; // Lưu lại trạng thái đã chọn trước đó

                dropdown.addEventListener('change', function() {
                    const complantId = this.getAttribute('data-complaints-id');
                    const newStatus = this.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    fetch('{{ route('admin.comlaints.updateStatus') }}', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                status: newStatus,
                                complantId: complantId,
                            })
                        })
                        .then(response => response.json()) // Giải mã JSON từ response
                        .then(data => {
                            if (data) {
                                if (data.message) {
                                    alert(data.message); // Hiển thị thông báo thành công

                                    // Disable các option đã chọn trước đó (trạng thái cũ)
                                    dropdown.querySelectorAll('option').forEach(option => {
                                        // Disable các option có giá trị nhỏ hơn trạng thái mới (Giải quyết thành công < Chờ xử lý)
                                        if (option.value === previousSelectedStatus) {
                                            option.disabled = true; // Disable trạng thái cũ
                                            
                                        }
                                    });

                                }
                                if (data.error) {
                                    alert(data.error); // Thông báo lỗi
                                    dropdown.value =
                                    previousSelectedStatus; // Quay về trạng thái đã chọn ban đầu
                                }

                            } else {
                                alert('Cập nhật thất bại: ' + result.message); // Thông báo lỗi
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert(
                            'Đã xảy ra lỗi. Vui lòng thử lại sau.'); // Thông báo khi có lỗi
                        });
                });
            });
        });
    </script>
@endpush
