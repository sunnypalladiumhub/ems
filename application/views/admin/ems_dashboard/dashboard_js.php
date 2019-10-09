<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script>
		var MONTHS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11','12','13','14','15','16','17','18','19','20','21','22','23'];
		var config = {
			type: 'line',
			data: {
				labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11','12','13','14','15','16','17','18','19','20','21','22','23'],
				datasets: [{
					label: 'Today',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						<?php echo $today_tickets; ?>
					],
					fill: false,
				}, {
					label: 'Yesterday',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						<?php echo $yesterday_tickets; ?>
                                                
					],
				}]
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'Chart.js Line Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Hours'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

//		document.getElementById('randomizeData').addEventListener('click', function() {
//			config.data.datasets.forEach(function(dataset) {
//				dataset.data = dataset.data.map(function() {
//					return randomScalingFactor();
//				});
//
//			});
//
//			window.myLine.update();
//		});

		var colorNames = Object.keys(window.chartColors);
//		document.getElementById('addDataset').addEventListener('click', function() {
//			var colorName = colorNames[config.data.datasets.length % colorNames.length];
//			var newColor = window.chartColors[colorName];
//			var newDataset = {
//				label: 'Dataset ' + config.data.datasets.length,
//				backgroundColor: newColor,
//				borderColor: newColor,
//				data: [],
//				fill: false
//			};
//
//			for (var index = 0; index < config.data.labels.length; ++index) {
//				newDataset.data.push(randomScalingFactor());
//			}
//
//			config.data.datasets.push(newDataset);
//			window.myLine.update();
//		});

//		document.getElementById('addData').addEventListener('click', function() {
//			if (config.data.datasets.length > 0) {
//				var month = MONTHS[config.data.labels.length % MONTHS.length];
//				config.data.labels.push(month);
//
//				config.data.datasets.forEach(function(dataset) {
//					dataset.data.push(randomScalingFactor());
//				});
//
//				window.myLine.update();
//			}
//		});

//		document.getElementById('removeDataset').addEventListener('click', function() {
//			config.data.datasets.splice(0, 1);
//			window.myLine.update();
//		});

//		document.getElementById('removeData').addEventListener('click', function() {
//			config.data.labels.splice(-1, 1); // remove the label first
//
//			config.data.datasets.forEach(function(dataset) {
//				dataset.data.pop();
//			});
//
//			window.myLine.update();
//		});
	</script>
        
        
        
       
<script>
    var weekly_payments_statistics;
    var user_dashboard_visibility = '';
    $(function() {
        $( "[data-container]" ).sortable({
            connectWith: "[data-container]",
            helper:'clone',
            handle:'.widget-dragger',
            tolerance:'pointer',
            forcePlaceholderSize: true,
            placeholder: 'placeholder-dashboard-widgets',
            start:function(event,ui) {
                $("body,#wrapper").addClass('noscroll');
                $('body').find('[data-container]').css('min-height','20px');
            },
            stop:function(event,ui) {
                $("body,#wrapper").removeClass('noscroll');
                $('body').find('[data-container]').removeAttr('style');
            },
            update: function(event, ui) {
                if (this === ui.item.parent()[0]) {
                    var data = {};
                    $.each($("[data-container]"),function(){
                        var cId = $(this).attr('data-container');
                        data[cId] = $(this).sortable('toArray');
                        if(data[cId].length == 0) {
                            data[cId] = 'empty';
                        }
                    });
                    $.post(admin_url+'staff/save_dashboard_widgets_order', data, "json");
                }
            }
        });

        // Read more for dashboard todo items
        $('.read-more').readmore({
            collapsedHeight:150,
            moreLink: "<a href=\"#\"><?php echo _l('read_more'); ?></a>",
            lessLink: "<a href=\"#\"><?php echo _l('show_less'); ?></a>",
        });

        $('body').on('click','#viewWidgetableArea',function(e){
            e.preventDefault();

            if(!$(this).hasClass('preview')) {
                $(this).html("<?php echo _l('hide_widgetable_area'); ?>");
                $('[data-container]').append('<div class="placeholder-dashboard-widgets pl-preview"></div>');
            } else {
                $(this).html("<?php echo _l('view_widgetable_area'); ?>");
                $('[data-container]').find('.pl-preview').remove();
            }

            $('[data-container]').toggleClass('preview-widgets');
            $(this).toggleClass('preview');
        });

        var $widgets = $('.widget');
        var widgetsOptionsHTML = '';
        widgetsOptionsHTML += '<div id="dashboard-options">';
        widgetsOptionsHTML += "<h4><i class='fa fa-question-circle' data-toggle='tooltip' data-placement=\"bottom\" data-title=\"<?php echo _l('widgets_visibility_help_text'); ?>\"></i> <?php echo _l('widgets'); ?></h4><a href=\"<?php echo admin_url('staff/reset_dashboard'); ?>\"><?php echo _l('reset_dashboard'); ?></a>";

        widgetsOptionsHTML += ' | <a href=\"#\" id="viewWidgetableArea"><?php echo _l('view_widgetable_area'); ?></a>';
        widgetsOptionsHTML += '<hr class=\"hr-10\">';

        $.each($widgets,function(){
            var widget = $(this);
            var widgetOptionsHTML = '';
            if(widget.data('name') && widget.html().trim().length > 0) {
                widgetOptionsHTML += '<div class="checkbox checkbox-inline">';
                var wID = widget.attr('id');
                wID = wID.split('widget-');
                wID = wID[wID.length-1];
                var checked= ' ';
                var db_result = $.grep(user_dashboard_visibility, function(e){ return e.id == wID; });
                if(db_result.length >= 0) {
                    // no options saved or really visible
                    if(typeof(db_result[0]) == 'undefined' || db_result[0]['visible'] == 1) {
                        checked = ' checked ';
                    }
                }
                widgetOptionsHTML += '<input type="checkbox" class="widget-visibility" value="'+wID+'"'+checked+'id="widget_option_'+wID+'" name="dashboard_widgets['+wID+']">';
                widgetOptionsHTML += '<label for="widget_option_'+wID+'">'+widget.data('name')+'</label>';
                widgetOptionsHTML += '</div>';
            }
            widgetsOptionsHTML += widgetOptionsHTML;
        });

        $('.screen-options-area').append(widgetsOptionsHTML);
        $('body').find('#dashboard-options input.widget-visibility').on('change',function(){
          if($(this).prop('checked') == false) {
            $('#widget-'+$(this).val()).addClass('hide');
        } else {
            $('#widget-'+$(this).val()).removeClass('hide');
        }

        var data = {};
        var options = $('#dashboard-options input[type="checkbox"]').map(function() {
            return { id: this.value, visible: this.checked ? 1 : 0 };
        }).get();

        data.widgets = options;
/*
        if (typeof(csrfData) !== 'undefined') {
            data[csrfData['token_name']] = csrfData['hash'];
        }
*/
        $.post(admin_url+'staff/save_dashboard_widgets_visibility',data).fail(function(data) {
            // Demo usage, prevent multiple alerts
            if($('body').find('.float-alert').length == 0) {
                alert_float('danger', data.responseText);
            }
        });
    });

        var tickets_chart_departments = $('#tickets-awaiting-reply-by-department');
        var tickets_chart_status = $('#tickets-awaiting-reply-by-status');
        var leads_chart = $('#leads_status_stats');
        var projects_chart = $('#projects_status_stats');

        if (tickets_chart_departments.length > 0) {
            // Tickets awaiting reply by department chart
            var tickets_dep_chart = new Chart(tickets_chart_departments, {
                type: 'doughnut',
                data: '',
            });
        }
        if (tickets_chart_status.length > 0) {
            // Tickets awaiting reply by department chart
            new Chart(tickets_chart_status, {
                type: 'doughnut',
                data:'',
                options: {
                   onClick:function(evt){
                    onChartClickRedirect(evt,this);
                }
            },
        });
        }
        if (leads_chart.length > 0) {
            // Leads overview status
            new Chart(leads_chart, {
                type: 'doughnut',
                data: '',
                options:{
                    maintainAspectRatio:false,
                    onClick:function(evt){
                        onChartClickRedirect(evt,this);
                    }
                }
            });
        }
        if(projects_chart.length > 0){
            // Projects statuses
            new Chart(projects_chart, {
                type: 'doughnut',
                data: '',
                options: {
                    maintainAspectRatio:false,
                    onClick:function(evt){
                       onChartClickRedirect(evt,this);
                   }
               }
           });
        }

        if($(window).width() < 500) {
            // Fix for small devices weekly payment statistics
            $('#weekly-payment-statistics').attr('height', '250');
        }

        fix_user_data_widget_tabs();
        $(window).on('resize', function(){
            $('.horizontal-scrollable-tabs ul.nav-tabs-horizontal').removeAttr('style');
            fix_user_data_widget_tabs();
        });
        // Payments statistics
        //init_weekly_payment_statistics( <?php //echo $weekly_payment_stats; ?> );
        $('select[name="currency"]').on('change', function() {
            init_weekly_payment_statistics();
        });
    });
    function fix_user_data_widget_tabs(){
        if((app.browser != 'firefox'
                && isRTL == 'false' && is_mobile()) || (app.browser == 'firefox'
                && isRTL == 'false' && is_mobile())){
                $('.horizontal-scrollable-tabs ul.nav-tabs-horizontal').css('margin-bottom','26px');
        }
    }
    function init_weekly_payment_statistics(data) {
        if ($('#weekly-payment-statistics').length > 0) {

            if (typeof(weekly_payments_statistics) !== 'undefined') {
                weekly_payments_statistics.destroy();
            }
            if (typeof(data) == 'undefined') {
                var currency = $('select[name="currency"]').val();
                $.get(admin_url + 'home/weekly_payments_statistics/' + currency, function(response) {
                    weekly_payments_statistics = new Chart($('#weekly-payment-statistics'), {
                        type: 'bar',
                        data: response,
                        options: {
                            responsive:true,
                            scales: {
                                yAxes: [{
                                  ticks: {
                                    beginAtZero: true,
                                }
                            }]
                        },
                    },
                });
                }, 'json');
            } else {
                weekly_payments_statistics = new Chart($('#weekly-payment-statistics'), {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                              ticks: {
                                beginAtZero: true,
                            }
                        }]
                    },
                },
            });
            }

        }
    }
</script>
