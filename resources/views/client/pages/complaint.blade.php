@extends('client.components.default')

@section('content')
<main class="main container border rounded shadow mt-4 mb-4 p-4">
    <h1 class="text-center mb-4">Hỗ trợ khiếu nại</h1>
    <p class="text-center mb-4">Nếu bạn gặp vấn đề với đơn hàng, hãy điền thông tin dưới đây để chúng tôi hỗ trợ bạn sớm nhất.</p>
    <form class="complaint-form">
        <div class="form-group ">
            <label for="order-id">Mã đơn hàng:</label>
            <input type="text" id="order-id" class="form-control" placeholder="Nhập mã đơn hàng" required>
        </div>

        
        <div class="form-group">
            <label for="order-date">Ngày đặt hàng:</label>
            <input type="date" id="order-date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="reason">Lý do khiếu nại:</label>
            <select id="reason" class="form-control" required>
                <option value="" disabled selected>Chọn lý do</option>
                <option value="wrong-product">Sai sản phẩm</option>
                <option value="damaged">Sản phẩm hư hỏng</option>
                <option value="delayed">Giao hàng chậm</option>
                <option value="other">Khác</option>
            </select>
        </div>

        <div class="form-group">
            <label for="details">Mô tả chi tiết:</label>
            <textarea id="details" class="form-control" rows="5" placeholder="Nhập chi tiết vấn đề" required></textarea>
        </div>

        <div class="form-group">
            <label for="file">Đính kèm hình ảnh:</label>
            <input type="file" id="file" class="form-control">
        </div>

        <div class="form-actions text-end mt-4">
            <button type="submit" class="btn btn-secondary ">Hủy</button>
            <button type="submit" class="btn btn-primary">Gửi khiếu nại</button>
        </div>
    </form>
    <div class="complaint__footer text-center mt-4 border-top pt-4">
        <p>Email: support@cuahang.com | Hotline: 1900 1234</p>
    <p>Chính sách hỗ trợ: Chúng tôi sẽ phản hồi khiếu nại sớm nhất có thể.</p>
    </div>
</main>
@endsection


