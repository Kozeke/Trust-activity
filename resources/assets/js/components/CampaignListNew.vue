<template>

    <div>  
        <!--<transition name="fade">
            <div class="campaign_help_2" v-show="show_step == true">
                <span class="campaign_help_label">2 step</span>
                <p>Add new campaign to start converting visitors to your customers!</p>
                <span class="campaign_help_arrow"></span>
            </div> 
        </transition>-->
        <transition name="fade">
            <div class="notification_preloader" v-show="campaignListShowPreloader == true"></div>
        </transition>

        <div class="notification_item" id="notification_overall" v-bind:class="[domain_settings.viewing_this_page == 'on' ? '' : 'off']">      
            <div class="notification_toggle">
                <div class="c-notification_toggle">
                    <input type="checkbox" v-if="domain_settings.viewing_this_page == 'on'" @click="updateSettings('overall-notification')" checked="checked"> 
                    <input type="checkbox" v-else @click="updateSettings('overall-notification')">                  
                    <label class="checkbox_label">
                        <span class="checkbox_label_txt checkbox_label_on">{{ translation.on }}</span> 
                        <span class="checkbox_toggle"></span> 
                        <span class="checkbox_label_txt checkbox_label_off">{{ translation.off }}</span>
                    </label>
                </div>
            </div>
            <div class="notification_name">
                <div class="notification_name_text">{{ translation['amount-of-visitors-viewing'] }}</div>
                <div class="notification_name_options">
                    <p>{{ translation.created }}: <span>{{ domain_created_at }}</span></p>
                </div>
            </div> 
            <div class="metrics_block_ex_content currently">
                <div class="module_example_desc">
                    <div class="module_example_img">
                        <img src="/cdn/img/green_view_icon.svg" atl="" style="width: 44px;">
                    </div>
                    <div class="module_example_right">
                        <div class="module_example_text">
                            <p class="module_example_name"><span class="num_marked">315 {{ translation.visitors }}</span> {{ translation['currently-viewing-this-page'] }}</p>
                        </div> 
                        <div class="module_example_by">
                            <p>
                                <span class="done"></span>
                                <span>by <span class="green_text">Trust Activity</span>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <transition-group name="fade" tag="div">
            <div v-bind:key="index" class="notification_item" v-for="(campaign, index) in campaignList" v-bind:class="{ delete: campaign.deleted }">
                <div class="notification_toggle">
                    <div class="c-notification_toggle">
                        <input type="checkbox" v-model="campaign.status" :disabled="campaign.deleted === true" @click="checkStatus(campaign.id)">        
                        <label class="checkbox_label">
                            <span class="checkbox_label_txt checkbox_label_on">{{ translation.on }}</span>
                            <span class="checkbox_toggle"></span>
                            <span class="checkbox_label_txt checkbox_label_off">{{ translation.off }}</span>
                        </label>
                    </div>
                </div>
                <div class="notification_name" v-if="campaign.deleted !== true">
                    <div class="notification_name_text">{{ campaign.name }}</div>
                    <div class="notification_name_options">
                        <p>{{ translation.modified }}: <span>{{ campaign.updated_at }}</span></p>
                        <p>{{ translation.shows }}: <span>{{ campaign.shows }} {{ translation.times }}</span></p>
                    </div>
                </div>

                <div class="notification_name" v-else>
                    <div class="notification_name_text">{{ campaign.name }}</div>
                    <div class="notification_delete_status">
                        <p>{{ translation['campaign-deleted'] }}.</p>
                        <a @click="restoreCampaign(campaign.id)">{{ translation.undo }}</a>
                    </div>
                    <div class="notification_delete_text">{{ translation['fully-deleted'] }} {{ campaign.deleted_left }} {{ translation.hours }}. {{ translation['press-undo'] }}</div>
                </div>

                <div class="metrics_block_ex_content">
                    <div class="module_example_desc">
                        <div class="module_example_img" v-if="campaign.image == 'map'">
                            <img src="/cdn/img/map.svg" atl="" style="width: 44px;">
                        </div> 
                        <div class="module_example_img" v-else-if="campaign.image == 'party'">
                            <img src="/cdn/img/party.svg" atl="" style="width: 44px;">
                        </div> 
                        <div class="module_example_img" v-else-if="campaign.image == 'discount'">
                            <img src="/cdn/img/discount.svg" atl="" style="width: 44px;">
                        </div> 
                        <div class="module_example_img" v-else-if="campaign.image != ''">
                            <img :src="campaign.image" atl="" style="width: 44px;">
                        </div> 
                        <div class="module_example_img" v-else>
                            <img src="/img/module_img.png" atl="" style="width: 44px;">
                        </div> 
                        <div class="module_example_right">
                            <div class="module_example_text"> 
                                <p class="module_example_name">Mike Harris {{ translation.from }} New York</p>
                                <p class="module_example_mess">{{ campaign.message }}</p>
                            </div> 
                            <div class="module_example_time">
                                <p>2 minutes ago</p>
                            </div>
                                <div class="module_example_by">
                                    <p>
                                        <span class="done"></span>
                                        <span>by <span class="green_text">Trust Activity</span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>    
                </div>

                <div class="notification_settings domain">
                    <button class="show_more_btn" @click="showMore(campaign.id)">
                        <span class="notification_settings_icon"></span>
                        <span>{{ translation.more }}</span>
                    </button>
                    <div class="settings_list domain" :id="'std-'+ campaign.id">
                        <a class="notification_settings_link metrics_link" @click="showMetrics(index)">
                            <span>{{ translation.metrics }}</span>
                        </a>
                        <a class="notification_settings_link contacts_link" @click="showContacts(index)">
                            <span>{{ translation.contacts }}</span>
                        </a>
                        <a :href="'/admin/domains/' + campaign.domain_id + '/notification/' + campaign.id" class="notification_settings_link edit_link">
                            <span>{{ translation.edit }}</span>
                        </a>
                        <a class="notification_settings_link delete_link" @click="deleteCampaign(campaign.id)">
                            <span>{{ translation.delete }}</span>
                        </a>

                    </div>
                </div>             
            </div>





            <div v-bind:key="777" v-if="campaignList.length == 0 && purchase && campaignListShowPreloader == false" class="notification_disabled_fon">
                <div class="c-notification_disabled_fon new_campaign">
                    <div class="no-company-row">
                        <div class="icon_disabled_fon"></div>
                        <div class="title_disabled_fon">Quick Start</div>
                        <div class="text_disabled_fon">Your successfull campaign is only one click away!</div>
                        <div class="link_disabled_fon">
                            <a href="#" @click="createReadyMade()" class="comp-presets-btn"><span>Start with Presets</span></a>
                            <span class="comp-devider">or create new campaign</span>
                            <a :href="domain_id" class="comp-new-btn"><span></span><span>{{ translation['new-campaign'] }}</span></a>
                        </div> 
                    </div>
                    <!--<div class="no-company-row">
                        <div class="icon_disabled_fon"></div>
                        <div class="title_disabled_fon">{{ translation['no-active-campaign-yet'] }}</div>
                        <div class="text_disabled_fon">{{ translation['need-to-add-first-notification-campaign-for-start'] }}. <br> {{ translation['just-click-the-button-below'] }}:</div>
                        <div class="link_disabled_fon">
                            <a :href="domain_id"><span>{{ translation['new-campaign'] }}</span><span></span></a>
                        </div>                        
                    </div>-->
                </div>
            </div>

            <div v-bind:key="777" v-if="purchase === false" class="notification_disabled_fon">
                <div class="c-notification_disabled_fon">
                    <div class="icon_disabled_fon"></div>
                    <div class="title_disabled_fon">{{ translation['no-subscription-yet'] }}</div>
                    <div class="text_disabled_fon">{{ translation['sorry-you-dont-have'] }}</div>
                    <div class="link_disabled_fon">
                        <a href="#" @click="activatePurchase()"><span>{{ translation.activate }}</span><span></span></a>
                    </div>
                </div>
            </div>

            <div v-bind:key="777" v-if="purchase && purchase.status == 0" class="notification_disabled_fon">
                <div class="c-notification_disabled_fon">
                    <div class="icon_disabled_fon"></div>
                    <div class="title_disabled_fon">{{ translation['cancelled-your-plan'] }}</div>
                    <div class="text_disabled_fon">{{ translation['remain-active-until'] }} {{ purchase.purchases_till }}.</div>
                    <div class="link_disabled_fon">
                        <a href="/admin/dashboard"><span>{{ translation.activate }}</span><span></span></a>
                    </div>
                </div>
            </div>        
        </transition-group>
    </div>

</template>

<script>
    export default {
		data () {
			return this.$parent._data;
		},
        watch: {
            // эта функция запускается при любом изменении вопроса
            campaignListLoaded: function () {
                if (this.translationLoaded == true) {
                    setTimeout(() => { this.campaignListShowPreloader = false; }, 300);
                }
            },
            translationLoaded: function () {
                if (this.campaignListLoaded == true) {
                    setTimeout(() => { this.campaignListShowPreloader = false; }, 300);
                }
            }
        },
	 	methods: {
            updateSettings: function(field) {

                let data = {    
                    'domain-id' : this.domain_settings.domain_id,
                    'field' : field,
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                };

                if (field == 'overall-notification') {
                    this.overallNotificationSwitch();
                    data.value = this.domain_settings.viewing_this_page;
                }


    
                $.post( '/api/domains/notification/put-settings', data, function( result ) {});
            },
            overallNotificationSwitch: function() {
                if (this.domain_settings.viewing_this_page == 'on') {
                    this.domain_settings.viewing_this_page = 'off';
                } else if (this.domain_settings.viewing_this_page == 'off') {
                    this.domain_settings.viewing_this_page = 'on';
                }
            },
            showMore: function(id) {

                $('.settings_list.domain').removeClass('active');
                $('.settings_list.domain').hide();
                
                if ($('#std-' + id).hasClass('active')) {
                    $('#std-' + id).hide();
                    $('#std-' + id).removeClass('active');
                } else {
                    $('#std-' + id).show();
                    $('#std-' + id).addClass('active');
                }

            },
            createReadyMade: function() {

                var vm = this;

                let data = {    
                    'domain_id' : $('input[name=domain-id]').val(),
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };

                $.post( '/api/domains/notification/presets', data, function( result ) {
                    if (result == 'true') {
                        vm.$parent.getList();
                    }
                });

                return false;
            },
            deleteCampaign: function(id) {

                let data = {    
                    'module-id' : id,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };

                for(index in this.campaignList)
                {
                    if (this.campaignList[index].id == id) {
                        this.campaignList[index].deleted = true;
                        this.campaignList[index].status   = 0;
                        this.campaignList[index].deleted_left = '23:59';
                        $.post( '/api/domains/notification/post-delete', data, function( result ) {});
                    }
                }
            },
            restoreCampaign: function(id) {

                let data = {    
                    'module-id' : id,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };

                for(index in this.campaignList)
                {
                    if (this.campaignList[index].id == id) {
                        this.campaignList[index].deleted = null;
                        this.campaignList[index].status  = 1;
                        $.post( '/api/domains/notification/post-delete', data, function( result ) {});
                    }
                }
            },
	 		showContacts: function(index) {

	 			this.show_contacts = true;
	 			$("body,html").addClass("overflow");
	 			this.activityList = this.campaignList[index].activity;
                
                this.paginationBuilder();
                this.paginate(1);
	 			return false;
	 		},
            paginate: function(page) {
                this.pagination.current_page = page;
                let index_start = (this.pagination.current_page - 1) * this.pagination.per_page; 
                let index_end   = index_start + (this.pagination.per_page - 1); 

                this.activityList.forEach(function callback(currentValue, index, array) {
                 // if activity related to compaign
                    if(index >= index_start && index <= index_end) {
                        currentValue.status = 1;    
                    } else {
                        currentValue.status = 0;                        
                    }
                });  
            },
            paginationBuilder: function() {
                let number = this.activityList.length;
                this.pagination.per_page;
                this.pagination.total_page = Math.round(number / this.pagination.per_page);
            },
            showMetrics: function(index) {

                this.show_metrics = true;
                $("body,html").addClass("overflow");
                let id = this.campaignList[index].id;
                this.metricsList    = (this.trafficList[id] ? this.trafficList[id] : []);
                this.metricsList.id = index;
                
                return false;
            },
	 		checkStatus: function(id) {
 
				let data = {	
					'module-id' : id,
					'_token' : $('meta[name="csrf-token"]').attr('content')
				};
	
	       		$.post( '/api/domains/notification/post-status', data, function( result ) {});
	 		},
            getTranslation: function() {

                let data = {    
                    'page' : 'domain-item',
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };

                var vm = this;

                $.post( '/api/translation/get', data, function( result ) {
                    for (var index in result) {
                        vm.translation[index] = result[index];
                    }

                    vm.translationLoaded = true;
                    //setTimeout(function(){ vm.campaignListShowPreloader = false; }, 300);
                });       
            },
            activatePurchase: function() {
                console.log('activity');
                this.show_update_plan = !this.show_update_plan;
                return false;
            }
	 	},
        mounted() {

            // Detect all clicks on the document
            document.addEventListener("click", function(event) {
                // If user clicks inside the element, do nothing
                //console.log('click all');
                if (event.target.closest(".settings_list.domain, .show_more_btn")) return;
                //console.log('click outside');
                // If user clicks outside the element, hide it!
                $('.settings_list.domain').removeClass('active');
                $('.settings_list.domain').hide();
            });


            this.domain_id = '/admin/domains/' + $('input[name=domain-id]').val() + '/notification/add';
            this.getTranslation();
            console.log('Component mounted.')
        }
    }
</script>
