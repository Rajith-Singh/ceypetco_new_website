<?php



use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Plugin;




class wpsection_wps_countdown_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'wpsection_wps_countdown';
    }

    public function get_title()
    {
        return __('Countdown', 'wpsection');
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_keywords()
    {
        return ['countdown', 'wpsection'];
    }

    public function get_categories()
    {
        return ['wpsection_category'];
    }


    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Icon', 'wpsection'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'sec_class',
            [
                'label'   => esc_html__('Choose Different Style', 'wpsection'),
                'label_block' => true,
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => array(
                    '1' => esc_html__('Style 1', 'wpsection'),
                    '2' => esc_html__('Style 2', 'wpsection'),
                    '3' => esc_html__('Style 3', 'wpsection'),
                    '4' => esc_html__('Style 4', 'wpsection'),
                    '5' => esc_html__('Style 5', 'wpsection'),
                ),
            ]
        );

        $this->add_control(
			'due_date',
			[
				'label' => esc_html__( 'Date Time', 'wpsection' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
			]
		);
        // $this->add_control(
        //     'date_time',
        //     [
        //         'type'        => Controls_Manager::TEXT,
        //         'label'       => esc_html__('Date & Time', 'wpsection'),
        //         'default' => esc_html('08 Oct 2020 01:51 pm'),
        //         'label_block' => true
        //     ]
        // );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_infobox_style',
            [
                'label' => esc_html__('Style', 'wpsection'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'num_color',
            [
                'label'     => esc_html__('Number Color', 'wpsection'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpsection-countdown .count-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'wpsection'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpsection-countdown .count-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label'     => esc_html__('Primary Color', 'wpsection'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpsection-countdown-1 > span, {{WRAPPER}} .wpsection-countdown-2 > span' => 'border-right-color: {{VALUE}};',
                    '{{WRAPPER}} .wpsection-countdown-3 > span' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .wpsection-countdown-4 > span' => 'border-left-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => ['1', '2', '3', '4'],
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label'     => esc_html__('Secondary Color', 'wpsection'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpsection-countdown-4 > span' => 'border-right-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => ['4'],
                ],
            ]
        );

        $this->add_group_control(
            \elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'wrap_bg',
                'label'    => esc_html__('Background', 'wpsection'),
                'types'    => ['gradient'],
                'selector' => '{{WRAPPER}} .wpsection-countdown-5 > span',
                'condition' => [
                    'style' => ['5'],
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'     => esc_html__('Number Size', 'wpsection'),
                'name'     => 'typography_number',
                'selector' => '{{WRAPPER}} .wpsection-countdown .count-number',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'     => esc_html__('Text Size', 'wpsection'),
                'name'     => 'typography_text',
                'selector' => '{{WRAPPER}} .wpsection-countdown .count-text',
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label'      => esc_html__('Item Margin', 'wpsection'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpsection-countdown > span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Item Padding', 'wpsection'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpsection-countdown > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $allowed_tags = wp_kses_allowed_html('post');
?>


        <?php
        $unique_id = uniqid();
        $style     = wpsection()->get_settings_atts('style', '1');
        $date_time = wpsection()->get_settings_atts('due_date', '01 Jan 2024 12:00 pm');

        ?>



        <div id="wpsection-countdown-<?php echo esc_attr($unique_id); ?>" class="wpsection-countdown wpsection-countdown-<?php echo esc_attr($settings['sec_class']);?>"></div>
        <script>
            (function($, window, document) {
                "use strict";

                (function updateTime() {
                    var countDownDate = new Date(new Date('<?php echo esc_attr($date_time); ?>').toString()).getTime(),
                        now = new Date().getTime(),
                        distance = countDownDate - now,
                        days = 0,
                        hours = 0,
                        minutes = 0,
                        seconds = 0;

                    if (distance > 0) {
                        days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    }

                    days = days < 10 ? '0' + days : days;
                    hours = hours < 10 ? '0' + hours : hours;
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    seconds = seconds < 10 ? '0' + seconds : seconds;

                    $("#wpsection-countdown-<?php echo esc_attr($unique_id); ?>").html(
                        '<span class="days"><span class="count-number">' + days + '</span><span class="count-text"><?php esc_html_e('Days', 'wpsection'); ?></span></span>' +
                        '<span class="hours"><span class="count-number">' + hours + '</span><span class="count-text"><?php esc_html_e('Hours', 'wpsection') ?></span></span>' +
                        '<span class="minutes"><span class="count-number">' + minutes + '</span><span class="count-text"><?php esc_html_e('Minutes', 'wpsection'); ?></span></span>' +
                        '<span class="seconds"><span class="count-number">' + seconds + '</span><span class="count-text"><?php esc_html_e('Seconds', 'wpsection') ?></span></span>');

                    setTimeout(updateTime, 1000);
                })();

            })(jQuery, window, document);
        </script>


<?php
    }
}


Plugin::instance()->widgets_manager->register(new \wpsection_wps_countdown_Widget());
