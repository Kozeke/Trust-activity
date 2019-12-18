@extends('Panel::layouts/admin')

@section('content')
 
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
          <div class="row">
            <div class="col-lg-12">
                    <div class="domain_list_search">
                        <form method="get" action="/admin/payment-history">
                            <input type="search" name="search" placeholder="Type to search..." style="margin-bottom: 10px;" value="<? if(isset($_GET['search'])) echo $_GET['search'];?>">
                            <div class="input-daterange input-group" id="datepicker">
                                <input autocomplete="off" type="text" class="input-sm form-control" name="start" value="<? if(isset($_GET['start'])) echo $_GET['start'];?>" />
                                <span class="input-group-addon">to</span>
                                <input autocomplete="off" type="text" class="input-sm form-control" name="end" value="<? if(isset($_GET['end'])) echo $_GET['end'];?>" />
                            </div>
                            <select name="status" style="font-size: 14px; margin-top: 10px;">
                                <option value="">All</option>
                                <option value="success" <? if(isset($_GET['status']) && $_GET['status'] == 'success') echo 'selected';?>>Success</option>
                                <option value="failed" <? if(isset($_GET['status']) && $_GET['status'] == 'failed') echo 'selected';?>>Failed</option> 
                            </select>
                            <input type="submit" name="submit" class="btn search-submit" value="Search" / >
                            <a href="/admin/payment-history" class="btn search-submit" style="display: inline-block;">Clean</a>
                        </form>
                    </div>
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active invoices-tab">
                            <h2>Invoices history</h2>
                            <div class="pagination contacts_pagination">
                                <ul>
                                    <? $total = count($list); ?>
                                    <? $pages = ceil($total / 10); ?>
                                    <? $current_page = (isset($_GET['page']) ? $_GET['page'] : 1); ?>
                                    <?
                                        $url = $_SERVER['REQUEST_URI'];
                                        if(strpos($_SERVER['REQUEST_URI'], 'page=')) {
                                            $url = str_replace('?page='.$current_page, '', $url);
                                            $url = str_replace('&page='.$current_page, '', $url);
                                        } 

                                        if ($url == '/admin/payment-history') {
                                            $url .= '?page=';
                                        } else {
                                            $url .= '&page=';                                                
                                        }

                                    ?>
 
                                    @for($j = 1; $j < $pages + 1; $j++)
                                        <li class="pagination_item">
                                            @if($current_page == $j)
                                                <a href="<?=$url;?><?=$j;?>" data-id="1" class="pagination_link active"><?=$j;?></a>
                                            @else
                                                <a href="<?=$url;?><?=$j;?>" data-id="1" class="pagination_link"><?=$j;?></a>
                                            @endif
                                        </li>
                                    @endfor

                  
                                    <!--<li class="pagination_item">
                                        <a href="#" class="pagination_link">...</a>
                                    </li>
                          
                                    <li class="pagination_item">
                                        <a href="#" class="pagination_link">&gt;</a>
                                    </li>-->
                                </ul>
                            </div> 
                            <div class="payment_block_list_head invoices" style="margin-bottom: 30px;">
                                <p class="payment_left">Operation</p>
                                <p class="payment_center" style="width: 20%;">User</p>          
                                <p class="payment_center" style="width: 15%;">Date</p>                            
                                <p class="payment_center" style="width: 15%;">Amount</p>
                                <p class="payment_right" style="width: 10%; text-align: left;">Status</p>
                            </div>
                            <div class="payment_block_list invoices">
 
                                <? $i = 0; ?> 
                                <?php 

                                    $end          = $current_page * 10;
                                    $start        = $end - 10;

                                  ?>
                                @for($k = $start; $k < $end; $k++)
                                    <?php if(!isset($list[$k])) break; ?>
                                    <?php  $action = ($list[$k]['method'] == 'admin-remove' ? '-' : '+'); ?>
                                    
                                    <? if($i == 0): ?>
                                        <? $i = 1; ?>
                                        <div class="payment_block_list_item" style="padding: 10px 0; background-color: #F6F9FD;"> 
                                    <? else: ?>
                                        <?php $i = 0; ?>
                                        <div class="payment_block_list_item" style="padding: 10px 0"> 
                                    <? endif; ?>
                               
       
                                        <p class="payment_amount payment_left" style="line-height: 24px; padding-left: 45px;">
                                        @if($list[$k]['type'])
                                            @if($list[$k]['status'] == 'failed')
                                                <i class="balance-fail-icon" style="left: 10px; margin-top: 1px;"></i>  
                                            @elseif($action == '+') 
                                                <i class="balance-up-icon" style="left: 10px; margin-top: 1px;"></i>
                                            @else
                                                <i class="balance-down-icon" style="left: 10px; margin-top: 1px;"></i>     
                                            @endif 
                                            @if($list[$k]['method'] == 'admin-add' || $list[$k]['method'] == 'admin-remove') 
                                                Manually</p>  
                                            @elseif($list[$k]['method'] == 'promo-code') 
                                                {{ $list[$k]['type'] }}</p> 
                                            @else
                                                {{ $list[$k]['type'] }} Balance</p>  
                                            @endif
                                        @else 
                                            <i class="balance-down-icon" style="left: 10px;"></i>  
                                            Purchasing Website <span>{{ $list[$k]['domain_id'] }} : {{ $list[$k]['domain_name'] }} - {{ $list[$k]['module_name'] }} {{ $list[$k]['module_plan_name'] }}</span></p>    
                                        @endif
                                        <p class="payment_amount payment_center" style="width: 20%; word-break: break-all;">{{ $list[$k]['email'] }}</p>   
                                        <p class="payment_amount payment_center" style="width: 15%;">{{ $list[$k]['date'] }}</p>    
                                        @if($list[$k]['type'])
                                            @if($list[$k]['status'] == 'failed')
                                                <p class="payment_amount payment_center grey" style="width: 15%;"> {{ $action }} ${{ $list[$k]['amount'] }}</p>      
                                            @else 
                                                @if($list[$k]['bonus'] > 0)
                                                    <p class="payment_amount payment_center green" style="width: 15%;"> + ${{ $list[$k]['amount'] }} + bonus ${{ $list[$k]['bonus'] }}</p>      
                                                @else
                                                    <p class="payment_amount payment_center <?=($action == '+' ? 'green' : 'red');?>" style="width: 15%;"> {{ $action }} ${{ $list[$k]['amount'] }}</p>  
                                                @endif;
                                            @endif    
                                        @else 
                                            <p class="payment_amount payment_center red" style="width: 15%;"> - ${{ $list[$k]['module_plan_price'] }}</p>   
                                        @endif

                                        @if($list[$k]['status'])
                                            <p class="payment_status payment_right grey" style="width: 10%; text-align: left;">{{ $list[$k]['status'] }}</p> 
                                        @else 
                                            <p class="payment_status payment_right grey" style="width: 10%; text-align: left;">success</p> 
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>



        
      
            </div>
          </div>
        </div>         
      </div>
    </div>

    <style type="text/css">
        
        .history {
            -display: none;
        }

        .history.active {
            display: block;
        }

        .title-user {
            cursor: pointer;
            background-color: #f8fafd;
        }

        .title-user.active {
            background-color: #ebebef;
        }

        .title-user:hover {
            background-color: #f1f1f1;
        }

    </style>
    
    <script type="text/javascript">
        $('.input-daterange').datepicker({
            maxViewMode: 2,
            format: 'yyyy.mm.dd',
            todayBtn: "linked",
            clearBtn: true
        });
    </script>
 
@endsection
