@extends('client.components.default')
@push('styles')
    <style>
        .voucher-page {
            padding: 40px;
            background-color: #f8f8f8;

            .voucher-header {
                text-align: center;
                margin-bottom: 30px;

                h1 {
                    font-size: 2rem;
                    color: #333;
                }

                p {
                    font-size: 1rem;
                    color: #666;
                }
            }

            .voucher-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                align-items: stretch; /* Đảm bảo các ô luôn có chiều cao bằng nhau */
            }

            .voucher-card {
                display: flex;
                flex-direction: column;
                justify-content: space-between; /* Duy trì khoảng cách hợp lý giữa các phần */
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
                transition: transform 0.3s;

                &:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                }

                h2 {
                    font-size: 1.5rem;
                    color: #ff4d4d;
                    margin-bottom: 10px;
                }

                p {
                    font-size: 1rem;
                    color: #333;
                    margin-bottom: 15px;
                }

                .voucher-code {
                    font-size: 1rem;
                    font-weight: bold;
                    margin-bottom: 20px;

                    span {
                        color: #007bff;
                    }
                }

                .btn {
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 1rem;
                    transition: background-color 0.3s;

                    &:hover {
                        background-color: #0056b3;
                    }
                }
            }

        }
    </style>
@endpush
@section('content')
    <section class="voucher-page">
        <div class="voucher-header">
            <h1>Khám phá Voucher Ưu Đãi</h1>
            <p>Chọn voucher phù hợp và tận hưởng ưu đãi đặc biệt khi mua sắm!</p>
        </div>
        <div class="voucher-grid">
            <!-- Voucher Item -->
            @foreach ($list_coupon as $item)
                <div class="voucher-card">
                    @if ($item->discount_type == 'percentage')
                        <h2>Giảm giá theo phần trăm</h2>
                        <p>{{ number_format($item->discount_value) }} %</p>
                        @if($item->maximum_discount)
                            <p>Tối đa giảm {{ number_format($item->maximum_discount, 0, ',', '.') }} VNĐ</p>
                        @endif
                    @else
                        <h2>Giảm giá theo giá trị</h2>
                        <p>{{ number_format($item->discount_value, 0, ',', '.') }} VNĐ</p>
                    @endif
                    
                    <p>Cho đơn hàng từ {{ number_format($item->minimum_order_value, 0, ',', '.') }} VND</p>
                    
                    <p class="voucher-code">Mã: <span>{{ $item->code }}</span></p>
                
                    <button class="btn btn-copy">Sao chép mã</button>
                </div>  
            
            @endforeach
            <!-- Add more vouchers as needed -->
        </div>
    </section>
@endsection
@push('script')
    <script>
        document.querySelectorAll('.btn-copy').forEach((button) => {
            button.addEventListener('click', (e) => {
                const code = e.target.previousElementSibling.querySelector('span').innerText;
                navigator.clipboard.writeText(code).then(() => {
                    alert(`Mã "${code}" đã được sao chép!`);
                });
            });
        });
    </script>
@endpush
