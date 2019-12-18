<template>

    <div class="metrics_block" v-bind:class="{ show_metrics: show_metrics }">
        <div class="metrics_block_fon" @click="hideMetricBlock()"></div>
        <div class="c-metrics_block">
            <div class="metrics_block_name">{{ translation['campaign-metrics'] }}</div>
            <div class="metrics_block_ex metric_jumpout_preview" v-if="metricsList.data" :style="'padding: 0; overflow: hidden; background-color: ' + metricsList.data.popup_overlay + '; background-image: url(/img/redactor_bg.jpg);'">
                <div class="metrics_block_ex_title">
                   
                </div>
                <div class="metrics_block_ex_content" style="width: 100%;">
                    <div id="metric-box" :class="metricsList.data.popup_size + ' ' + metricsList.data.popup_position" :style="'padding: 20px; border-style: solid;' +
                    'border-width: ' + metricsList.data.border_size_count + 'px;' +
                    'border-color: ' + metricsList.data.popup_border + ';' +
                    'border-radius: ' + metricsList.data.border_size_radius + 'px;' +
                    'background-color: ' + metricsList.data.popup_background + ';' +
                    'box-shadow: ' + metricsList.data.popup_shadow + ' 0px 0px ' + metricsList.data.shadow_size_count + 'px 0px;' +
                    'transform: scale(' + metricsList.data.scale2 + ');' 
                    ">
                        <a href="#" class="close" v-if="metricsList.data.closeButton == 'true'"></a>
                        <template v-for="(element, index) in metricsList.data.elements">

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
            </div>
            <div class="metrics_block_title">{{ translation['metrics'] }}</div>
            <div class="metrics_tabs">
                <ul>
                    <li class="metrics_tabs_link active">24 {{ translation['hours'] }}</li>
                    <li class="metrics_tabs_link">1 {{ translation['week'] }}</li>
                    <li class="metrics_tabs_link">1 {{ translation['month'] }}</li>
                </ul>
                <div class="metrics_tabs_content active">
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.day">{{ metricsList.day.close }}</div>
                        <div class="metrics_item_count" v-else>0</div>                       
                        <div class="metrics_item_name">
                            <p>Closing</p>
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.day">{{ metricsList.day.action }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>Action</p>
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.day">{{ metricsList.day.ctr  }} %</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>CTR</p>
                        </div>
                    </div>                  
                </div>
                <div class="metrics_tabs_content">
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.week">{{ metricsList.week.close }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>Closing</p>
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.week">{{ metricsList.week.action }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>Action</p>
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.week">{{ metricsList.week.ctr }} %</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>CTR</p>
                        </div>
                    </div>  
                </div>
                <div class="metrics_tabs_content">
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.month">{{ metricsList.month.close }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>Closing</p>
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.month">{{ metricsList.month.action }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>Action</p>
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.month">{{ metricsList.month.ctr }} %</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>CTR</p>
                        </div>
                    </div>  
                </div>

            </div>
        </div>
    </div>

</template>

<script>
    export default {
		data () {
			return this.$parent._data;
		},
	 	methods: {
            hideMetricBlock: function() {
                this.show_metrics = false;
                console.log(this.metricsList);
                $("body,html").removeClass("overflow");
            },
            getTranslation: function() {

                let data = {    
                    'page' : 'domain-metrics',
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };

                var vm = this;

                $.post( '/api/translation/get', data, function( result ) {
                    for (var index in result) {
                        vm.translation[index] = result[index];
                    }
                });       
            },
	 	},
        mounted() {
            this.getTranslation();
        }
    }
</script>
