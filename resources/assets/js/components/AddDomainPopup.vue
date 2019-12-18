<template>

    <div>
        <div class="add_domain_modal">
            <div class="domain_modal_fon"></div>
            <div class="c-domain_modal">
                <div class="domain_modal_title">{{ translation['new-domain'] }}</div>
                <div class="domain_modal_text">{{ translation['enter-domain-info-about-site-on-which-you-want-to-apply-our-service'] }}</div>
                <transition name="fade">
                    <div class="domain_modal_preloader" v-if="AddDomainPopupShowPreloader == true"></div>
                    <div class="domain_modal_success" v-if="AddDomainPopupShowSuccess == true"><p class="success">{{ translation['domain-successfully-added'] }}</p></div>
                </transition>
                <div class="domain_modal_form">
                    <form>
                        <div class="domain_modal_form_row">
                            <div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">{{ translation['domain-name'] }}</p>
                                        <p class="question_block_text">{{ translation['that-is-how-your-domain-will-show'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <label for="domain_name">{{ translation['domain-name'] }}</label>
                            <input type="text" :placeholder="translation.example +': My landing page'" name="domain-name" id="domain_name">
                        </div>
                        <div class="domain_modal_form_row">
                            <div class="question">
                                <div class="question_icon"></div>
                                <div class="question_fon"></div>
                                <div class="question_block_hidden">
                                    <div class="c-question_block">
                                        <p class="question_block_name">{{ translation['domain-url'] }}</p>
                                        <p class="question_block_text">{{ translation['enter-your-domain-url-without'] }} http:// {{ translation['or'] }} https://. {{ translation['example'] }}: www.trustactivity.com</p>
                                    </div>
                                </div>
                            </div>
                            <label for="domain_url">{{ translation['domain-url'] }}</label>
                            <input type="text" :placeholder="translation.example +':  Thelandingpage.com'" name="domain-url" id="domain_url">
                        </div>
                        <div class="domain_modal_form_row">
                            <div class="question">
                              <div class="question_icon"></div>
                              <div class="question_fon"></div>
                              <div class="question_block_hidden">
                                  <div class="c-question_block">
                                      <p class="question_block_name">{{ translation['locale'] }}</p>
                                      <p class="question_block_text">{{ translation['this-option-is-designed-to-correctly-translate-time-information'] }}</p>
                                      <a class="question_block_ok">{{ translation['got-it'] }}</a>
                                      <a href="/admin/faq/setup-and-adjustments/how-to-launch-your-first-proof-notifications" target="_blank" class="question_block_false">{{ translation['still-confused'] }}</a>
                                  </div>
                              </div>
                            </div>
                            <label for="domain_locale">{{ translation['locale'] }}</label>
                            <div class="module_add_row_input">
                            <select name="domain_locale" id="domain_locale">
                              <option value="en">{{ translation['english'] }}</option>
                              <option value="it">{{ translation['german'] }}</option>     
                              <option value="it">{{ translation['italian'] }}</option>    
                              <option value="el">{{ translation['greek'] }}</option>
                              <option value="ru">{{ translation['russian'] }}</option>      
                              <option value="tr">{{ translation['turkish'] }}</option>                                                    
                            </select>
                            </div>
                        </div>
                        <div class="domain_modal_form_row">
                            <div class="domain_modal_form_btn">
                                <button class="btn" @click="addDomain($event)">{{ translation['add-domain'] }}</button>
                            </div>
                        </div>
                    </form>
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
                getTranslation: function() {

                    let data = {    
                        'page' : 'domain-add',
                        '_token' : $('meta[name="csrf-token"]').attr('content')
                    };

                    var vm = this;      

                    $.post( '/api/translation/get', data, function( result ) {
                        for (var index in result) {
                            vm.translation[index] = result[index];
                        }
                        //setTimeout(function(){ vm.campaignListShowPreloader = false; }, 300);
                    });       
                },
                addDomain: function(e) {
                    e.preventDefault();
                    var vm = this;
                    var d_name = $('#domain_name').val();
                    var d_url  = $('#domain_url').val();
                    var d_locale = $('#domain_locale option:selected').val();

                    var data = {    
                        'locale' : d_locale,
                        'name' : d_name,
                        'url'  : d_url,
                        '_token' : $('meta[name="csrf-token"]').attr('content')
                    }; 

                    this.AddDomainPopupShowPreloader = true;
 
                    $.post( '/api/domains/add', data, function( result ) {
                        setTimeout(function(){
                            $('.domain_modal_form input').removeClass('error');
                            $('.domain_modal_form .error_icon').remove();                          
                            if (result.success) {
                                vm.AddDomainPopupShowSuccess = true;
                                setTimeout(function(){ window.location.replace("/admin/domains/" + result.domain_id); }, 1000);
                            } else if (result.errors) {
                                console.log(result.errors);
                                for(var index in result.errors) {
                                    $('.domain_modal_form input[name="domain-' + index + '"]').addClass('error');
                                    $('.domain_modal_form input[name="domain-' + index + '"]').after('<span class="error_icon"></span>');
                                }
                            } else {
                                alert('something went wrong. try later.')
                            }
                             vm.AddDomainPopupShowPreloader = false;
                        }, 300);
                    });
                    return false;
                }
	 	},
        mounted() {

            this.getTranslation();

            $(document).on('click', '.add_domain button', function(){
               $('.add_domain_modal').addClass('show_modal');
                this.AddDomainPopupShowSuccess   = false; 
                this.AddDomainPopupShowPreloader = false;
               return false;
            });
        }
    }
</script>
