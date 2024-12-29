<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    {{-- <link rel="stylesheet" href="{{asset('backend/plugins/jqvmap/jqvmap.min.css')}}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('backend/plugins/summernote/summernote-bs4.min.css')}}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- thư viện datatables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    @vite(['resources/js/bootstrap.js'])    

    {{-- css thông báo --}}
    <style>
        .notification-unread {
            background-color: #f8f9fa; /* Màu nền sáng hơn */
            font-weight: bold;
            border-left: 4px solid #dc3545; /* Viền đỏ để làm nổi bật */
        }
        .notification-unread:hover {
            background-color: #e9ecef; /* Thay đổi màu nền khi hover */
        }


    </style>

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        @include('admin.layout.navbar')
        
       

        <!-- Main Sidebar Container -->
        @include('admin.layout.slidebar')
        

        <!-- Content Wrapper. Contains page content -->
        @yield('content')

        


        <!-- /.content-wrapper -->
        @include('admin.layout.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('backend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('backend/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    {{-- <script src="{{asset('backend/plugins/sparklines/sparkline.js')}}"></script> --}}
    <!-- JQVMap -->
    {{-- <script src="{{asset('backend/plugins/jqvmap/jquery.vmap.min.js')}}"></script> --}}
    {{-- <script src="{{asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> --}}
    <!-- jQuery Knob Chart -->
    <script src="{{asset('backend/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('backend/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('backend/dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{asset('backend/dist/js/demo.js')}}"></script> --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('backend/dist/js/pages/dashboard.js')}}"></script>

    <script type="module">

            const userId = {{ Auth()->user()->id }};
            

            Echo.private('new-orders.'+userId)  // Lắng nghe kênh Private
                .listen('NewOrderEvent', (event) => {
                    console.log('Thông báo đơn hàng mới:', event);

                    // Cập nhật thông báo mới trong giao diện
                    displayNewNotification(event);                       
            });

            function displayNewNotification(event) {
                const dropdown = document.getElementById('notifications-dropdown');
                const notificationCount = document.getElementById('notification-count');
                const notificationHeader = document.getElementById('notification-header');

                // Kiểm tra nếu phần tử notificationCount không tồn tại
                if (!notificationCount) {
                    console.error('Không tìm thấy phần tử notification-count!');
                    return;
                }

                // Cập nhật số lượng thông báo chưa đọc
                let unreadCount = 0;

                // lấy ra giá trị số lượng của thông báo
                if (notificationCount.textContent) {
                    console.log(notificationCount.textContent);
                    unreadCount = parseInt(notificationCount.textContent) || 0; // Nếu không phải là số, gán 0
                }

                // Cập nhật số lượng thông báo chưa đọc
                unreadCount += 1;
                notificationCount.textContent = unreadCount;

                // Chỉ hiển thị notificationCount nếu có thông báo chưa đọc
                if (unreadCount > 0) {
                    notificationCount.style.display = 'inline';  // Hiển thị số lượng thông báo chưa đọc
                } else {
                    notificationCount.style.display = 'none';  // Ẩn nếu không có thông báo
                }

                // Cập nhật tiêu đề của danh sách thông báo
                let totalNotification = parseInt(notificationHeader.textContent) + 1;
                notificationHeader.textContent = `${totalNotification} Thông báo`;

                const notificationHeaderContainer = document.querySelector('.notification-header-container');

                // Thêm thông báo mới vào dropdown
                const notificationItem = `
                    <a href="#" class="dropdown-item notification-unread" data-id="${event.notificationId}" onclick="handleNotificationClick(${event.notificationId})">
                        <div>
                            <i class="fas fa-bell mr-2"></i> ${event.title}
                            <span class="badge badge-danger ml-2">Mới</span>
                        </div>
                        <span class="float-right text-muted text-sm">
                            ${new Date().toLocaleString()}
                        </span>
                    </a>
                    <div class="dropdown-divider"></div>
                `;

                

                

                // Chèn thông báo mới sau notificationHeader trong dropdown
                notificationHeaderContainer.insertAdjacentHTML('afterend', notificationItem);

            }

            
    </script>

    {{-- lấy thông báo khi lần đầu vào trang quản trị --}}
    <script type="module">
        document.addEventListener("DOMContentLoaded", function () {

          

            // Lấy token từ thẻ meta
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Hàm lấy thông báo từ API
                function fetchNotifications() {
                    fetch('{{route('fetchNotifications')}}', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}` // Thêm token vào header
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch notifications');
                        }
                        return response.json();
                    })
                    .then(notifications => {
                        updateNotificationUI(notifications);
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                    });
                }

                // Hàm cập nhật giao diện thông báo
                function updateNotificationUI(notifications) {
                    const dropdown = document.getElementById('notifications-dropdown');
                    const notificationCount = document.getElementById('notification-count');
                    const notificationHeader = document.getElementById('notification-header');

                    

                    // Lọc thông báo chưa đọc
                    const unreadCount = notifications.filter(n => n.status === 'unread').length;

                    // Cập nhật số lượng thông báo
                    if (unreadCount > 0) {
                        notificationCount.textContent = unreadCount;
                        notificationCount.style.display = 'inline'; // Hiển thị số lượng
                    } else {
                        notificationCount.style.display = 'none'; // Ẩn số lượng nếu không có thông báo chưa đọc
                    }

                    
                    
                    // Tạo danh sách thông báo
                    const notificationItems = notifications.map(notification => `
                        <a href="#" class="dropdown-item ${notification.status === 'unread' ? 'notification-unread' : ''}" 
                        data-id="${notification.id}" onclick="handleNotificationClick(${notification.id})">
                            <div>
                                <i class="fas fa-bell mr-2"></i> ${notification.title}
                                ${notification.status === 'unread' ? '<span class="badge badge-danger ml-2">Mới</span>' : ''}
                            </div>
                            <span class="float-right text-muted text-sm">
                                ${new Date(notification.created_at).toLocaleString()}
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                    `).join('');

                    // Cập nhật nội dung dropdown
                    dropdown.innerHTML = `
                        <div class="notification-header-container">
                            <span class="dropdown-item dropdown-header" id="notification-header">${notifications.length} Thông báo</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        ${notificationItems}
                        <a href="#" class="dropdown-item dropdown-footer"
                        onclick="markAllNotificationsAsRead()"
                        >Xem tất cả thông báo</a>
                    `;
                }

                // Hàm đánh dấu tất cả thông báo là đã đọc
                function markAllNotificationsAsRead() {
                    fetch('{{route('markAllAsRead')}}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token, // Thêm CSRF token vào header
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to mark notifications as read');
                        }
                        return response.json();
                    })
                    .then(data => {
                        window.location.href = '{{route('admin.order.index')}}';
                    })
                    .catch(error => {
                        console.error('Error marking notifications as read:', error);
                    });
                }

            // Gọi hàm khi trang được load
            fetchNotifications();
        });

        // hàm xử lí khi nhấn đọc thông báo
        window.handleNotificationClick = function (notificationId) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Gửi yêu cầu đánh dấu thông báo là đã đọc
            fetch('{{ route('markAsRead') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token, // Gửi token CSRF ở đây
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ id: notificationId }) // Gửi ID thông báo qua body
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to mark notification as read');
                }
                return response.json();
            })
            .then(() => {
                // Chuyển hướng tới trang quản lý đơn hàng
                window.location.href = '{{route('admin.order.index')}}';
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }


    </script>
    
    

    @stack('script')
</body>

    
</html>
