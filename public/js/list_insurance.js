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
        url: '/api/insurance-list',
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
            $(this.el).html(this.template({ insuranceLists: this.collection.toJSON() }));
        }
    });

    var app = new InsuranceView({
        // define the el where the view will render
        el: $('#appContainer')
    });