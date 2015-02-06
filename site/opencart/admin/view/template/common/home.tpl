<?php echo $header; ?><?php echo $menu; ?>
<?php MiwoShop::get('base')->addHeader(MPATH_MIWOSHOP_OC . '/admin/view/stylesheet/home.css'); ?>
<link type="text/css" href="view/javascript/jquery/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" />
<link type="text/css" href="view/javascript/jquery/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

<?php if ( Miwoshop::get('base')->is30() == false ) { ?>
<link type="text/css" href="view/javascript/jquery/bootstrap/css/miwoshop_custom_bootstrap.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/jquery/bootstrap/js/bootstrap.min.js"></script>
<?php } ?>

<script type="text/javascript" src="view/javascript/jquery/daterangepicker/moment.js"></script>
<script type="text/javascript" src="view/javascript/jquery/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.js"></script>
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.tickrotor.js"></script>
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.resize.js"></script>
<script language="javascript">
	function upgrade() {
		window.location = "<?php echo $this->url->link('common/upgrade', 'token=' . $this->session->data['token'], 'SSL'); ?>";
	}
</script>
<div id="content">
  <?php if ($error_install) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_install; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row" style="margin-top: 10px">
    <div class="col-sm-3">
      <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title"><i class="fa fa-clock-o fa-lg"></i> <?php echo $text_event_summary; ?></h1>
        </div>
        <div class="panel-body" style="padding: 0 !important;">
            <table class="adminlist table-striped table">
                <tr class="row0">
                  <td class="key"><a href="<?php echo $link_sales; ?>"><?php echo $text_total_sale; ?></a></td>
                  <td><b><?php echo $total_sale; ?></b></td>
                </tr>
                <tr class="row1">
                  <td class="key"><a href="<?php echo $link_sales; ?>"><?php echo $text_total_sale_year; ?></a></td>
                  <td><b><?php echo $total_sale_year; ?></b></td>
                </tr>
                <tr class="row0">
                  <td class="key"><a href="<?php echo $link_orders; ?>"><?php echo $text_total_order; ?></a></td>
                  <td><b><?php echo $total_order; ?></b></td>
                </tr>
                <tr class="row1">
                  <td class="key"><a href="<?php echo $link_customers; ?>"><?php echo $text_total_customer; ?></a></td>
                  <td><b><?php echo $total_customer; ?></b></td>
                </tr>
                <tr class="row0">
                  <td class="key"><a href="<?php echo $link_customer_waiting; ?>"><?php echo $text_total_customer_approval; ?></a></td>
                  <td><b><?php echo $total_customer_approval; ?></b></td>
                </tr>
                <tr class="row1">
                  <td class="key"><a href="<?php echo $link_review_waiting; ?>"><?php echo $text_total_review_approval; ?></a></td>
                  <td><b><?php echo $total_review_approval; ?></b></td>
                </tr>
                <tr class="row0">
                  <td class="key"><a href="<?php echo $link_affiliates; ?>"><?php echo $text_total_affiliate; ?></a></td>
                  <td><b><?php echo $total_affiliate; ?></b></td>
                </tr>
                <tr class="row1">
                  <td class="key"><a href="<?php echo $link_affiliate_waiting; ?>"><?php echo $text_total_affiliate_approval; ?></a></td>
                  <td><b><?php echo $total_affiliate_approval; ?></b></td>
                </tr>
              </table>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title"><i class="fa fa-info-circle fa-lg"></i> <?php echo $text_miwoshop_info; ?></h1>
        </div>
        <div class="panel-body" style="padding: 0 !important;">
          <?php
            $base = MiwoShop::get('base');
            $utility = MiwoShop::get('utility');
            $installed_version = $base->getMiwoshopVersion();
            $latest_version = $base->getLatestMiwoshopVersion();
            $version_status = version_compare($installed_version, $latest_version);
            $config = $base->getConfig();
            $pid = $base->getConfig()->get('pid');
          ?>
          <table class="adminlist table-striped table">
            <tr height="70">
                <td colspan="2">
                    <?php
                        if ($version_status == 0) {
                            echo '<b><font color="green">'.MText::_('COM_MIWOSHOP_CPANEL_LATEST_VERSION_INSTALLED').'</font></b>';
                        }
                        elseif($version_status == -1) {
                            echo '<b><font color="red">'.MText::_('COM_MIWOSHOP_CPANEL_OLD_VERSION').'</font></b>';
                        }
                        else {
                            echo '<b><font color="orange">'.MText::_('COM_MIWOSHOP_CPANEL_NEWER_VERSION').'</font></b>';
                        }
                    ?>
                </td>
            </tr>
            
            <tr height="40">
                <td>
                    <?php
                        if ($version_status == 0) {
                            echo MText::_('COM_MIWOSHOP_CPANEL_LATEST_VERSION');
                        }
                        elseif ($version_status == -1) {
                            echo '<b><font color="red">'.MText::_('COM_MIWOSHOP_CPANEL_LATEST_VERSION').'</font></b>';
                        }
                        else {
                            echo '<b><font color="orange">'.MText::_('COM_MIWOSHOP_CPANEL_LATEST_VERSION').'</font></b>';
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if ($version_status == 0) {
                            echo $latest_version;
                        }
                        elseif ($version_status == -1) {
                            echo '<b><font color="red">'.$latest_version.'</font></b>&nbsp;';
                            echo '<input type="button" class="button btn btn-danger" value="'.MText::_('COM_MIWOSHOP_UPGRADE').'" onclick="upgrade();" />';
                        }
                        else {
                            echo '<b><font color="orange">'.$latest_version.'</font></b>';
                        }
                    ?>
                </td>
            </tr>
            <tr height="40">
                <td>
                    <?php echo MText::_('COM_MIWOSHOP_CPANEL_INSTALLED_VERSION'); ?>
                </td>
                <td>
                    <?php echo $installed_version; ?>
                </td>
            </tr>
            <tr height="40">
                <td>
                    <?php echo MText::_('COM_MIWOSHOP_CPANEL_COPYRIGHT'); ?>
                </td>
                <td>
                    <a href="http://miwisoft.com" target="_blank"><?php echo $base->getXmlText(MPATH_WP_PLG.'/miwoshop/miwoshop.xml', 'copyright'); ?></a>
                </td>
            </tr>
        </table>
        </div>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="panel panel-default">
        <div class="panel-body">
          <div id="block-range" class="btn-group">
            <li class="btn btn-default active" id="day"><?php echo $text_day; ?></li>
            <li class="btn btn-default" id="month"><?php echo $text_month; ?></li>
            <li class="btn btn-default " id="year"><?php echo $text_year; ?></li>
          </div>
          <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            <span></span> <b class="caret"></b>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1 class="panel-title"><i class="fa fa-bar-chart-o fa-lg"></i> <?php echo $text_analytics; ?></h1>
        </div>
        <div id="tab_toolbar" class="panel-body" style="width: 100%; display: table; color: #555555;">
            <dl onclick="getChart(this, 'sales');" class="col-xs-4 col-lg-2 active" style="background-color: #1777B6">
                <dt><?php echo $text_sale; ?></dt>
                <dd class="data_value size_l"><span id="sales_score"></span></dd>
            </dl>
            <dl onclick="getChart(this, 'orders');" class="col-xs-4 col-lg-2 passive" style="background-color: #2CA121">
                <dt><?php echo $text_order; ?></dt>
                <dd class="data_value size_l"><span id="orders_score"></span></dd>
            </dl>
            <dl onclick="getChart(this, 'customers');" class="col-xs-4 col-lg-2 passive" style="background-color: #6B399C">
                <dt><?php echo $text_customer; ?></dt>
                <dd class="data_value size_l"><span id="customers_score"></span></dd>
            </dl>
            <dl onclick="getChart(this, 'affiliates');" class="col-xs-4 col-lg-2 passive" style="background-color: #FF7F00">
                <dt><?php echo $text_affiliates; ?></dt>
                <dd class="data_value size_l"><span id="affiliates_score"></span></dd>
            </dl>
            <dl onclick="getChart(this, 'reviews');" class="col-xs-4 col-lg-2 passive" style="background-color: #E61409">
                <dt><?php echo $text_reviews; ?></dt>
                <dd class="data_value size_l"><span id="reviews_score"></span></dd>
            </dl>
            <dl onclick="getChart(this, 'rewards');" class="col-xs-4 col-lg-2 passive" style="background-color: #B3591F">
                <dt><?php echo $text_rewards; ?></dt>
                <dd class="data_value size_l"><span id="rewards_score"></span></dd>
            </dl>
        </div>
        <div id="charts" class="panel-body">
            <div id="chart-sales" class="chart chart_active"></div>
            <div id="chart-orders" class="chart "></div>
            <div id="chart-customers" class="chart "></div>
            <div id="chart-affiliates" class="chart "></div>
            <div id="chart-reviews" class="chart "></div>
            <div id="chart-rewards" class="chart "></div>
        </div>
      </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title"><i class="fa fa-th-list fa-lg"></i> <?php echo $text_products_and_sales; ?></h1>
          </div>
            <div style="padding: 10px">
                <nav>
                    <ul class="nav nav-pills">
                        <li class="active">
                            <a data-toggle="tab" href="#dash_recent_orders">
                                <i class="fa fa-fire"></i>
                                <span class="hidden-inline-xs"><?php echo $text_last_order; ?></span>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#dash_best_sellers">
                                <i class="fa fa-trophy"></i>
                                <span class="hidden-inline-xs"><?php echo $text_best_sellers; ?></span>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#dash_less_sellers">
                                <i class="fa fa-thumbs-down"></i>
                                <span class="hidden-inline-xs"><?php echo $text_less_sellers; ?></span>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#dash_most_viewed">
                                <i class="fa fa-eye"></i>
                                <span class="hidden-inline-xs"><?php echo $text_most_viewed; ?></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="tab-content panel">
                    <div id="dash_recent_orders" class="tab-pane active">
                        <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <td class="text-right"><?php echo $column_order_id; ?></td>
                                  <td><?php echo $column_customer; ?></td>
                                  <td><?php echo $column_status; ?></td>
                                  <td><?php echo $column_date_added; ?></td>
                                  <td class="text-right"><?php echo $column_total; ?></td>
                                  <td class="text-right"><?php echo $column_action; ?></td>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if ($orders) { ?>
                                <?php foreach ($orders as $order) { ?>
                                <tr>
                                  <td class="text-right"><?php echo $order['order_id']; ?></td>
                                  <td><?php echo $order['customer']; ?></td>
                                  <td><?php echo $order['status']; ?></td>
                                  <td><?php echo $order['date_added']; ?></td>
                                  <td class="text-right"><?php echo $order['total']; ?></td>
                                  <td class="text-right"><a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-success"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                    </div>
                    <div id="dash_best_sellers" class="tab-pane">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <td class="text-right"><?php echo $column_product_id; ?></td>
                              <td><?php echo $column_product_name; ?></td>
                              <td><?php echo $column_total; ?></td>
                              <td><?php echo $column_action; ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($bestseller) { ?>
                            <?php foreach ($bestseller as $_bestseller) { ?>
                            <tr>
                              <td class="text-right"><?php echo $_bestseller['product_id']; ?></td>
                              <td><?php echo $_bestseller['name']; ?></td>
                              <td><?php echo $_bestseller['total']; ?></td>
                              <td class="text-right"><a href="<?php echo $_bestseller['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                              <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div id="dash_less_sellers" class="tab-pane">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <td class="text-right"><?php echo $column_product_id; ?></td>
                              <td><?php echo $column_product_name; ?></td>
                              <td><?php echo $column_total; ?></td>
                              <td><?php echo $column_action; ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($lessseller) { ?>
                            <?php foreach ($lessseller as $_lessseller) { ?>
                            <tr>
                              <td class="text-right"><?php echo $_lessseller['product_id']; ?></td>
                              <td><?php echo $_lessseller['name']; ?></td>
                              <td><?php echo $_lessseller['total']; ?></td>
                              <td class="text-right"><a href="<?php echo $_lessseller['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                              <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div id="dash_most_viewed" class="tab-pane">
                        <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <td class="text-right"><?php echo $column_product_id; ?></td>
                                  <td><?php echo $column_product_name; ?></td>
                                  <td><?php echo $column_total; ?></td>
                                  <td><?php echo $column_action; ?></td>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if ($viewed) { ?>
                                <?php foreach ($viewed as $_viewed) { ?>
                                <tr>
                                  <td class="text-right"><?php echo $_viewed['product_id']; ?></td>
                                  <td><?php echo $_viewed['name']; ?></td>
                                  <td><?php echo $_viewed['total']; ?></td>
                                  <td class="text-right"><a href="<?php echo $_viewed['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var start_date = '';
var end_date = '';
var block_range = 'day';

jQuery(document).ready(function() {
    var cb = function(start, end, label) { /* date range picker callback */
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        /* set global dates */
        start_date = start.format('YYYY-MM-DD');
        end_date = end.format('YYYY-MM-DD');
        /******************************************/

        getCharts();
    }

    var option_daterangepicker = {
        startDate: moment().subtract('days', 29),
        endDate: moment(),
        minDate: '01/01/2000',
        maxDate: '12/31/2100',
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small button-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
            'Last 7 Days': [moment().subtract('days', 6), moment()],
            'Last 30 Days': [moment().subtract('days', 29), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    };

    jQuery('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    jQuery('#reportrange').daterangepicker(option_daterangepicker, cb);

    start_date  = option_daterangepicker.startDate.format('YYYY-MM-DD');
    end_date    = option_daterangepicker.endDate.format('YYYY-MM-DD')
    block_range = $('#block-range li.active').attr('id');

    getCharts();
});

$('#block-range li').on('click', function(e) {
	e.preventDefault();
	
	$(this).parent().find('li').removeClass('active');
	$(this).addClass('active');

    block_range = $(this).attr('id');

    getCharts();
});

function getChart(tab, chart) {
    jQuery('#tab_toolbar dl').removeClass('active');
    jQuery('#tab_toolbar dl').addClass('passive');
    jQuery('#charts div').removeClass('chart_active');

    jQuery('#chart-'+chart).addClass('chart_active');
    jQuery(tab).removeClass('passive');
    jQuery(tab).addClass('active');

    switch (chart) {
        case 'sales' :
            sales();
            break;
        case 'orders' :
            orders();
            break;
        case 'customers' :
            customers();
            break;
        case 'affiliates' :
            affiliates();
            break;
        case 'reviews' :
            reviews();
            break;
        case 'rewards' :
            rewards();
            break;
        default :
            break;
    }
}

function getCharts(){
    sales();
    orders();
    customers();
    affiliates();
    reviews();
    rewards();
}

function sales() {
    $('#sales_score').html('<img src="view/image/loader.gif">');
    $('#chart-sales').html('<div class="loading"><img src="view/image/loader.gif"></div>');

    $.ajax({
        type: 'get',
        url: 'index.php?route=common/home/sales&start='+ start_date +'&end='+ end_date +'&token=<?php echo $token; ?>&range=' + block_range,
        dataType: 'json',
        success: function(json) {
            var option = {
                shadowSize: 0,
                lines: {
                    show: true
                },
                grid: {
                    backgroundColor: '#FFFFFF',
                    hoverable: true
                },
                points: {
                    show: true,
                    fillColor: '#1777B6'
                },
                xaxis: {
                    show: true,
                    rotateTicks : 45,
                    ticks: json['xaxis']
                },
                yaxis: {
                    mode: "money",
                    min: 0,
                    tickDecimals: 2,
                    tickFormatter: function (v, axis) { return "<?php echo $symbol_left; ?>" + v.toFixed(axis.tickDecimals) + "<?php echo $symbol_right; ?>" }
                }
            };

            json['order']['color'] = "#1777B6";
            $.plot('#chart-sales', [json['order']], option);

            $('#chart-sales').bind('plothover', function(event, pos, item) {
                $('.tooltip').remove();

                if (item) {
                    $('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

                    $('#tooltip').css({
                        position: 'absolute',
                        left: item.pageX - ($('#tooltip').outerWidth() / 2),
                        top: item.pageY - $('#tooltip').outerHeight(),
                        pointer: 'cusror'
                    }).fadeIn('slow');

                    $('#chart-sales').css('cursor', 'pointer');
                } else {
                    $('#chart-sales').css('cursor', 'auto');
                }
            });

            $('#sales_score').html(json['order']['total']);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

}

function orders() {
    $('#orders_score').html('<img src="view/image/loader.gif">');
    $('#chart-orders').html('<div class="loading"><img src="view/image/loader.gif"></div>');

	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/orders&start='+ start_date +'&end='+ end_date +'&token=<?php echo $token; ?>&range=' + block_range,
		dataType: 'json',
		success: function(json) {
			var option = {
				shadowSize: 0,
				lines: {
					show: true
				},
				grid: {
					backgroundColor: '#FFFFFF',
					hoverable: true
				},
				points: {
					show: true,
                    fillColor: '#2CA121'
				},
				xaxis: {
					show: true,
                    rotateTicks : 45,
            		ticks: json['xaxis']
				},
                yaxis : {
                    min: 0,
                    tickDecimals: 0
                }
			};

            json['order']['color'] = "#2CA121";
			$.plot('#chart-orders', [json['order']], option);

			$('#chart-orders').bind('plothover', function(event, pos, item) {
				$('.tooltip').remove();

				if (item) {
					$('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

					$('#tooltip').css({
						position: 'absolute',
						left: item.pageX - ($('#tooltip').outerWidth() / 2),
						top: item.pageY - $('#tooltip').outerHeight(),
						pointer: 'cusror'
					}).fadeIn('slow');

					$('#chart-orders').css('cursor', 'pointer');
			  	} else {
					$('#chart-orders').css('cursor', 'auto');
				}
			});

            $('#orders_score').html(json['order']['total']);
		},
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
}

function customers() {
    $('#customers_score').html('<img src="view/image/loader.gif">');
    $('#chart-customers').html('<div class="loading"><img src="view/image/loader.gif"></div>');

	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/customers&start='+ start_date +'&end='+ end_date +'&token=<?php echo $token; ?>&range=' + block_range,
		dataType: 'json',
		success: function(json) {
			var option = {
				shadowSize: 0,
				lines: {
					show: true
				},
				grid: {
					backgroundColor: '#FFFFFF',
					hoverable: true
				},
				points: {
					show: true,
                    fillColor: '#6B399C'
				},
				xaxis: {
					show: true,
                    rotateTicks : 45,
            		ticks: json['xaxis']
				},
                yaxis : {
                    min: 0,
                    tickDecimals: 0
                }
			};

            json['order']['color'] = "#6B399C";
			$.plot('#chart-customers', [json['order']], option);

			$('#chart-customers').bind('plothover', function(event, pos, item) {
				$('.tooltip').remove();

				if (item) {
					$('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

					$('#tooltip').css({
						position: 'absolute',
						left: item.pageX - ($('#tooltip').outerWidth() / 2),
						top: item.pageY - $('#tooltip').outerHeight(),
						pointer: 'cusror'
					}).fadeIn('slow');

					$('#chart-customers').css('cursor', 'pointer');
			  	} else {
					$('#chart-customers').css('cursor', 'auto');
				}
			});

            $('#customers_score').html(json['order']['total']);
		},
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
}

function affiliates() {
    $('#affiliates_score').html('<img src="view/image/loader.gif">');
    $('#chart-affiliates').html('<div class="loading"><img src="view/image/loader.gif"></div>');

	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/affiliates&start='+ start_date +'&end='+ end_date +'&token=<?php echo $token; ?>&range=' + block_range,
		dataType: 'json',
		success: function(json) {
			var option = {
				shadowSize: 0,
				lines: {
					show: true
				},
				grid: {
					backgroundColor: '#FFFFFF',
					hoverable: true
				},
				points: {
					show: true,
                    fillColor: '#FF7F00'
				},
				xaxis: {
					show: true,
                    rotateTicks : 45,
            		ticks: json['xaxis']
				},
                yaxis : {
                    min: 0,
                    tickDecimals: 0
                }
			};

            json['order']['color'] = "#FF7F00";
			$.plot('#chart-affiliates', [json['order']], option);

			$('#chart-affiliates').bind('plothover', function(event, pos, item) {
				$('.tooltip').remove();

				if (item) {
					$('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

					$('#tooltip').css({
						position: 'absolute',
						left: item.pageX - ($('#tooltip').outerWidth() / 2),
						top: item.pageY - $('#tooltip').outerHeight(),
						pointer: 'cusror'
					}).fadeIn('slow');

					$('#chart-affiliates').css('cursor', 'pointer');
			  	} else {
					$('#chart-affiliates').css('cursor', 'auto');
				}
			});

            $('#affiliates_score').html(json['order']['total']);
		},
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
}

function reviews() {
    $('#reviews_score').html('<img src="view/image/loader.gif">');
    $('#chart-reviews').html('<div class="loading"><img src="view/image/loader.gif"></div>');

	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/reviews&start='+ start_date +'&end='+ end_date +'&token=<?php echo $token; ?>&range=' + block_range,
		dataType: 'json',
		success: function(json) {
			var option = {
				shadowSize: 0,
				lines: {
					show: true
				},
				grid: {
					backgroundColor: '#FFFFFF',
					hoverable: true
				},
				points: {
					show: true,
                    fillColor: '#E61409'
				},
				xaxis: {
					show: true,
                    rotateTicks : 45,
            		ticks: json['xaxis']
				},
                yaxis : {
                    min: 0,
                    tickDecimals: 0
                }
			};

            json['order']['color'] = "#E61409";
			$.plot('#chart-reviews', [json['order']], option);

			$('#chart-reviews').bind('plothover', function(event, pos, item) {
				$('.tooltip').remove();

				if (item) {
					$('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

					$('#tooltip').css({
						position: 'absolute',
						left: item.pageX - ($('#tooltip').outerWidth() / 2),
						top: item.pageY - $('#tooltip').outerHeight(),
						pointer: 'cusror'
					}).fadeIn('slow');

					$('#chart-reviews').css('cursor', 'pointer');
			  	} else {
					$('#chart-reviews').css('cursor', 'auto');
				}
			});

            $('#reviews_score').html(json['order']['total']);
		},
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
}

function rewards() {
    $('#rewards_score').html('<img src="view/image/loader.gif">');
    $('#chart-rewards').html('<div class="loading"><img src="view/image/loader.gif"></div>');

	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/rewards&start='+ start_date +'&end='+ end_date +'&token=<?php echo $token; ?>&range=' + block_range,
		dataType: 'json',
		success: function(json) {
			var option = {
				shadowSize: 0,
				lines: {
					show: true
				},
				grid: {
					backgroundColor: '#FFFFFF',
					hoverable: true
				},
				points: {
					show: true,
                    fillColor: '#B3591F'
				},
				xaxis: {
					show: true,
                    rotateTicks : 45,
            		ticks: json['xaxis']
				},
                yaxis : {
                    min: 0,
                    tickDecimals: 0
                }
			};

            json['order']['color'] = "#B3591F";
			$.plot('#chart-rewards', [json['order']], option);

			$('#chart-rewards').bind('plothover', function(event, pos, item) {
				$('.tooltip').remove();

				if (item) {
					$('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');

					$('#tooltip').css({
						position: 'absolute',
						left: item.pageX - ($('#tooltip').outerWidth() / 2),
						top: item.pageY - $('#tooltip').outerHeight(),
						pointer: 'cusror'
					}).fadeIn('slow');

					$('#chart-rewards').css('cursor', 'pointer');
			  	} else {
					$('#chart-rewards').css('cursor', 'auto');
				}
			});

            $('#rewards_score').html(json['order']['total']);
		},
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
}
//--></script> 
<?php echo $footer; ?>