<template>

    <form>
        <div class="module_add_row">
            <div class="question">
                <div class="question_icon"></div>
                <div class="question_fon"></div> 
                <div class="question_block_hidden question_block_top2">
                    <div class="c-question_block">
                        <p class="question_block_name">{{ translation['hide-notifications-on-mobile'] }}</p>
                        <p class="question_block_text">{{ translation['toggle-this-option-on-if-you-dont-want-to-show-any-notifications-on-mobile-devices'] }}</p> 
                        <a href="#" class="question_block_ok">{{ translation['got-it'] }}</a>
                    </div>
                </div>
            </div> 
            <label>{{ translation['hide-notifications-on-mobile'] }}</label>
            <div class="check_block" v-if="domain_settings.hide_notifications == 'no'">
                <input type="radio" id="hide_notifications_no" name="hide_notifications" value="no" checked="checked" @click="updateSettings('hide_notifications', 'no')"> 
                <label for="hide_notifications_no" class="check_label">{{ translation.no }}</label> 
                <input type="radio" id="hide_notifications_yes" name="hide_notifications" value="yes" @click="updateSettings('hide_notifications', 'yes')"> 
                <label for="hide_notifications_yes" class="check_label">{{ translation.yes }}</label> 
                <span class="toggle-outside">
                    <span class="toggle-inside"></span>
                </span>
            </div>
            <div class="check_block" v-if="domain_settings.hide_notifications == 'yes'">
                <input type="radio" id="hide_notifications_no" name="hide_notifications" value="no" @click="updateSettings('hide_notifications', 'no')"> 
                <label for="hide_notifications_no" class="check_label">{{ translation.no }}</label> 
                <input type="radio" id="hide_notifications_yes" name="hide_notifications" value="yes" checked="checked" @click="updateSettings('hide_notifications', 'yes')"> 
                <label for="hide_notifications_yes" class="check_label">{{ translation.yes }}</label> 
                <span class="toggle-outside">
                    <span class="toggle-inside"></span>
                </span>
            </div> 
        </div> 
        <div class="module_add_row customize_row">
            <div class="question">
                <div class="question_icon"></div> 
                <div class="question_fon"></div> 
                <div class="question_block_hidden question_block_top2">
                    <div class="c-question_block">
                        <p class="question_block_name">{{ translation['show-on-top-of-page-on-mobile'] }}</p>
                        <p class="question_block_text">{{ translation['choose-position-for-notifications-on-mobile-devices-top-or-bottom'] }}</p> 
                        <a href="#" class="question_block_ok">{{ translation['got-it'] }}</a>
                    </div>
                </div>
            </div> 
            <label>{{ translation['show-on-top-of-page-on-mobile'] }}</label> 
            <div class="check_block" v-if="domain_settings.show_on_top == 'no'">
                <input type="radio" id="show_on_top_no" name="show_on_top" checked="checked" value="no" @click="updateSettings('show_on_top', 'no')">  
                <label for="show_on_top_no" class="check_label">{{ translation.off }}</label> 
                <input type="radio" id="show_on_top_yes" name="show_on_top" value="yes" @click="updateSettings('show_on_top', 'yes')">  
                <label for="show_on_top_yes" class="check_label">{{ translation.on }}</label> 
                <span class="toggle-outside">
                    <span class="toggle-inside"></span>
                </span>
            </div>
            <div class="check_block" v-else-if="domain_settings.show_on_top == 'yes'">
                <input type="radio" id="show_on_top_no" name="show_on_top" value="no" @click="updateSettings('show_on_top', 'no')">  
                <label for="show_on_top_no" class="check_label">{{ translation.off }}</label> 
                <input type="radio" id="show_on_top_yes" name="show_on_top" checked="checked" value="yes" @click="updateSettings('show_on_top', 'yes')">  
                <label for="show_on_top_yes" class="check_label">{{ translation.on }}</label> 
                <span class="toggle-outside">
                    <span class="toggle-inside"></span>
                </span>
            </div>
        </div>
        <div class="module_add_row customize_row">
            <div class="question">
                <div class="question_icon"></div>
                <div class="question_fon"></div> 
                <div class="question_block_hidden question_block_top2">
                    <div class="c-question_block">
                        <p class="question_block_name">{{ translation['position-notifications'] }}</p> 
                        <p class="question_block_text">{{ translation['choose-position-for-notifications-on-desktop-laptops-and-tablet-devices-left-or-right'] }}</p> 
                        <a href="#" class="question_block_ok">{{ translation['got-it'] }}</a>
                    </div>
                </div>
            </div> 
            <label>{{ translation['position-notifications'] }}</label> 
            <div class="check_block" v-if="domain_settings.position == 'off'">
                <input type="radio" id="position_left" name="position" value="off" checked="checked" @click="updateSettings('position', 'off')">   
                <label for="position_left" checked="checked" class="check_label">{{ translation.left }}</label> 
                <input type="radio" id="position_right" name="position" value="on" @click="updateSettings('position', 'on')">   
                <label for="position_right" class="check_label">{{ translation.right }}</label> 
                <span class="toggle-outside">
                    <span class="toggle-inside"></span>
                </span>
            </div>
            <div class="check_block" v-if="domain_settings.position == 'on'">
                <input type="radio" id="position_left" name="position" value="off" @click="updateSettings('position', 'off')">   
                <label for="position_left" checked="checked" class="check_label">{{ translation.left }}</label> 
                <input type="radio" id="position_right" name="position" value="on" checked="checked" @click="updateSettings('position', 'on')">   
                <label for="position_right" class="check_label">{{ translation.right }}</label> 
                <span class="toggle-outside">
                    <span class="toggle-inside"></span>
                </span>
            </div>
        </div> 
        <div class="module_add_row customize_row">
            <div class="question"><div class="question_icon"></div> 
            <div class="question_fon"></div> 
            <div class="question_block_hidden">
                <div class="c-question_block">
                    <p class="question_block_name">{{ translation['set-the-spacing-between-notifications-in'] }}</p> 
                    <p class="question_block_text">{{ translation['setting-the-interval-with-which-notifications-will-be-displayed'] }}</p> 
                    <a href="#" class="question_block_ok">{{ translation['got-it'] }}</a>
                </div>
            </div>
        </div> 
        <label for="spacing_between">
            <span>{{ translation['set-the-spacing-between-notifications-in'] }}</span>
            <input type="number" name="spacing_between" id="spacing_between" placeholder="30" v-model="domain_settings.spacing_between" class="input_small" @change="updateSettings('spacing_between', false)"> 
            <span>{{ translation['seconds'] }}.</span>
        </label>
    </div>      
    <div class="module_add_row customize_row">
      <div class="question">
          <div class="question_icon"></div>
          <div class="question_fon"></div>
          <div class="question_block_hidden">
              <div class="c-question_block">
                  <p class="question_block_name">{{ translation['locale'] }}</p>
                  <p class="question_block_text">{{ translation['this-option-is-designed-to-correctly-translate-time-information'] }}</p>
                  <a class="question_block_ok">{{ translation['got-it'] }}</a> 
              </div>
          </div>
      </div>
      <label for="locale">{{ translation['locale'] }}</label>
      <div class="module_add_row_input">
        <select name="locale" id="locale" v-model="domain_settings.locale" @change="updateSettings('locale', false)">
          <option value="en">{{ translation['english'] }}</option>
          <option value="de">{{ translation['german'] }}</option>     
          <option value="it">{{ translation['italian'] }}</option>     
          <option value="el">{{ translation['greek'] }}</option>     
          <option value="ru">{{ translation['russian'] }}</option>     
          <option value="tr">{{ translation['turkish'] }}</option>     
        </select>
      </div>
    </div>    
</form>

</template>

<script>
 
    export default {
        data () {
            return this.$parent._data;
        },
	 	methods: {
            updateSettings: function(field, value) {

                let data = {    
                    'domain-id' : this.domain_settings.domain_id,
                    'field' : field,
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                };

                if (field == 'hide_notifications' || field == 'show_on_top' || field == 'position') {
                    data.value = value;
                }

                if (field == 'spacing_between') {
                    data.value = this.domain_settings.spacing_between;
                }

                if (field == 'locale') {
                    data.value = this.domain_settings.locale;
                }             

                $.post( '/api/domains/notification/put-settings', data, function( result ) {});
            }  

	 	},
        mounted() {
 
        }
    }
</script>
