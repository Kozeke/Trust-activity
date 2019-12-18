<template>

    <div class="metrics_block" v-bind:class="{ show_metrics: show_metrics }">
        <div class="metrics_block_fon" @click="hideMetricBlock()"></div>
        <div class="c-metrics_block">
            <div class="metrics_block_name">{{ translation['campaign-metrics'] }}</div>
            <div class="metrics_block_ex">
                <div class="metrics_block_ex_title">
                    <p>{{ translation['how-it-looks'] }}</p>
                    <div class="module_example_arrow"></div>
                </div>
                <div class="metrics_block_ex_content">
                    <div class="module_example_desc">
                        <div class="module_example_img">
                            <img src="/cdn/img/map.svg" atl="" style="width: 55px;">
                        </div>
                        <div class="module_example_right">
                            <div class="module_example_text">
                                <p class="module_example_name">Someone from Oregon</p>
                                <p class="module_example_mess" v-if="metricsList.id != null">{{ campaignList[metricsList.id].message }}</p>
                            </div>
                            <div class="module_example_time">
                                <p>2 {{ translation['minutes-ago'] }}</p>
                            </div>
                            <div class="module_example_by">
                                <p><span class="done"></span><span>by <span class="green_text">Trust Activity</span></span></p>
                            </div>
                        </div>
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
                        <div class="metrics_item_count" v-if="metricsList.day">{{ metricsList.day.shows }}</div>
                        <div class="metrics_item_count" v-else>0</div>                       
                        <div class="metrics_item_name">
                            <p>{{ translation.pageviews }}</p>
                            <!--<div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">Campaign name</p>
                                        <p class="question_block_text">Enter name of  campaign, you will see it in the list of campaigns on domain page.</p>
                                        <a href="" class="question_block_ok">Got It!</a>
                                        <a href="" class="question_block_false">Still confused</a>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.day">{{ metricsList.day.visitors }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>{{ translation.visitors }}</p>
                            <!--<div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">Campaign name</p>
                                        <p class="question_block_text">Enter name of  campaign, you will see it in the list of campaigns on domain page.</p>
                                        <a href="" class="question_block_ok">Got It!</a>
                                        <a href="" class="question_block_false">Still confused</a>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="metrics_tabs_content">
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.week">{{ metricsList.week.shows }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>{{ translation.pageviews }}</p>
                            <!--<div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">Campaign name</p>
                                        <p class="question_block_text">Enter name of  campaign, you will see it in the list of campaigns on domain page.</p>
                                        <a href="" class="question_block_ok">Got It!</a>
                                        <a href="" class="question_block_false">Still confused</a>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.week">{{ metricsList.week.visitors }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>{{ translation.visitors }}</p>
                            <!--<div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">Campaign name</p>
                                        <p class="question_block_text">Enter name of  campaign, you will see it in the list of campaigns on domain page.</p>
                                        <a href="" class="question_block_ok">Got It!</a>
                                        <a href="" class="question_block_false">Still confused</a>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="metrics_tabs_content">
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.month">{{ metricsList.month.shows }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>{{ translation.pageviews }}</p>
                            <!--<div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">Campaign name</p>
                                        <p class="question_block_text">Enter name of  campaign, you will see it in the list of campaigns on domain page.</p>
                                        <a href="" class="question_block_ok">Got It!</a>
                                        <a href="" class="question_block_false">Still confused</a>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="metrics_item">
                        <div class="metrics_item_count" v-if="metricsList.month">{{ metricsList.month.visitors }}</div>
                        <div class="metrics_item_count" v-else>0</div> 
                        <div class="metrics_item_name">
                            <p>{{ translation.visitors }}</p>
                            <!--<div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">Campaign name</p>
                                        <p class="question_block_text">Enter name of  campaign, you will see it in the list of campaigns on domain page.</p>
                                        <a href="" class="question_block_ok">Got It!</a>
                                        <a href="" class="question_block_false">Still confused</a>
                                    </div>
                                </div>
                            </div>-->
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
