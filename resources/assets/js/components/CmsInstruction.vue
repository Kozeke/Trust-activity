<template>

    <div class="metrics_block" v-bind:class="{ show_instruction: show_instruction }">
        <div class="metrics_block_fon" @click="hideInstruction()"></div>
        <div class="c-metrics_block">
                <p class="mini-title">{{ instructionTitle }}</p>
                <h1>{{ instructionDescription }}</h1>     
                <div class="guide_step_desc" v-html="instructionContent"></div>
                <transition name="fade">
                    <div class="preloader" v-if="instructionPreloader">
                        <div class="domain_modal_preloader"></div>
                    </div>
                </transition>
        </div>
    </div>

</template>

<script>
    export default {
		data () {
			return this.$parent._data;
		},
	 	methods: {
            showInsctruction: function() {

                let vm = this;
                // get current cms mode on
                let type = $('.w-platform-item.active').data('type');      
                // prepare data for request
                let data = {    
                    'type' : type,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };
                // posting data
                $.post( '/api/domains/get-instruction', data, function( result ) {

                    setTimeout(function() { 
                        vm.instructionTitle       = result.article.title;
                        vm.instructionDescription = result.article.description ;             
                        vm.instructionContent     = result.article.content;
                        vm.instructionPreloader   = false;
                     }, 300);
                });
                // show block
                this.show_instruction = true;
                $("body,html").addClass("overflow");
            },
            hideInstruction: function() {

                this.instructionTitle       = '';
                this.instructionDescription = '';
                this.instructionContent     = '';
                this.show_instruction = false;
                $("body,html").removeClass("overflow");
                this.instructionPreloader   = true;
            }
	 	},
        mounted() {
            let vm = this;
            $(document).on('click', '#show_instruction', function(){
                vm.showInsctruction();
                console.log('click');
            });

            var checkInstall = setInterval(function() {
                // prepare data for request
                let data = {    
                    'id' : document.getElementById('domain_id').value,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };
                // posting data
                $.post( '/api/domains/isInstalled', data, function( result ) {
                    if (result.status == true) {
                        $('.w-platform-loading').addClass('success');
                        setTimeout(function() {
                            document.location.href="/admin/domains/"+document.getElementById('domain_id').value;
                        }, 10000);
                    }
                });

            }, 5000);

        }
    }
</script>
