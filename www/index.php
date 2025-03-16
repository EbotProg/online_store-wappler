<!doctype html>
<html>

<head>
    <base href="/">
    <script src="dmxAppConnect/dmxAppConnect.js"></script>
    <meta charset="UTF-8">
    <title>Untitled Document</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap/5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="dmxAppConnect/dmxBootstrap5TableGenerator/dmxBootstrap5TableGenerator.css" />
    <script src="dmxAppConnect/dmxStateManagement/dmxStateManagement.js" defer></script>
    <script src="dmxAppConnect/dmxBootstrap5PagingGenerator/dmxBootstrap5PagingGenerator.js" defer></script>
    <script src="dmxAppConnect/dmxDataTraversal/dmxDataTraversal.js" defer></script>
    <script src="dmxAppConnect/dmxBootstrap5Modal/dmxBootstrap5Modal.js" defer></script>
    <script src="dmxAppConnect/dmxBootstrap5Navigation/dmxBootstrap5Navigation.js" defer></script>
    <script src="dmxAppConnect/dmxBootstrap5Theme/dmxBootstrap5Theme.js" defer></script>
    <script src="dmxAppConnect/dmxFormatter/dmxFormatter.js" defer></script>
</head>

<body is="dmx-app" id="index">
    <dmx-data-detail id="ddCustomerOrder" dmx-bind:data="scCustomerOrders.data.qryCustomerOrders"></dmx-data-detail>
    <dmx-datetime id="var1" interval="days"></dmx-datetime>
    <dmx-serverconnect id="scCustomerOrders" url="dmxConnect/api/orders/list_customer_orders.php"></dmx-serverconnect>
    <dmx-serverconnect id="scPagedProducts" url="dmxConnect/api/products/list_paged_products.php" dmx-param:limit="query.limit" dmx-param:offset="query.offset" dmx-param:firstnamefilter="firstNameFilterInput.value" dmx-param:addressfilter="addressFilterInput.value"></dmx-serverconnect>
    <dmx-data-view id="dvPagedProducts" dmx-bind:data="scPagedProducts.data.qryProducts"></dmx-data-view>
    <dmx-data-detail id="data_detail1" dmx-bind:data="scPagedCustomers.data.qryPagedCustomers.data" key="id"></dmx-data-detail>
    <dmx-serverconnect id="scProductsNeverOrdered" url="dmxConnect/api/products/list_products_never_ordered.php"></dmx-serverconnect>
    <dmx-serverconnect id="scCustomersByOrderValue" url="dmxConnect/api/customers/list_top_customers_by_ordervalue.php"></dmx-serverconnect>
    <dmx-serverconnect id="scCustomersWithoutOrders" url="dmxConnect/api/customers/list_customers_without_orders.php"></dmx-serverconnect>
    <dmx-serverconnect id="scProductsOrderFrequency" url="dmxConnect/api/products/list_products_and_order_frequency.php"></dmx-serverconnect>
    <dmx-toggle id="toggleProducts"></dmx-toggle>
    <dmx-toggle id="toggleOrder"></dmx-toggle>
    <dmx-toggle id="toggleCustomer" checked="true"></dmx-toggle>
    <dmx-query-manager id="qryPagedCustomers"></dmx-query-manager>
    <dmx-serverconnect id="scPagedCustomers" url="dmxConnect/api/customers/list_paged_customers.php" dmx-param:limit="6" dmx-param:offset="query.offset" dmx-param:firstnamefilter="firstNameFilterInput.value" dmx-param:addressfilter="addressFilterInput.value" dmx-param:sort="query.sort" dmx-param:dir="query.dir"></dmx-serverconnect>
    <dmx-serverconnect id="scDeleteCancelledOrders" url="dmxConnect/api/orders/delete_cancelled_orders.php"></dmx-serverconnect>
    <dmx-serverconnect id="scUpdatePriceBy5Percent" url="dmxConnect/api/products/update_price_by_5percent.php" dmx-on:success=""></dmx-serverconnect>
    <dmx-serverconnect id="scOrdersInLastMonth" url="dmxConnect/api/orders/list_orders_created_lastmonth.php" dmx-param:start_date="" dmx-param:end_date=""></dmx-serverconnect>
    <dmx-serverconnect id="scProductsAbove15k" url="dmxConnect/api/products/list_products_above_15k.php"></dmx-serverconnect>
    <dmx-serverconnect id="scCustomers" url="dmxConnect/api/customers/list_customers.php"></dmx-serverconnect>
    <div class="container mt-2 ms-0 me-0">
        <ul class="nav nav-tabs" id="navTabs1_tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="navTabs1_1_tab" data-bs-toggle="tab" href="#" data-bs-target="#navTabs1_1" role="tab" aria-controls="navTabs1_1" aria-selected="true">Customers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navTabs1_2_tab" data-bs-toggle="tab" href="#" data-bs-target="#navTabs1_2" role="tab" aria-controls="navTabs1_2" aria-selected="false">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navTabs1_3_tab" data-bs-toggle="tab" href="#" data-bs-target="#navTabs1_3" role="tab" aria-controls="navTabs1_3" aria-selected="false">Orders</a>
            </li>
        </ul>
        <div class="tab-content" id="navTabs1_content">
            <div class="tab-pane fade show active" id="navTabs1_1" role="tabpanel">
                <div class="container" id="customerContainer" dmx-show="toggleCustomer.checked">

                    <div class="row">
                        <div class="col">
                            <h1>Customers without orders</h1>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                        </tr>
                                    </thead>
                                    <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scCustomersWithoutOrders.data.qryCustomersWithoutOrders" id="tableRepeat3">
                                        <tr>
                                            <td dmx-text="firstname"></td>
                                            <td dmx-text="lastname"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-start">
                            <button id="btn1" class="btn btn-primary mt-2 mb-2" dmx-on:click="mdlAddCustomer.show()"><i class="fas fa-plus"></i><i class="fas fa-user-plus"></i>&nbsp; Add customer</button>
                        </div>
                    </div>
                    <div class="row" dmx-show="toggleCustomer.checked">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h4 class="text-start">All Customers</h4>
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="firstNameFilterInput" name="text1" type="text" class="form-control mb-1" placeholder="First Name">
                                        </div>
                                        <div class="col-3">
                                            <input id="addressFilterInput" name="text3" type="text" class="form-control" placeholder="Address ">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" dmx-on:click="qryPagedCustomers.set('sort','firstname');qryPagedCustomers.set('dir',qryPagedCustomers.data.dir == 'desc' ? 'asc' : 'desc')" dmx-class:sorting_asc="qryPagedCustomers.data.sort=='firstname' && qryPagedCustomers.data.dir == 'asc'" dmx-class:sorting_desc="qryPagedCustomers.data.sort=='firstname' && qryPagedCustomers.data.dir == 'desc'">Firstname</th>
                                                    <th class="sorting" dmx-on:click="qryPagedCustomers.set('sort','lastname');qryPagedCustomers.set('dir',qryPagedCustomers.data.dir == 'desc' ? 'asc' : 'desc')" dmx-class:sorting_asc="qryPagedCustomers.data.sort=='lastname' && qryPagedCustomers.data.dir == 'asc'" dmx-class:sorting_desc="qryPagedCustomers.data.sort=='lastname' && qryPagedCustomers.data.dir == 'desc'">Lastname</th>
                                                    <th class="sorting" dmx-on:click="qryPagedCustomers.set('sort','address');qryPagedCustomers.set('dir',qryPagedCustomers.data.dir == 'desc' ? 'asc' : 'desc')" dmx-class:sorting_asc="qryPagedCustomers.data.sort=='address' && qryPagedCustomers.data.dir == 'asc'" dmx-class:sorting_desc="qryPagedCustomers.data.sort=='address' && qryPagedCustomers.data.dir == 'desc'">Address</th>
                                                    <th class="sorting" dmx-on:click="qryPagedCustomers.set('sort','email');qryPagedCustomers.set('dir',qryPagedCustomers.data.dir == 'desc' ? 'asc' : 'desc')" dmx-class:sorting_asc="qryPagedCustomers.data.sort=='email' && qryPagedCustomers.data.dir == 'asc'" dmx-class:sorting_desc="qryPagedCustomers.data.sort=='email' && qryPagedCustomers.data.dir == 'desc'">Email</th>
                                                    <th class="sorting" dmx-on:click="qryPagedCustomers.set('sort','phone');qryPagedCustomers.set('dir',qryPagedCustomers.data.dir == 'desc' ? 'asc' : 'desc')" dmx-class:sorting_asc="qryPagedCustomers.data.sort=='phone' && qryPagedCustomers.data.dir == 'asc'" dmx-class:sorting_desc="qryPagedCustomers.data.sort=='phone' && qryPagedCustomers.data.dir == 'desc'">Phone</th>
                                                    <th scope="row">Edit</th>
                                                    <th scope="row">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scPagedCustomers.data.qryPagedCustomers.data" id="tableRepeat1" dmx-state="qryPagedCustomers" dmx-sort="sort" dmx-order="dir">
                                                <tr dmx-on:click="scCustomerOrders.load({id: id});mdlCustomerOrders.show();data_detail1.select(id)">
                                                    <td dmx-text="firstname"></td>
                                                    <td dmx-text="lastname"></td>
                                                    <td dmx-text="address"></td>
                                                    <td dmx-text="email"></td>
                                                    <td dmx-text="phone"></td>
                                                    <td><i class="fas fa-user-edit" dmx-on:click.stop="data_detail1.select(id);mdlEditCustomer.show()"></i></td>
                                                    <td><i class="fas fa-user-times" dmx-on:click.stop="mdlDeleteCustomer.show();mdlDeleteCustomer.frmDeleteCustomer.inp_id.setValue(id)"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul class="pagination" dmx-populate="scPagedCustomers.data.qryPagedCustomers" dmx-state="qryPagedCustomers" dmx-offset="offset" dmx-generator="bs5paging">
                                        <li class="page-item" dmx-class:disabled="scPagedCustomers.data.qryPagedCustomers.page.current == 1" aria-label="First">
                                            <a href="javascript:void(0)" class="page-link" dmx-on:click="qryPagedCustomers.set('offset',scPagedCustomers.data.qryPagedCustomers.page.offset.first)"><span aria-hidden="true">&lsaquo;&lsaquo;</span></a>
                                        </li>
                                        <li class="page-item" dmx-class:disabled="scPagedCustomers.data.qryPagedCustomers.page.current == 1" aria-label="Previous">
                                            <a href="javascript:void(0)" class="page-link" dmx-on:click="qryPagedCustomers.set('offset',scPagedCustomers.data.qryPagedCustomers.page.offset.prev)"><span aria-hidden="true">&lsaquo;</span></a>
                                        </li>
                                        <li class="page-item" dmx-class:active="title == scPagedCustomers.data.qryPagedCustomers.page.current" dmx-class:disabled="!active" dmx-repeat="scPagedCustomers.data.qryPagedCustomers.getServerConnectPagination(2,1,'...')">
                                            <a href="javascript:void(0)" class="page-link" dmx-on:click="qryPagedCustomers.set('offset',(page-1)*scPagedCustomers.data.qryPagedCustomers.limit)">{{title}}</a>
                                        </li>
                                        <li class="page-item" dmx-class:disabled="scPagedCustomers.data.qryPagedCustomers.page.current ==  scPagedCustomers.data.qryPagedCustomers.page.total" aria-label="Next">
                                            <a href="javascript:void(0)" class="page-link" dmx-on:click="qryPagedCustomers.set('offset',scPagedCustomers.data.qryPagedCustomers.page.offset.next)"><span aria-hidden="true">&rsaquo;</span></a>
                                        </li>
                                        <li class="page-item" dmx-class:disabled="scPagedCustomers.data.qryPagedCustomers.page.current ==  scPagedCustomers.data.qryPagedCustomers.page.total" aria-label="Last">
                                            <a href="javascript:void(0)" class="page-link" dmx-on:click="qryPagedCustomers.set('offset',scPagedCustomers.data.qryPagedCustomers.page.offset.last)"><span aria-hidden="true">&rsaquo;&rsaquo;</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </table>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h1>Top 5 customers who have ordered most</h1>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Customer name</th>
                                            <th>Order frequency</th>
                                        </tr>
                                    </thead>
                                    <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scCustomersByOrderValue.data.qryTopCustomersByOrderValue" id="tableRepeat6">
                                        <tr>
                                            <td dmx-text="firstname + ' ' + lastname"></td>
                                            <td dmx-text="orderFrequency"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="mdlAddCustomer" is="dmx-bs5-modal" tabindex="-1" dmx-on:hide-bs-modal="frmAddCustomer.reset()">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form is="dmx-serverconnect-form" id="frmAddCustomer" method="post" action="dmxConnect/api/customers/insert_customers.php" dmx-generator="bootstrap5" dmx-form-type="horizontal" dmx-on:success="scPagedCustomers.load({limit: query.limit, offset: query.offset})">
                                        <div class="form-group mb-3 row">
                                            <label for="inp_firstname" class="col-sm-2 col-form-label">Firstname</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_firstname" name="firstname" aria-describedby="inp_firstname_help" placeholder="Enter Firstname">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_lastname" class="col-sm-2 col-form-label">Lastname</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_lastname" name="lastname" aria-describedby="inp_lastname_help" placeholder="Enter Lastname">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_address" name="address" aria-describedby="inp_address_help" placeholder="Enter Address">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_email" name="email" aria-describedby="inp_email_help" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_phone" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="inp_phone" name="phone" aria-describedby="inp_phone_help" placeholder="Enter Phone">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" dmx-on:click="frmAddCustomer.submit();mdlAddCustomer.hide()">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="mdlEditCustomer" is="dmx-bs5-modal" tabindex="-1" dmx-on:hide-bs-modal="frmEditCustomer.reset()">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form is="dmx-serverconnect-form" id="frmEditCustomer" method="post" action="dmxConnect/api/customers/edit_customer.php" dmx-generator="bootstrap5" dmx-form-type="horizontal" dmx-populate="data_detail1.data" dmx-on:success="scPagedCustomers.load({limit: query.limit, offset: query.offset})">
                                        <input type="hidden" name="id" id="inp_id" dmx-bind:value="data_detail1.data.id">
                                        <div class="form-group mb-3 row">
                                            <label for="inp_firstname" class="col-sm-2 col-form-label">Firstname</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_firstname" name="firstname" dmx-bind:value="data_detail1.data.firstname" aria-describedby="inp_firstname_help" placeholder="Enter Firstname">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_lastname" class="col-sm-2 col-form-label">Lastname</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_lastname" name="lastname" dmx-bind:value="data_detail1.data.lastname" aria-describedby="inp_lastname_help" placeholder="Enter Lastname">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_address" name="address" dmx-bind:value="data_detail1.data.address" aria-describedby="inp_address_help" placeholder="Enter Address">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inp_email" name="email" dmx-bind:value="data_detail1.data.email" aria-describedby="inp_email_help" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 row">
                                            <label for="inp_phone" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="inp_phone" name="phone" dmx-bind:value="data_detail1.data.phone" aria-describedby="inp_phone_help" placeholder="Enter Phone">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" dmx-on:click="frmEditCustomer.submit();mdlEditCustomer.hide()">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="mdlDeleteCustomer" is="dmx-bs5-modal" tabindex="-1" dmx-on:hide-bs-modal="frmDeleteCustomer.reset()">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Remove Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to remove this customer?</p>
                                    <form is="dmx-serverconnect-form" id="frmDeleteCustomer" method="post" action="dmxConnect/api/customers/delete_customer.php" dmx-generator="bootstrap5" dmx-form-type="horizontal" dmx-on:success="scPagedCustomers.load({limit: query.limit, offset: query.offset})">
                                        <input type="hidden" name="id" id="inp_id">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" dmx-on:click="frmDeleteCustomer.submit();mdlDeleteCustomer.hide()">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="mdlCustomerOrders" is="dmx-bs5-modal" tabindex="-1" dmx-on:hide-bs-modal="scCustomerOrders.reset()">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" dmx-text="'Orders for '+data_detail1.data.firstname+' '+data_detail1.data.lastname"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Product name</th>
                                                    <th>Status</th>
                                                    <th>Qty ordered</th>
                                                    <th>Total amount</th>
                                                    <th>Ordered</th>
                                                    <th>Executed on</th>
                                                </tr>
                                            </thead>
                                            <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scCustomerOrders.data.qryCustomerOrders" id="tableRepeat7">
                                                <tr>
                                                    <td dmx-text="productName"></td>
                                                    <td dmx-text="status"></td>
                                                    <td dmx-text="qtyOrdered"></td>
                                                    <td dmx-text="totalAmount"></td>
                                                    <td dmx-text="orderedOn.daysUntil(var1.datetime)+' days ago'"></td>
                                                    <td dmx-text="executedOn"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="navTabs1_2" role="tabpanel">

                <div class="container" id="productsContainer">
                    <div class="row">
                        <div class="col text-xxl-start">
                            <button id="btn2" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp; Add Product</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4 class="text-xxl-start">All Products</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Edit</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scPagedProducts.data.queryPagedProducts.data" id="tableRepeat8">
                                        <tr>
                                            <td dmx-text="name"></td>
                                            <td dmx-text="price"></td>
                                            <td dmx-text="qty"></td>
                                            <td dmx-text="qty"><i class="fas fa-edit"></i></td>
                                            <td dmx-text="qty"><i class="fas fa-times"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <ul class="pagination" dmx-populate="scPagedProducts.data.queryPagedProducts" dmx-state="qmPagedProducts" dmx-offset="offset" dmx-generator="bs5paging">
                                <li class="page-item" dmx-class:disabled="scPagedProducts.data.queryPagedProducts.page.current == 1" aria-label="First">
                                    <a href="javascript:void(0)" class="page-link" dmx-on:click="qmPagedProducts.set('offset',scPagedProducts.data.queryPagedProducts.page.offset.first)"><span aria-hidden="true">&lsaquo;&lsaquo;</span></a>
                                </li>
                                <li class="page-item" dmx-class:disabled="scPagedProducts.data.queryPagedProducts.page.current == 1" aria-label="Previous">
                                    <a href="javascript:void(0)" class="page-link" dmx-on:click="qmPagedProducts.set('offset',scPagedProducts.data.queryPagedProducts.page.offset.prev)"><span aria-hidden="true">&lsaquo;</span></a>
                                </li>
                                <li class="page-item" dmx-class:active="title == scPagedProducts.data.queryPagedProducts.page.current" dmx-class:disabled="!active" dmx-repeat="scPagedProducts.data.queryPagedProducts.getServerConnectPagination(2,1,'...')">
                                    <a href="javascript:void(0)" class="page-link" dmx-on:click="qmPagedProducts.set('offset',(page-1)*scPagedProducts.data.queryPagedProducts.limit)">{{title}}</a>
                                </li>
                                <li class="page-item" dmx-class:disabled="scPagedProducts.data.queryPagedProducts.page.current ==  scPagedProducts.data.queryPagedProducts.page.total" aria-label="Next">
                                    <a href="javascript:void(0)" class="page-link" dmx-on:click="qmPagedProducts.set('offset',scPagedProducts.data.queryPagedProducts.page.offset.next)"><span aria-hidden="true">&rsaquo;</span></a>
                                </li>
                                <li class="page-item" dmx-class:disabled="scPagedProducts.data.queryPagedProducts.page.current ==  scPagedProducts.data.queryPagedProducts.page.total" aria-label="Last">
                                    <a href="javascript:void(0)" class="page-link" dmx-on:click="qmPagedProducts.set('offset',scPagedProducts.data.queryPagedProducts.page.offset.last)"><span aria-hidden="true">&rsaquo;&rsaquo;</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h1>Products above 15000</h1>
                            <div class="row">
                                <div class="col">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scProductsAbove15k.data.productsAbove15k" id="tableRepeat4">
                                            <tr>
                                                <td dmx-text="name"></td>
                                                <td dmx-text="price"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h1>Product Order Frequency</h1>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Num of times ordered</th>
                                        </tr>
                                    </thead>
                                    <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scProductsOrderFrequency.data.qryProductsAndOrderFrequency" id="tableRepeat2">
                                        <tr>
                                            <td dmx-text="name"></td>
                                            <td dmx-text="NumOfTimesOrdered"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h1>Products Which have not been ordered</h1>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scProductsNeverOrdered.data.qryProductsNeverOrdered" id="tableRepeat5">
                                        <tr>
                                            <td dmx-text="name"></td>
                                            <td dmx-text="price"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane fade" id="navTabs1_3" role="tabpanel">
                <div class="container" id="orderContainer">

                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h1>Orders made from&nbsp;</h1>

                                    <input id="start_date1" name="start_date1" type="date" class="form-control">
                                    <h1>to</h1><input id="end_date1" name="end_date1" type="date" class="form-control">
                                    <button id="btn4" class="btn btn-outline-primary" dmx-on:click="scOrdersInLastMonth.load({start_date: start_date1.value, end_date: end_date1.value})">Get orders</button>
                                    <button id="btn4" class="btn btn-outline-primary" dmx-on:click="scUpdatePriceBy5Percent.load({})">Update Prices by 5%</button>
                                    <button id="btn4" class="btn btn-outline-primary" dmx-on:click="scDeleteCancelledOrders.load({})">Delete cancelled orders</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Customer firstname</th>
                                            <th>Product name</th>
                                            <th>Ordered date</th>
                                            <th>Product Price</th>
                                            <th>Order status</th>
                                        </tr>
                                    </thead>
                                    <tbody is="dmx-repeat" dmx-generator="bs5table" dmx-bind:repeat="scOrdersInLastMonth.data.getCustomerNameProductName" id="tableRepeat4">
                                        <tr>
                                            <td dmx-text="customer_firstname"></td>
                                            <td dmx-text="product_name"></td>
                                            <td dmx-text="ordered_date"></td>
                                            <td dmx-text="product_price"></td>
                                            <td dmx-text="order_status"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>


    </div>
    </div>
    </div>

    <script src="bootstrap/5/js/bootstrap.bundle.min.js"></script>
</body>

</html>