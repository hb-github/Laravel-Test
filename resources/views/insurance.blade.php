@extends('layouts.app')
@section('content')
    <!-- ========= -->
    <!-- Your HTML -->
    <!-- ========= -->
    <script type="text/template" id="insuranceTemplate">
        <div class="row">
            <div class="col-lg-12">
                <div id="main">
                    <a href="{{ URL('add-insurance') }}" class="btn btn-primary btn-sm">Add Insurance</a><br/>
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tel Number</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <% _.each(insuranceLists, function (data, index) { %>
                            <tr>
                                <td><%= index+1 %></td>
                                <td><%= data.first_name %> <%= data.last_name %></td>
                                <td><%= data.email %></td>
                                <td><%= data.telnumber %></td>
                                <td><%= data.product_name %></td>
                                <td><%= data.cost %> <%= data.currency %></td>
                                <td><%= data.start_date %></td>
                                <td><%= data.end_date %></td>
                            </tr>
                            <% }); %>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </script>
    <div id="search_container"></div>
    <div id="container"></div>
@endsection

@section('add_js')
<script src = "{{ asset('js/list_insurance.js') }}" type ="text/javascript"></script>
@endsection
