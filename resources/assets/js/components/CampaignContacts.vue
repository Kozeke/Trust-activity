<template>

    <div class="contacts_block" v-bind:class="{ show_contacts: show_contacts }">
        <div class="contacts_block_fon" @click="hideContactBlock()"></div>
        <div class="c-contacts_block">
            <!--<div class="contacts_block_name">Booking Hotel Page Visitors Check Campaign</div>-->
            <div class="contacts_block_title">{{ translation['contact-list'] }}</div>
            <div class="contacts_block_text">{{ translation['see-all'] }}</div>
            <!--<div class="contacts_block_form">
                <form>
                    <span class="contacts_block_form_icon"></span>
                    <input type="search" placeholder="Type to search..." v-model="search_contacts" v-on:keyup="searchFilter()">
                </form>
            </div>-->
            <div class="pagination contacts_pagination">
            	<ul v-if="pagination.total_page > 0">
                    <li class="pagination_item" v-if="1 <= pagination.current_page - 1"><a href="#" class="pagination_link" @click="prevPage" v-if=""><</a></li>
            		<!--<li class="pagination_item" v-for="pages in pagination.total_page"><a href="#" v-bind:class="{ active: pagination.current_page === pages }"  class="pagination_link" :data-id="pages" @click="paginate(pages)" >{{ pages }}</a></li>-->  
                    <li class="pagination_item" v-if="1 <= pagination.current_page - 3"><a href="#" v-bind:class="{ active: pagination.current_page === 1 }"  class="pagination_link" :data-id="1" @click="paginate(1)" >1</a></li>    

                    <li class="pagination_item" v-if="1 <= pagination.current_page - 4"><a href="#" class="pagination_link">...</a></li>   

                    <li class="pagination_item" v-if="1 <= pagination.current_page - 2"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page - 2 }"  class="pagination_link" :data-id="pagination.current_page - 2" @click="paginate(pagination.current_page - 2)" >{{ pagination.current_page - 2 }}</a></li>

                    <li class="pagination_item" v-if="1 <= pagination.current_page - 1"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page - 1 }"  class="pagination_link" :data-id="pagination.current_page - 1" @click="paginate(pagination.current_page - 1)" >{{ pagination.current_page - 1 }}</a></li>

                    <li class="pagination_item"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page }"  class="pagination_link" :data-id="pagination.current_page" @click="paginate(pagination.current_page)" >{{ pagination.current_page }}</a></li>

                    <li class="pagination_item" v-if="pagination.total_page >= pagination.current_page + 1"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page + 1 }"  class="pagination_link" :data-id="pagination.current_page + 1" @click="paginate(pagination.current_page + 1)" >{{ pagination.current_page + 1 }}</a></li>

                    <li class="pagination_item" v-if="pagination.total_page >= pagination.current_page + 2"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page + 2 }"  class="pagination_link" :data-id="pagination.current_page + 2" @click="paginate(pagination.current_page + 2)" >{{ pagination.current_page + 2 }}</a></li>

                    <li class="pagination_item" v-if="pagination.total_page >= pagination.current_page + 4"><a href="#" class="pagination_link">...</a></li>  

                    <li class="pagination_item" v-if="pagination.total_page >= pagination.current_page + 3"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.total_page }"  class="pagination_link" :data-id="pagination.total_page" @click="paginate(pagination.total_page)" >{{ pagination.total_page }}</a></li>                  

                    <li class="pagination_item" v-if="pagination.total_page >= pagination.current_page + 1"><a href="#" class="pagination_link" @click="nextPage">></a></li>    		
            	</ul>
            </div>
            <div class="contacts_list">
                <div class="contacts_item" v-for="activity in activityList" v-if="activity.status == 1">
                    <div class="contacts_item_logo">
                        <img v-if="activity.gravatar_data && activity.gravatar_data.thumbnailUrl" :src="activity.gravatar_data.thumbnailUrl" alt="" style="border-radius: 50%;">
                        <img v-else :src="'/' + activity.image" alt="" style="border-radius: 50%;">
                    </div>
                    <div class="contacts_item_desc">
                        <div class="contacts_item_name">
                            <p v-if="activity.gravatar_data.name && activity.gravatar_data.name.formatted">{{ activity.gravatar_data.name.formatted }}</p>
                            <p v-else>{{ translation.someone }}</p>
                            <p>
                                <a href=""><span></span>{{ activity.email }}</a>
                            </p>
                        </div>
                        <div class="contacts_item_time">{{ translation.from }} {{ activity.city }}  |  {{ activity.created_at }} </div>
                    </div>
                    <!--<div class="contacts_delete">
                        <a href=""><span></span>Delete</a>
                    </div>
                    <div class="contacts_restore">
                        <a href=""><span></span>Restore</a>
                    </div>-->
                    <div class="contacts_item_disabled_fon"></div>
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
            prevPage: function() {
                if (this.pagination.current_page > 1) {
                    this.pagination.current_page = this.pagination.current_page - 1;
                    this.paginate(this.pagination.current_page);
                }
            },
            nextPage: function() {
                if (this.pagination.total_page > this.pagination.current_page) {
                    this.pagination.current_page = this.pagination.current_page + 1;
                    this.paginate(this.pagination.current_page);
                }
            },
	 		paginate: function(page) {
	 			this.pagination.current_page = page;
				var index_start = (this.pagination.current_page - 1) * this.pagination.per_page; 
				var index_end   = index_start + (this.pagination.per_page - 1); 

				this.activityList.forEach(function callback(currentValue, index, array) {
				 // if activity related to compaign
					if(index >= index_start && index <= index_end) {
						currentValue.status = 1;	
					} else {
						currentValue.status = 0;						
					}
				});  
	 		},
            searchFilter: function() {
  
                var searching = this.search_contacts;

                if (searching.trim() != '') {
                    for (index in this.activityList) {
                        //var email = this.activityList[index].email;
 
                        if(this.activityList[index].email.indexOf(searching) !== -1) {
                            this.activityList[index].status = 1;
                        } else {
                            this.activityList[index].status = 0;        
                        }
                    }                    
                } else {
                    for (index in this.activityList) {
                        this.activityList[index].status = 1;
                    }             
                }
 
            },
            hideContactBlock: function() {
                this.show_contacts = false;
                $("body,html").removeClass("overflow");
            },
            getTranslation: function() {

                let data = {    
                    'page' : 'domain-contacts',
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
