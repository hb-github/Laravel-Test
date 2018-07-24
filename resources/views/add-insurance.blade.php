@extends('layouts.app')
@section('content')
    <!-- ========= -->
    <!-- Your HTML -->
    <!-- ========= -->
    <script type="text/template" id="insuranceTemplate">
        <div class="row">
            <div class="col-lg-12">
                <div id="main">
                    <a href="{{ URL('/') }}" class="btn btn-primary btn-sm">Go Back</a><br/>
                    <form class="form-horizontal" method="post" name="addInsurance" id="addInsurance">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" name="first_name"  placeholder="Enter First Name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Tel Number</label>
                            <input type="text" class="form-control" name="telnumber" placeholder="Enter Tel Number" required>
                        </div>
                        <div class="form-group">
                            <label for="address1">Address 1</label>
                            <input type="text" class="form-control" name="address1" placeholder="Enter Address 1" required>
                        </div>
                        <div class="form-group">
                            <label for="address2">Address 2</label>
                            <input type="text" class="form-control" name="Address2" placeholder="Enter Address 2" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Enter Country" required>
                        </div>    
                        <div class="form-group">
                            <label for="postcode">Postal Code</label>
                            <input type="text" class="form-control" name="postcode" placeholder="Enter Postal code" required>
                        </div>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Enter Product Name" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date"  placeholder="Select Start Date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date"  placeholder="Select End Date" required>
                        </div>
                        <div class="form-group">
                            <label for="cost">Currency Type</label>
                            <select name="currency" class="form-control">
                                <option value="usd">USD</option>
                                <option value="gbp">GBP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="number" class="form-control" name="cost" placeholder="Enter Cost" required min="0">
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnInsuranceSubmit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </script>
    <div id="search_container"></div>
    <div id="container"></div>
@endsection

@section('add_js')
<script src = "{{ asset('js/add_insurance.js') }}" type ="text/javascript"></script>
@endsection
