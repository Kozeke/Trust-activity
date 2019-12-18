<template>
    <main>
        <transition name="fade">
            <div class="notification_preloader" v-show="ShowPreloader == true"></div>
        </transition>
        <header>
            <div class="header_item header_left">
                <a href="#" class="back_to_admin" @click="back()">
                    <span></span>
                    <span>Back to admin panel</span>
                </a>
            </div>
            <div class="header_item header_center">
                <div class="header_title">
                    <p class="header_title_logo">
                        <span></span>
                        <span>Jump Out Designer</span>
                    </p>
                    <p class="header_title_line">/</p>
                    <p class="jump_out_name">{{ company_name }}</p>
                </div>
            </div>
            <div class="header_item header_right">
                <div class="done_link">
                    <a href="#" class="save_templates" @click="saveTemplate()">
                        <span></span>
                        <span>Save to templates</span>
                    </a>
                </div>
                <div class="done_link">
                    <a href="#" class="finish_creating" @click="finish()">Finish Creating</a>
                </div>
            </div>
        </header>
        <div class="elements_block">
            <div class="jump_out_tabs">
                <ul class="jump_out_tabs_list">
                    <li class="jump_out_tabs_item jump_out_pop_up active" data-type="pop_up" @click="changeMode('pop_up')">
                        <span class="jump_out_tabs_icon"></span>
                        <span>Create</span>
                    </li>
                    <li class="jump_out_tabs_item jump_out_templates" data-type="templates" @click="changeMode('templates')">
                        <span class="jump_out_tabs_icon"></span>
                        <span>Start with preset</span>
                    </li>
                    <li class="jump_out_tabs_item jump_out_blocks" data-type="blocks" @click="changeMode('blocks')">
                        <span class="jump_out_tabs_icon"></span>
                        <span>Blocks</span>
                    </li>
                </ul>
                <div class="jump_out_tabs_content elements_pop_up active">
                    <div class="jump_out_elements_item">
                        <div class="elements_title">Style</div>
                        <div class="choose_pop_up">
                            <div class="item_pop_up small_pop_up active" id="small_pop_up" @click="setStyle('small_pop_up')">
                                <div class="c-item_pop_up">
                                    <div class="img_pop_up"></div>
                                </div>
                                <div class="item_pop_up_name">Small</div>
                            </div>
                            <div class="item_pop_up medium_pop_up" id="medium_pop_up" @click="setStyle('medium_pop_up')">
                                <div class="c-item_pop_up">
                                    <div class="img_pop_up"></div>
                                </div>
                                <div class="item_pop_up_name">Medium</div>
                            </div>
                            <div class="item_pop_up large_pop_up" id="large_pop_up" @click="setStyle('large_pop_up')">
                                <div class="c-item_pop_up">
                                    <div class="img_pop_up"></div>
                                </div>
                                <div class="item_pop_up_name">Large</div>
                            </div>
                            <div class="item_pop_up f_w_pop_up" id="f_w_pop_up" @click="setStyle('f_w_pop_up')">
                                <div class="c-item_pop_up">
                                    <div class="img_pop_up"></div>
                                </div>
                                <div class="item_pop_up_name">Full width</div>
                            </div>
                            <div class="item_pop_up f_h_pop_up" id="f_h_pop_up" @click="setStyle('f_h_pop_up')">
                                <div class="c-item_pop_up">
                                    <div class="img_pop_up"></div>
                                </div>
                                <div class="item_pop_up_name">Full height</div>
                            </div>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">Overlay</div>
                        <div class="choose_overlay">
                            <form class="overlay_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_overlay" id="choose_color_overlay">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>              
                    <div class="jump_out_elements_item">
                        <div class="elements_title">closing</div>
                        <div class="closing_item">
                            <div class="closing_item_name">Display closing button</div>
                            <div class="closing_item_toggle">
                                <input type="checkbox" id="closing_button" v-model="closeButton">
                                <label for="closing_button">
                                    <span class="closing_toggle_on">ON</span>
                                    <span class="closing_toggle_off">OFF</span>
                                </label>
                            </div>
                        </div>
                        <div class="closing_item">
                            <div class="closing_item_name">Close when overlay is clicked</div>
                            <div class="closing_item_toggle">
                                <input type="checkbox" id="closing_overlay" v-model="closeOnOverlay">
                                <label for="closing_overlay">
                                    <span class="closing_toggle_on">ON</span>
                                    <span class="closing_toggle_off">OFF</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jump_out_tabs_content elements_templates">
                    <div class="jump_out_elements_item">
                        <div class="elements_title">templates</div>
                        <div v-for="(template, index) in gallery" class="gallery-template"> 
                            <h2>Template {{ index + 1 }}</h2>
                            <div class="gallery-element">
                                <template v-for="elem in template.elements">
                                    <div  :class="'gallery-element-block ' + elem.id_name" v-bind:style="{ 
                                        fontFamily: elem.styles.font_type,
                                        fontWeight: elem.styles.font_weigth,
                                        color: elem.styles.font_color,
                                        backgroundColor: elem.styles.background_color,
                                        border: elem.styles.border_size + 'px solid ' + elem.styles.border_color,
                                        borderRadius: elem.styles.border_radius,
                                        boxShadow: elem.styles.shadow_color + ' 0px 0px ' + elem.styles.shadow_size + 'px 0px'
                                    }">{{ elem.name }}</div>
                                </template>
                                <div class="gallery-element-hover" @click="setTemplate(index)"><p>Select</p></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jump_out_tabs_content elements_blocks">
                    <div class="jump_out_elements_item">
                        <div class="elements_title">drag & drop blocks into your pop up</div>
                        <div class="choose_blocks">
                        <draggable
                            class="dragArea list-group"
                            :list="list1"
                            :clone="cloneDog"
                            :group="{ name: 'people', pull: 'clone', put: false }"
                            @change="log"
                        >
                        <template v-for="(element, index) in list1">

                            <div class="item_blocks title_blocks active" :id="element.id_name" :key="index" v-if="index == 0" @click="selectElement(index)">
                                <div class="c-item_blocks">
                                    <div class="img_item_blocks"></div>
                                </div>
                                <div class="item_pop_up_name">{{ element.name }}</div>
                            </div>

                            <div class="item_blocks title_blocks" :id="element.id_name" :key="index" v-else @click="selectElement(index)">
                                <div class="c-item_blocks">
                                    <div class="img_item_blocks"></div>
                                </div>
                                <div class="item_pop_up_name">{{ element.name }}</div>
                            </div>

                        </template>
                        </draggable>
                            <!--<div class="item_blocks title_blocks" id="jump_out_title">
                                <div class="c-item_blocks">
                                    <div class="img_item_blocks"></div>
                                </div>
                                <div class="item_pop_up_name">Title</div>
                            </div>
                            <div class="item_blocks text_blocks" id="jump_out_text">
                                <div class="c-item_blocks">
                                    <div class="img_item_blocks"></div>
                                </div>
                                <div class="item_pop_up_name">Text</div>
                            </div>
                            <div class="item_blocks button_blocks" id="jump_out_button">
                                <div class="c-item_blocks">
                                    <div class="img_item_blocks"></div>
                                </div>
                                <div class="item_pop_up_name">Button</div>
                            </div>
                            <div class="item_blocks img_blocks" id="jump_out_img">
                                <div class="c-item_blocks">
                                    <div class="img_item_blocks"></div>
                                </div>
                                <div class="item_pop_up_name">Image</div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="redactor_block" v-bind:style="{
            backgroundColor: popup_overlay
        }">
            <div class="redactor_canvas" id="box" data-sc="#FFFFFF"

                v-bind:style="{ 
                    backgroundImage: 'url(' + background_image + ')',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center center',
                    backgroundColor: popup_background,
                    borderColor: popup_border,
                    borderWidth: border_size_count,
                    borderRadius: border_size_radius,
                    boxShadow: popup_shadow + ' 0px 0px ' + shadow_size_count + 'px 0px'
                    }"
            > 
                <a href="#" class="jumpout-close-btn" v-if="closeButton"></a>
                <div class="show_size_canvas">
                    <div class="width_size_canvas">W: <span class="width_size_count"></span> <span class="width_size_units"></span></div>
                    <div class="height_size_canvas">H: <span class="height_size_count"></span> <span class="height_size_units"></span></div>
                </div>
                <div class="redactor_start_screen" ref="listGroup">
                  <draggable
                    class="dragArea list-group"
                    :list="list2"
                    group="people"
                    @change="log"
                  >
                    <div
                        @click="setActive"
                        :class="element.id_name + ' list-group-item ' + is_disabled"
                        v-for="(element, index) in list2"
                        :key="index"
                        v-bind:style="{ 
                            fontFamily: element.styles.font_type,
                            fontWeight: element.styles.font_weigth,
                            color: element.styles.font_color,
                            backgroundColor: element.styles.background_color,
                            border: element.styles.border_size + 'px solid ' + element.styles.border_color,
                            borderRadius: element.styles.border_radius,
                            boxShadow: element.styles.shadow_color + ' 0px 0px ' + element.styles.shadow_size + 'px 0px'
                        }"

 
                    >
                        <div class="popup"><span class="edit" @click="editElement(index)" :data-name="element.id_name"><i></i>Edit</span><span class="delete" @click="removeElement(index)">X</span></div>
                      {{ element.name }}
                    </div> 
                  </draggable>
                    <!--<div class="redactor_start_icon"></div>
                    <div class="redactor_start_title">Drag & Drop</div>
                    <div class="redactor_start_text">blocks from the left <br />or choose from templates</div>-->
                </div>
            </div>
        </div>
        <div class="setting_block">
            <!--<div class="setting_edit">
                <div class="ctrlZ">
                    <a href="#"></a>
                </div>
                <div class="ctrlY">
                    <a href="#"></a>
                </div>
                <div class="preview">
                    <a href="#">
                        <span></span>
                        <span>Preview</span>
                    </a>
                </div>
            </div>-->
            <div class="setting_elements setting_pop_up active">
                <div class="setting_item">
                    <div class="elements_title">Position</div>
                    <div class="choose_position square active">
                        <div class="position_item position_tl" id="position_tl" @click="positionBox('left-top')" :class="{ 'active' : popup_position == 'left-top'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_tc" id="position_tc" @click="positionBox('center-top')" :class="{ 'active' : popup_position == 'center-top'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_tr" id="position_tr" @click="positionBox('right-top')" :class="{ 'active' : popup_position == 'right-top'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_cl" id="position_cl" @click="positionBox('left-mid')" :class="{ 'active' : popup_position == 'left-mid'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_cc" id="position_cc" @click="positionBox('center-mid')" :class="{ 'active' : popup_position == 'center-mid'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_cr" id="position_cr" @click="positionBox('right-mid')" :class="{ 'active' : popup_position == 'right-mid'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_bl" id="position_bl" @click="positionBox('left-bot')" :class="{ 'active' : popup_position == 'left-bot'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_bc" id="position_bc" @click="positionBox('center-bot')" :class="{ 'active' : popup_position == 'center-bot'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_br" id="position_br" @click="positionBox('right-bot')" :class="{ 'active' : popup_position == 'right-bot'}">
                            <div class="position_img"></div>
                        </div>
                    </div>
                    <div class="choose_position full_width">
                        <div class="position_item position_tc" id="position_tc" @click="positionBox('center-top')" :class="{ 'active' : popup_position == 'center-top'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_bc" id="position_bc" @click="positionBox('center-bot')" :class="{ 'active' : popup_position == 'center-bot'}">
                            <div class="position_img"></div>
                        </div>
                    </div>
                    <div class="choose_position full_height">
                        <div class="position_item position_cl" id="position_cl" @click="positionBox('left-mid')" :class="{ 'active' : popup_position == 'left-mid'}">
                            <div class="position_img"></div>
                        </div>
                        <div class="position_item position_cr" id="position_cr" @click="positionBox('right-mid')" :class="{ 'active' : popup_position == 'right-mid'}">
                            <div class="position_img"></div>
                        </div>
                    </div>        
                </div>
                <div class="setting_item">
                    <div class="elements_title">background</div>
                    <div class="choose_background">
                        <form class="background_form">
                            <div class="background_form_row">
                                <div class="choose_color choose_color_background" id="choose_color_background">
                                    <div class="show_choose_color"></div>
                                </div>
                            </div> 
                            <div class="background_form_row" id="background_image">
                                <div class="c-background_image">
                                    <img src="/img/labradodel.png" alt="">
                                </div>
                                <div class="background_image_name">labradoodle.jpg</div>
                                <div class="background_image_delete"></div>
                            </div>
                            <div class="background_form_row">
                                <div class="upload_image">
                                    <input type="file" id="upload_image_11" name="upload_image" ref="myFiles" @change="readURL()">
                                    <label for="upload_image_11">
                                        <span class="upload_image_icon"></span>
                                        <span class="upload_image_text">Upload image</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="setting_item">
                    <div class="elements_title">Border</div>
                    <div class="choose_border">
                        <form class="border_form">
                            <div class="background_form_row">
                                <div class="choose_color choose_color_border" id="choose_color_border">
                                    <div class="show_choose_color"></div>
                                </div>
                            </div>
                            <div class="background_form_row">
                                <div class="border_size">
                                    <div class="border_name">Size (px):</div>
                                    <div class="border_size_setting">
                                        <div class="border_size_input">
                                            <input type="text" id="border_size_count" value="0" v-model="border_size_count">
                                        </div>
                                        <div class="size_block" id="border_size_choose">
                                            <span></span>
                                            <ul class="size_list" id="border_size_list" data-model="border_size_count">
                                                <li>0</li>
                                                <li>1</li>
                                                <li>2</li>
                                                <li>3</li>
                                                <li>4</li>
                                                <li>5</li>
                                                <li>10</li>
                                                <li>20</li>
                                                <li>40</li>
                                                <li>80</li>
                                                <li>160</li>
                                                <li>240</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="background_form_row">
                                <div class="border_radius">
                                    <div class="border_name">Corner radius (px):</div>
                                    <div class="border_size_setting">
                                        <div class="border_size_input">
                                            <input type="text" id="border_radius_count" value="0" v-model="border_size_radius">
                                        </div>
                                        <div class="size_block" id="border_radius_choose">
                                            <span></span>
                                            <ul class="size_list" id="border_radius_list" data-model="border_size_radius">
                                                <li>0</li>
                                                <li>1</li>
                                                <li>2</li>
                                                <li>3</li>
                                                <li>4</li>
                                                <li>5</li>
                                                <li>10</li>
                                                <li>20</li>
                                                <li>40</li>
                                                <li>80</li>
                                                <li>160</li>
                                                <li>240</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="setting_item">
                    <div class="elements_title">shadow</div>
                    <div class="choose_shadow">
                        <form class="shadow_form">
                            <div class="background_form_row">
                                <div class="choose_color choose_color_shadow" id="choose_color_shadow">
                                    <div class="show_choose_color"></div>
                                </div>
                            </div>
                            <div class="background_form_row">
                                <div class="border_size">
                                    <div class="border_name">Size (px):</div>
                                    <div class="border_size_setting">
                                        <div class="border_size_input">
                                            <input type="text" id="border_size_count" value="20" v-model="shadow_size_count">
                                        </div>
                                        <div class="size_block" id="border_size_choose">
                                            <span></span>
                                            <ul class="size_list" id="border_size_list" data-model="shadow_size_count"> 
                                                <li class="active">0</li>
                                                <li>1</li>
                                                <li>2</li>
                                                <li>3</li>
                                                <li>4</li>
                                                <li>5</li>
                                                <li>10</li>
                                                <li>20</li>
                                                <li>40</li>
                                                <li>80</li>
                                                <li>160</li>
                                                <li>240</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="setting_elements setting_templates"></div>
            <div class="setting_elements setting_blocks">
                <div class="setting_blocks_item setting_blocks_title" id="setting_blocks_title" data-element="jump_out_title" v-if="mode == 'add'">
                    <div class="setting_item">
                        <div class="elements_title">Text</div>
                        <div class="jump_out_title">
                            <form class="jump_out_title_form">
                                <div class="background_form_row">
                                    <input type="text" value="Sample Title" id="setting_blocks_title--text">
                                </div>
                                <div class="background_form_row">
                                   <select class="selectbox choose_ff" name="setting_blocks_title--font">
                                       <option>Lato</option>
                                       <option>Arial</option>
                                       <option>Times New Roman</option>
                                   </select>
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_fw" name="setting_blocks_title--weight">
                                        <option>Normal</option>
                                        <option>Medium</option>
                                        <option>Bold</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_title--color">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="setting_blocks_item setting_blocks_title" id="setting_blocks_title" data-element="jump_out_title" v-else="mode == 'edit'">
                    <div class="setting_item">
                        <div class="elements_title">Text</div>
                        <div class="jump_out_title">
                            <form class="jump_out_title_form">
                                <div class="background_form_row">
                                    <input type="text" id="setting_blocks_title--text" v-model="edit_object.name">
                                </div>
                                <div class="background_form_row">
                                   <select class="selectbox choose_ff" name="setting_blocks_title--font" v-model="edit_object.styles.font_type">
                                       <option value="Lato">Lato</option>
                                       <option value="Arial">Arial</option>
                                       <option value="Times New Roman">Times New Roman</option>
                                   </select>
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_fw" name="setting_blocks_title--weight" v-model="edit_object.styles.font_weigth">
                                        <option value="Normal">Normal</option> 
                                        <option value="Medium">Medium</option>
                                        <option value="Bold">Bold</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_title--color">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="setting_blocks_item setting_blocks_text" id="setting_blocks_text" data-element="jump_out_text" v-if="mode == 'add'">
                    <div class="setting_item">
                        <div class="elements_title">Text</div>
                        <div class="jump_out_ext">
                            <form class="jump_out_text_form">
                                <div class="background_form_row">
                                    <input type="text" value="Sample Text" id="setting_blocks_text--text">
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_ff" name="setting_blocks_text--font">
                                        <option>Lato</option> 
                                        <option>Arial</option>
                                        <option>Times New Roman</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_fw" name="setting_blocks_text--weight">
                                        <option>Normal</option>
                                        <option>Medium</option>
                                        <option>Bold</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_text--color">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="setting_blocks_item setting_blocks_text" id="setting_blocks_text" data-element="jump_out_text" v-else="mode == 'edit'">
                    <div class="setting_item">
                        <div class="elements_title">Text</div>
                        <div class="jump_out_ext">
                            <form class="jump_out_text_form">
                                <div class="background_form_row">
                                    <input type="text" id="setting_blocks_text--text" v-model="edit_object.name">
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_ff" name="setting_blocks_text--font" v-model="edit_object.styles.font_type">
                                       <option value="Lato">Lato</option>
                                       <option value="Arial">Arial</option>
                                       <option value="Times New Roman">Times New Roman</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_fw" name="setting_blocks_text--weight" v-model="edit_object.styles.font_weigth">
                                        <option value="Normal">Normal</option> 
                                        <option value="Medium">Medium</option>
                                        <option value="Bold">Bold</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_text--color">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
 
                <div class="setting_blocks_item setting_blocks_button" id="setting_blocks_button" data-element="jump_out_button" v-if="mode == 'add'">
                    <div class="setting_item">
                        <div class="elements_title">Text</div>
                        <div class="jump_out_text_button">
                            <form class="jump_out_text_button_form">
                                <div class="background_form_row">
                                    <input type="text" value="Button Text" name="setting_blocks_button--text">
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_ff" id="ff_button" name="setting_blocks_button--font">
                                        <option>Lato</option>
                                        <option>Arial</option>
                                        <option>Times New Roman</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_fw" id="fw_button" name="setting_blocks_button--weight">
                                        <option>Normal</option>
                                        <option>Medium</option>
                                        <option>Bold</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_button--color">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">Link</div>
                        <div class="jump_out_text_button">
                            <form class="jump_out_text_button_form">
                                <div class="background_form_row">
                                    <input type="text" value="Button Link" name="setting_blocks_button--link">
                                </div>
                            </form>
                        </div>
                    </div>          
                    <div class="setting_item">
                        <div class="elements_title">background</div>
                        <div class="jump_out_bg_button"> 
                            <form class="jump_out_bg_button_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_button--background">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">Border</div>
                        <div class="jump_out_border_button">
                            <form class="jump_out_border_button_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_border" id="setting_blocks_button--bcolor">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_size">
                                        <div class="border_name">Size (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="setting_blocks_button--bsize" value="0" v-model="new_button_border_size">
                                            </div>
                                            <div class="size_block" id="border_size_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_size_list" data-model="new_button_border_size">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_radius"> 
                                        <div class="border_name">Corner radius (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="setting_blocks_button--bradius" value="0" v-model="new_button_corner_radius">
                                            </div>
                                            <div class="size_block" id="border_radius_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_radius_list" data-model="new_button_corner_radius">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">shadow</div>
                        <div class="jump_out_shadow_button">
                            <form class="jump_out_shadow_button_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_shadow" id="setting_blocks_button--scolor">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_size">
                                        <div class="border_name">Size (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="setting_blocks_button--ssize" value="0" v-model="new_button_shadow_size">
                                            </div>
                                            <div class="size_block" id="border_size_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_size_list" data-model="new_button_shadow_size">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="setting_blocks_item setting_blocks_button" id="setting_blocks_button" data-element="jump_out_button" v-if="mode == 'edit'">
                    <div class="setting_item">
                        <div class="elements_title">Text</div>
                        <div class="jump_out_text_button">
                            <form class="jump_out_text_button_form">
                                <div class="background_form_row">
                                    <input type="text"  name="setting_blocks_button--text"  v-model="edit_object.name">
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_ff" id="ff_button" name="setting_blocks_button--font" v-model="edit_object.styles.font_type">
                                       <option value="Lato">Lato</option>
                                       <option value="Arial">Arial</option>
                                       <option value="Times New Roman">Times New Roman</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <select class="selectbox choose_fw" id="fw_button" name="setting_blocks_button--weight" v-model="edit_object.styles.font_weigth">
                                        <option value="Normal">Normal</option> 
                                        <option value="Medium">Medium</option>
                                        <option value="Bold">Bold</option>
                                    </select>
                                </div>
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_button--color">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">Link</div>
                        <div class="jump_out_text_button">
                            <form class="jump_out_text_button_form">
                                <div class="background_form_row">
                                    <input type="text" value="Button Link" name="setting_blocks_button--link" v-model="edit_object.link">
                                </div>
                            </form>
                        </div>
                    </div>    
                    <div class="setting_item">
                        <div class="elements_title">background</div>
                        <div class="jump_out_bg_button"> 
                            <form class="jump_out_bg_button_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_background" id="setting_blocks_button--background">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">Border</div>
                        <div class="jump_out_border_button">
                            <form class="jump_out_border_button_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_border" id="setting_blocks_button--bcolor">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_size">
                                        <div class="border_name">Size (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="setting_blocks_button--bsize" value="0">
                                            </div>
                                            <div class="size_block" id="border_size_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_size_list">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_radius">
                                        <div class="border_name">Corner radius (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="setting_blocks_button--bradius" value="0">
                                            </div>
                                            <div class="size_block" id="border_radius_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_radius_list">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">shadow</div>
                        <div class="jump_out_shadow_button">
                            <form class="jump_out_shadow_button_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_shadow" id="setting_blocks_button--scolor">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_size">
                                        <div class="border_name">Size (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="setting_blocks_button--ssize" value="0">
                                            </div>
                                            <div class="size_block" id="border_size_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_size_list">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="setting_blocks_item setting_blocks_img" id="setting_blocks_img" data-element="jump_out_img">
                    <div class="setting_item">
                        <div class="elements_title">image</div>
                        <div class="jump_out_img">
                            <form class="jump_out_img_form">
                                <div class="background_form_row" id="preview_jump_out_image">
                                    <div class="c-background_image">
                                        <img src="/img/labradodel.png" alt="">
                                    </div>
                                    <div class="background_image_name">labradoodle.jpg</div>
                                    <div class="background_image_delete"></div>
                                </div>
                                <div class="background_form_row">
                                    <div class="upload_image">
                                        <input type="file" id="upload_jump_out_image" name="jump_out_image">
                                        <label for="upload_image">
                                            <span class="upload_image_icon"></span>
                                            <span class="upload_image_text">Upload image</span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">view</div>
                        <div class="choose_view_img">
                            <div class="view_img_item view_padding active">
                                <div class="view_img"></div>
                            </div>
                            <div class="view_img_item view_full">
                                <div class="view_img"></div>
                            </div>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">Border</div>
                        <div class="jump_out_border_img">
                            <form class="jump_out_border_img_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_border" id="choose_color_border_img">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_size">
                                        <div class="border_name">Size (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="border_size_count" value="0">
                                            </div>
                                            <div class="size_block" id="border_size_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_size_list">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_radius">
                                        <div class="border_name">Corner radius (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="border_radius_count" value="0">
                                            </div>
                                            <div class="size_block" id="border_radius_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_radius_list">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="setting_item">
                        <div class="elements_title">shadow</div>
                        <div class="jump_out_shadow_img">
                            <form class="jump_out_shadow_img_form">
                                <div class="background_form_row">
                                    <div class="choose_color choose_color_shadow" id="choose_color_shadow_img">
                                        <div class="show_choose_color"></div>
                                    </div>
                                </div>
                                <div class="background_form_row">
                                    <div class="border_size">
                                        <div class="border_name">Size (px):</div>
                                        <div class="border_size_setting">
                                            <div class="border_size_input">
                                                <input type="text" id="border_size_count" value="20">
                                            </div>
                                            <div class="size_block" id="border_size_choose">
                                                <span></span>
                                                <ul class="size_list" id="border_size_list">
                                                    <li>0</li>
                                                    <li>1</li>
                                                    <li>2</li>
                                                    <li>3</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>10</li>
                                                    <li class="active">20</li>
                                                    <li>40</li>
                                                    <li>80</li>
                                                    <li>160</li>
                                                    <li>240</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>               
    </main>
</template>

<script>
    import draggable from 'vuedraggable'
    var Pickr = require('./pickr.min.js');

    export default {
        components: {
            draggable,
        },
		data () {
			return this.$parent._data;
		},
        watch: {
            type: function (val) {
                this.is_disabled = (val == 'blocks' ? '' : 'disable');
            },
            border_size_count: function (val) {
                $('#box').css({'border-width': val + 'px', 'border-style': 'solid'});
            },
            border_size_radius: function (val) {
                $('#box').css('border-radius', val + 'px');
            },
            shadow_size_count: function (val) {
                var shadow_color = $('#box').data('sc');
                $('#box').css('box-shadow', '0px 0px ' + val + 'px 0px' + shadow_color);
            },
        },
	 	methods: {
            changeMode: function(type) {

                if (type !== 'blocks') {
                    $('#box .list-group-item').removeClass('active').addClass('disable');                    
                }

                if (type == 'blocks') {
                    $('#box .list-group-item').removeClass('disable');
                }

                this.type = type;
            },
            setTemplate: function(gallery_index) {

                var vm      = this;
                var object = this.gallery[gallery_index];
                vm.list2    = [];

                vm.positionBox(object.popup_position);

                for (var index in object.elements) {
                    vm.list2.push(object.elements[index]);
                }
            },
            setActive: function(event) {

                if (event.target.className !== 'edit' && event.target.className !== 'popup' && event.target.className !== 'delete' && this.type == 'blocks') {
                    $('#box .list-group-item').removeClass('active');
                    $(event.target).addClass("active");                     
                }
            },
            selectElement: function(index) {

                var item       = $('.choose_blocks .item_blocks:nth-child(' + (index + 1) + ')');
                var items      = $('.choose_blocks .item_blocks');
                var id_element = $(this).attr('id');
                var item_type  = item.attr('id');
                var redraw     = true;
                var vm         = this;

                if (this.mode == 'edit') {
                    $('.setting_blocks_item').removeClass('edited');   
                    this.rebuildFields(item_type);
                }

                this.mode         = 'add';

                items.removeClass('active');
                item.addClass('active');

                $('.setting_pop_up').removeClass('active');
                $('.setting_blocks').addClass('active');
                $('.setting_blocks_item').removeClass('active');

                $('.setting_blocks_item').each(function() {
                    var data_element = $(this).data('element');

                    if(item_type == data_element) {
                        $(this).addClass('active');
                        if($(this).hasClass('edited')) {
                            redraw = false;
                        } else {
                            $(this).addClass('edited');
                        }

                    } else {
                        $(this).removeClass('active');
                    }
                }); 

                this.changeRedraw(item_type, 'add');

                //setTimeout(() => {
                //if (redraw) {
                    //this.changeRedraw(item_type, 'add');
                //}
                    /*var element = $('.setting_blocks_item[data-element="' + item_type + '"] .choose_color');

                    element.each(function(index) {
                        console.log(this.firstChild); 
                    });
 
                    element.each(function(index) {
                        var id_element = $(this).attr('id');
                        //var start_color = $(this).css('color');
                        var start_color = vm.selectColorForDrawing(id_element, $(this).css('color'));
 
                        vm.DrawPallete(id_element, start_color);
                        
                        console.log($('#' + id_element + ' .show_choose_color'));
                        console.log($('#' + id_element + ' .show_choose_color').length);
                    });         
                }
                //},500);*/

                //$('.setting_blocks_item[data-element="' + data_element + '"]').addClass('active');
            },
            editElement: function(index) {

                if (this.mode == 'add') {
                    $('.setting_blocks_item').removeClass('edited');   
                }

                var item_type     = this.list2[index].id_name;
                this.edit_object  = this.list2[index];
                this.mode         = 'edit';
                var redraw        = true;
                var vm            = this;
 
                $('.setting_blocks_item').each(function() {
                    var data_element = $(this).data('element');

                    if(item_type == data_element) {
                        $(this).addClass('active');
                        if($(this).hasClass('edited')) {
                            redraw = false;
                        } else {
                            $(this).addClass('edited');
                        }

                    } else {
                        $(this).removeClass('active');
                    }
                }); 
  

                //if (redraw) {
                    this.changeRedraw(item_type, 'edit');
                //}
            },
            changeRedraw: function(item_type, type) {
 
                var vm      = this;
                var element = $('.setting_blocks_item[data-element="' + item_type + '"] .choose_color');
 
                element.each(function(index) {
                    var id_element       = $(this).attr('id');
                    var start_color      = (type == 'edit' ? vm.selectColorForDrawing(id_element, $(this).css('color')) : $(this).css('color'));
                    $(this)[0].innerHTML = '<div class="show_choose_color"></div>';
                    vm.DrawPallete(id_element, start_color);
                });   
            },
            selectColorForDrawing: function(id_element, default_color) {

                var color = default_color;

                switch(id_element) {
                    case 'setting_blocks_title--color': 
                    case 'setting_blocks_text--color':
                    case 'setting_blocks_button--color':
                        color = this.edit_object.styles.font_color;
                        break;
                    case 'setting_blocks_button--background':
                        color = this.edit_object.styles.background_color;
                        break;
                    case 'setting_blocks_button--bcolor':
                        color = this.edit_object.styles.border_color;
                        break;
                    case 'setting_blocks_button--scolor':
                        color = this.edit_object.styles.shadow_color;
                        break;
                }

                return color;
            },
            DrawPallete: function(id_element, start_color) {

                setTimeout(() => {
                    if ($('#' + id_element + ' .show_choose_color').length) {
                        this.choose_color_bg(id_element, start_color);
                    } else {
                        setTimeout(() => {
                            console.log('recall');
                            this.DrawPallete(id_element, start_color);
                        }, 100); 
                    }
                }, 100); 
            },
            /*DrawPallete: function(id_element, start_color) {

                if ($('#' + id_element + ' .show_choose_color').length) {
                    this.choose_color_bg(id_element, start_color);
                    this.repeats = 0;
                } else {

                    if (this.repeats < 500) {
                        setTimeout(() => {
                            this.repeats++;
                            this.DrawPallete(id_element, start_color);
                        }, 100);                        
                    }
                }
            },*/
            rebuildFields: function(data_element) {
                //console.log('rebuildFields ' + data_element);
                if (data_element == 'jump_out_button') {
                  this.new_button_border_size   = 0;
                  this.new_button_corner_radius = 0;
                  this.new_button_shadow_size   = 0;
                }
            },
            readURL: function() {

                var vm    = this;
                var input = this.$refs.myFiles;
 
                if (input.files && input.files[0])
                {
                    var reader = new FileReader();

                    reader.onload = function(e)
                    {
                        vm.background_image = e.target.result;
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            },
            removeElement: function(index) {
                this.list2.splice(index, 1);
            },
		    cloneDog: function({ id }) {

                var selected_element = $('.item_blocks.title_blocks.active').attr('id');

                var data = { 
                    name: '',
                    id: id,
                    id_name: '',
                    link: '',
                    styles: {
                        font_type: '',
                        font_weigth: '',
                        font_color: '',
                        background_color: '',
                        border_color: '',
                        border_size: '',
                        border_radius: '',
                        shadow_color: '',
                        shadow_size: '',
                    }
                };
 
                if (selected_element == 'jump_out_button')
                {
                    data.name    = $('input[name="setting_blocks_button--text"]').val();
                    data.id_name = 'jump_out_button';
                    data.link    = $('input[name="setting_blocks_button--link"]').val();
                    data.styles.font_type        = $('select[name="setting_blocks_button--font"] option:selected').text();
                    data.styles.font_weigth      = $('select[name="setting_blocks_button--weight"] option:selected').text();
                    data.styles.font_color       = $('#setting_blocks_button--color .choose_background_text').html();
                    data.styles.background_color = $('#setting_blocks_button--background .choose_background_text').html();
                    data.styles.border_color     = $('#setting_blocks_button--bcolor .choose_background_text').html();
                    data.styles.border_size      = $('#setting_blocks_button--bsize').val();
                    data.styles.border_radius    = $('#setting_blocks_button--bradius').val();
                    data.styles.shadow_color     = $('#setting_blocks_button--scolor .choose_background_text').html();
                    data.styles.shadow_size      = $('#setting_blocks_button--ssize').val();
                }

                if (selected_element == 'jump_out_text')
                {
                    data.name        = $('#setting_blocks_text--text').val();
                    data.id_name     = 'jump_out_text';
                    data.styles.font_type   = $('select[name="setting_blocks_text--font"] option:selected').text();
                    data.styles.font_weigth = $('select[name="setting_blocks_text--weight"] option:selected').text();
                    data.styles.font_color  = $('#setting_blocks_text--color .choose_background_text').html();
                    data.styles.shadow_size = 0;
                }

                if (selected_element == 'jump_out_title')
                {
                    data.name        = $('#setting_blocks_title--text').val();
                    data.id_name     = 'jump_out_title';
                    data.styles.font_type   = $('select[name="setting_blocks_title--font"] option:selected').text();
                    data.styles.font_weigth = $('select[name="setting_blocks_title--weight"] option:selected').text();
                    data.styles.font_color  = $('#setting_blocks_title--color .choose_background_text').html();
                    data.styles.shadow_size = 0;
                }

                console.log(data);
                
                return data;
		    },
            log: function(evt) {

            },
            positionBox: function(pos) {

                this.popup_position = pos;

                switch (pos) {
                  case 'left-top':
                    var coords = [0, 'auto', 'auto', 0];
                    break;
                  case 'center-top':
                    var coords = [0, 0, 'auto', 0];
                    break;
                  case 'right-top':
                     var coords = [0, 0, 'auto', 'auto'];
                    break;
                  case 'left-mid':
                     var coords = [0, 'auto', 0, 0];
                    break;
                  case 'center-mid':
                     var coords = [0, 0, 0, 0];
                    break;
                  case 'right-mid':
                     var coords = [0, 0, 0, 'auto'];
                     break;
                  case 'left-bot':
                     var coords = ['auto', 'auto', 0, 0];
                    break;
                  case 'center-bot':
                    var coords = ['auto', 0, 0, 0];
                    break;
                  case 'right-bot':
                    var coords = ['auto', 0, 0, 'auto'];
                    break;   
                  default:
                    var coords = ['auto', 'auto', 0, 0];
                }

                $('#box').css({
                   'top' : coords[0],
                   'right' : coords[1],
                   'bottom' : coords[2],
                   'left' : coords[3],
                });

            },
            textSizeCanvas: function() {
                console.log($('.redactor_canvas'));
                var width_size_canvas = $('.redactor_canvas')[0].offsetWidth;
                var height_size_canvas = $('.redactor_canvas')[0].offsetHeight;
                $('.width_size_canvas .width_size_count').text(width_size_canvas);
                $('.height_size_canvas .height_size_count').text(height_size_canvas);
                $('.width_size_canvas .width_size_units').text('px');
                $('.height_size_canvas .height_size_units').text('px');
            },
            textSizeCanvas_FW: function() {
                var height_size_canvas = $('.redactor_canvas')[0].offsetHeight;
                $('.width_size_canvas .width_size_count').text('100');
                $('.height_size_canvas .height_size_count').text(height_size_canvas);
                $('.width_size_canvas .width_size_units').text('%');
                $('.height_size_canvas .height_size_units').text('px');
            },
            textSizeCanvas_FH: function() {
                var width_size_canvas = $('.redactor_canvas')[0].offsetWidth;
                $('.width_size_canvas .width_size_count').text(width_size_canvas);
                $('.height_size_canvas .height_size_count').text('100');
                $('.width_size_canvas .width_size_units').text('px');
                $('.height_size_canvas .height_size_units').text('%');
            },
            setStyle: function(name, toDefault = 0) {
                var vm  = this;
                var old = $('.item_pop_up.active').attr('id');
                $('.item_pop_up').removeClass('active');
                $('#' + name).addClass('active');

                $('.redactor_canvas').removeClass('small medium large full_width full_height');     
                $('.choose_position').removeClass('active');

                switch(name) {
                    case "small_pop_up":
                        this.popup_size = 'small';
                        $('.redactor_canvas').addClass('small');
                        $('.choose_position.square').addClass('active');
                        vm.textSizeCanvas();
                    break;
                    case "medium_pop_up":
                        this.popup_size = 'medium';
                        $('.redactor_canvas').addClass('medium');
                        $('.choose_position.square').addClass('active');
                        vm.textSizeCanvas();
                    break;
                    case "large_pop_up":
                        this.popup_size = 'large';
                        $('.redactor_canvas').addClass('large');
                        $('.choose_position.square').addClass('active');
                        vm.textSizeCanvas();
                    break;
                    case "f_w_pop_up":
                        this.popup_size = 'f_w';
                        $('.redactor_canvas').addClass('full_width');
                        $('.choose_position.full_width').addClass('active');
                        vm.textSizeCanvas_FW();
                    break;
                    case "f_h_pop_up":
                        this.popup_size = 'f_h';
                        $('.redactor_canvas').addClass('full_height');
                        $('.choose_position.full_height').addClass('active');
                        vm.textSizeCanvas_FH();
                    break;

                }

                if (toDefault == 0) {
                    vm.PositionToDefault(name, old);                    
                }
            },
            PositionToDefault: function(name, old) {

                if (name == 'small_pop_up' ||  name == 'medium_pop_up' || name == 'large_pop_up') {

                    if (old != 'small_pop_up' &&  old != 'medium_pop_up' && old != 'large_pop_up') {
                        this.popup_position = 'center-mid';
                        //$('.choose_position .position_item').removeClass('active');
                        //$('.choose_position.square .position_item.position_cc').addClass('active');
                        $('#box').css({'top' : 0,'right' : 0,'bottom' : 0,'left' : 0});                        
                    }

                } else if (name == 'f_w_pop_up') {
                    this.popup_position = 'center-top';
                    //$('.choose_position.full_width .position_item.position_tc').addClass('active');
                    $('#box').css({'top' : 0,'right' : 0,'bottom' : 'auto','left' : 0});
                } else if (name == 'f_h_pop_up') {
                    this.popup_position = 'right-mid';
                    //$('.choose_position.full_height .position_item.position_cr').addClass('active');
                    $('#box').css({'top' : 0,'right' : 0,'bottom' : 0,'left' : 'auto'});
                }

            },
            back: function() {
                var element = document.getElementById("module_id");
                var path        = document.location.pathname;
                var path        = path.replace('/#', '');
                var redirect_to = path.replace('/redactor', '');
 
                if (typeof(element) != 'undefined' && element != null) {
                    var type = 'edit';
                } else {    
                    redirect_to     = redirect_to + '/add';  
                    var type = 'create';
                }    
                 
                document.location.href = redirect_to;   
            },
            finish: function() {

                var element = document.getElementById("module_id");
                var path        = document.location.pathname;
                var path        = path.replace('/#', '');
                var redirect_to = path.replace('/redactor', '');
 
                if (typeof(element) != 'undefined' && element != null) {
                    var type = 'edit';
                } else {    
                    redirect_to     = redirect_to + '/add';  
                    var type = 'create';
                }    
 
                var data = {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'data' : {
                        'popup_size' : this.popup_size,
                        'popup_position' : this.popup_position,
                        'popup_background' : this.popup_background,
                        'popup_overlay' : this.popup_overlay,
                        'popup_border' : this.popup_border,
                        'popup_shadow' : this.popup_shadow,
                        'elements' : this.list2,  
                        'closeButton' : this.closeButton,
                        'closeOnOverlay' : this.closeOnOverlay,    
                        'border_size_count' : this.border_size_count,  
                        'border_size_radius' : this.border_size_radius,  
                        'shadow_size_count' : this.shadow_size_count,   
                        'background_image' : this.background_image,           
                        'type' : type,               
                    }
                }

                $.post( '/api/jumpout/store-redactor', data, function( result ) {

                    if (result == 'updated') {
                        document.location.href = redirect_to;    
                    } else {
                        alert('Storing temp data failed.');
                    }
                }); 

                return false;
            },
            saveTemplate: function() {

                var data = {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'data' : {
                        'popup_size' : this.popup_size,
                        'popup_position' : this.popup_position,
                        'popup_background' : this.popup_background,
                        'popup_overlay' : this.popup_overlay,
                        'popup_border' : this.popup_border,
                        'popup_shadow' : this.popup_shadow,
                        'elements' : this.list2,  
                        'closeButton' : this.closeButton,
                        'closeOnOverlay' : this.closeOnOverlay,    
                        'border_size_count' : this.border_size_count,  
                        'border_size_radius' : this.border_size_radius,  
                        'shadow_size_count' : this.shadow_size_count, 
                        'background_image' : this.background_image,               
                        'type' : type,                 
                    }
                }

                $.post( '/api/jumpout/store-template', data, function( result ) {
                    if (result == 'success') {

                    } else {
                        alert('Storing temp data failed.');
                    }
                });
            },
            loadData: function() {
                var vm      = this;
                var element =  document.getElementById("module_id");
                
                if (typeof(element) != 'undefined' && element != null)
                {
                    var data = {
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                        'module_id' : element.value
                    }

                    $.post( '/api/jumpout/load-template', data, function( result ) {
                        if (result.template) {

                            result.template.closeButton
                            result.template.closeOnOverlay     

                            vm.company_name       = result.name;
                            vm.closeButton        = (result.template.closeButton == 'true' ? true : false);
                            vm.closeOnOverlay     = (result.template.closeOnOverlay == 'true' ? true : false);
                            vm.popup_background   = result.template.popup_background;
                            vm.popup_overlay      = result.template.popup_overlay;
                            vm.popup_border       = result.template.popup_border;
                            vm.popup_shadow       = result.template.popup_shadow;
                            vm.border_size_count  = result.template.border_size_count;
                            vm.border_size_radius = result.template.border_size_radius;
                            vm.shadow_size_count  = result.template.shadow_size_count; 
                            vm.background_image   = this.background_image;              
 
                            vm.setStyle(result.template.popup_size + '_pop_up', 1);
                            vm.positionBox(result.template.popup_position);
  
                            for (var index in result.template.elements) {
                                vm.list2.push(result.template.elements[index]);
                            }

                            vm.generateDefaultFields();

                            setTimeout(() => {
                                vm.ShowPreloader = false; 
                            }, 300);
                        }
                    });
                } else {
                    this.generateDefaultFields();
                    setTimeout(() => {
                        vm.ShowPreloader = false; 
                    }, 300);
                }
            },
            documentClick: function(e) {

                /*var el     = this.$refs.listGroup;
                var target = e.target;
 
                if (( el !== target) && !el.contains(target)) {
                    $('.list-group-item').removeClass('active');
                    $('.setting_blocks_item').removeClass('active');
                }*/
            },
            choose_color_bg: function(id, color) {
                //console.log('choose_color_bg ' + id + ',' + color);
                var vm = this;  

                var pickr = new Pickr({
                    el: '#' + id + ' .show_choose_color',
                    default: color,
                    //default: '#FFFFFF',
                    components: {
                        preview: false,
                        opacity: true,
                        hue: true,

                        interaction: {
                            hex: false,
                            rgba: false,
                            hsva: false,
                            input: true,
                            clear: false,
                            save: true
                        }
                    },
                    convertHex: function(colors,opacity) {

                        var hex = colors[0] + colors[1] + colors[2];
                        var r = parseInt(hex.substring(0,2), 16);
                        var g = parseInt(hex.substring(2,4), 16);
                        var b = parseInt(hex.substring(4,6), 16);

                        var result = 'rgba(' + r + ',' + g + ',' + b + ',' + opacity + ')';
                        return result;
                    },
                    onChange: function(hsva, instance) {

                        var colors     = hsva.toHEX();
                        var color_code = this.convertHex(colors, hsva.a);

                        var assoc      = {
                            'choose_color_background' : 'popup_background',
                            'choose_color_overlay' : 'popup_overlay',
                            'choose_color_border' : 'popup_border',
                            'choose_color_shadow' : 'popup_shadow',
                            'setting_blocks_title--color' : 'font_color',
                            'setting_blocks_text--color' : 'font_color',
                            'setting_blocks_button--color' : 'font_color',
                            'setting_blocks_button--background' : 'background_color',
                            'setting_blocks_button--bcolor' : 'border_color',   
                            'setting_blocks_button--scolor' : 'shadow_color'                    
                        };
 
                        if (id.indexOf('setting_blocks') !== -1) {
                            if (vm.mode == 'edit') {
                                vm.edit_object.styles[assoc[id]] = color_code;
                            }
                        } else {
                            vm[assoc[id]] = color_code;
                        }
 
                        $('#' + id).find('.pcr-button').css('background', hsva.toHEX());
                        $('#' + id).find('.choose_background_text').text(hsva.toHEX());
                    },
                    onSave: function(hsva, instance) {

                        var colors     = hsva.toHEX();
                        var color_code = this.convertHex(colors, hsva.a);

                        var assoc      = {
                            'choose_color_background' : 'popup_background',
                            'choose_color_overlay' : 'popup_overlay',
                            'choose_color_border' : 'popup_border',
                            'choose_color_shadow' : 'popup_shadow',
                            'setting_blocks_title--color' : 'font_color',
                            'setting_blocks_text--color' : 'font_color',
                            'setting_blocks_button--color' : 'font_color',
                            'setting_blocks_button--background' : 'background_color',
                            'setting_blocks_button--bcolor' : 'border_color',   
                            'setting_blocks_button--scolor' : 'shadow_color'                    
                        };
 
                        if (id.indexOf('setting_blocks') !== -1) {
                            if (vm.mode == 'edit') {
                                vm.edit_object.styles[assoc[id]] = color_code;
                            }
                        } else {
                            vm[assoc[id]] = color_code;
                        }

                        $('#' + id).find('.choose_background_text').text(hsva.toHEX());
                    }
                });

                $('#' + id).find('.pcr-button').append('<div class="choose_background_text"></div>');
                $('#' + id).find('.pcr-button').append('<div class="choose_background_arrow"></div>');

                var color_element = pickr.getColor();
                var text_color_element = color_element.toHEX();
                $('#' + id).find('.choose_background_text').text(text_color_element);
            },
            generateDefaultFields: function() {

                var vm      = this;
                var element = $('.choose_color');

                element.each(function(index) {

                   var id_element = $(this).attr('id');
                   var start_color = $(this).css('color');

                   if (id_element == 'choose_color_background') {   
                        start_color = vm.popup_background;
                   }

                   if (id_element == 'choose_color_overlay') {   
                        start_color = vm.popup_overlay;
                   }

                   if (id_element == 'choose_color_border') {   
                        start_color = vm.popup_border;
                   }

                   if (id_element == 'choose_color_shadow') {
                        start_color = vm.popup_shadow;
                   }
 
                    vm.choose_color_bg(id_element, start_color );
                });
            }, 
	 	},
        created () {
          /*document.addEventListener('click', this.documentClick);*/
        },
        mounted() {

            $('.setting_blocks_item').addClass('edited');
             
            this.loadData();

            var vm = this;

            $(document).on('click', '.size_list li', function(e) {
                e.preventDefault();
                $(this).addClass('active').siblings().removeClass('active');
                $(this).parent('.size_list').removeClass('open');
                var size_count = $(this).text();
                var data_model = $(this).parent('.size_list').data('model');
 
                if (data_model == 'border_size_count') {
                    vm.border_size_count = size_count;
                }

                if (data_model == 'border_size_radius') {
                    vm.border_size_radius = size_count;
                }              

                if (data_model == 'shadow_size_count') {
                    vm.shadow_size_count = size_count;
                }  

                if (data_model == 'new_button_border_size') {
                    vm.new_button_border_size = size_count;
                }  

                if (data_model == 'new_button_corner_radius') {
                    vm.new_button_corner_radius = size_count;
                }  

                if (data_model == 'new_button_shadow_size') {
                    vm.new_button_shadow_size = size_count;
                }  

            });

            var vm = this;
            vm.textSizeCanvas();
        }
    }
</script>
