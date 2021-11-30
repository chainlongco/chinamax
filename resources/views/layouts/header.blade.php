<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ChinaMax</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/order">Order</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/cart">Cart</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item" id="checkoutMenu">
                    <!-- <a class="nav-link active" aria-current="page" href="/checkout">Checkout</a> -->
                    <?php
                        checkoutElement();
                    ?>
                </li>
            </ul>
            
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Customer
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/customer/list">My Customers</a></li>
                        <li><a class="dropdown-item" href="/customer/add">Add Customer</a></li>
                    </ul>
                  </li>
            </ul>
            
            <div class="nav navbar-nav ms-auto">
                <a href="/cart" class="nav-item nav-link active">
                    <h5 class="px-5 cart">
                        <i class="fas fa-shopping-cart"></i>Cart
                        <span id="cartCount">        
                            <?php
                                require_once(public_path() ."/shared/component.php");
                                cartCountSpanElement();
                            ?>
                        </span>
                    </h5>
                </a>
                <li class="dropdown" id="customerLogin">
                    @if(Session::has('customer'))
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Session::get('customer')->first_name ." " . Session::get('customer')->last_name }}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/customerLogout">Logout</a></li>
                        </ul>
                    @else
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Customer</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/customerLogin">Login</a></li>
                            <li><a class="dropdown-item" href="/customerSignup">Sign Up</a></li>
                        </ul>
                    @endif
                </li>
                <li class="dropdown" id="userLogin">
                    @if(Session::has('user'))
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">{{ Session::get('user')->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" aria-expended="false">
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    @else
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">User</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" aria-expended="false">
                            <li><a class="dropdown-item" href="/login">Login</a></li>
                            <li><a class="dropdown-item" href="/register">Register</a></li>
                        </ul>
                    @endif

                </li>
            </div>       
        </div>
    </div>
</nav>