@extends('layouts.app')
@section('content')
<!-- ========= -->
    <!-- Your HTML -->
    <!-- ========= -->
    <script type="text/template" id="search_template">
    <!-- Access template variables with <%= %> -->
    <label>asdasd</label>
    <input type="text" id="search_input" />
    <input type="button" id="search_button" value="Search" />
    </script>
    <script type="text/template" id="insuranceTemplate">
        <div class="row">
            <div class="col-lg-12">
                <div id="main">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Transaction Date</th>
                                <th scope="col">Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <% _.each(insuranceLists, function (data, index) { %>
                            <tr>
                                <td><%= index+1 %></td>
                                <td><%= data.first_name %></td>
                                <td><%= data.first_name %></td>
                                <td><%= data.email %></td>
                                <td><%= data.telnumber %></td>
                                <td><%= data.transaction_date %></td>
                                <td><%= data.start_date %></td>
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
<script type = "text/javascript">
    insurance = Backbone.Model.extend({
        defaults: {
            start_date: "",
            end_date: "",
            first_name: "",
            last_name: "",
            email: "",
            telnumber: "",
            address1: "",
            Address2: "",
            city: "",
            country: "",
            postcode: "",
            product_name: "",
            cost: "",
            currency:"",
            transaction_date: ""
        },
        initialize: function(){
            console.log('Insurance has been initialized');
        },
        showAlert: function () {
            alert('First name: ' + this.get('first_name') + ', Last Name: ' + this.get('last_name'));
        }
    });

    insurance_collection = Backbone.Collection.extend({
        model: insurance,
        // Url to request when fetch() is called
        url: 'http://192.168.38.5/WebApiDevelopment/public/api/insurance-list',
        parse: function(response) {
            return response.data;
        },
        // Overwrite the sync method to pass over the Same Origin Policy
        sync: function(method, model, options) {
            var that = this;
            var params = _.extend({
                type: 'GET',
                dataType: 'json',
                url: that.url,
                processData: false
            }, options);
            return $.ajax(params);
        }
    });

    // Define the View
    InsuranceView = Backbone.View.extend({
        initialize: function() {
            // _.bindAll(this, 'render');
            // create a collection
            this.collection = new insurance_collection;
            // Fetch the collection and call render() method
            var that = this;
            this.collection.fetch({
                success: function () {
                    that.render();
                }
            });
        },
        // Use an extern template
        template: _.template($('#insuranceTemplate').html()),

        render: function() {
            // Fill the html with the template and the collection
            console.log('here');
            $(this.el).html(this.template({ insuranceLists: this.collection.toJSON() }));
        }
    });

    var app = new InsuranceView({
        // define the el where the view will render
        el: $('#appContainer')
    });
</script>
@endsection
