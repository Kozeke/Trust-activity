@extends('Panel::layouts/app')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>{!! Helpers::translate('invoices', 'Invoices') !!}</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/invoices" class="breadcrumbs_link">{!! Helpers::translate('invoices', 'Invoices') !!}</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active invoices-tab">
                            <h2>{!! Helpers::translate('invoices-history', 'Invoices history') !!}</h2>
                            <div class="pagination contacts_pagination">
                                <ul>
                                    <? $pages = ceil($total / 10); ?>
                                    <? $current_page = (isset($_GET['page']) ? $_GET['page'] : 1); ?>
                                    <?
                                        $url = $_SERVER['REQUEST_URI'];
                                        if(strpos($_SERVER['REQUEST_URI'], 'page=')) {
                                            $url = str_replace('?page='.$current_page, '', $url);
                                            $url = str_replace('&page='.$current_page, '', $url);
                                        } 

                                        if ($url == '/admin/invoices') {
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
                                </ul>
                            </div> 
                            <div class="payment_block_list_head invoices">
                                <p class="payment_left">{!! Helpers::translate('operation', 'Operation') !!}</p>
                                <p class="payment_center">{!! Helpers::translate('date', 'Date') !!}</p>                            
                                <p class="payment_center">{!! Helpers::translate('amount-invoice', 'Amount') !!}</p>
                                <p class="payment_right">{!! Helpers::translate('status', 'Status') !!}</p>
                            </div>
                            <div class="payment_block_list invoices">
                                @foreach($list as $item)
                                    <?php if(!isset($item)) break; ?>
                                    <?php  $action = ($item['method'] == 'admin-remove' ? '-' : '+'); ?>
                                    <div class="payment_block_list_item"> 
                                        <p class="payment_amount payment_left" style="line-height: 24px;">
                                        @if($item['type'])
                                            <?php if($item['type'] == 'top up') {
                                                $item['type'] = Helpers::translate('top-up-invoice', 'Top up');
                                            } ?>
                                            @if($item['status'] == 'failed')
                                                <i class="balance-fail-icon"></i>  
                                            @elseif($action == '+') 
                                                <i class="balance-up-icon"></i>
                                            @else
                                                <i class="balance-down-icon"></i>     
                                            @endif 
                                            @if($item['method'] == 'admin-add' || $item['method'] == 'admin-remove') 
                                                {!! Helpers::translate('manually', 'Manually') !!}</p>  
                                            @elseif($item['method'] == 'promo-code') 
                                                {{ $item['type'] }}</p> 
                                            @else
                                                {{ $item['type'] }} {!! Helpers::translate('balance-3', 'Balance') !!}</p>  
                                            @endif
                                        @else
                                            <i class="balance-down-icon"></i>  
                                            {!! Helpers::translate('purchasing-website', 'Purchasing Website') !!} <span>{{ $item['domain_name'] }} - {{ $item['module_name'] }} {{ $item['module_plan_name'] }}</span></p>    
                                        @endif
                                        <p class="payment_amount payment_center">{{ $item['date'] }}</p>   
                                        @if($item['type'])
                                            @if($item['status'] == 'failed')
                                                <p class="payment_amount payment_center grey"> {{ $action }} ${{ $item['amount'] }}</p>      
                                            @else 
                                                @if($item['bonus'] > 0)
                                                    <p class="payment_amount payment_center green"> + ${{ $item['amount'] }} + bonus ${{ $item['bonus'] }}</p>      
                                                @else
                                                    <p class="payment_amount payment_center <?=($action == '+' ? 'green' : 'red');?> "> {{ $action }} ${{ $item['amount'] }}</p>  
                                                @endif
                                            @endif    
                                        @else 
                                            <p class="payment_amount payment_center red"> - ${{ $item['module_plan_price'] }}</p>   
                                        @endif
                                        <?print_r($item);?>
                                        @if($item['status'] == 'success')
                                            <p class="payment_status payment_right grey">{!! Helpers::translate('success-invoice', 'success') !!}</p> 
                                        @elseif($item['status'] == 'failed')
                                            <p class="payment_status payment_right grey">{!! Helpers::translate('failed', 'failed') !!}</p> 
                                        @else 
                                            <p class="payment_status payment_right grey">{!! Helpers::translate('success-invoice', 'success') !!}</p> 
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
