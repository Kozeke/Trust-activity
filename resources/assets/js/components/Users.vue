<template>
    <div class="row">
        <div class="admin-users-preloader"></div>
        <div class="col-lg-offset-1 col-lg-10">
            <div class="domain_list_search">
                <form>
                    <button></button>
                    <input type="search" placeholder="Type to search..." v-model="search" v-on:keyup="searchFilter()">
                </form>
            </div>
            <div class="notification_tabs admin-users">
                <div class="notification_tabs_content active">
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
                    <div class="notification_item" v-for="item in users_list" v-if="item.status == 1">
                        <div class="notification_name">
                            <div class="notification_name_text">{{ item.email }}</div>
                            <div class="notification_name_options">
                                <p>registered: <span>{{ item.created_at }}</span></p>
                                <p>balance: <span :id="'balance-' + item.id">${{ item.balance }} (${{ item.referral_balance}})</span></p>                                        
                                <div class="domain-user-list">
                                    <p v-for="domain in item.domains">{{ domain.url }} ({{ domain.hot_streaks_count }})</p>
                                </div>
                            </div>
                        </div>
                        <div class="notification_settings">
                            <div class="c-notification_settings">
                                <div class="c-notification_settings-left">
                                    <a :href="'/admin/users/enter/' + item.id" class="notification_settings_link contacts_link"><span class="notification_settings_icon"></span><span>Enter as user</span></a>
                                    <a href="" class="notification_settings_link metrics_link change_balance" :data-id="item.id" :data-balance="item.balance"><span class="notification_settings_icon"></span><span>Change balance</span></a>                                    
                                </div>
                                <div class="c-notification_settings-right">
                                    <a v-if="item.role == 2" :href="'/admin/users/promote/' + item.id" class="notification_settings_link metrics_link" :data-id="item.id" :data-balance="item.balance">
                                    <span class="notification_settings_icon"></span><span><span style="color: #e39891; vertical-align: top;">Demote</span> to user</span></a>  
                                    <a v-else :href="'/admin/users/promote/' + item.id" class="notification_settings_link metrics_link" :data-id="item.id" :data-balance="item.balance">
                                    <span class="notification_settings_icon"></span><span><span style="color: #32BA7C; vertical-align: top;">Promote</span> to partner</span></a>
                                    <a @click="DeleteUser(item.id)" class="notification_settings_link contacts_link"><span class="notification_settings_icon"></span><span>Delete user</span></a>
                                </div>

                            </div>
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
            sorted_items(total){
                const items = this.users_list.sort((a,b) => {
                    if(a.search > b.search){return 1}
                    if(a.search < b.search){return -1}
                    return 0
                });

                if (total < this.users_list.length) {
                    this.users_list.reverse();
                } else {
                    this.users_list.reverse();
                }
         
                return items;
            },
            DeleteUser: function(id) {
                console.log('user ' + id); 
                var isDelete = confirm("Are u sure? All data of this user will be deleted permanently!");
                if (isDelete === true) {
                    $('.admin-users-preloader').show();
                    var data = {    
                        'user_id' : id,
                        '_token' : $('meta[name="csrf-token"]').attr('content')
                    };
                    var vm = this;
                    $.post( '/api/users/delete', data, function( result ) {
                        if(result == 'true') {
                            alert('success');         
                            document.location.reload(true);

                        } else {
                            alert('fail');
                            $('.admin-users-preloader').hide();
                        }
                    });
                }
            },
            sortedArray: function() {
              // Set slice() to avoid to generate an infinite loop!
              return this.users_list.slice().sort(function(a, b) {
                return a.position < b.position;
              });
            },
            prevPage: function() {
                if (this.pagination.current_page > 1) {
                    this.pagination.current_page = this.pagination.current_page - 1;
                    this.$parent.paginate(this.pagination.current_page);
                }
            },
            nextPage: function() {
                if (this.pagination.total_page > this.pagination.current_page) {
                    this.pagination.current_page = this.pagination.current_page + 1;
                    this.$parent.paginate(this.pagination.current_page);
                }
            },
            searchFilter: function() {
                var searching = this.search;
                var total     = 0;
                console.log(this.users_list);
                if (searching.trim() != '') {
                    for (index in this.users_list) {
                        //var email = this.users_list[index].email;

                        if(this.users_list[index].email.indexOf(searching) !== -1) {
                            this.users_list[index].search = 1;
                            total++;
                        } else {
                            var matches = 0;
                            for (var index2 in this.users_list[index].domains) {
                                var url = this.users_list[index].domains[index2].url;
                                if(url.indexOf(searching) !== -1) {
                                    this.users_list[index].search = 1;
                                    total++;   
                                    matches = 1;
                                    continue;
                                }
                            }
                                
                            if (matches == 0) {
                                this.users_list[index].search = 0;                                 
                            }
       
                        }
                    }                    
                } else {
                    for (index in this.users_list) {
                        this.users_list[index].search = 1;
                        total++;
                    }             
                }

                this.pagination.total_page = Math.ceil(total / this.pagination.per_page);
                this.sorted_items(total);
                this.$parent.paginate(1);
            },
            paginate: function(page) {
                this.$parent.paginate(page);
            }
	 	},
        mounted() {
 
            console.log(this);
        }
    }
</script>
