<?php
    use App\Shared\Utility;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ChinaMax</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/menu">Menu</a>
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
                        $utility = new Utility();
                        $utility->checkoutElement();
                    ?>
                </li>
            </ul>
            
            <?php
                $canAccessCustomerOrOrder = false;
                $canAccessUser = false;
                $canAccessOrderOnly = false;
                if (Session::has('user')) {
                    $user = Session::get('user');
                    $roles = DB::table('roles')
                        ->select('roles.name')
                        ->join('role_users', 'role_id', '=', 'roles.id')
                        ->where('role_users.user_id', $user->id)
                        ->get();
                    foreach ($roles as $role) {
                        if ($role->name == "Admin" || $role->name == "Manager"){
                            $canAccessCustomerOrOrder = true;
                            break;
                        }
                    }
                    foreach ($roles as $role) {
                        if ($role->name == "Admin") {
                            $canAccessUser = true;
                            break;
                        }
                    }
                    foreach ($roles as $role) {
                        if ($role->name == "Employee") {
                            $canAccessOrderOnly = true;
                            break;
                        }
                    }
                }
            ?>
            
            @if ($canAccessCustomerOrOrder || $canAccessOrderOnly)
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/order">Order</a>
                    </li>
                </ul>
            @endif

            @if ($canAccessCustomerOrOrder)
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
            @endif
            
            @if ($canAccessUser)
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/user/list">User</a>
                    </li>
                </ul>
            @endif
            
            <div class="nav navbar-nav ms-auto">
                <a href="/cart" class="nav-item nav-link active">
                    <h5 class="px-5 cart">
                        <i class="fas fa-shopping-cart"></i>Cart
                        <span id="cartCount">        
                            <?php
                                $utility = new Utility();
                                $utility->cartCountSpanElement();
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
                            <li><a class="dropdown-item" href="/customerRegister">Register</a></li>
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