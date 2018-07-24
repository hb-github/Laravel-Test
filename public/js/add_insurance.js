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
    transaction_date: ""
  },
  initialize: function(){
   console.log('Insurance has been initialized');
 },
 showAlert: function () {
   alert('First name: ' + this.get('first_name') + ', Product Name: ' + this.get('product_name'));
  },
  getCustomUrl: function (method) {
    switch (method) {
      case 'create':
      return '/api/add-insurance';
      break;

      default: 
      return '/api/insurance-list';
      break;
    }
  },
    // Now lets override the sync function to use our custom URLs
  sync: function (method, model, options) {
      // options || (options = {});
      // options.url = this.getCustomUrl(method.toLowerCase());
      // return Backbone.sync.apply(this, arguments);
      var that = this;
      var params = _.extend({
            type: 'POST',
             dataType: 'text',
             url: that.getCustomUrl(method.toLowerCase()),
             //processData: false,
             data:model.attributes
        }, options);
        return $.ajax(params);
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
        $(this.el).html(this.template());
      }
    });

      var app = new InsuranceView({
    // define the el where the view will render
    el: $('#appContainer')
  });

jQuery(document).ready(function(){
    jQuery(document).on('submit','#addInsurance',function(e){
        e.preventDefault();
        var formJson = jQuery('#addInsurance').serializeArray();
        var postObject = {};
        $.each(formJson, function(i, data) {
            postObject[data['name']] = data['value'];
        });
        addRecord(postObject);
    });
});
function addRecord(postObject){
  var insuranceObject = new insurance(postObject);
  insuranceObject.save(null, {
      success: function (model, respose, options) {
          window.location.href = '/';
      },
      error: function (model, xhr, options) {
          console.log("Something went wrong while saving the model");
      }
   });
}