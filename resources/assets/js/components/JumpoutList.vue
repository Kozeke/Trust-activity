<template>

    <div>  
        <transition name="fade">
            <div class="notification_preloader" v-show="campaignListShowPreloader == true"></div>
        </transition>

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

                <div class="metrics_block_ex_content" style="width: 320px; text-align: right; height: 80px; overflow: hidden; padding-left: 230px;'">
                    <div id="metric-box-mini" :class="campaign.data.popup_size + ' ' + campaign.data.popup_position" :style="'padding: 20px; border-style: solid;' +
                    'border-width: ' + campaign.data.border_size_count + 'px;' +
                    'border-color: ' + campaign.data.popup_border + ';' +
                    'border-radius: ' + campaign.data.border_size_radius + 'px;' +
                    'background-color: ' + campaign.data.popup_background + ';' +
                    'box-shadow: ' + campaign.data.popup_shadow + ' 0px 0px ' + campaign.data.shadow_size_count + 'px 0px;' +
                    'transform: scale(' + campaign.data.scale + ');' +
                    'top: -' + campaign.data.gap + 'px;' +
                    'left: -' + campaign.data.gap + 'px;'
                    ">
                        <a href="#" class="close" v-if="campaign.data.closeButton == 'true'"></a>
                        <template v-for="(element, index) in campaign.data.elements">
                            <div v-if="element.id_name == 'jump_out_title'" :key="index" :class="'metric_' + element.id_name" :style="'color: ' + 
                            element.styles.color + '; font-family:' + 
                            element.styles['font-family'] + '; font-weigth: ' +
                            element.styles['font-weigth'] + ';'">
                            {{ element.name }}
                            </div>
                            <div v-else-if="element.id_name == 'jump_out_text'" :key="index" :class="'metric_' + element.id_name" :style="'color: ' + 
                            element.styles.color + '; font-family:' + 
                            element.styles['font-family'] + '; font-weigth: ' +
                            element.styles['font-weigth'] + ';'">
                            {{ element.name }}
                            </div>           
                            <div v-else-if="element.id_name == 'jump_out_img'" :key="index" :class="'metric_' + element.id_name" :style="'height: ' + 
                            element.styles['height'] + 'px; background-image: url(' +
                            element.styles['background-image'] + ');'">
                            {{ element.name }}
                            </div>
                            <div v-else-if="element.id_name == 'jump_out_button'" :key="index" :class="'metric_' + element.id_name" :style="'background-color: ' + 
                            element.styles['background-color'] + '; border-radius: ' + 
                            element.styles['border-radius'] + 'px; border: ' + 
                            element.styles['border-size'] + 'px solid ' + element.styles['border-color'] + '; color: ' + 
                            element.styles.color + '; font-family:' + 
                            element.styles['font-family'] + '; font-weigth: ' + 
                            element.styles['font-weigth'] + '; shadow-box: ' + element.styles['shadow-color'] + ' 0px 0px ' + element.styles['shadow-size'] + 'px 0px;'">
                            {{ element.name }}
                            </div>
                        </template>
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
                        <a :href="'/admin/domains/' + campaign.domain_id + '/jumpout/' + campaign.id" class="notification_settings_link edit_link">
                            <span>{{ translation.edit }}</span>
                        </a>
                        <a class="notification_settings_link delete_link" @click="deleteCampaign(campaign.id)">
                            <span>{{ translation.delete }}</span>
                        </a>

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
            showMetrics: function(index) {

                this.show_metrics = true;
                $("body,html").addClass("overflow");

                let id              = this.campaignList[index].id;
                this.metricsList    = (this.trafficList[id] ? this.trafficList[id] : []);
                this.metricsList.id = index;
                this.metricsList.data = this.campaignList[index].data;
  
                return false;
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
            checkStatus: function(id) {
 
                let data = {    
                    'module-id' : id,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };
    
                $.post( '/api/domains/notification/post-status', data, function( result ) {});
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
                        $.post( '/api/domains/jumpout/post-delete', data, function( result ) {});
                    }
                }
            },
            checkStatus: function(id) {
 
                let data = {    
                    'module-id' : id,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };
    
                $.post( '/api/domains/jumpout/post-status', data, function( result ) {});
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
                        $.post( '/api/domains/jumpout/post-delete', data, function( result ) {});
                    }
                }
            },
	 	},
        mounted() {
            var vm = this;
            this.getTranslation();

            document.addEventListener("click", function(event) {
                // If user clicks inside the element, do nothing
                //console.log('click all');
                if (event.target.closest(".settings_list.domain, .show_more_btn")) return;
                //console.log('click outside');
                // If user clicks outside the element, hide it!
                $('.settings_list.domain').removeClass('active');
                $('.settings_list.domain').hide();
            });
        }
    }
</script>
