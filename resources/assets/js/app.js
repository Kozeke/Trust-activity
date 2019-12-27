
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 
Vue.component('jumpoutlist', require('./components/JumpoutList.vue').default);
Vue.component('jumpoutmetrics', require('./components/JumpoutMetrics.vue').default);
Vue.component('campaignlist', require('./components/CampaignList.vue').default);
Vue.component('campaignlistnew', require('./components/CampaignListNew.vue').default);
Vue.component('campaigncontacts', require('./components/CampaignContacts.vue').default);
Vue.component('campaignmetrics', require('./components/CampaignMetrics.vue').default);
Vue.component('adddomainpopup', require('./components/AddDomainPopup.vue').default);
Vue.component('billing', require('./components/Billing.vue').default);
Vue.component('cmsinstruction', require('./components/CmsInstruction.vue').default);
Vue.component('campaignpurchase', require('./components/CampaignPurchase.vue').default);
Vue.component('topuppurchase', require('./components/TopupPurchase.vue').default);
Vue.component('campaignsettings', require('./components/CampaignSettings.vue').default);
Vue.component('history_payment', require('./components/HistoryPayment').default);

// import router from './router';
var pathname = window.location.pathname;
if(document.getElementById('payment_history') !== null) {

    const app = new Vue({
        el: '#payment_history',
        /**
         * The application's data.
         */

        data: {
        },
        methods: {

        }});
}
// if(pathname != '/admin/domains' && document.getElementById('app') !== null) {
if(document.getElementById('app') !== null) {

  const app = new Vue({
         el: '#app',
         /**
         * The application's data.
         */
         data: {
                purchase_domain_show: false,
                TopupPlan: {
                  pay_type: null,
                  step: 1,
                  selected: [],
                  date: {
                    mask: '00',
                    lazy: false
                  },
                  ccv: {
                    mask: '000',
                    lazy: false
                  },
                  card: {
                    mask: '0000 0000 0000 0000',
                    lazy: false
                  }
                },        
                show_topup_plan: false,  
                updatePlan: {
                  pay_type: null,
                  selected: [],
                },
                translation: { shows: '', 'domain-name' : '' },
                pagination: {
                  per_page: 20,
                  current_page: 1,
                  total_page: 1,
                },
                campaignUpdate: {
                  plans: [],
                },
                domain_id: false,
                domain_settings: { 'viewing_this_page' : 'on', 'spacing_between' : 0 },
                domain_created_at : null,
                DashboardShowPreloader: false,
                hide_billiing_sidebar: true,
                search_contacts: '',
                search_billing: '',
                search_billing_404: false,
                AddDomainPopupShowPreloader: false,
                AddDomainPopupShowSuccess: false,
                show_contacts: false,
                show_metrics: false,
                show_update_plan: false,
                purchase_domain_url: '',
                show_instruction: false,
                current_campaign: null,
                show_step: false,
                instructionTitle: '',
                instructionDescription: '',
                instructionContent: '',
                instructionPreloader: true,
                campaignListShowPreloader: true,
                translationLoaded: false,
                campaignListLoaded: false,
                campaignList: [],
                trafficList: [],
                metricsList: [],
                activityList: [],
                purchase: true,
                billing: {
                  pay_type: 'paypal',
                  selected: [],
                  total: 0,
                  domains: [],
                  plans: [],
                  user: [],  
                  counter: 0,
                  up_to: null,
                  order_price: 0,
                }
         },
         methods: {
          getList: function() {
            var vm   = this;

            var data = {  
              'domain-id' : $('input[name="domainId"]').val(),
              '_token' : $('meta[name="csrf-token"]').attr('content')
            };

            $.post( '/api/domains/notification/get-list', data, function( result ) {
                // foreach result (activity list)
                vm.purchase          = result.purchase;
                vm.trafficList       = result.traffic;
                vm.domain_created_at = result.domain;
                vm.domain_settings   = result.domain_settings;

                vm.isPurchased(result.purchase);
                for(index in result.compaigns) {
                        // making data array
                        var compaign = {
                               'id' : result.compaigns[index].id,                                     
                               'name' : result.compaigns[index].name,
                               'message' : result.compaigns[index].message,                               
                               'image' : result.compaigns[index].image,
                               'updated_at' : result.compaigns[index].modified_at,
                               'status' : result.compaigns[index].status,
                               'shows' : result.compaigns[index].shows,    
                               'domain_id' : result.compaigns[index].domain_id,   
                               'deleted_left' : result.compaigns[index].deleted_left,  
                               'deleted' : result.compaigns[index].deleted,                     
                               'activity' : []
                        } 
                        // mutate for live event
                        vm.campaignList.push(compaign);
                }

                vm.campaignListLoaded = true;
       
                for(index in result.activity) {
                    var activity = {
                           'email' : result.activity[index].email,
                           'gravatar_data' : result.activity[index].gravatar_data,    
                           'city' : result.activity[index].city,                                     
                           'city_code' : result.activity[index].city_code, 
                           'image' : result.activity[index].image,
                           'created_at' : result.activity[index].created_at,                       
                           'updated_at' : result.activity[index].updated_at,  
                           'hot_streak_id' : result.activity[index].hot_streak_id,
                           'status' : 1,                                                           
                    }
                    // get right compaign 
                    vm.campaignList.forEach(function callback(currentValue, index, array) {
                       // if activity related to compaign
                       if (currentValue.id == activity.hot_streak_id) {
                          // adding 
                          vm.campaignList[index]['activity'].push(activity);      
                       }                    
                    });     
                }
            }); 
          },
          isPrime: function(object) {
            return (this.current_campaign.hot_streak_id == object.id ? true : false);
          },
          isPurchased: function(purchase) {
            if (purchase == false) {
              $('.c-notification').addClass('notification_disabled');
              $('#notifications-paid-days').addClass('disabled');
              $('#notifications-paid-days').html('Paid days: 0');
              $('#notifications-paid-days').fadeIn();
            } else if(purchase && purchase.status == 0) {
              $('.c-notification').addClass('notification_disabled');
              $('#notifications-paid-days').html('Paid days: ' + purchase.days);
              $('#notifications-paid-days').fadeIn();
            } else if(purchase && purchase.status == 1) {
              $('#notifications-paid-days').html('Paid days: ' + purchase.days);
              $('#notifications-paid-days').fadeIn();
            } else if(purchase && purchase.status == 2) {
              $('#notifications-paid-days').html('out of limit');
              $('#notifications-paid-days').css(['background-color', '#e53d3d']);
              $('#notifications-paid-days').css(['color', 'white']);
              $('#notifications-paid-days').fadeIn();             
            //} else {
              //$('#notifications-paid-days').html('Paid days: ' + purchase.days);
              //$('#notifications-paid-days').fadeIn();
              //$('#notifications-paid-days').show();
            }
          }
         },
         mounted() {
          this.getList();
 
    }
  });
}

if(document.getElementById('jumpout-app') !== null) {

  const app = new Vue({
    el: '#jumpout-app',
    /**
    * The application's data.
    */
    data: {
      AddDomainPopupShowPreloader: false,
      AddDomainPopupShowSuccess: false,
      campaignListShowPreloader: true,
      campaignListLoaded: false,
      campaignList: [],
      metricsList: [],   
      trafficList: [],
      show_metrics: false,
      translation: { shows: '', 'domain-name' : '' },
      domain_settings: { 'viewing_this_page' : 'on', 'spacing_between' : 0, 'hide_notifications' : 'no' },
      domain_created_at: null,
    },
    methods: {
      getList: function() {

            var vm   = this;

            var data = {  
              'domain-id' : $('input[name="domainId"]').val(),
              '_token' : $('meta[name="csrf-token"]').attr('content')
            };

            $.post( '/api/jumpout/get-list', data, function( result ) {

                vm.trafficList       = result.traffic;
                vm.domain_created_at = result.domain;
                vm.domain_settings   = result.domain_settings;
 
                for(index in result.compaigns) {
                        // making data array
                        switch(result.compaigns[index].data.popup_size) {
                          case 'small':
                            scale  = 0.2222;
                            scale2 = 0.8333;
                            size   = 360;
                            break;
                          case 'medium':
                            scale  = 0.16;
                            scale2 = 0.60;
                            size   = 500;
                            break;
                          case 'large':
                            scale  = 0.123;
                            scale2 = 0.46;
                            size   = 650;
                            break;
                          case 'f_w':
                            scale  = 0.26;
                            scale2 = 1;
                            size   = 300;
                            break; 
                          case 'f_h':
                            scale  = 0.26;
                            scale2 = 1;
                            size   = 300;
                            break;                          
                        }
  
                        var gap  = (size - 80) / 2;
                        var gap2 = (size - 300) / 2;

                        result.compaigns[index].data.scale  = scale;
                        result.compaigns[index].data.gap    = gap;
                        result.compaigns[index].data.scale2 = scale2;
                        result.compaigns[index].data.gap2   = gap2;

                        var compaign = {
                               'id' : result.compaigns[index].id,                                     
                               'name' : result.compaigns[index].name,
                               'updated_at' : result.compaigns[index].modified_at,
                               'status' : result.compaigns[index].status,
                               'domain_id' : result.compaigns[index].domain_id,   
                               'deleted_left' : result.compaigns[index].deleted_left,  
                               'deleted' : result.compaigns[index].deleted,   
                               'data' : result.compaigns[index].data,          
                               'activity' : []
                        } 
                        // mutate for live event
                        vm.campaignList.push(compaign);
                }

                vm.campaignListLoaded = true;
            });
      }, 
    },
    mounted() {
      this.getList();
    }
  });
}
 
Vue.component('users', require('./components/Users.vue').default);

if(document.getElementById('admin_app') !== null) {

  const app = new Vue({
         el: '#admin_app',
         /**
         * The application's data.
         */
         data: {
          users_list: [],
          search: '',
          pagination: {
            per_page: 10,
            current_page: 1,
            total_page: 1,
          },
         },
         methods: {
            paginationBuilder: function() {
                var number = this.users_list.length;
                this.pagination.total_page = Math.round(number / this.pagination.per_page);
            },
            paginate: function(page) {
                this.pagination.current_page = page;
                var index_start = (this.pagination.current_page - 1) * this.pagination.per_page; 
                var index_end   = index_start + (this.pagination.per_page - 1); 

                this.users_list.forEach(function callback(currentValue, index, array) {
                 // if activity related to compaign
                    if(index >= index_start && index <= index_end) {
                        if(currentValue.search == 1) {
                          currentValue.status = 1;    
                        } else {
                          currentValue.status = 0;          
                        }
                    } else {
                        currentValue.status = 0;                        
                    }
                });  
            }
         },
         mounted() {

          var data = {  
            '_token' : $('meta[name="csrf-token"]').attr('content')
          };

          let vm = this;
          $.post( '/api/users/list', data, function( result ) {
              console.log(result)
            if (result != 'false') {
              for(index in result.list) {
                result.list[index].status = 1;
                result.list[index].search = 1;
                vm.users_list.push(result.list[index]);
              }

              vm.paginationBuilder();
              vm.paginate(1);
            }
          });
        }
  });
}
 
Vue.component('redactor', require('./components/Redactor.vue').default);

if(document.getElementById('redactor') !== null) {
 
  const app = new Vue({
         el: '#redactor',
         /**
         * The application's data.
         */
         data: {
          isNew: true,
          ShowPreloader: true,
          company_name: 'Summer sale 30%',
          is_disabled: '',
          type: 'pop_up',
          repeats: 0,
          closeButton: false,
          closeOnOverlay: false,
          mode: 'add',
          edit_object: [],
          gallery: [],
          idGlobal: 0,
          popup_position: 'center-mid',
          popup_size: 'small',    
          popup_background: 'white',   
          popup_overlay: '#9B9B9B',
          popup_border: 'white',
          popup_shadow: 'black', 
          border_size_count: 0,
          border_size_radius: 0,
          shadow_size_count: 0,  
          new_button_border_size: 0,
          new_button_corner_radius: 0,
          new_button_shadow_size: 0,
          new_image_height: 100,
          background_image: '',
          list1: [
            {
              name: "Title",
              id: 1,
              id_name: 'jump_out_title'
            },
            {
              name: "Text",
              id: 2,
              id_name: 'jump_out_text'
            },
            {
              name: "Button",
              id: 3,
              id_name: 'jump_out_button',
            },
            {
              name: "Image",
              id: 4,
              id_name: 'jump_out_img'
            }
          ],
          list2: [],

         },
         methods: {
          getTemplateGallery: function() {

              var data = {
                  '_token' : $('meta[name="csrf-token"]').attr('content'),
              }

              var vm = this;

              $.post( '/api/jumpout/get-gallery', data, function( result ) {
                  vm.gallery = [];

                  for (var i = result.length - 1; i > -1; i--) {
                    //console.log(result[i]);
                    vm.gallery.push(result[i]);
                  }

                  /*for (index in result) {
                    vm.gallery.push(result[index]);
                  }*/
              });
          }
         },
         mounted() {

            this.getTemplateGallery();
 
        }
  });
}


