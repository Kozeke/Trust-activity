<template>
    <div>
        <div class="admin_header">
            <div class="admin_title">
                <h1>Payment history</h1>
            </div>
        </div>
        <div class="admin_breadcrumbs">
            <ul class="breadcrumbs_list">
                <li class="breadcrumbs_item"><a href="/admin/payment-history/" class="breadcrumbs_link">Payment history</a></li>
            </ul>
        </div>
        <div class="admin_content">
            <div class="container admin_container">
                <div class="add-module-tab active">
                    <div class="">
                        <div class="col-lg-12">
                            <div class="domain_list_search">
                                <form method="get" action="/admin/payment-history">
                                    <input type="search" name="search" placeholder="Type to search..." v-model="search_text" style="margin-bottom: 10px;">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <datepicker v-model="start_date" :format="customFormatterStartDate"></datepicker>
                                        <span class="input-group-addon">to</span>
                                        <datepicker v-model="end_date" :format="customFormatterEndDate"></datepicker>

                                    </div>
                                    <select v-model="status" name="status" style="font-size: 14px; margin-top: 10px;">
                                        <option value="">All</option>
                                        <option value="success" >Success</option>
                                        <option value="failed" >Failed</option>
                                    </select>
                                    <select v-model="method" name="status" style="font-size: 14px; margin-top: 10px;">
                                        <option value="">All</option>
                                        <option value="paypal" >paypal</option>
                                        <option value="2checkout" >2checkout</option>
                                        <option value="promo-code" >promo-code</option>
                                    </select>
                                    <input @click.prevent="getHistory" class="btn search-submit" value="Search">
                                    <a href="/admin/payment-history" class="btn search-submit" style="display: inline-block;">Clean</a>
                                </form>
                            </div>
                            <div style="position:relative;right:1px">
                                <div class="pagination contacts_pagination">

                                    <ul v-if="pagination.last_page > 0">
                                        <li class="pagination_item" v-if="1 <= pagination.current_page - 1"><a href="#" class="pagination_link" @click="getHistory(pagination.current_page-1)" ><</a></li>
                                        <!--<li class="pagination_item" v-for="pages in pagination.last_page"><a href="#" v-bind:class="{ active: pagination.current_page === pages }"  class="pagination_link" :data-id="pages" @click="getHistory(pages)" >{{ pages }}</a></li>-->
                                        <li class="pagination_item" v-if="1 <= pagination.current_page - 3"><a href="#" v-bind:class="{ active: pagination.current_page === 1 }"  class="pagination_link" :data-id="1" @click="getHistory(1)" >1</a></li>

                                        <li class="pagination_item" v-if="1 <= pagination.current_page - 4"><a href="#" class="pagination_link">...</a></li>

                                        <li class="pagination_item" v-if="1 <= pagination.current_page - 2"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page - 2 }"  class="pagination_link" :data-id="pagination.current_page - 2" @click="getHistory(pagination.current_page - 2)" >{{ pagination.current_page - 2 }}</a></li>

                                        <li class="pagination_item" v-if="1 <= pagination.current_page - 1"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page - 1 }"  class="pagination_link" :data-id="pagination.current_page - 1" @click="getHistory(pagination.current_page - 1)" >{{ pagination.current_page - 1 }}</a></li>

                                        <li class="pagination_item"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page }"  class="pagination_link" :data-id="pagination.current_page" @click="getHistory(pagination.current_page)" >{{ pagination.current_page }}</a></li>

                                        <li class="pagination_item" v-if="pagination.last_page >= pagination.current_page + 1"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page + 1 }"  class="pagination_link" :data-id="pagination.current_page + 1" @click="getHistory(pagination.current_page + 1)" >{{ pagination.current_page + 1 }}</a></li>

                                        <li class="pagination_item" v-if="pagination.last_page >= pagination.current_page + 2"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.current_page + 2 }"  class="pagination_link" :data-id="pagination.current_page + 2" @click="getHistory(pagination.current_page + 2)" >{{ pagination.current_page + 2 }}</a></li>

                                        <li class="pagination_item" v-if="pagination.last_page >= pagination.current_page + 4"><a href="#" class="pagination_link">...</a></li>

                                        <li class="pagination_item" v-if="pagination.last_page >= pagination.current_page + 3"><a href="#" v-bind:class="{ active: pagination.current_page === pagination.last_page }"  class="pagination_link" :data-id="pagination.last_page" @click="getHistory(pagination.last_page)" >{{ pagination.last_page }}</a></li>

                                        <li class="pagination_item" v-if="pagination.last_page >= pagination.current_page + 1"><a href="#" class="pagination_link" @click="getHistory(pagination.current_page+1)">></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="notification_tabs">
                                <div class="notification_tabs_content active invoices-tab">
                                    <h2>Invoices history</h2>
                                    <div class="payment_block_list_head invoices" style="margin-bottom: 30px;">

                                        <p class="payment_left" >Operation</p>
                                        <p class="payment_center" style="width: 20%;" >User</p>
                                        <p class="payment_center" style="width: 15%">Date</p>
                                        <p class="payment_center" style="width: 15%">Amount</p>
                                        <p class="payment_right"  style="width: 10%; text-align: left;">Status</p>
                                    </div>
                                    <div class="payment_block_list invoices">
                                        <div class="payment_block_list_item" style="padding: 10px 0; background-color: #F6F9FD;"  v-for="payment in payments" :key="payment.id">
                                            <p v-if="payment.method=='promo-code'" class="payment_amount payment_left" style="line-height: 24px; padding-left: 45px; ">
                                            <i v-if="payment.status=='failed'" class="balance-fail-icon" style="left: 10px; margin-top: 1px;"></i>
                                            <i v-else class="balance-down-icon" style="left: 10px; margin-top: 1px;"></i>
                                                {{payment.type}}</p>
                                            <p v-if="payment.method=='admin-add'" class="payment_amount payment_left" style="line-height: 24px; padding-left: 45px;">
                                                <i v-if="payment.status=='failed'" class="balance-fail-icon" style="left: 10px; margin-top: 1px;"></i>
                                                <i v-else class="balance-up-icon" style="left: 10px; margin-top: 1px;"></i>Manually
                                            </p>
                                            <p v-if="payment.method=='admin-remove'" class="payment_amount payment_left" style="line-height: 24px; padding-left: 45px;">
                                                <i v-if="payment.status=='failed'" class="balance-fail-icon" style="left: 10px; margin-top: 1px;"></i>
                                                <i v-else class="balance-down-icon" style="left: 10px; margin-top: 1px;"></i>Manually
                                            </p>
                                            <p v-if="!payment.method"  class="payment_amount payment_left" style="line-height: 24px; padding-left: 45px; " >
                                                <i v-if="payment.status=='failed'" class="balance-fail-icon" style="left: 10px; margin-top: 1px;"></i>
                                                <i v-else class="balance-down-icon" style="left: 10px; "></i>
                                                {{payment.domain_id}}:{{payment.domain_name}}-{{payment.module_name}} {{payment.module_plan_name}}
                                            </p>
                                            <p v-if="payment.type=='top up'" class="payment_amount payment_left" style="line-height: 24px; padding-left: 45px; ">
                                                <i v-if="payment.status=='failed'" class="balance-fail-icon" style="left: 10px; margin-top: 1px;"></i>
                                                <i v-else class="balance-down-icon" style="left: 10px; margin-top: 1px;"></i>
                                                {{payment.type}} Balance</p>
                                            <p class="payment_amount payment_center" style="width: 20%; word-break: break-all;">{{payment.email}}</p>
                                            <p class="payment_amount payment_center" style="width: 15%;">{{payment.date}}</p>
                                            <p v-if="payment.type!=null&&payment.status=='failed'&&payment.type!='admin-add'" class="payment_amount payment_center red" style="width: 15%;"> - ${{payment.amount}}</p>
                                            <p v-if="payment.type!=null&&payment.status=='failed'&&payment.type=='admin-add'" class="payment_amount payment_center green" style="width: 15%;"> + ${{payment.amount}}</p>

                                            <p v-if="payment.type!=null&&payment.status!='failed'&&payment.type!='admin-add'&&payment.bonus>0" class="payment_amount payment_center green" style="width: 15%;"> + ${{payment.amount}}+bonus ${{payment.bonus}}</p>
                                            <p v-if="payment.type!=null&&payment.status!='failed'&&payment.bonus==0&&payment.type!='admin-add'" class="payment_amount payment_center green" style="width: 15%;"> + ${{payment.amount}}</p>
                                            <p v-if="payment.type!=null&&payment.bonus==0&&payment.type=='admin-add'" class="payment_amount payment_center green" style="width: 15%;"> + ${{payment.amount}}</p>
                                            <p v-if="payment.type==null" class="payment_amount payment_center red" style="width: 15%;"> - ${{payment.module_plan_price}}</p>
                                            <p v-if="payment.status!=1&&payment.status!=0" class="payment_status payment_right grey" style="width: 10%; text-align: left;">{{ payment.status }}</p>
                                            <p v-if="payment.status==0" class="payment_status payment_right grey" style="width: 10%; text-align: left;">failed</p>

                                            <p  v-if="payment.status==1" class="payment_status payment_right grey" style="width: 10%; text-align: left;">success</p>
                                        </div>
                                    </div>
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

    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';
    export default {
        components: {
            Datepicker
        },
        data () {
            return{
                payments:[],
                pagination:{},
                search_text:"",
                start_date:"",
                end_date:"",
                status:"",
                method:""
            }
        },
        methods:{
            customFormatterStartDate(date) {
                var date= moment(date).format('YYYY.MM.DD');
                this.start_date=date;
                return date;
            },
            customFormatterEndDate(date) {
                var date= moment(date).format('YYYY.MM.DD');
                this.end_date=date;
                return date;
            },
            getHistory(page){
                axios.get("/api/payment_history",{
                    params:{
                        page: page,
                        search_text:this.search_text,
                        start:this.start_date,
                        end:this.end_date,
                        status:this.status,
                        method:this.method
                    }
                }).then(response=>{
                    this.payments=response.data.data;
                    let pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        next_page_url: response.data.next_page_url,
                        prev_page_url: response.data.prev_page_url
                    };
                    this.pagination = pagination;
                }).catch(e=>{
                    console.log(e);
                })
            }
        },
        mounted() {
            this.getHistory();
        }
    }

</script>
<style>

</style>