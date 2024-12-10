   {{-- lấy ra danh mục , thương hiệu --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fetchCategoriesUrl = "{{ route('api.category') }}"; // API lấy danh mục
            const fetchBrandsUrl = "{{ route('api.brand') }}"; // API lấy thương hiệu

            // Fetch danh mục
            function fetchCategories() {
                fetch(fetchCategoriesUrl)
                    .then(response => response.json())
                    .then(data => {
                        renderCategories(data);
                    })
                    .catch(error => console.error('Error fetching categories:', error));
            }

            // Fetch thương hiệu
            function fetchBrands() {
                fetch(fetchBrandsUrl)
                    .then(response => response.json())
                    .then(data => {
                        renderBrands(data);
                    })
                    .catch(error => console.error('Error fetching brands:', error));
            }

            // Render danh mục vào giao diện
            function renderCategories(categories) {
                const categoryContainer = document.querySelector('.widget-categories .widget-info ul');
                
                let categoryHTML = '';
                
                categories.forEach(category => {
                    categoryHTML += `
                        <li><a href="#">${category.name}</a></li>
                    `;
                });
                
                categoryContainer.innerHTML = categoryHTML;
            }

            // Render thương hiệu vào giao diện
            function renderBrands(brands) {
                const brandContainer = document.querySelector('.widget-brand .widget-info ul');
                let brandHTML = '';
                
                brands.forEach(brand => {
                    brandHTML += `
                        <li><a href="#">${brand.name}</a></li>
                    `;
                });
                
                brandContainer.innerHTML = brandHTML;
            }

            // Gọi các API khi trang được tải
            fetchCategories();
            fetchBrands();
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // const gridContainer = document.querySelector('#grid-view .row');
            // const listContainer = document.querySelector('#list-view .row');
            // const fetchProductsUrl = "{{ route('api.products') }}"; 
            // const productDetailUrl = "{{ route('getDetailProduct',['slug'=>'__slug']) }}"; 

            // Format lại giá tiền
            // function formatPrice(price) {
            //     // Chuyển giá trị thành chuỗi và loại bỏ các ký tự không phải là số
            //     let formattedPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            //     // Thêm đuôi "VNĐ"
            //     return formattedPrice + " VNĐ";
            // }

            // function fetchProducts(page = 1 ) {
            //     const url = `${fetchProductsUrl}?page=${page}`; // Sử dụng biến từ Blade

            //     fetch(url)
            //         .then(response => response.json())
            //         .then(data => {
            //             console.log(data.data);
                        
            //             const products = data.data; // Sản phẩm từ backend
            //             renderProducts(products);
            //             renderPagination(data);
            //         })
            //         .catch(error => console.error('Error fetching products:', error));
            // }

            // function renderProducts(products) {
            //     let gridHTML = '';
            //     let listHTML = '';

            //     products.forEach(product => {
            //         const productUrl = productDetailUrl.replace('__slug',product.slug); 

            //         gridHTML += `
            //             <div class="col-lg-4 col-md-6 col-12">
            //                             <div class="single-product border">
            //                                 <div class="product-img">
            //                                     <span class="pro-label new-label">new</span>
            //                                     <form action="" class=" pro-price-2">
            //                                         <button data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></button>
            //                                     </form>
            //                                     <a href="${productUrl}"><img src="${product.image}" alt="" /></a>
            //                                 </div>
            //                                 <div class="product-info clearfix ">
            //                                     <div class="fix">
            //                                         <h4 class="post-title"><a href="#">${product.name}}</a></h4>
            //                                     </div>
            //                                     <div class="d-flex align-items-center">
            //                                         <p class="pro-price">${formatPrice(product.main_variant.price)}</p>
    
            //                                     </div>
            //                                 </div>
            //                             </div>
            //             </div>
            //         `;

            //         listHTML += `
            //              <div class="col-12">
            //                             <div class="single-product clearfix">
            //                                 <div class="product-img">
            //                                     <span class="pro-label new-label">new</span>
            //                                     {{-- <a href="#" class="pro-price-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline "></i></a> --}}
            //                                     <a href="${productUrl}"><img src="${product.image}" alt="" /></a>
            //                                 </div>
            //                                 <div class="product-info">
            //                                     <div class="fix">
            //                                         <h4 class="post-title floatleft"><a href="#">${product.name}</a></h4>
                                                    
            //                                     </div>
            //                                     <div class="fix mb-20">
            //                                         <span class="pro-price">${formatPrice(product.main_variant.price)}</span>
            //                                     </div>
            //                                     {{-- <div class="clearfix">
            //                                         <div class="product-action clearfix">
                                                        
            //                                             <a href="#" data-bs-toggle="modal"  data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
            //                                             <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
            //                                         </div>
            //                                     </div> --}}
            //                                     <div class="product-description">
            //                                         <p>${product.description}</p>
            //                                     </div>
            //                                     <div class="fix">
            //                                         <button class="submit-button button-one" data-text="Thêm Vào Yêu Thích">Thêm Vào yêu thích</button>
            //                                     </div>
                                                
            //                                 </div>
            //                             </div>
            //                         </div>
            //         `;

                    
            //     });

            //     gridContainer.innerHTML = gridHTML;
            //     listContainer.innerHTML = listHTML;
            // }

            // function renderPagination(data) {
            //     const paginationContainer = document.querySelector('.pagination ul');
            //     let paginationHTML = '';

            //     if (data.prev_page_url) {
            //         paginationHTML += `<li><a href="#" data-page="${data.current_page - 1}"><i class="zmdi zmdi-long-arrow-left"></i></a></li>`;
            //     }

            //     for (let i = 1; i <= data.last_page; i++) {
            //         paginationHTML += `
            //             <li class="${data.current_page === i ? 'active' : ''}">
            //                 <a href="#" data-page="${i}">${i}</a>
            //             </li>
            //         `;
            //     }

            //     if (data.next_page_url) {
            //         paginationHTML += `<li><a href="#" data-page="${data.current_page + 1}"><i class="zmdi zmdi-long-arrow-right"></i></a></li>`;
            //     }

            //     paginationContainer.innerHTML = paginationHTML;

            //     // Add event listeners for pagination links
            //     document.querySelectorAll('.pagination a').forEach(link => {
            //         link.addEventListener('click', function (e) {
            //             e.preventDefault();
            //             const page = this.getAttribute('data-page');
            //             fetchProducts(page);
            //         });
            //     });
            // }

            // gọi api lần đầu tiên khi vào trang web
            // fetchProducts();
        });

    </script>